
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
echo form_open_multipart(base_url('admin/barang/tambah'));
?>
<div class="row">
    <div class="col-md-4">

        <div class="form-group form-group-lg">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?php echo set_value('nama_barang') ?>">
        </div>

    </div>


    <div class="col-md-4">

        <div class="form-group">
            <label>Kategori Barang</label>
            <select name="id_kategori_barang" class="form-control">

                <?php foreach($kategori_barang as $kategori_barang) { ?>
                <option value="<?php echo $kategori_barang->id_kategori ?>"><?php echo $kategori_barang->nama_kategori ?></option>
                <?php } ?>

            </select>

        </div>
    </div>
    <div class="col-md-4">

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" placeholder="" value="<?php echo set_value('harga') ?>">

        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required="required"><?php echo set_value('deskripsi') ?></textarea>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Upload gambar</label>
            <input type="file" name="gambar" class="form-control" required="required" placeholder="Upload gambar">
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