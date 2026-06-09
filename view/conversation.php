<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation</title>
    <style>
    #zone_conversation{
        width:1000px;
        height: 450px;
        overflow : scroll;
        background-color: skyblue;
        border: 3px solid black;
        margin: 0 auto;
        padding: 15px;
    }

    #message{
        display: block;
        margin: 15px auto;
        width: 1000px;
        height: 30px;
        
    }
    </style>
</head>
<body onload="loadMessage()">
    <div id="welcome" name="welcome">
        <?php 
        
            include 'welcome.php';
        ?>
    </div>

    <div id="zone_conversation" name="zone_conversation"></div>

    <input type="text" name="message" id="message" placeholder= "Enter something.....">
    <button id="button" name="button" onclick="sendMessage()">Send</button>
    <script>
        function sendMessage(){
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange=function(){
                if(xhr.readyState == 4 && xhr.status==200){
                    var message = document.getElementById("message");
                    message.value = "";
                }
                else{
                    console.log(xhr.responseText);
                }
            };
            xhr.open('POST', '../Controller/msgcontroller.php?action=send', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send("message="+message.value);
            loadMessage();
        }

        function loadMessage(){
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange=function(){
                if(xhr.readyState == 4 && xhr.status==200){
                    document.getElementById('zone_conversation').innerHTML = xhr.responseText;
                }
                else{
                    console.log(xhr.responseText);
                }  
             }
            xhr.open('GET', '../controller/msgcontroller.php?action=messages', true);
            xhr.send();
        }
    </script>

</body>
</html>