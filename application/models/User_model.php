<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUser()
    {
        $user_email = $this->session->userdata('email');
        $this->db->where('email', $user_email);
        return $this->db->get('user')->row_array();
    }

    public function getRoleUser()
    {
        $this->db->where('id', 1);
        return $this->db->get('user_role')->row_array();
    }

    public function getRoleMenu()
    {
        $role_id = $this->session->userdata('role_id');

        $this->db->select('menu, number');
        $this->db->from('user_menu');
        $this->db->join('user_access_menu', 'user_menu.number = user_access_menu.menu_id');
        $this->db->where('user_access_menu.role_id =' . $role_id);
        $this->db->order_by('user_access_menu.menu_id ASC');
        return $this->db->get()->result_array();
    }

    public function getLoopingMenu($menu_id)
    {
        $this->db->select('user_menu.number, user_sub_menu.id, title, url,icon');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.number');
        $this->db->where('user_sub_menu.menu_id =' . $menu_id);
        $this->db->where('user_sub_menu.is_active = 2');
        $this->db->order_by('id ASC');
        return $this->db->get()->result_array();
    }
}
