<script>
  $("button").click(function(){
    $("textarea").select();
    document.execCommand('copy');
});
</script>
<p class="btn-group">
  <a href="<?php echo base_url('admin/galeri/tambah') ?>" class="btn btn-success btn-lg">
  <i class="fa fa-plus"></i> Invoice Pembayaran</a>

</p>


<div class="table-responsive mailbox-messages">
<table id="example1" class="display table table-bordered table-hover" cellspacing="0" width="100%">
<thead>
<tr>
    <th>Invoice Number</th>
    <th>Tanggal Invoice</th>
    <th>Status Invoice</th>
    <th width="15%">Action</th>
</tr>
</thead>
<tbody>

<?php if (empty($invoices)): ?>
        <p>No invoices found.</p>
<?php else: ?>
    <?php foreach ($invoices as $invoice): ?>
      <tr class="odd gradeX">
        <td><?php echo htmlspecialchars($invoice->invoiceNumber); ?></td>
        <td><?php echo date('F j, Y', strtotime($invoice->orderDate)); ?></td>
        <td><?php echo $invoice->status; ?></td>
        <td>
          <div class="btn-group">
          <a href="<?php echo base_url('admin/invoice_controller/display/'.$invoice->id) ?>" 
          class="btn btn-success btn-xs" target="_blank"><i class="fa fa-eye"></i></a>

          <a href="<?php echo base_url('admin/galeri/delete/'.$invoice->id) ?>" 
          class="btn btn-danger btn-xs " onclick="confirmation(event)"><i class="fa fa-trash-o"></i></a>
        </div>
        </td>
      </tr>
    <?php endforeach; ?>
<?php endif; ?>

</tbody>
</table>