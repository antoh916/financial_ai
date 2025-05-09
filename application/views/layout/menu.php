<?php 
$site                       = $this->konfigurasi_model->listing(); 
$site_nav                   = $this->konfigurasi_model->listing();
$nav_profil                 = $this->nav_model->nav_profil();
$nav_download               = $this->nav_model->nav_download();
$nav_berita                 = $this->nav_model->nav_berita();
$nav_agenda                 = $this->nav_model->nav_agenda();
$nav_layanan                = $this->nav_model->nav_layanan();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/css/menu.css') ?>">

<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

<!-- Start Menu -->
<header>
  <div class="bg-main-menu menu-scroll py-3">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo base_url() ?>">
          <img src="<?php echo $this->website->logo() ?>" alt="logo" style="max-height: 50px; width: auto;">
        </a>

        <!-- Search Bar -->
        <div class="search-bar flex-grow-1 mx-4">
          <i class="fas fa-search"></i>
          <input type="text" class="form-control" placeholder="Search">
        </div>

        <!-- Cart -->
        <a href="<?=  base_url('cart'); ?>" class="cart-button">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-info" style="font-weight: bold !important;">
            <?php 
                $cart = $this->session->userdata('cart');

                if($cart == NULL)
                  {
                    echo " 0 Items - Rp. 0 /days";
                  }
                else 
                  {
                    echo $cart['total_product']." Items - Rp. ".number_format($cart['total_harga'],0,",",".")." /days";
                  }
            ?>
           
          </span>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Optional JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>