<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }
    // ----------------------------show menu manager-----------------------------------
    public function getShowManager($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('user_menu')->row_array();
    }

    public function getEditManager($id, $menu)
    {
        $data = ['menu' => $menu];
        $this->db->where('id', $id);
        return $this->db->update('user_menu', $data);
    }

    public function getDeleteManager($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    public function getCountManager()
    {
        $this->db->select('COUNT(number), menu');
        $this->db->from('user_menu');
        $this->db->order_by('number ASC');
        return $this->db->get()->row_array();
    }

    public function getAddManager($data)
    {
        $this->db->insert('user_menu', $data);
    }

    // ---------------------------show sub menu--------------------------

    public function getShowSubMenu()
    {
        $this->db->select('user_sub_menu.id, title, menu_template, icon, template_id, is_active, event');
        $this->db->from('user_sub_menu');
        $this->db->join('user_template', 'user_template.id = user_sub_menu.template_id');
        $this->db->order_by('template_id ASC');
        return $this->db->get()->result_array();
    }

    public function getMenuTemplate()
    {
        $this->db->select('*');
        $this->db->from('user_template');
        $this->db->where('is_active_menu = 1');
        return $this->db->get()->result_array();
    }

    public function getMax_menu()
    {
        $this->db->select('COUNT(template_id)');
        $this->db->from('user_sub_menu');
        $this->db->where('menu_id = 3');
        return $this->db->get()->row_array();
    }

    // --------------------------------------------------------------------------

    public function getInsertMenu($dataDB, $whereId)
    {
        $where = ['id' => $whereId];
        $data = ['is_active_menu' => 0];
        $this->db->where($where);
        $this->db->update('user_template', $data);

        $this->db->insert('user_sub_menu', $dataDB);
    }

    public function getShowEditMenu($id)
    {
        $this->db->select('*');
        $this->db->from('user_sub_menu');
        $this->db->join('user_template', 'user_sub_menu.template_id = user_template.id');
        $this->db->where('template_id =' . $id);
        return $this->db->get()->result_array();
    }

    public function getDelete($menuId, $templateId)
    {
        $whereId = ['id' => $templateId];
        $mDataActive = ['is_active_menu' => 1];
        $this->db->where($whereId);
        $this->db->update('user_template', $mDataActive);

        $this->db->where('id', $menuId);
        $this->db->delete('user_sub_menu');
    }

    public function getUpdate($data1, $data2, $data3)
    {
        $where = ['template_id' => $data1];
        $data = ['title' => $data2, 'icon' => $data3];
        $this->db->where($where);
        $this->db->update('user_sub_menu', $data);
    }

    public function getActivetMenu($activeId, $templateId)
    {
        $where = ['template_id' => $templateId];
        $dataTrue = ['is_active' => 2];
        $dataFalse = ['is_active' => 0];

        if ($activeId == 0) {
            $this->db->where($where);
            $this->db->update('user_sub_menu', $dataTrue);
        } else {
            $this->db->where($where);
            $this->db->update('user_sub_menu', $dataFalse);
        }
    }

    public function getShowDefaultIcon($data)
    {
        $this->db->select('icon_default');
        $this->db->from('user_template');
        $this->db->where('id', $data);
        return $this->db->get()->result_array();
    }

    public function getDisableDataCek()
    {
        $this->db->select('COUNT(is_active), menu_id, id');
        $this->db->from('user_sub_menu');
        $this->db->where('is_active > 1 AND menu_id = 3');
        $this->db->order_by('template_id ASC');
        return $this->db->get()->row_array();
    }

    public function getdeleteDataSosmet()
    {
        $clearSosmet = [
            'acun_sosmet' => '',
            'is_active' => 0,
            'is_readonly' => ''
        ];
        $this->db->update('user_sosmet', $clearSosmet);
    }

    public function getdeleteDataSubtitle($id)
    {
        $query = "ALTER TABLE user_select_subtitle AUTO_INCREMENT =1;";
        $this->db->where('id', $id);
        $this->db->delete('user_select_subtitle');
        $this->db->query($query);
    }

    public function getdeleteDataHome()
    {
        $query = "ALTER TABLE user_template_home AUTO_INCREMENT = 1;";
        $this->db->where('id', 1);
        $this->db->delete('user_template_home');
        $this->db->query($query);
    }
}
