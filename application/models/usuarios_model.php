<?php

	class Usuarios_model extends CI_Model {
			
		function login($dados)
		{

			$this->db
					->where('user', $dados['user'])
					->where('password', sha1($dados['password']));
			return $this->db->get('users')->result();
		}

		public function listarUsuarios($id = null)
		{

			if ($id) {

				$this->db

					->select('*')
					->from('tb_usuarios')
					->where('id', $id);

				$query = $this->db->get();

				return $query->result();

			}

			$this->db

				->select('*')
				->from('tb_usuarios');

			$query = $this->db->get();

			return $query->result();

		}


		function gravar($dados)
		{

			$this->db->where('id', $dados['id']);

			$gravou = $this->db->update('tb_usuarios', $dados);

			if ($gravou)
				return $gravou;
			else
				return false;    	

		}	



		public function inserir($dados)
		{
			
			return $this->db->insert('tb_usuarios', $dados); 

		}


		function excluir($id)
		{

			$this->db->where('id', $id);
			$this->db->delete('tb_usuarios');

			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
				
		}  	
		

	}