<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    
    body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        color: #333;
        line-height: 1.6;
    }
    
    .section {
        margin-bottom: 50px;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: 600;
    }
    
    .about-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        font-size: 15px;
        margin-bottom: 40px;
    }
    
    .info-block {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
        gap: 30px;
    }
    
    .info-block.reverse {
        flex-direction: row-reverse;
    }
    
    .info-text {
        flex: 1;
    }
    
    .info-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .info-description {
        font-size: 14px;
        color: #555;
    }
    
    .info-image {
        flex: 1;
        max-width: 50%;
    }
    
    .info-image img {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .clients {
        text-align: center;
    }
    
    .clients-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin: 30px 0;
    }
    
    .client-logo {
        width: 150px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .client-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .client-text {
        font-size: 14px;
        color: #666;
        margin-bottom: 30px;
    }
    
    .cta-section {
        background-color: #e7f7f9;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .cta-text {
        flex: 2;
        text-align: left;
        padding-right: 20px;
    }
    
    .cta-title {
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .cta-description {
        font-size: 14px;
        color: #555;
        margin-bottom: 20px;
    }
    
    .cta-button {
        background-color: #0CA4AD;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }
    
    .cta-image {
        flex: 1;
        max-width: 200px;
    }
    
    .cta-image img {
        width: 100%;
    }
    
    @media (max-width: 768px) {
        .info-block, .info-block.reverse {
            flex-direction: column;
            text-align: center;
        }
        
        .info-image {
            max-width: 100%;
            height: 50px;
            margin-top: 20px;
        }
        
        .cta-section {
            flex-direction: column;
        }
        
        .cta-text {
            text-align: center;
            padding-right: 0;
            margin-bottom: 20px;
        }
    }
</style>
<div class="section">
    <h2 class="section-title">Tentang Kami</h2>
    <p class="about-content">
        Colony Communication adalah sebuah usaha yang menyediakan peralatan untuk segala jenis acara dengan produk unggulan HT dan Command Center. Kami menyediakan solusi komunikasi profesional dengan layanan terbaik untuk mendukung kesuksesan acara dan pertunjukan multimedia dalam berbagai bentuk, baik EO, maupun dll.
    </p>
</div>

<div class="section">
    <div class="info-block">
        <div class="info-text">
            <h3 class="info-title">Colony Communication</h3>
            <p class="info-description">
                Telah dipercaya sebagai mitra strategis dalam menyediakan berbagai bunta kebutuhan internal dan eksekusi acara perusahaan. Kami selalu memastikan solusi komunikasi terbaik yang disesuaikan khusus untuk kebutuhan teknis setiap acara.
            </p>
            <p class="info-description">
                Kami berkomitmen untuk memberikan bahasa setiap klien dengan baik dan memastikan pelayanan serta memprioritaskan kesan mendalam bagi semua peserta.
            </p>
        </div>
        <div class="info-image">
            <img src="<?= base_url('assets/upload/image/event1.png'); ?>" alt="Tim Colony Communication">
        </div>
    </div>
</div>

<div class="section">
    <div class="info-block reverse">
        <div class="info-text">
            <h3 class="info-title">Mendukung Segala Jenis Acara</h3>
            <p class="info-description">
                Colony Communication telah banyak melayani perusahaan dan berbagai acara sebagai mitra yang teruji mendukung berbagai jenis acara korporasi, konferensi hingga festival musik.
            </p>
            <p class="info-description">
                Dengan tim handal dan teknisi yang telah berpengalaman dalam bidang acara skala kecil hingga sangat profesional dan mendukung setidp momen berbikir dan sukses.
            </p>
        </div>
        <div class="info-image">
            <img src="<?= base_url('assets/upload/image/event2.png'); ?>" alt="Dukungan Event">
        </div>
    </div>
</div>

<div class="section clients">
    <h2 class="section-title">Client Kami</h2>
    <div class="clients-grid">
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client1.png'); ?>" alt="World Islamic Forum">
        </div>
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client2.png'); ?>" alt="PON XX Papua 2020">
        </div>
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client3.png'); ?>" alt="2018 Indonesia International Motor Show">
        </div>
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client4.png'); ?>" alt="Mangkunegaran">
        </div>
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client5.png'); ?>" alt="Mandalika GP Series">
        </div>
        <div class="client-logo">
            <img src="<?= base_url('assets/upload/image/client6.png'); ?>" alt="Asian Games 2018">
        </div>
    </div>
    <p class="client-text">
        Masih ada lebih dari 1000 client yang telah puas dengan pelayanan Colony Communication
    </p>
</div>

<div class="section">
    <div class="cta-section">
        <div class="cta-text">
            <h3 class="cta-title">Colony Communication</h3>
            <p class="cta-description">Semua alat satu tempat</p>
            <p class="cta-description">Solusi lengkap untuk kebutuhan rental HT, intercom, multimedia dan command center</p>
            <a href="https://wa.me/<?= $wa?>" class="cta-button">Chat via WhatsApp sekarang</a>
        </div>
        <div class="cta-image">
            <img src="<?= base_url('assets/upload/image/people.png'); ?>" alt="Peralatan Komunikasi">
        </div>
    </div>
</div>