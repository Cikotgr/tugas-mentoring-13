<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_files()
	{
		$query = $this->db->get('files');
		return $query->result();
	}

	public function insert_file($file_name)
	{
		$data = array(
			'file_name' => $file_name
		);
		$this->db->insert('files', $data);
	}

	public function get_file_info($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('files');

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function delete_file($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('files');
	}
}
