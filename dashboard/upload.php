<form method="POST" action="upload.php" id="profileData" enctype="multipart/form-data">
  <div class="form-row">
    <div class="col">
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input name="firstName" type="text" id="firstName" class="form-control" placeholder="First name">
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input name="lastName" type="text" id="lastName" class="form-control" placeholder="Last name">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="sendimage">Profile Picture</label>
    <input name="sendimage" type="file" class="form-control" id="sendimage">
  </div>
  <div class="form-group">
    <button type="button" id="submit" class="btn btn-outline-primary">Submit</button>
  </div>
</form>
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
});
</script>