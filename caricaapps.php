<html>
<head>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
 <table class="table table-bordered">
    <tr>
    <td>nama</td>
    <td>stok</td>
</tr>
   <tbody id="data">
   </tbody>
</table>   

<script>

  getData();

  async function getData(){
       const response = await fetch('https://caricapps.herokuapp.com/v1/kebutuhan/list', {
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
          temp+="<tr>";
          temp+="<td>"+data[i].nama+"</td>";
          temp+="<td>"+data[i].jumlah+"</td>";
       }

    document.getElementById("data").innerHTML=temp;
     }

</script>
</body>

</html>