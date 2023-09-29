<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('file_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}

	public function index()
	{
		$data['files'] = $this->file_model->get_files();
		$this->load->view('upload_form', $data);
	}

	public function do_upload()
	{
		$config['upload_path'] = './public/uploads/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
		$config['max_size'] = 2048;

		$this->load->library('upload', $config);

		$files = $_FILES['userfile'];

		$file_names = array();
		$errors = array();

		for ($i = 0; $i < count($files['name']); $i++) {
			$_FILES['userfile']['name'] = $files['name'][$i];
			$_FILES['userfile']['type'] = $files['type'][$i];
			$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
			$_FILES['userfile']['error'] = $files['error'][$i];
			$_FILES['userfile']['size'] = $files['size'][$i];

			if (!$this->upload->do_upload('userfile')) {
				$errors[] = $this->upload->display_errors();
			} else {
				$data = $this->upload->data();
				if (isset($data['file_name'])) {
					$file_names[] = $data['file_name'];
				}
			}
		}

		if (!empty($errors)) {
			$error = array('error' => implode("<br>", $errors));
			$this->load->view('upload_form', $error);
		} else {
			foreach ($file_names as $file_name) {
				$this->file_model->insert_file($file_name);
			}
			redirect('upload');
		}
	}

	public function delete($id)
	{
		$file_info = $this->file_model->get_file_info($id);

		if ($file_info) {
			$file_path = './public/uploads/' . $file_info->file_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
			$this->file_model->delete_file($id);

			redirect('upload');
		} else {
			$error = array('error' => 'File tidak ditemukan');
			$this->load->view('upload_form', $error);
		}
	}
}
