<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fas fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
<?php flash('register_success'); ?>
  <h2>Add a Post</h2>
  <p>Fill out the form for creating a new post.</p>
  <form action="<?php echo URLROOT ?>/posts/add" method="post">
    <div class="form-group">
      <label for="title">Title: <sup>*</sup></label>
      <!-- is-invalid class added if the 'email_err' index has a value in it -->
      <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['err_title'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
      <span class="invalid-feedback"><?php echo $data['err_title']; ?></span>
    </div>
    <div class="form-group">
      <label for="body">Body: <sup>*</sup></label>
      <!-- is-invalid class added if the 'err_password' index has a value in it -->
      <textarea type="text" name="body" class="form-control form-control-lg <?php echo (!empty($data['err_body'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
      <span class="invalid-feedback"><?php echo $data['err_body']; ?></span>
    </div>
    <input type="submit" class="btn btn-success" value="Submit">
  </form>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>