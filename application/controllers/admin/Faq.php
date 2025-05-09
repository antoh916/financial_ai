<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		// Tambahkan proteksi halaman
		$url_pengalihan = str_replace('index.php/', '', current_url());
		$pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
		// Ambil check login dari simple_login
		$this->simple_login->check_login($pengalihan);
        $this->load->model('faq_model');
	}

	// Halaman utama
	public function index()
	{
        $faq = $this->faq_model->get_all_faqs();

		$data = array(	'title'		=> 'FAQ Management',
						'faqs'	=> $faq,
						'isi'		=> 'admin/faq/list'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}
    
    public function create() {
        // Validasi
		$validasi = $this->form_validation;

        $validasi->set_rules('question','Question','required',
            array(	'required'		=> '%s harus diisi'));

        $validasi->set_rules('answer','Answer','required',
            array(	'required'		=> '%s harus diisi'));

        $validasi->set_rules('category','Category','required',
            array(	'required'		=> '%s harus diisi'));

		if($validasi->run()===FALSE) {
		// End validasi

            $data = array(	'title'		=> 'Tambah FAQ Baru',
                            'isi'		=> 'admin/faq/tambah'
                        );
            $this->load->view('admin/layout/wrapper', $data, FALSE);
		// Masuk ke database
		}else{
			$inp = $this->input;

            $data = [
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer'),
                'category' => $this->input->post('category'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'order_number' => $this->input->post('order_number')
            ];
            
            $this->faq_model->add_faq($data);
			$this->session->set_flashdata('sukses', 'Data telah ditambahkan');
			redirect(base_url('admin/faq'),'refresh');
		}
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data = array(	
                        'title'		=> 'Add New FAQ',
						'isi'	=> 'admin/faq/tambah'
            );
            $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            $data = [
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer'),
                'category' => $this->input->post('category'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'order_number' => $this->input->post('order_number')
            ];
            
            $this->faq_model->add_faq($data);
            redirect('faq/admin');
        }
    }

    public function edit($id = NULL) {
        // Check for admin authorization here
        
        if($id == NULL) {
            redirect('faq/admin');
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit FAQ';
            $faq = $this->faq_model->get_faq_by_id($id);
            $data = array(	'title'		=> 'Edit FAQ',
                            'faq'		=> $faq,
                            'isi'		=> 'admin/faq/edit'
                        );
            if(empty($data['faq'])) {
                show_404();
            }
        
            $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            $data = [
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer'),
                'category' => $this->input->post('category'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'order_number' => $this->input->post('order_number')
            ];
            
            $this->faq_model->update_faq($id, $data);
            redirect('admin/faq');
        }
    }
    
    public function delete($id = NULL) {
        // Check for admin authorization here
        
        if($id == NULL) {
            redirect('faq/admin');
        }
        
        $this->faq_model->delete_faq($id);
        redirect('admin/faq');
    }
}