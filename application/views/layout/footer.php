<?php
$site = $this->konfigurasi_model->listing();
?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/footer.css') ?>">

<footer class="custom-footer">
  <div class="footer-container">
    <div class="footer-col">
      <h4>Information</h4>
      <ul>
        <li><a href="#">Delivery Information</a></li>
        <li><a href="#">How to rent</a></li>
        <li><a href="#">Terms of Service</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Customer Services</h4>
      <ul>
        <li><a href="<?= base_url('home/findStore/'); ?>">Contact us</a></li>
        <li><a href="#">Site Map</a></li>
        <li><a href="<?= base_url('home/faq/')?>">FAQ</a></li>
      </ul>
    </div>
  </div>
</footer>