<html>
<head>
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>Caricapps - Riwayat</title>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
 <table class="table table-bordered">
    <tr>
    <td>ID</td>
    <td>Kebutuhan</td>
    <td>Tipe</td>
    <td>Pembaharuan</td>
    <td>Balance Akhir</td>
    <td>Created</td>
</tr>
<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" /> 
   <tbody id="data">
   </tbody>
</table>   

<script>

let host = "http://caricapps.herokuapp.com";

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
       length=data.length;
       var temp="";
       for(i=0;i<length;i++)
       {
         temp+="<tr>";
         temp+="<td>"+data[i].id+"</td>";
         temp+="<td>"+data[i].nama+"</td>";
         temp+="<td>"+data[i].tipe+"</td>";
         temp+="<td>"+data[i].jumlah+"</td>";
         temp+="<td>"+data[i].balance_akhir+"</td>";
         temp+="<td>"+data[i].created_at+"</td>";
       }

    document.getElementById("data").innerHTML=temp;
     }

</script>
</body>

</html>