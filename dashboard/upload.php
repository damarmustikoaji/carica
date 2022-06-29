<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>Caricapps - Upload</title>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
}

.form-inline label {
  margin: 5px 10px 5px 0;
}

.form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}

.form-inline button {
  padding: 10px 20px;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;
}

.form-inline button:hover {
  background-color: royalblue;
}

@media (max-width: 800px) {
  .form-inline input {
    margin: 10px 0;
  }
  
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>
</head>
<body>
    <input type="button" value="List" onClick="myFunction()"/> 
        <script>
        function myFunction() {
            window.location.href="./upload_list.php";  
        }
    </script>
    <h2>Upload Form</h2>
    <div id="data"></div>
    <form class="form-inline" method="POST" id="form_upload" enctype="multipart/form-data">
        <input type="file" id="sendimage" name="sendimage">
        <input type="text" id="nominal" placeholder="Nominal" name="nominal">
        <textarea id="catatan" placeholder="Catatan..." name="catatan"></textarea>
        <button type="submit" id="submit" name="submit">Submit</button>
    </form>
</body>

<script>

let host = "http://caricapps.herokuapp.com";
     
const thisForm = document.getElementById('form_upload');
thisForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const form = new FormData(document.querySelector('#form_upload'));
    const response = await fetch(host+'/v1/upload/file', {
        method: 'POST',
        headers: { 'token': 'cocobain123' },
        body: form
    });

    const results = await response.json();
    if(results.status == "00"){ 
        var loadnya = '<p style="color:blue"><b>'+results.message+'</b></p>'
    } else {
        var loadnya = '<p style="color:red"><b>'+results.message+'</b></p>'
    }
    
    document.getElementById("data").innerHTML=loadnya;
});

</script>
</html>
