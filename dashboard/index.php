<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
<title>Caricapps</title>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
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

<h2>Stok</h2>

<form id="myForm">
    <input id="myName" name="name" value="" placeholder="Kata Kunci" required>
    <input id="postSubmit" type="submit" value="Cari">
    <input type="reset" value="Reset" onClick="myReset()"/>
    <script>
       function myReset() {
         window.location.href="./";  
       }
     </script>
    <input type="button" value="Buat" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./buat.php";  
       }
     </script>
    <input type="button" value="Riwayat" onClick="myRiwayat()"/> 
     <script>
       function myRiwayat() {
         window.location.href="./riwayat.php";  
       }
     </script>
    <input type="button" value="Pengeluaran" onClick="myUpload()"/> 
     <script>
       function myUpload() {
         window.location.href="./upload.php";  
       }
     </script>
</form>
<div style="overflow-x:auto;">
  <table>
    <tr>
      <th>Nama</th>
      <th>Stok</th>
      <th>Expired</th>
    </tr>
        <tbody id="data">
        <img id="loader1" src="../assets/loading.gif" alt="loading gif" /> 
  </table>
      </div>

<script>

let host = "http://caricapps.herokuapp.com";

  getData();

  async function getData(){
       const response = await fetch(host+'/v1/kebutuhan/list', {
                                    method: 'GET',
                                    headers: {
                                        'token': 'cocobain123'
                                    }
                                    })
       const results = await response.json();
       hideLoader();
       const data = results.data;
       var temp="";
       try {
          length=data.length;
          for(i=0;i<length;i++)
          {
            temp+="<tr>";
            temp+="<td><a href='./detail.php?id="+data[i].id+"'>"+data[i].nama+"</a></td>";
            temp+="<td>"+data[i].jumlah+"</td>";
            temp+="<td>"+data[i].expired_at+"</td>";
            temp+="</tr>";
          }
        }
        catch(err) {
          temp+="<tr><td colspan='3'><p style='text-align:center'>"+results.pesan+"</b></td></tr>";
        }

    document.getElementById("data").innerHTML=temp;
     }
     
const thisForm = document.getElementById('myForm');
thisForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="../assets/loading.gif" alt="loading gif" />'
    document.getElementById("data").innerHTML=loadnya;
    const formData = new FormData(thisForm).entries()
    const coba = Object.fromEntries(formData)
    const response = await fetch(host+'/v1/kebutuhan/search/'+coba.name, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' }
    });

    const results = await response.json();
       const data = results.data;
       var temp="";
       try {
          length=data.length;
          for(i=0;i<length;i++)
          {
              temp+="<tr>";
              temp+="<td><a href='./detail.php?id="+data[i].id+"'>"+data[i].nama+"</a></td>";
              temp+="<td>"+data[i].jumlah+"</td>";
              temp+="<td>"+data[i].expired_at+"</td>";
              temp+="</tr>";
          }
        }
        catch(err) {
          temp+="<tr>";
          temp+="<td><b>'"+coba.name+"' Tidak Ditemukan</b></td>";
          temp+="</tr>";
        }

    document.getElementById("data").innerHTML=temp;
});



</script>
</body>

</html>