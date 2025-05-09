<?php
$posts = [
    [
        'image' => 'assets/images/banner.jpg',
        'category' => 'Technology',
        'title' => 'The Impact of Technology on the Workplace: How Technology is Changing',
        'author' => 'Tracey Wilson',
        'date' => 'August 20, 2022'
    ],
    [
        'image' => 'assets/images/banner.jpg',
        'category' => 'Technology',
        'title' => 'The Impact of Technology on the Workplace: How Technology is Changing',
        'author' => 'Jason Francisco',
        'date' => 'August 20, 2022'
    ],
    [
        'image' => 'assets/images/banner.jpg',
        'category' => 'Technology',
        'title' => 'The Impact of Technology on the Workplace: How Technology is Changing',
        'author' => 'Elizabeth Slavin',
        'date' => 'August 20, 2022'
    ]
];
?>

<link rel="stylesheet" href="assets/css/layanan.css">

<div class="layanan-page">
    <div class="container">
        <div class="header">
            <h2>Latest Post</h2>
            <a href="<?= base_url('berita')?>">View All</a>
        </div>

        <div class="card-grid">
        <?php foreach($berita as $berita) { ?>
            <div class="card">
                <a href="<?php echo base_url('berita/read/' . $berita->slug_berita); ?>">
                    <img src="<?php echo base_url('assets/upload/image/thumbs/' . $berita->gambar); ?>" alt="upcoming-events-img-1" class="img-responsive" />
                </a>
                <div class="card-content">
                    <span class="category"><?= $berita->slug_berita ?></span>
                    <h3><?php echo $berita->judul_berita; ?></h3>
                    <div class="author">
                        <span><?php echo $berita->nama; ?></span> • <span><?php echo date('d', strtotime($berita->tanggal_publish)); ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>