<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Button_model extends CI_Model {
	
	function where($where = '') {
		if($where != '') $this->db->where($where);
		return $this;
	}
	
	function set_limit($limit, $start = 0) {
    	$this->db->limit($limit, $start);
        return $this;
    }
	
	function order_by($field, $direction = 'asc') {
		$this->db->order_by($field, $direction);
		return $this;
	}
	
	function like($field, $keyword, $pattern = 'both') {
		$this->db->like($field, $keyword, $pattern);
		return $this;
	}
	
	function or_like($field, $keyword = '', $pattern = 'both'){
		if($keyword != '') $this->db->or_like($field, $keyword, $pattern);
		else  $this->db->or_like($field);
		return $this;
	}
	
	function group_by($group_by = ''){
		$this->db->group_by($group_by);
		return $this;
	}
	
	/* ---------------------------------------- All About Admin ------------------------- */
	
	function get_login(){
		return $this->db->get('button')->row_array();
	}
	
	function get_all(){
		return $this->db->get('button')->result_array();
	}
	
	function posts($data){
		return $this->db->insert('button', $data);
	}
	
	function puts($data){
		return $this->db->update('button', $data);
	}
	
	function delete($data){
		return $this->db->delete('button', $data);
	}
	
}

?>