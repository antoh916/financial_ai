
<?php
// Validasi error
echo validation_errors('<div class="alert alert-warning">','</div>');

// Error upload
if(isset($error)) {
	echo '<div class="alert alert-warning">';
	echo $error;
	echo '</div>';
}

// Form open
echo form_open_multipart(base_url('admin/transaction/proses'));
?>
<div class="row">

<div class="col-md-4">
<div class="form-group">
<label>Upload pdf</label>
<input type="file" name="file" class="form-control" required="required" placeholder="Upload PDF">
</div>
</div>

<div class="col-md-12">

<div class="form-group">
<input type="submit" name="submit" class="btn btn-success btn-lg" value="Simpan Data">
<input type="reset" name="reset" class="btn btn-default btn-lg" value="Reset">
</div>

</div>
</div>
<?php
// Form close
echo form_close();
?>