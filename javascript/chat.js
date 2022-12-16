const form = document.querySelector(".typing-area");
inputField = form.querySelector(".input-field");
sendBtn = form.querySelector("button");
chatBox = document.querySelector(".chat-box");


form.onsubmit = (e) =>{
    e.preventDefault();
}

sendBtn.onclick = () =>{
     // lets start Ajax
     let xhr = new XMLHttpRequest(); // creating xml object
     xhr.open("POST","php/insert-chat.php",true);
     xhr.onload = () =>{
         if(xhr.readyState === XMLHttpRequest.DONE){
             if(xhr.status === 200){
                inputField.value = " "; // once message is inserted into the database then leave blank the input field
                scrollToBottom();
             }
         }
     }
 
     // we have to send the form data through ajax to php
     let formData = new FormData(form); // creating new formdata object        
     xhr.send(formData);  // sending ther form data to php
}

chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
}
chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
}

setInterval( () => {
    // lets starty Ajax
    let xhr = new XMLHttpRequest(); // creating xml object
    xhr.open("POST","php/get-chat.php",true);
    xhr.onload = () =>{
     if(xhr.readyState === XMLHttpRequest.DONE){
       if(xhr.status === 200){
         let data = xhr.response;         
         chatBox.innerHTML = data;
         if(!chatBox.classList.contains("active")){  // if active class not contain in chatbox then  scroll to bottom
          scrollToBottom(); 
         }             
                 
       }
     }
   }
   let formData = new FormData(form); // creating new formdata object
    
   xhr.send(formData);  // sending ther form data to php
  
 },500); // this function will run after 500ms


 function scrollToBottom(){
  chatBox.scrollTop = chatBox.scrollHeight;
 }


