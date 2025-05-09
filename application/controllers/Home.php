<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('konfigurasi_model');
		$this->load->model('berita_model');
		$this->load->model('galeri_model');
		$this->load->model('video_model');
		$this->load->model('agenda_model');
		$this->load->model('kategori_barang_model');
		$this->load->model('barang_model');
		$this->load->model('faq_model');
	}

	public function index()
	{
		$site 			= $this->konfigurasi_model->listing();
		$slider 		= json_encode($this->galeri_model->slider());
		$slide			= $this->galeri_model->slider();
		$popup 			= $this->galeri_model->popup_aktif();
		$headline		= $this->berita_model->listing_headline();
		$galeri 		= $this->galeri_model->galeri_home();
		$kategori_galeri= $this->galeri_model->kategori();
		$video 			= $this->video_model->home();
		$agenda 		= $this->agenda_model->home();
		$layanan 		= $this->nav_model->nav_layanan();
		$profil 		= $this->nav_model->nav_profil();

		$kategori_barang 	= $this->kategori_barang_model->get_kategori_barang()->order_by('nama_kategori','ASC')->get()->result();
		$barang 	        = $this->barang_model->get_barang_detail()->order_by('b.nama_kategori','asc')->get()->result();

		// Berita dan paginasi
		$this->load->library('pagination');
		$config['base_url'] 		= base_url().'home/index/';
		$config['total_rows'] 		= count($this->berita_model->total());
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] 		= 5;
		$config['uri_segment'] 		= 3;
		$config['full_tag_open'] 	= '<ul class="pagination">';
        $config['full_tag_close'] 	= '</ul>';
        $config['first_link'] 		= '&laquo; Awal';
        $config['first_tag_open'] 	= '<li class="prev page">';
        $config['first_tag_close'] 	= '</li>';

        $config['last_link'] 		= 'Akhir &raquo;';
        $config['last_tag_open'] 	= '<li class="next page">';
        $config['last_tag_close'] 	= '</li>';

        $config['next_link'] 		= 'Selanjutnya &rarr;';
        $config['next_tag_open'] 	= '<li class="next page">';
        $config['next_tag_close'] 	= '</li>';

        $config['prev_link'] 		= '&larr; Sebelumnya';
        $config['prev_tag_open'] 	= '<li class="prev page">';
        $config['prev_tag_close'] 	= '</li>';

        $config['cur_tag_open'] 	= '<li class="active"><a href="">';
        $config['cur_tag_close'] 	= '</a></li>';

        $config['num_tag_open'] 	= '<li class="page">';
        $config['num_tag_close'] 	= '</li>';
		$config['per_page'] 		= 8;
		$config['first_url'] 		= base_url().'home/';
		$this->pagination->initialize($config); 
		$page 		= ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;
		$berita 	= $this->berita_model->berita($config['per_page'], $page);

		$data = array(	'title'				=> $site->namaweb.' - '.$site->tagline,
						'deskripsi'			=> $site->deskripsi,
						'keywords'			=> $site->keywords,
						'site'				=> $site,
						'slider'			=> $slider,
						'slide'				=> $slide,
						'headline'			=> $headline,
						'pagin' 			=> $this->pagination->create_links(),
						'berita'			=> $berita,
						'popup'				=> $popup,
						'galeri'			=> $galeri,
						'video'				=> $video,
						'kategori_galeri'	=> $kategori_galeri,
						'agenda'			=> $agenda,
						'layanan'			=> $layanan,
						'profil'			=> $profil,
						'kategori_barang'	=> $kategori_barang,
						'barang'			=> $barang,
						'wa'				=> $site->hp,
						'isi'				=> 'home/list'
			);
		$this->load->view('layout/wrapper', $data);
	}

	// Oops
	public function oops()
	{
		$site 			= $this->konfigurasi_model->listing();

		$data = array(	'title'				=> 'Not found',
						'deskripsi'			=> $site->deskripsi,
						'keywords'			=> $site->keywords,
						'site'				=> $site,
						'isi'				=> 'home/oops'
			);
		$this->load->view('layout/wrapper', $data);
	}

	public function about(){
		$site 			= $this->konfigurasi_model->listing();
		$profil 		= $this->nav_model->nav_profil();
		$data = array(	'title'				=> 'About',
						'deskripsi'			=> $site->deskripsi,
						'keywords'			=> $site->keywords,
						'site'				=> $site,
						'isi'				=> 'home/about',
						'profil'			=> $profil,
						'wa'				=> $site->hp,
			);
		$this->load->view('layout/wrapper', $data);
	}

	public function findStore(){
		$site 			= $this->konfigurasi_model->listing();
		$data = array(	'title'				=> 'Find Store',
						'deskripsi'			=> $site->deskripsi,
						'keywords'			=> $site->keywords,
						'site'				=> $site,
						'isi'				=> 'home/kontak',
			);
		$this->load->view('layout/wrapper', $data);
	}

	public function faq(){
		$site 		= $this->konfigurasi_model->listing();
        $faq 		= $this->faq_model->get_all_faqs();
		$data = array(	'title'				=> 'FAQ',
						'deskripsi'			=> $site->deskripsi,
						'keywords'			=> $site->keywords,
						'site'				=> $site,
						'faqs'				=> $faq,
						'isi'				=> 'home/faq',
			);
		$this->load->view('layout/wrapper', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */