<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function index()
	{
		$this->load->model('category_model');
		$data['categories'] = $this->category_model->get_all_categories();
		$this->load->view('cat_create', $data);
	}

	public function artikel($id)
	{
		$data['page_title'] = $this->category_model->get_category_by_id($id)->cat_mobil;
		$data['all_artikel'] = $this->blog_rentcar->get_artikel_by_category($id);
	}

	public function create()
	{

		$this->load->model('category_model');

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cat_mobil', 'Kategori Mobil', 'required|is_unique[categories.cat_mobil]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Judul ' .$this->input->post('cat_mobil'). ' sudah ada!'
			));
		$this->form_validation->set_rules('description', 'Deskripsi', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			if($this->input->post('simpan'))
		    {
		    	$this->category_model->create_category();	
		    	redirect('category');
		    }    	
		}
		else
		{
			  redirect('category');
		}
		
	}

	public function ubah($id){

		$this->load->model('category_model');
		$data['categories'] = $this->category_model->get_all_categories();

	    if($this->input->post('simpan'))
	    {
	    	$this->category_model->edit($id);
	        redirect('Category');
	    }    	
	    $data['tampil'] = $this->category_model->view_by($id);

	    $this->load->helper('form');
	    $this->load->library('form_validation');

		$this->form_validation->set_rules('cat_mobil', 'Kategori Mobil', 'required|is_unique[categories.cat_mobil]',
		array(
				'required' 		=> 'Harap " %s " di isi agar bisa di simpan',
				'is_unique' 	=> 'Judul ' .$this->input->post('cat_mobil'). ' sudah ada!'
			));
		$this->form_validation->set_rules('description', 'Deskripsi', 'required|max_length[750]',
			array(
				'required' 		=> 'Isi %s, tidak boleh kosong',
				'min_length' 	=> 'text %s belum mencapai limit',
			));

		if ($this->form_validation->run() == TRUE)
		{
			echo "SUKSES";
		}
		else
		{
			  $this->load->view('ubah_kategori', $data);
		}
	 }

	public function hapus($id) 
	{
		$this->load->model('category_model');

	    $this->category_model->delete($id);
	    redirect('category');
	}
}