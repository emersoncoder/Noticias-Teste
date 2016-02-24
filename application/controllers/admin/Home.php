<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('output_helper');
		$this->load->model('usuarios_model');
	}

	function index()
	{
		$this->load->view('login');
	}

	function login()
	{

		$this->form_validation->set_rules('user', 'Usuário', 'trim|required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[3]|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		try{
			if ($this->form_validation->run() == FALSE)
				 throw new Exception(validation_errors());
			else
			{
				$dados['user']		= $this->input->post('user');
				$dados['password']	= $this->input->post('password');
				$consulta			= $this->usuarios_model->login($dados);

				if($consulta)
				{
					$dados = ['id_users'=> $consulta[0]->id_users,'user'=>$consulta[0]->user,'logado'=>TRUE];
					$this->session->set_userdata($dados);
					echo output_json('ok | acesso permitado', TRUE);
				}
				else
					echo output_json($e->getMessage(), FALSE);
			}
		}
		catch(Exception $e)
		{
			echo output_json($e->getMessage(), FALSE);
		}
	}		
}
