<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
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
<style>
        #loader1 {
            position:absolute;
            left:40%;
            top:35%;
            border-radius:20px;
            padding:25px;
        }
    </style>
        <script>
        function hideLoader() { 
            document.getElementById('loader1').style.display = "none"; 
        }
    </script>
</head>
<body>
<input type="button" value="Kembali" onClick="myKembali()"/> 
        <script>
        function myKembali() {
            window.location.href="./";  
        }
    </script>
    <input type="button" value="List" onClick="myFunction()"/> 
        <script>
        function myFunction() {
            window.location.href="./upload_list.php";  
        }
    </script>
    <h2>Upload Form</h2>
    <img id="loader1" src="../assets/loading.gif" alt="loading gif" /> 
    <div id="pengeluaran"></div>
    <div id="notif"></div>
    <form class="form-inline" method="POST" id="form_upload" enctype="multipart/form-data">
        <input type="file" id="sendimage" name="sendimage">
        <input type="text" id="nominal" placeholder="Nominal" name="nominal">
        <textarea id="catatan" placeholder="Catatan..." name="catatan"></textarea>
        <button type="submit" id="submit" name="submit">Submit</button>
    </form>
</body>

<script>

let host = "http://caricapps.herokuapp.com";

getData();

async function getData(){
     const response = await fetch(host+'/v1/pengeluaran/total', {
                                  method: 'GET',
                                  headers: {
                                      'token': 'cocobain123'
                                  }
                                  })
     const results = await response.json();
      hideLoader();
     const data = results.data.pengeluaran;
     const format = data.toString().split('').reverse().join('');
      const convert = format.match(/\d{1,3}/g);
      const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
     var temp="";
     temp+="Pengeluaran "+rupiah;

  document.getElementById("pengeluaran").innerHTML=temp;
   }
     
const thisForm = document.getElementById('form_upload');
thisForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="../assets/loading.gif" alt="loading gif" />';
    document.getElementById("notif").innerHTML=loadnya;
    const form = new FormData(document.querySelector('#form_upload'));
    const response = await fetch(host+'/v1/upload/file', {
        method: 'POST',
        headers: { 'token': 'cocobain123' },
        body: form
    });

    const results = await response.json();
    if(results.status == "00"){ 
        var notif = '<p style="color:blue"><b>'+results.pesan+' '+results.fileName+'</b></p>'
    } else {
        var notif = '<p style="color:red"><b>'+results.pesan+'</b></p>'
    }
    hideLoader();
    document.getElementById("notif").innerHTML=notif;
    getData();
});

</script>
</html>
