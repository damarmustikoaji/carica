<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
<title>Caricapps - Upload</title>
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
<form id="myForm">
    <input type="button" value="Kembali" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./";  
       }
     </script>
</form> 

<div style="overflow-x:auto;">
  <table>
    <tr>
      <th>ID</th>
      <th>Kebutuhan</th>
      <th>Tipe</th>
      <th>Pembaharuan</th>
      <th>Balance Akhir</th>
      <th>Created</th>
    </tr>
        <tbody id="data">
        <img id="loader1" src="../assets/loading.gif" alt="loading gif" /> 
  </table>
      </div>

<script>

let host = "https://caricapps.herokuapp.com";

  getData();

  async function getData(){
       const response = await fetch(host+'/v1/kebutuhan/riwayat', {
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
         temp+="<td>"+data[i].id+"</td>";
         temp+="<td>"+data[i].nama+"</td>";
         temp+="<td>"+data[i].tipe+"</td>";
         temp+="<td>"+data[i].jumlah+"</td>";
         temp+="<td>"+data[i].balance_akhir+"</td>";
         temp+="<td>"+data[i].created_at+"</td>";
         temp+="</tr>";
       }
      }
        catch(err) {
          temp+="<tr><td colspan='6'><p style='text-align:center'>"+results.pesan+"</b></td></tr>";
        }


    document.getElementById("data").innerHTML=temp;
     }

</script>
</body>

</html>