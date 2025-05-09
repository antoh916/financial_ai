<script>
  $("button").click(function(){
    $("textarea").select();
    document.execCommand('copy');
});
</script>
<?php
echo form_open(base_url('admin/barang/proses'));
?>
<p class="btn-group">
  <a href="<?php echo base_url('admin/barang/tambah') ?>" class="btn btn-success btn-lg">
  <i class="fa fa-plus"></i> Tambah Barang</a>

  <button class="btn btn-danger" type="submit" name="hapus" onClick="check();" >
      <i class="fa fa-trash-o"></i> Hapus
    </button> 

</p>


<div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered table-hover" cellspacing="0" width="100%">
<thead>
<tr>
    <th>
        <div class="mailbox-controls">
            <!-- Check all button -->
            <button type="button" class="btn btn-default btn-xs checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
        </div>
    </th>
    <th>Gambar</th>
    <th>Nama Barang</th>
    <th>Kategori</th>
    <th>Deskripsi</th>
    <th>Harga</th>
  
    <th width="15%">Action</th>
</tr>
</thead>
<tbody>

<?php $i=1; foreach($barang as $barang) { ?>

<tr class="odd gradeX">
    <td>
      <div class="mailbox-star text-center"><div class="text-center">
        <input type="checkbox" class="icheckbox_flat-blue " name="id_barang[]" value="<?php echo $barang->id_barang ?>">
        <span class="checkmark"></span>
      </div>
    </td>
    <td>
      <img src="<?php echo base_url('assets/upload/barang/'.$barang->gambar) ?>" width="60">
    </td>
    
    </td>
    <td><?php echo $barang->nama_barang ?></td>
    <td><?php echo $barang->nama_kategori ?></td>
    <td><?php echo $barang->deskripsi ?></td>
    <td><?php echo $barang->harga ?></td>
    
    <td>
      <div class="btn-group">
      <a href="<?php echo base_url('product/detail/'.$barang->id_barang) ?>" 
      class="btn btn-success btn-xs" target="_blank"><i class="fa fa-eye"></i></a>

      <a href="<?php echo base_url('admin/barang/edit/'.$barang->id_barang) ?>" 
      class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>

       <a href="<?php echo base_url('admin/barang/delete/'.$barang->id_barang) ?>" 
      class="btn btn-danger btn-xs " onclick="confirmation(event)"><i class="fa fa-trash-o"></i></a>
    </div>
    </td>
</tr>

<?php $i++; } ?>

</tbody>
</table>