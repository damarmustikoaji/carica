<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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

select {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
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

<h2>Buat Stok</h2>

<form class="form-inline" id="myForm">
    <input type="text" id="nama" placeholder="Nama" name="nama">
    <input id="jumlah" name="jumlah" value="" placeholder="Stok" required>
    <input type="date" id="expired" placeholder="Expired (22/05/31)" name="expired">
    <select name="kategori" id="kategori" required>
        <option value="">kategori</option>
    </select>
    <button type="submit" id="postSubmit">Submit</button>
    <input type="button" value="Batal" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./";  
       }
     </script>
</form>

</body>
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
</html>
