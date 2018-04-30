<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		$this->load->view('login');
	}
	public function DoLogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->load->model('blog_rentcar');
		$login = $this->blog_rentcar->login($username, $password);

		if($login->num_rows() == 1){
			foreach ($login->result() as $sess) {
				$sess_data['logged_in'] = 'LogIn';
				$sess_data['id'] = $sess->id;
				$sess_data['username'] = $sess->username;
			}

			$this->session->set_userdata('logged_in2', $sess_data);
			redirect('admin', 'refresh');
		}
		else{
			redirect(site_url('login'), 'refresh');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}