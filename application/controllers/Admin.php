<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	var $data;

	public function __construct()
 	{
 		parent::__construct();
 		// Do your magic here
 		$this->load->library('session');
 		// $this->load->model('m_global');
		if($this->session->userdata('logged_in')){
			$sess_data = $this->session->userdata('logged_in');
			$this->data = array(
				'username' => $sess_data['username'],
				'id' => $sess_data['id'],

			);
			// $this->$data['nama'] = $sess_data['nama'];
			// $this->$data['id'] = $sess_data['id_user'];
		}else{
			// redirect('login','refresh');
			
		}
 	}

// READ
	public function index()
	{
		$this->load->view('dashboard');
	}
	public function tampil_admin()
	{
		$this->load->model('blog_rentcar');
		$data['tampil'] = $this->blog_rentcar->tampil();
		$this->load->view('admin', $data);
	}
	public function tampil_user()
	{
		$this->load->model('blog_rentcar');
		$data['tampil_user'] = $this->blog_rentcar->tampil_user();
		$this->load->view('user', $data);
	}
	public function tampil_car()
	{
		$this->load->model('blog_rentcar');
		$data['tampil_car'] = $this->blog_rentcar->tampil_car();
		$this->load->view('car', $data);
	}
	public function tampil_driver()
	{
		$this->load->model('blog_rentcar');
		$data['tampil_driver'] = $this->blog_rentcar->tampil_driver();
		$this->load->view('driver', $data);
	}
	public function tampil_kategori()
	{
		$this->load->model('blog_rentcar');
		$data['tampil_kategori'] = $this->blog_rentcar->tampil_kategori();
		$this->load->view('categories', $data);
	}

	// CREAT
	public function tambah_admin()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->model('blog_rentcar');
		$data = array();

		$this->form_validation->set_rules('input_username', 'Username', 'required|is_unique[login.username]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Judul ' .$this->input->post('input_username'). ' sudah ada!'
			));
		$this->form_validation->set_rules('input_password', 'Password', 'required');
		$this->form_validation->set_rules('input_email', 'Email', 'required');
		$this->form_validation->set_rules('input_no_telp', 'Contact', 'required|numeric|min_length[12]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_alamat', 'Alamat', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			if ($this->input->post('simpan'))
			{
				$this->blog_rentcar->insert();
				redirect('admin/tampil_admin');
			}
		}
		else
		{
			$this->load->view('tambah_admin', $data);
		}
	}

	public function tambah_user()
	{
		$this->load->model('blog_rentcar');
		$data = array();

		if ($this->input->post('simpan'))
		{
			$upload = $this->blog_rentcar->upload();

			if ($upload['result'] == 'success')
			{
				$this->blog_rentcar->insert_user($upload);
				redirect('admin/tampil_user');
			}
			else
			{
				$data['messege'] = $upload['error'];
			}
		}

		$this->load->view('tambah_user', $data);
	}

	public function tambah_car()
	{
		$this->load->model('category_model');
		$this->load->model('blog_rentcar');
		$data = array();
		$data['categories'] = $this->category_model->get_all_categories();

		if ($this->input->post('simpan'))
		{
			$upload = $this->blog_rentcar->upload();

			if ($upload['result'] == 'success')
			{
				$this->blog_rentcar->insert_car($upload);
				redirect('admin/tampil_car');
			}
			else
			{
				$data['messege'] = $upload['error'];
			}
		}

		$this->load->view('tambah_car', $data);
	}

	public function tambah_driver()
	{
		$this->load->model('blog_rentcar');
		$data = array();

		if ($this->input->post('simpan'))
		{
			$upload = $this->blog_rentcar->upload();

			if ($upload['result'] == 'success')
			{
				$this->blog_rentcar->insert_driver($upload);
				redirect('admin/tampil_driver');
			}
			else
			{
				$data['messege'] = $upload['error'];
			}
		}

		$this->load->view('tambah_driver', $data);
	}

