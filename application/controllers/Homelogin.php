<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homelogin extends CI_Controller {
	public function index()
	{
		$this->load->view('login_user');
	}

public function DoLogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->load->model('blog_rentcar');
		$login = $this->blog_rentcar->login($username, $password);

		if($login->num_rows() == 1){
			foreach ($login->result() as $sess) {
				$sess_data['logged_in2'] = 'LogIn';
				$sess_data['id_user'] = $sess->id;
				$sess_data['username'] = $sess->username;
			}

			$this->session->set_userdata('logged_in2', $sess_data);
			redirect('home', 'refresh');
		}
		else{
			redirect(site_url('login'), 'refresh');
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('home_login', 'refresh');
	}
}