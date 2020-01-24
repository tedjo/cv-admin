<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('login');
    } else {
        //mengambil nilai
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        //mengambil nilai
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['number'];
        // buat filter kerua nilai 
        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);
    }
}


function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_access_menu($is_active)
{
    if ($is_active == 2) {
        return "checked='checked'";
    }
}

function check_sosmet($data)
{
    if ($data == 1) {
        return "checked='checked'";
    }
}

function check_number_effect($number)
{
    $ci = get_instance();
    if ($number < 0) {
    } else {
        $data = [
            'select_number' => $number
        ];
        $ci->session->set_userdata($data);
    }
}

function accordion($fild_accordion, $int)
{
    $ci = get_instance();
    if ($int) {
        $ci->load->view($fild_accordion);
    }
}
