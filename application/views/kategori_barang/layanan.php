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
            <a href="#">View All</a>
        </div>

        <div class="card-grid">
            <?php foreach ($posts as $post) : ?>
                <div class="card">
                    <img src="<?= base_url($post['image']); ?>" alt="<?= $post['title'] ?>">
                    <div class="card-content">
                        <span class="category"><?= $post['category'] ?></span>
                        <h3><?= $post['title'] ?></h3>
                        <div class="author">
                            <span><?= $post['author'] ?></span> • <span><?= $post['date'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>