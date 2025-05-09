<?php
$slides = json_decode($slider,true);
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/slider2.css') ?>">
<div class="slider-container">
    <div class="slider-wrapper">
        <?php foreach($slides as $index => $image): ?>
        <div class="slide <?= ($index == 0) ? 'active' : ''; ?>">
            <img src="<?= base_url('assets/upload/image/'.$image['gambar']); ?>" alt="<?= $image['judul_galeri']; ?>">
            <div class="slide-content">
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="slider-navigation">
        <button class="prev-btn"><i class="fa fa-chevron-left"></i></button>
        <div class="slider-indicators">
            <?php for($i = 0; $i < count($slides); $i++): ?>
            <span class="indicator <?= ($i == 0) ? 'active' : ''; ?>" data-index="<?= $i; ?>"></span>
            <?php endfor; ?>
        </div>
        <button class="next-btn"><i class="fa fa-chevron-right"></i></button>
    </div>
</div>