//UPDATE
	public function ubah($id){

		$this->load->model('blog_rentcar');

	    if($this->input->post('simpan'))
		    {
		    	$this->blog_rentcar->update($id);
		        redirect('admin/tampil_admin');
		    } 
		    $data['tampil'] = $this->blog_rentcar->view_by($id);

	    $this->load->helper('form');
	    $this->load->library('form_validation');

		$this->form_validation->set_rules('input_username', 'Username', 'required|is_unique[login.username]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Username ' .$this->input->post('input_judul'). ' sudah ada!'
			));
		$this->form_validation->set_rules('input_password', 'Password', 'required|max_length[50]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'text %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_email', 'Email', 'required');
		$this->form_validation->set_rules('input_no_telp', 'No HP', 'required|numeric|min_length[12]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_alamat', 'Alamat', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			echo "SUKSES";
		}
		else
		{
			$this->load->view('ubah_admin', $data);
		}
	 }

	public function ubah_user($id){

		$this->load->model('blog_rentcar');

	    if($this->input->post('simpan'))
		    {
		    	$upload=$this->blog_rentcar->upload();
		    	$this->blog_rentcar->update_user($upload, $id);
		        redirect('admin/tampil_user');
		    } 
		    $data['tampil'] = $this->blog_rentcar->view_by_user($id);

	    $this->load->helper('form');
	    $this->load->library('form_validation');

		$this->form_validation->set_rules('input_username', 'Username', 'required|is_unique[user.username]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Username ' .$this->input->post('input_username'). ' sudah ada!'
			));
		$this->form_validation->set_rules('input_alamat', 'Alamat', 'required|max_length[50]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'text %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_no_telp', 'No HP', 'required|numeric|min_length[12]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_email', 'Email', 'required');
		$this->form_validation->set_rules('input_birth', 'Birth', 'required');
		$this->form_validation->set_rules('input_password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			echo "SUKSES";
		}
		else
		{
			$this->load->view('ubah_user', $data);
		}
	 }

	public function ubah_car($id){

		$this->load->model('blog_rentcar');
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->get_all_categories();


	    if($this->input->post('simpan'))
		    {
		    	$upload=$this->blog_rentcar->upload();
		    	$this->blog_rentcar->update_car($upload, $id);
		        redirect('admin/tampil_car');
		    } 
		    $data['tampil'] = $this->blog_rentcar->view_by_car($id);

	    $this->load->helper('form');
	    $this->load->library('form_validation');

		$this->form_validation->set_rules('input_no_polisi', 'No Polisi', 'required|is_unique[car.no_polisi]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Username ' .$this->input->post('input_no_polisi'). ' sudah ada!'
			));
		$this->form_validation->set_rules('input_merk', 'Merk', 'required|max_length[50]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'text %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_jenis_mobil', 'Jenis Mobil', 'required');
		$this->form_validation->set_rules('input_warna_mobil', 'Warna Mobil', 'required');
		$this->form_validation->set_rules('input_tahun_mobil', 'Tahun Mobil', 'required|numeric|min_length[4]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_bahan_bakar', 'Bahan Bakar', 'required');
		$this->form_validation->set_rules('input_price', 'Price', 'required|numeric|max_length[10]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));

		if ($this->form_validation->run() == TRUE)
		{
			echo "SUKSES";
		}
		else
		{
			$this->load->view('ubah_car', $data);
		}
	 }

	 public function ubah_driver($id){

		$this->load->model('blog_rentcar');

	    if($this->input->post('simpan'))
		    {
		    	$upload=$this->blog_rentcar->upload();
		    	$this->blog_rentcar->update_driver($upload, $id);
		        redirect('admin/tampil_driver');
		    } 
		    $data['tampil'] = $this->blog_rentcar->view_by_driver($id);

	    $this->load->helper('form');
	    $this->load->library('form_validation');

		$this->form_validation->set_rules('input_username', 'Username', 'required|is_unique[user.username]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Username ' .$this->input->post('input_username'). ' sudah ada!'
			));
		$this->form_validation->set_rules('input_alamat', 'Alamat', 'required|max_length[50]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'text %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_no_telp', 'No HP', 'required|numeric|min_length[12]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'angka %s belum mencapai limit',
			));
		$this->form_validation->set_rules('input_email', 'Email', 'required');
		$this->form_validation->set_rules('input_umur', 'Umur', 'required');
		$this->form_validation->set_rules('input_price', 'Price', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			echo "SUKSES";
		}
		else
		{
			$this->load->view('ubah_driver', $data);
		}
	 }

//DELETE
	public function hapus($id) //ADMIN
	{
		$this->load->model('blog_rentcar');

	    $this->blog_rentcar->delete($id);
	    redirect('admin/tampil_admin');
	}
	public function hapus_user($id) //ADMIN
	{
		$this->load->model('blog_rentcar');

	    $this->blog_rentcar->delete_user($id);
	    redirect('admin/tampil_user');
	}
	public function hapus_car($id) //ADMIN
	{
		$this->load->model('blog_rentcar');

	    $this->blog_rentcar->delete_car($id);
	    redirect('admin/tampil_car');
	}
	public function hapus_driver($id) //ADMIN
	{
		$this->load->model('blog_rentcar');

	    $this->blog_rentcar->delete_driver($id);
	    redirect('admin/tampil_driver');
	}
}
?>