<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	// Load database
	public function __construct()
	{
		parent::__construct();
		$this->load->model('galeri_model');
		$this->load->model('kategori_galeri_model');
        // Load models
        $this->load->model('invoice_model');
        $this->load->model('invoice_detail_model');
		$this->log_user->add_log();
		// Tambahkan proteksi halaman
		$url_pengalihan = str_replace('index.php/', '', current_url());
		$pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
		// Ambil check login dari simple_login
		$this->simple_login->check_login($pengalihan);
	}

	public function save_to_database() {
        
        // This would be your JSON response from the API
        $json_response = '{"responseCode":"00","responseMessage":"Success","data":[{"id":1,"invoiceNumber":"INV-V-2023","orderDate":"2025-03-05","uploadedAt":"2025-05-08T07:19:28.009432","status":"WAITING","uploadedBy":{"username":null},"invoiceDetails":[{"profession":"Application Developer","salary":"5.400.ooo"},{"profession":"Data Analyst","salary":"3.745.ooo"},{"profession":"Database Administrator","salary":"4,900.000"}]}]}';
        
        // Decode the JSON response
        $response = json_decode($json_response);
        
        if ($response && $response->responseCode === "00") {
            // Begin transaction
            $this->db->trans_begin();
            
            try {
                foreach ($response->data as $invoice_data) {
                    // Format the date from the API
                    $order_date = date('Y-m-d', strtotime($invoice_data->orderDate));
                    $uploaded_at = date('Y-m-d H:i:s', strtotime($invoice_data->uploadedAt));
                    
                    // Prepare invoice data for database
                    $invoice = [
                        'external_id' => $invoice_data->id,
                        'invoice_number' => $invoice_data->invoiceNumber,
                        'order_date' => $order_date,
                        'uploaded_at' => $uploaded_at,
                        'status' => $invoice_data->status,
                        'username' => $invoice_data->uploadedBy->username
                    ];
                    
                    // Insert invoice and get the inserted ID
                    $invoice_id = $this->invoice_model->insert($invoice);
                    
                    // Insert invoice details
                    foreach ($invoice_data->invoiceDetails as $detail) {
                        $detail_data = [
                            'invoice_id' => $invoice_id,
                            'profession' => $detail->profession,
                            'salary' => $detail->salary
                        ];
                        
                        $this->invoice_detail_model->insert($detail_data);
                    }
                }
                
                // Commit the transaction
                $this->db->trans_commit();
                echo "Data saved successfully";
                
            } catch (Exception $e) {
                // Rollback the transaction in case of error
                $this->db->trans_rollback();
                echo "Error saving data: " . $e->getMessage();
            }
        } else {
            echo "Invalid response or error code";
        }
    }

	// Halaman galeri
	public function index()	{
		$url = 'http://18.136.200.165/api/mini_project/auth/login';
		$fields = array (
			'username' => 'admin',
			'password' => '123456'
		);
		$fields = json_encode ( $fields );
		$headers = array (
				'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url);
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		$data_login = json_decode($result);
		$this->session->set_userdata('token', $data_login->token);
		$headers = array (
				'Authorization: Bearer ' . $data_login->token,
				'Content-Type: application/json'
		);

		$url2 = 'http://18.136.200.165/api/approve/list';

		$ch = curl_init ();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url2);
		curl_setopt($ch, CURLOPT_HTTPGET, true);  // Changed from POST to GET
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		
		$result_data = curl_exec ( $ch );
		curl_close ( $ch );
		$response = json_decode($result_data);
		if ($response && $response->responseCode === "00") {
            $invoices = $response->data;
        } else {
            // Handle error case
            echo "Error processing data: " . ($response ? $response->responseMessage : "Invalid response");
        }
		// echo json_encode($invoices); exit;
		$data = array(	'title'			=> 'Payment',
						'invoices'		=> $invoices,
						'isi'			=> 'admin/transaction/list');
		$this->load->view('admin/layout/wrapper', $data, FALSE);		
	}

	// Proses
	public function proses()
	{
		// Konfigurasi upload
		$config['upload_path']      = './assets/upload/pdf/';
		$config['allowed_types']    = 'pdf';
		$config['max_size']         = 5000; // dalam KB
		$config['file_ext_tolower'] = TRUE;
		$this->load->library('image_lib', $config);
		redirect(base_url('admin/transaction'),'refresh');

		if (!$this->upload->do_upload('file')) { // 'userfile' adalah nama input file di form
			// Jika upload gagal
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			// Tampilkan error atau redirect dengan pesan error
		} else {
			// Jika upload berhasil
			$upload_data = $this->upload->data();
			$pdf_path = './assets/upload/pdf/'.$upload_data['file_name'];
			
			// Baca file PDF dan konversi ke base64
			$pdf_content = file_get_contents($pdf_path);
			$base64_pdf = base64_encode($pdf_content);
			
			// Simpan base64 string ke session atau database
			$this->session->set_userdata('pdf_base64', $base64_pdf);
			
			// Jika perlu menyimpan data PDF ke database
			$pdf_data = array(
				'pdf_name' => $upload_data['file_name'],
				'pdf_path' => $pdf_path,
				'pdf_base64' => $base64_pdf
				// tambahkan field lain sesuai kebutuhan
			);

			$url = 'http://18.136.200.165/api/ocr/submit';
			$fields = array (
				'username' => 'admin',
				'base64pdf' => $base64_pdf
			);
			$token = $this->session->userdata('token');
			$fields = json_encode ( $fields );
			$headers = array (
					'Content-Type: application/json',
					'Authorization: Bearer ' . $token
			);
			
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $url);
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
			
			$result = curl_exec ( $ch );
			curl_close ( $ch );
	        $this->session->set_flashdata('sukses', 'Data telah diedit');
	        redirect(base_url('admin/transaction'),'refresh');
		}
	}

	// Tambah galeri
	public function tambah(){
		$data = array(	'title'				=> 'Upload Resi',
						'isi'				=> 'admin/transaction/tambah');
		$this->load->view('admin/layout/wrapper', $data, FALSE);		
	}

	// Edit galeri
	public function edit($id_galeri)	{
		$kategori_galeri 	= $this->kategori_galeri_model->listing();
		$galeri 	= $this->galeri_model->detail($id_galeri); 

		// Validasi
		$valid = $this->form_validation;

		$valid->set_rules('judul_galeri','Judul','required',
			array(	'required'	=> 'Judul harus diisi'));

		$valid->set_rules('isi','Isi','required',
			array(	'required'	=> 'Isi galeri harus diisi'));

		if($valid->run()) {

			if(!empty($_FILES['gambar']['name'])) {

			$config['upload_path']   = './assets/upload/image/';
      		$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
      		$config['max_size']      = '12000'; // KB  
			$this->load->library('upload', $config);
      		if(! $this->upload->do_upload('gambar')) {
		// End validasi

		$data = array(	'title'				=> 'Edit Galeri',
						'kategori_galeri'	=> $kategori_galeri,
						'galeri'			=> $galeri,
						'error'    			=> $this->upload->display_errors(),
						'isi'				=> 'admin/galeri/edit');
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		// Masuk database
		}else{
			$upload_data        		= array('uploads' =>$this->upload->data());
	        // Image Editor
	        $config['image_library']  	= 'gd2';
	        $config['source_image']   	= './assets/upload/image/'.$upload_data['uploads']['file_name']; 
	        $config['new_image']     	= './assets/upload/image/thumbs/';
	        $config['create_thumb']   	= TRUE;
	        $config['quality']       	= "100%";
	        $config['maintain_ratio']   = TRUE;
	        $config['width']       		= 360; // Pixel
	        $config['height']       	= 360; // Pixel
	        $config['x_axis']       	= 0;
	        $config['y_axis']       	= 0;
	        $config['thumb_marker']   	= '';
	        $this->load->library('image_lib', $config);
	        $this->image_lib->resize();

	        // Proses hapus gambar
			if($galeri->gambar != "") {
				unlink('./assets/upload/image/'.$galeri->gambar);
				unlink('./assets/upload/image/thumbs/'.$galeri->gambar);
			}
			// End hapus gambar

	        $i 		= $this->input;

	        $data = array(	'id_galeri'			=> $id_galeri,
	        				'id_kategori_galeri'=> $i->post('id_kategori_galeri'),
	        				'id_user'			=> $this->session->userdata('id_user'),
	        				'judul_galeri'		=> $i->post('judul_galeri'),
	        				'isi'				=> $i->post('isi'),
	        				'jenis_galeri'		=> $i->post('jenis_galeri'),
	        				'gambar'			=> $upload_data['uploads']['file_name'],
	        				'website'			=> $i->post('website'),
	        				'status_text'		=> $i->post('status_text'),
	        				'urutan'		=> $i->post('urutan')
	        				);
	        $this->galeri_model->edit($data);
	        $this->session->set_flashdata('sukses', 'Data telah diedit');
	        redirect(base_url('admin/galeri'),'refresh');
		}}else{
			$i 		= $this->input;

	        $data = array(	'id_galeri'			=> $id_galeri,
	        				'id_kategori_galeri'=> $i->post('id_kategori_galeri'),
	        				'id_user'			=> $this->session->userdata('id_user'),
	        				'judul_galeri'		=> $i->post('judul_galeri'),
	        				'isi'				=> $i->post('isi'),
	        				'jenis_galeri'		=> $i->post('jenis_galeri'),
	        				'website'			=> $i->post('website'),
	        				'status_text'		=> $i->post('status_text'),
	        				'urutan'		=> $i->post('urutan')
	        				);
	        $this->galeri_model->edit($data);
	        $this->session->set_flashdata('sukses', 'Data telah diedit');
	        redirect(base_url('admin/galeri'),'refresh');
		}}
		// End masuk database
		$data = array(	'title'				=> 'Edit Galeri',
						'kategori_galeri'	=> $kategori_galeri,
						'galeri'			=> $galeri,
						'isi'				=> 'admin/galeri/edit');
		$this->load->view('admin/layout/wrapper', $data, FALSE);		
	}

	public function approve(){
		$url = 'http://18.136.200.165/api/approve/update';
		$fields = array (
			'id' => '1',
			'status' => 'APPROVED'
		);
		$token = $this->session->userdata('token');
		$fields = json_encode ( $fields );
		$headers = array (
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url);
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		$this->session->set_flashdata('sukses', 'Approved');
		redirect(base_url('admin/transaction'),'refresh');
	}


	// Delete
	public function delete($id_galeri) {
		// Tambahkan proteksi halaman
		$url_pengalihan = str_replace('index.php/', '', current_url());
		$pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
		// Ambil check login dari simple_login
		$this->simple_login->check_login($pengalihan);

		$galeri = $this->galeri_model->detail($id_galeri);
		// Proses hapus gambar
		if($galeri->gambar=="") {
		}else{
			unlink('./assets/upload/image/'.$galeri->gambar);
			unlink('./assets/upload/image/thumbs/'.$galeri->gambar);
		}
		// End hapus gambar
		$data = array('id_galeri'	=> $id_galeri);
		$this->galeri_model->delete($data);
	    $this->session->set_flashdata('sukses', 'Data telah dihapus');
	    redirect(base_url('admin/galeri'),'refresh');
	}
}

/* End of file Galeri.php */
/* Location: ./application/controllers/admin/Galeri.php */