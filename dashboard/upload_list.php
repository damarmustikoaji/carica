<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>Caricapps - Upload List</title>
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
         window.location.href="./upload.php";  
       }
     </script>
</form>
 <table class="table table-bordered">
    <tr>
    <td>ID</td>
    <td>Nama</td>
    <td>Catatan</td>
    <td>Created</td>
    <td>Preview</td>
</tr>
<img id="loader1" src="../assets/loading.gif" alt="loading gif" /> 
   <tbody id="data">
   </tbody>
</table>   

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
       length=data.length;
       var temp="";
       for(i=0;i<length;i++)
       {
         temp+="<tr>";
         temp+="<td>"+data[i].id+"</td>";
         temp+="<td>"+data[i].name+"</td>";
         temp+="<td>"+data[i].catatan+"</td>";
         temp+="<td>"+data[i].created_at+"</td>";
         temp+="<td><a href='../upload/"+data[i].name+"' target='_blank'><img src='../upload/"+data[i].name+"' width='50' height='60'/></a></td>";
       }

    document.getElementById("data").innerHTML=temp;
     }

</script>
</body>

</html>