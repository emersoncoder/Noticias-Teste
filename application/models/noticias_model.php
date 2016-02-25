<?php

	class Noticias_model extends CI_Model {

		function gravar($dados)
		{
			if(!empty($dados['id_noticias']))
			{
				$this->db->where('id_noticias', $dados['id_noticias']);

				if ($this->db->update('noticias', $dados))
					return TRUE;
				else
					return false;				
			}
			else
			{
				return $this->db->insert('noticias', $dados); 	
			}
		}
	    
	    function listarNoticias($offset = null)
	    {

	        $this->db->where('ativo', 1);

	        $query = $this->db->get('noticias', 4, $offset);

	        return $query->result();

	    }

	    function listarNoticiasTotal()
	    {

	        $this->db->where('ativo', 1);

	        $query = $this->db->get('noticias');

	        return $query->result();

	    }	    

		function excluir($id_noticias)
		{
			$this->db->where('id_noticias', $id_noticias);
			$this->db->delete('noticias');

			if ($this->db->affected_rows() > 0)
				return true;
			else
				return false;
		}  

		function listar($id_noticias = null)
		{
			if ($id_noticias) 
			{
				$this->db
					->select('*')
					->from('noticias')
					->where('id_noticias', $id_noticias);
				$query = $this->db->get();
				return $query->result();
			}
			$this->db
				->select('*')
				->where('ativo', 1)
				->from('noticias');
			$query = $this->db->get();
			return $query->result();
		}

		function listar_front()
		{
			$this->db
				->select('*')
				->where('ativo', 1)
				->from('noticias');
			$query = $this->db->get();
			return $query->result();
		}

	}