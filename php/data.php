<?php
  while($row = mysqli_fetch_assoc($sql)){
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id ={$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id ={$outgoing_id} OR outgoing_msg_id ={$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_assoc($query2);
    if(mysqli_num_rows($query2) >0){
        $result = $row2['msg'];
    }else{
        $result = "No  message avilable";
    }
       // trimming the message if word are more then 28
    (strlen($result) > 28) ? $msg = substr($result,0,28).'...' : $msg = $result;
    // adding you to  text before msg if long id and msg
    if(isset($row2['outgoing_msg_id'])){
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
    }else{
        $you = ""; 
    }
   // check users is online or offline
    if(isset($row['status'])){
        ($row['status'] == "offline now") ? $offline = "offline" : $offline = "";
    }else{
        $offline = "";
    } 
    $output .= '<a href="chat.php?user_id='.$row['unique_id'].'">
                <div class="content">
                    <img src="php/../images/'. $row['img']. '" alt="">
                    <div class="details">
                        <span>'.$row['fname'] ." ". $row['lname'].'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                </div>
                 <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>