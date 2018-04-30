<?php
class Blog_rentcar extends CI_Model {

	public function tampil()
	{
		$this->db->select('*');
		$query = $this->db->get('login');
		return $query->result();
	}
	public function tampil_user()
	{
		$this->db->select('*');
		$query = $this->db->get('user');
		return $query->result();
	}
	public function tampil_car()
	{
		$this->db->select('*');
		$this->db->from('car');
		// $query = $this->db->get('car');
		// return $query->result();
		// $this->db->join('categories', 'car.id_cat= categories.id_cat');
		return $this->db->get()->result();
	}
	public function tampil_driver()
	{
		$this->db->select('*');
		$query = $this->db->get('driver');
		return $query->result();
	}
	public function tampil_kategori()
	{
		$this->db->select('*');
		$query = $this->db->get('categories');
		return $query->result();
	}

// CREATE
	public function upload()
	{
		$config['upload_path'] = './assets/picture/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '2048';
		$config['remove_space'] = TRUE;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('input_gambar')) {
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}
		else
		{
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function insert() //ADMIN
	{
		$data = array(
			'id' => '',
			'username' => $this->input->post('input_username'),
			'password' => $this->input->post('input_password'),
			'email' => $this->input->post('input_email'),
			'no_telp' => $this->input->post('input_no_telp'),
			'alamat' => $this->input->post('input_alamat'),
			'level' => '1'
		);

		$this->db->insert('login', $data);
	}

	public function insert_user($upload) //USER
	{
		$data = array(
			'id_user' => '',
			'username' => $this->input->post('input_username'),
			'alamat' => $this->input->post('input_alamat'),
			'no_telp' => $this->input->post('input_no_telp'),
			'email' => $this->input->post('input_email'),
			'birth' => $this->input->post('input_birth'),
			'password' => $this->input->post('input_password'),
			'img' => $upload['file']['file_name']
		);

		$this->db->insert('user', $data);
	}

	public function insert_car($upload) //CAR
	{
		$data = array(
			'id_mobil' => '',
			'no_polisi' => $this->input->post('input_no_polisi'),
			'merk' => $this->input->post('input_merk'),
			'jenis_mobil' => $this->input->post('input_jenis_mobil'),
			'warna_mobil' => $this->input->post('input_warna_mobil'),
			'tahun_mobil' => $this->input->post('input_tahun_mobil'),
			'bahan_bakar' => $this->input->post('input_bahan_bakar'),
			'price' => $this->input->post('input_price'),
			'img' => $upload['file']['file_name']
		);

		$this->db->insert('car', $data);
	}

	public function insert_driver($upload) //DRIVER
	{
		$data = array(
			'id_driver' => '',
			'username' => $this->input->post('input_username'),
			'alamat' => $this->input->post('input_alamat'),
			'no_telp' => $this->input->post('input_no_telp'),
			'email' => $this->input->post('input_email'),
			'umur' => $this->input->post('input_umur'),
			'gender' => $this->input->post('input_gender'),
			'price' => $this->input->post('input_price'),
			'foto' => $upload['file']['file_name']
		);

		$this->db->insert('driver', $data);
	}

//UPDATE
	public function update($id)
	{
			$data = array(
				'username' => $this->input->post('input_username'),
				'password' => $this->input->post('input_password'),
				'email' => $this->input->post('input_email'),
				'no_telp' => $this->input->post('input_no_telp'),
				'alamat' => $this->input->post('input_alamat')
	    );
	    
	    $this->db->where('id', $id);
	    $this->db->update('login', $data);
	}

	public function view_by($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get('login')->row();
	}

	public function update_user($upload, $id)
	{
		if ($upload['result'] == 'success') 
		{
			$data = array(
				'username' => $this->input->post('input_username'),
				'alamat' => $this->input->post('input_alamat'),
				'no_telp' => $this->input->post('input_no_telp'),
				'email' => $this->input->post('input_email'),
				'birth' => $this->input->post('input_birth'),
				'password' => $this->input->post('input_password'),
				'img' => $upload['file']['file_name']
	    );
	    }
	    else
	    {
	    	$data = array(
				'username' => $this->input->post('input_username'),
				'alamat' => $this->input->post('input_alamat'),
				'no_telp' => $this->input->post('input_no_telp'),
				'email' => $this->input->post('input_email'),
				'birth' => $this->input->post('input_birth'),
				'password' => $this->input->post('input_password')
	    );
	    }	    
	    
	    $this->db->where('id_user', $id);
	    $this->db->update('user', $data);
	}

	public function view_by_user($id)
	{
	    $this->db->where('id_user', $id);
	    return $this->db->get('user')->row();
	}

	public function update_car($upload, $id)
	{
		if ($upload['result'] == 'success') 
		{
			$data = array(
				'no_polisi' => $this->input->post('input_no_polisi'),
				'merk' => $this->input->post('input_merk'),
				'jenis_mobil' => $this->input->post('input_jenis_mobil'),
				'warna_mobil' => $this->input->post('input_warna_mobil'),
				'tahun_mobil' => $this->input->post('input_tahun_mobil'),
				'bahan_bakar' => $this->input->post('input_bahan_bakar'),
				'price' => $this->input->post('input_price'),
				'img' => $upload['file']['file_name']
	    );
	    }
	    else
	    {
	    	$data = array(
				'no_polisi' => $this->input->post('input_no_polisi'),
				'merk' => $this->input->post('input_merk'),
				'jenis_mobil' => $this->input->post('input_jenis_mobil'),
				'warna_mobil' => $this->input->post('input_warna_mobil'),
				'tahun_mobil' => $this->input->post('input_tahun_mobil'),
				'bahan_bakar' => $this->input->post('input_bahan_bakar'),
				'price' => $this->input->post('input_price')
	    );
	    }	    
	    
	    $this->db->where('id_mobil', $id);
	    $this->db->update('car', $data);
	}

	public function view_by_car($id)
	{
	    $this->db->where('id_mobil', $id);
	    return $this->db->get('car')->row();
	}

	public function update_driver($upload, $id)
	{
		if ($upload['result'] == 'success') 
		{
			$data = array(
				'username' => $this->input->post('input_username'),
				'alamat' => $this->input->post('input_alamat'),
				'no_telp' => $this->input->post('input_no_telp'),
				'email' => $this->input->post('input_email'),
				'umur' => $this->input->post('input_umur'),
				'gender' => $this->input->post('input_gender'),
				'price' => $this->input->post('input_price'),
				'foto' => $upload['file']['file_name']
	    );
	    }
	    else
	    {
	    	$data = array(
				'username' => $this->input->post('input_username'),
				'alamat' => $this->input->post('input_alamat'),
				'no_telp' => $this->input->post('input_no_telp'),
				'email' => $this->input->post('input_email'),
				'umur' => $this->input->post('input_umur'),
				'gender' => $this->input->post('input_gender'),
				'price' => $this->input->post('input_price'),
	    );
	    }	    
	    
	    $this->db->where('id_driver', $id);
	    $this->db->update('driver', $data);
	}

	public function view_by_driver($id)
	{
	    $this->db->where('id_driver', $id);
	    return $this->db->get('driver')->row();
	}

//DELETE

	public function delete($id) //ADMIN
	{
	    $this->db->where('id', $id);
	    $this->db->delete('login');
	}
	public function delete_user($id)
	{
	    $this->db->where('id_user', $id);
	    $this->db->delete('user');
	}
	public function delete_car($id)
	{
	    $this->db->where('id_mobil', $id);
	    $this->db->delete('car');
	}
	public function delete_driver($id)
	{
	    $this->db->where('id_driver', $id);
	    $this->db->delete('driver');
	}

	//LOGIN
	public function login($username, $password)
	{
		$data = array(
			'username' => $username,
			'password' => $password
		);

		$this->db->where($data);
		return $this->db->get('login');
	}
	public function login_user($username, $password)
	{
		$data = array(
			'username' => $username,
			'password' => $password
		);

		$this->db->where($data);
		return $this->db->get('user');
	}
}
?>