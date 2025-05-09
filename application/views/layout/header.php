<?php
$site = $this->konfigurasi_model->listing();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/header.css') ?>">

<div class="box-layout">
    <div class="bg-header-top">
        <div class="container">
            <div class="nav-links">
                <a href="<?= base_url('home/findStore/'); ?>">Kontak Kami</a>
                <a href="<?= base_url('home/about/'); ?>">
                    Tentang Kami
                </a>
                <a href="<?= base_url('berita')?>">Artikel</a>
            </div>
        </div>
    </div>
</div>