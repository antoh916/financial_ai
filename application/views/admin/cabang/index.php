
<!-- tambah data -->

<button class="btn btn-primary" data-toggle="modal" data-target="#Tambah">
    <i class="fa fa-plus"></i> Tambah
</button>
<div class="modal fade" id="Tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah data?</h4>
            </div>
            <div class="modal-body">
                
            <?php
            // Validasi error
            echo validation_errors('<div class="alert alert-warning">','</div>');

            // Form buka 
            echo form_open(base_url('admin/cabang'));
            ?>

            <div class="form-group">
                <input type="text" name="nama_cabang" class="form-control" placeholder="Nama Cabang" value="<?php echo set_value('nama_cabang') ?>" required>
            </div>

            

            <div class="form-group text-center">
            <input type="submit" name="submit" class="btn btn-success btn-lg" value="Simpan Data">
            </div>
            <div class="clearfix"></div>

            <?php
            // Form close 
            echo form_close();
            ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
                

            </div>
        </div>
    </div>
</div>
<!-- end  tambah data -->


<!-- table kategori barang -->

<table class="table table-bordered table-hover table-striped" id="example1">
    <thead class="bordered-darkorange">
        <tr>
            <th>#</th>
            <th>Nama Cabang</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    <?php $i=1; foreach($cabang as $cabang) { ?>

    <tr class="odd gradeX">
        <td><?php echo $i ?></td>
        <td><?php echo $cabang->nama_cabang ?></td>
        <td>
        
            <a href="<?php echo base_url('admin/cabang/edit/'.$cabang->id_cabang) ?>" 
            class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>

            <a href="<?php echo base_url('admin/cabang/delete/'.$cabang->id_cabang) ?>" 
            class="btn btn-danger btn-xs " onclick="confirmation(event)"><i class="fa fa-trash-o"></i></a>

        </td>
    </tr>

    <?php $i++; } ?>

    </tbody>
</table>

<!-- end table kategori barang -->

<script>
    $(document).ready(function(){
        
    });
</script>