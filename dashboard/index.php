<html>
<head>
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
</form>
 <table class="table table-bordered">
    <tr>
    <td>Nama</td>
    <td>Stok</td>
    <td>Expired</td>
</tr>
  <img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" /> 
   <tbody id="data">
   </tbody>
</table>   

<script>

let host = "https://caricapps.herokuapp.com";

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
       length=data.length;
       var temp="";
       for(i=0;i<length;i++)
       {
         temp+="<tr>";
         temp+="<td><a href='./detail.php?id="+data[i].id+"'>"+data[i].nama+"</a></td>";
         temp+="<td>"+data[i].jumlah+"</td>";
         temp+="<td>"+data[i].expired_at+"</td>";
       }

    document.getElementById("data").innerHTML=temp;
     }
     
const thisForm = document.getElementById('myForm');
thisForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />'
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
          }
        }
        catch(err) {
          temp+="<tr>";
          temp+="<td><b>'"+coba.name+"' Tidak Ditemukan</b></td>";
        }

    document.getElementById("data").innerHTML=temp;
});



</script>
</body>

</html>