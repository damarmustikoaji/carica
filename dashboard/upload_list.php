<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
<title>Caricapps - Pengeluaran</title>
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

<h2>Daftar Upload</h2>
<input type="button" value="Kembali" onClick="kembali()"/> 
        <script>
        function kembali() {
            window.location.href="./";  
        }
    </script>

<div style="overflow-x:auto;">
  <table>
    <tr>
      <th>Created</th>
      <th>Nominal</th>
      <th>Catatan</th>
      <th>Lampiran</th>
    </tr>
    <tr>
        <tbody id="data">
        <img id="loader1" src="../assets/loading.gif" alt="loading gif" /> 
    </tr>
  </table>
</div>

</body>
<script>

let host = "http://caricapps.herokuapp.com";

  getData();

  async function getData(){
       const response = await fetch(host+'/v1/upload/list', {
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
                temp+="<td>"+data[i].created_at+"</td>";
                temp+="<td>"+data[i].nominal+"</td>";
                temp+="<td>"+data[i].catatan+"</td>";
                temp+="<td><a href='../bukti/"+data[i].name+"' target='_blank'><img src='../bukti/"+data[i].name+"' width='50' height='60'/></a></td>";
            }
        }
        catch(err) {
          temp+="<tr><td colspan='4'><p style='text-align:center'>"+results.pesan+"</b></td></tr>";

        }


    document.getElementById("data").innerHTML=temp;
     }

</script>
</html>
