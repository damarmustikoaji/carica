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
 <table class="table table-bordered">
    <tr>
    <td>Nama</td>
    <td>Stok</td>
    <td>Kategori</td>
    <td>Expired</td>
</tr>
<input type="button" value="Kembali" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./";  
       }
     </script>
<form id="myGunakan">
    <input id="gunakan" type="submit" value="Gunakan">
</form>
<form id="myRestok">
    <input id="restok" type="submit" value="Restok">
</form>
<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />
<form id="myEdit">
  <tbody id="data"></tbody>
  <input id="edit" type="submit" value="Edit">
</form>
<form id="myHapus">
  <input id="hapus" type="submit" value="Hapus">
</form>
</table>   
<div id="notavailable"></div>
<script>

    let host = "https://caricapps.herokuapp.com";

    let idDetail = "<?php echo $_GET['id'];?>";
    let balance_akhir;

  getData();

  async function getData(){
       const response = await fetch(host+'/v1/kebutuhan/detail/'+idDetail, {
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
         temp+='<input type="text" id="idEdit" name="id" value="'+data[i].id+'" placeholder="nama" hidden>';
         temp+='<td><input type="text" id="nama" name="nama" value="'+data[i].nama+'" placeholder="nama" required></td>';
         temp+='<td><input type="text" id="jumlah" name="jumlah" value="'+data[i].jumlah+'" placeholder="jumlah" disabled></td>';
         temp+='<td><input type="text" id="kategori" name="kategori" value="'+data[i].kategori+'" placeholder="kategori" required></td>';
         temp+='<td><input type="text" id="expired" name="expired" value="'+data[i].expired_at+'" placeholder="expired (22/08/13)" required></td>';
         balance_akhir = data[i].jumlah;
       }

    document.getElementById("data").innerHTML=temp;
     }

const thisFormGunakan = document.getElementById('myGunakan');
thisFormGunakan.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />'
    document.getElementById("data").innerHTML=loadnya;
    const response = await fetch(host+'/v1/kebutuhan/stok/<?php echo $_GET['id'];?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' },
        body: JSON.stringify({
            'balance_akhir': balance_akhir,
            'jumlah': 1,
            'tipe': 'digunakan'
        })
    });

    const results = await response.json();
    if (results.status != "00") {
        var temp= "";
        alert(results.pesan);
        window.location.href="./detail.php?id="+idDetail;
    } else {
        window.location.href="./detail.php?id="+idDetail;
    }
})

const thisFormRestok = document.getElementById('myRestok');
thisFormRestok.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />'
    document.getElementById("data").innerHTML=loadnya;
    const response = await fetch(host+'/v1/kebutuhan/stok/'+idDetail, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' },
        body: JSON.stringify({
            'balance_akhir': balance_akhir,
            'jumlah': 1,
            'tipe': 'restok'
        })
    });

    const results = await response.json();
    window.location.href="./detail.php?id="+idDetail;
})

const thisFormEdit = document.getElementById('myEdit');
thisFormEdit.addEventListener('submit', async function (e) {
    e.preventDefault();
    const namaValue = document.getElementById("nama").value; 
    const kategoriValue = document.getElementById("kategori").value; 
    var loadnya = '<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />'
    document.getElementById("data").innerHTML=loadnya;
    const response = await fetch(host+'/v1/kebutuhan/edit/'+idDetail, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' },
        body: JSON.stringify({
            'nama': namaValue,
            'kategori': kategoriValue
        })
    });

    const results = await response.json();
    window.location.href="./detail.php?id="+idDetail;
})

const thisFormHapus = document.getElementById('myHapus');
thisFormHapus.addEventListener('submit', async function (e) {
    e.preventDefault();
    var loadnya = '<img id="loader1" src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="loading gif" />'
    document.getElementById("data").innerHTML=loadnya;
    const response = await fetch(host+'/v1/kebutuhan/hapus/'+idDetail, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'token': 'cocobain123' }
    });

    const results = await response.json();
    window.location.href="./";
})

</script>
</body>

</html>