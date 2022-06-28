<!DOCTYPE html> 

<html lang="en"> 

  

<head> 

    <script>

let base64String = ""; 

  

function imageUploaded() { 

    var file = document.querySelector( 

        'input[type=file]')['files'][0]; 

  

    var reader = new FileReader(); 

    console.log("next"); 

      

    reader.onload = function () { 

        base64String = reader.result.replace("data:", "") 

            .replace(/^.+,/, ""); 

  

        imageBase64Stringsep = base64String; 

  

        // alert(imageBase64Stringsep); 

        console.log(base64String); 

    } 

    reader.readAsDataURL(file); 
} 

  

function displayString() { 
    var temp = "";

    console.log("Base64String about to be printed"); 
    temp+='<textarea name="comment" form="usrform">'+base64String+'</textarea>';

    // alert(base64String); 
    document.getElementById("base64").innerHTML=temp;
} 

    </script> 

</head> 

  

<body> 

    <input type="file" name="" id="fileId" 

        onchange="imageUploaded()"> 

    <br><br> 

  

    <button onclick="displayString()"> 

        Display String 

    </button> 

    <div id="base64"></div>

</body> 

  

</html>