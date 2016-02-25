<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('output_helper');
		$this->load->model('noticias_model');
	}

	function index($offset = null)
	{
		$dados['noticias']        = $this->noticias_model->listarNoticias($offset);
		$config['base_url']       = site_url() .'/admin/noticias/index/';
		$config['total_rows']     = count($this->noticias_model->listarNoticiasTotal());
		$config['per_page']       = '4';
		$config['first_link']     = 'Início';
		$config['last_link']      = 'Fim';
		$this->pagination->initialize($config);
		$dados['paginas']         = $this->pagination->create_links();
		$this->load->view('admin/inicio', $dados);
	}

	function editar($id_noticias)
	{
		$dados['noticias'] = $this->noticias_model->listar($id_noticias);
		$this->load->view('admin/form_noticia', $dados);
	}

	function adicionar()
	{
		$this->load->view('admin/form_noticia');
	}

	function gravar()
	{
		$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
		$this->form_validation->set_rules('resumo', 'Resumo', 'trim|required');
		$this->form_validation->set_rules('data', 'Data', 'trim|required');
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');

		try{
			if ($this->form_validation->run() == FALSE)
				 echo validation_errors();
			else
			{

				if (empty($_FILES['userfile']['name'])) 
				{
					if(!empty($this->input->post('id_noticias')))
						$dados['id_noticias'] = $this->input->post('id_noticias');

					$dados['titulo']	= $this->input->post('titulo');
					$dados['resumo']	= $this->input->post('resumo');

					$data 				= $this->input->post('data');
					$data 				= explode('/', $data);
					$data 				= $data[2] . '-' . $data[1] . '-' . $data[0] . ' ' . date('H:i:s');
					$dados['data']		= $data;

					$dados['descricao']	= $this->input->post('descricao');
					$dados['publicado']	= $this->input->post('publicado');
					$consulta			= $this->noticias_model->gravar($dados);

					if($consulta)
						echo output_json('ok', TRUE);
				}
				else
				{
					$config['upload_path']		= './assets/imagem_noticias/';
					$config['allowed_types']	= 'gif|jpg|png|jpeg';
					$config['max_size']			= 0;
					$config['max_width']		= 0;
					$config['max_height']		= 0;
					$config['encrypt_name']		= TRUE;
					$this->load->library('upload', $config);

					if(!$this->upload->do_upload())
						echo $this->upload->display_errors();
					else
					{
						$imagem						=  $this->upload->data();
						$config['image_library']	= 'gd2';
						$config['source_image']		= './assets/imagem_noticias/' . $imagem['file_name'];
						$config['new_image']		= './assets/imagem_noticias/thumb_' . $imagem['file_name'];
						$config['maintain_ratio']	= FALSE;
						$config['width']			= 75;
						$config['height']			= 50;
						$this->load->library('image_lib', $config); 

						if(!$this->image_lib->resize())
							echo $this->image_lib->display_errors();
						else
						{

							if(!empty($this->input->post('id_noticias')))
								$dados['id_noticias'] = $this->input->post('id_noticias');

							$dados['titulo']	= $this->input->post('titulo');
							$dados['resumo']	= $this->input->post('resumo');
							$data 				= $this->input->post('data');
							$data 				= explode('/', $data);
							$data 				= $data[2] . '-' . $data[1] . '-' . $data[0] . ' ' . date('H:i:s');
							$dados['data']		= $data;
							$dados['descricao']	= $this->input->post('descricao');
							$dados['publicado']	= $this->input->post('publicado');
							$dados['imagem']	= $imagem['file_name'];

							$consulta			= $this->noticias_model->gravar($dados);

							if($consulta)
								echo output_json('ok', TRUE);
						}
					}
				}
			}
		}
		catch(Exception $e)
		{
			echo output_json($e->getMessage(), FALSE);
		}
	}

	function excluir()
	{
		try{

			$id_noticias = $this->input->post('id_noticias');

			if(empty($id_noticias))
				throw new Exception('ID da noticia não informado');

			$dados['id_noticias'] = $id_noticias;
			$dados['ativo']			= 0;			

			$this->noticias_model->gravar($dados);

			echo output_json('OK', TRUE);
		}
		catch(Exception $e)
		{
			echo output_json($e->getMessage(), FALSE);
		}
	}
}
