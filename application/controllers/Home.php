<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('output_helper');
		$this->load->model('noticias_model');
	}

	function index()
	{

		$dados['noticias'] = $this->noticias_model->listar_front();
		$this->load->view('lista', $dados);
	}

}
