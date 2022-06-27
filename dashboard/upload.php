
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>Caricapps - Upload</title>

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
<form method="POST" action="upload.php" id="profileData" enctype="multipart/form-data">
  <div class="form-row">
    <div class="col">
      <div class="form-group">
        <label for="catatan">Catatan</label>
        <input name="catatan" type="text" id="catatan" class="form-control" placeholder="Catatan">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="sendimage">Upload</label>
    <input name="sendimage" type="file" class="form-control" id="sendimage">
  </div>
  <div class="form-group">
    <button type="button" id="submit" class="btn btn-outline-primary">Submit</button>
  </div>
</form>
<input type="button" value="List" onClick="myFunction()"/> 
     <script>
       function myFunction() {
         window.location.href="./upload_list.php";  
       }
     </script>
<script>
let host = "http://caricapps.herokuapp.com";

const button = document.querySelector('#submit');

button.addEventListener('click', () => {
  const form = new FormData(document.querySelector('#profileData'));
  const url = host+'/v1/upload'
  const request = new Request(url, {
    method: 'POST',
    headers: { 'token': 'cocobain123' },
    body: form
  });

  fetch(request)
    .then(response => response.json())
    // .then(data => { console.log(data); })

document.getElementById("profileData").reset();
});
</script>