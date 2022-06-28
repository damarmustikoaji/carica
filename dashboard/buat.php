<html>
<head>
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>Caricapps - Buat</title>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<form id="myForm">
    <input id="nama" name="nama" value="" placeholder="nama" required>
    <select name="kategori" id="kategori" required>
        <option value="">kategori</option>
    </select>
    <input id="jumlah" name="jumlah" value="" placeholder="jumlah" required>
    <input id="expired" name="expired" value="" placeholder="expired (22/05/31)" required>
    <input type="button" value="Batal" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./";  
       }
     </script>
    <input id="postSubmit" type="submit" value="Buat">
</form> 

<script>

let host = "http://caricapps.herokuapp.com";

getData();

async function getData(){
     const response = await fetch(host+'/v1/kebutuhan/kategori', {
                                  method: 'GET',
                                  headers: {
                                      'token': 'cocobain123'
                                  }
                                  })
     const results = await response.json();
     const data = results.data;
     length=data.length;
     var temp="";
     for(i=0;i<length;i++)
     {
        temp+="<option value='"+data[i].nama+"'>"+data[i].nama+"</option>";
     }

  document.getElementById("kategori").innerHTML=temp;
   }
     
const thisForm = document.getElementById('myForm');
thisForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(thisForm).entries()
    const coba = Object.fromEntries(formData)
    const response = await fetch(host+'/v1/kebutuhan/buat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' },
        body: JSON.stringify({
            'nama': coba.nama,
            'jumlah': coba.jumlah,
            'kategori': coba.kategori,
            'expired': coba.expired
        })
    });

    const results = await response.json();
    window.location.href="./";
});


</script>
</body>

</html>