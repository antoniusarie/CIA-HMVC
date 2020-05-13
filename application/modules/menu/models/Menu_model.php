<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public $table = 'menu';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        // Self JOIN to get parent_name from id
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get all self join
    function get_all_self_join()
    {
        // Self JOIN to get parent_name from id
        $this->db->select('p.*, c.name as parent_name');
        $this->db->from('menu p');
        $this->db->join('menu c', 'c.id = p.parent', 'left');
        $this->db->order_by('p.id', 'ASC');
        return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get data by id self join
    function get_by_id_self_join($id)
    {
        $this->db->select('p.*, c.name as parent_name');
        $this->db->from('menu p');
        $this->db->join('menu c', 'c.id = p.parent', 'left');
        $this->db->order_by('p.id', 'ASC');
        $this->db->where('p.id', $id);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('url', $q);
        $this->db->or_like('icon', $q);
        $this->db->or_like('active', $q);
        $this->db->or_like('parent', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('url', $q);
        $this->db->or_like('icon', $q);
        $this->db->or_like('active', $q);
        $this->db->or_like('parent', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // activate
    function activate($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // deactivate
    function deactivate($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}