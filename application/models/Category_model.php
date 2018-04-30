<?php
class Category_model extends CI_Model {

	public function create_category()
	{

		$data = array (
			'id_cat' => '',
			'cat_mobil' => $this->input->post('cat_mobil'),
			'description' => $this->input->post('description'),
			'date_created' => date('Y-m-d')
		);

		$this->db->insert('categories', $data); 
	}

	public function get_all_categories()
	{
		$this->db->order_by('cat_mobil');
		$query = $this->db->get('categories');
		return $query->result();
	}

	public function get_category_by_id($id)
	{
		$query = $this->db->get_where('categories', array('id_cat' => $id));
		return $query->row();
	}

	public function edit($id)
	{
			$data = array(
				'cat_mobil' => $this->input->post('cat_moobi'),
				'description' => $this->input->post('description'),
	    );    
	    
	    $this->db->where('id_cat', $id);
	    $this->db->update('categories', $data);
	}

	public function delete($id)
	{
	    $this->db->where('id_cat', $id);
	    $this->db->delete('categories');
	}
	public function view_by($id)
	{
	    $this->db->where('id_cat', $id);
	    return $this->db->get('categories')->row();
	}
}