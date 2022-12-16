<?php 
session_start();
//include("config.php");
include_once "config.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
//$image = mysqli_real_escape_string($conn, $_POST['photo']);


if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
    // lets check the usere email is valid or not
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // if eamil is valid
        //lets check that email  alreay exist in the database or not
        $sql = mysqli_query($conn, " SELECT email FROM users WHERE email='{$email}'");
        if(mysqli_num_rows($sql) > 0){  // if eamil alrady exist
            echo "$email - This eamil  is already exist!";
        }else{
            // lets check user upload file or not
            if(isset($_FILES['image'])){  // if file is uploaded
                $img_name = $_FILES['image']['name'];  //getting user uploaded img name
               
               // $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // lets explode image and get the last extension like jpg png
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);  // here we get extension of an users uploaded img file

                $extensions = ['png','jpeg','jpg']; // there are some valid extensiion 

                if(in_array($img_ext, $extensions)  === true){
                    $time = time(); // this is current time

                    // lets move the user uploaded img to our particuler folder
                    $new_img_name = $time.$img_name;
                    
                    if(move_uploaded_file($tmp_name, "../images/" .$new_img_name)){    // if user upload the img move to folder 
                        $status = "Active now";  // once user signed up then his status will be active now)
                        $random_id = rand(time(),10000000); // creating randam id for users

                        // lets insert all users data inside table

                        $sql2= mysqli_query($conn, "INSERT INTO users(unique_id,fname,lname,email,password,img,status) VALUES ({$random_id},'{$fname}','{$lname}','{$email}','{$password}','{$new_img_name}','{$status}')");

                        if($sql2){ // if these data inserted
                            $sql3 = mysqli_query($conn,"SELECT * FROM users WHERE email = '{$email}'");
                            if(mysqli_num_rows($sql3) > 0){
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id']= $row['unique_id']; // using this session we used unique_id
                                echo "success";
                            }


                        }else{
                            echo "Something went wrong!";
                        }

                    }                    
                }else{
                    echo "Please select an image file -jpeg.png.jpg!";
                }
                
            }else{
                echo "Please select an image from file!";
            }
        }

    }else{
        echo "$email - This is not a valid eamil";
    }

}else{
    echo " All input field are required";
}

?>