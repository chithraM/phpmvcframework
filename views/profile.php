<?php
$this->title='Profile';
?>
<h1>Profile</h1>
<form method="post" action="">
  <div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="" required>
  </div>
  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="" required>
  </div>
  <div class="form-group">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
</form>