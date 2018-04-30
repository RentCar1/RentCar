<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('blog_rentcar');
		$data['tampil'] = $this->blog_rentcar->tampil_driver();
		$data['tampil_mobil'] = $this->blog_rentcar->tampil_car();
		$this->load->view('index',$data);
	}
	public function home_login() //LOGIN USER
	{
		$this->load->view('home_login2');
	}

}