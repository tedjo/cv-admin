<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user');
        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['kategori'] = 'Admin';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('admin/footer');
    }

    public function management()
    {
        $data['title'] = 'Menu Management';
        $data['kategori'] = 'Admin';
        $data['user'] = $this->user->getUser();
        $data['menu'] = $this->menu->getMenu();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/management', $data);
        $this->load->view('admin/footer');
    }

    public function addManager()
    {
        $menu = $this->input->post('add_menu');
        $data = $this->menu->getCountManager();

        if ($menu != null) {
            $mData = [
                'number' => $data['COUNT(number)'] + 1,
                'menu' => $menu
            ];

            $this->menu->getAddManager($mData);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">The menu field is required.</div>');
        }
    }

    public function showManager()
    {
        $output = array();
        $id = $this->input->post('menu_id');
        $data = $this->menu->getShowManager($id);
        $output['show_menu'] = $data['menu'];
        echo json_encode($output);
    }

    public function editManager()
    {
        $id = $this->input->post('menu_id');
        $menu = $this->input->post('menu_menu');
        $this->menu->getEditManager($id, $menu);
    }

    public function deleteManager()
    {
        $id = $this->input->post('menu_id');
        $this->menu->getDeleteManager($id);
    }

    public function submenu()
    {
        //menu tobar
        $data['title'] = 'Submenu Management';
        $data['kategori'] = 'Admin';
        $data['user'] = $this->user->getUser();

        //sub menu management
        $data['subMenu'] = $this->menu->getShowSubMenu();
        $data['menuTemplate'] = $this->menu->getMenuTemplate();

        $datamax = $this->menu->getMax_menu();
        if ($datamax['COUNT(template_id)'] == 8) {
            $data['menuMax'] = "disabled";
            $this->_load_view($data);
        } else {
            $data['menuMax'] = "enable";
            $this->_load_view($data);
        }
    }

    public function add_menu_()
    {
        $title = $this->input->post('add_title');
        $menuTemplate = $this->input->post('add_menu');
        $icon = $this->input->post('add_icon');
        $isActive = $this->input->post('add_is_active');

        if ($title == "") {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">The Title field is required.</div>');
        } else if ($icon == "") {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">The icon field is required.</div>');
        } else {
            $datamax = $this->menu->getMax_menu();
            if ($datamax['COUNT(template_id)'] == 8) {
                $data['menuMax'] = "disabled";
                $this->_load_view($data);
            } else {
                $data['menuMax'] = "enable";
                $this->_load_view($data);
                $dataUrl = [
                    'menu',
                    'menu/about',
                    'menu/experience',
                    'menu/education',
                    'menu/skills',
                    'menu/interests',
                    'menu/awards',
                    'menu/blog'
                ];
                $dataDB = [
                    'title' => $title,
                    'menu_id' => 3,
                    'template_id' => $menuTemplate,
                    'url' => $dataUrl[$menuTemplate - 1],
                    'icon' => $icon,
                    'is_active' => $isActive
                ];


                $this->menu->getInsertMenu($dataDB, $menuTemplate);
                $this->_disableCheck();
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            }
        }
    }

    private function _load_view($data)
    {
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('admin/footer');
    }

    public function roleAccess()
    {
        $data['title'] = 'Role Access';
        $data['kategori'] = 'Admin';
        $data['user'] = $this->user->getUser();
        $data['role'] = $this->user->getRoleUser();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('admin/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            $this->_allSeclectActive($menu_id, 2);
        } else {
            $this->db->delete('user_access_menu', $data);
            $this->_allSeclectActive($menu_id, 0);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    private function _allSeclectActive($menu_id, $data)
    {
        if ($menu_id == 3) {
            $dataTrue = ['is_active' => $data];
            $this->db->select('is_active');
            $this->db->where('menu_id = 3 AND template_id !=1');
            $this->db->update('user_sub_menu', $dataTrue);
        }
    }

    public function changeAccSubMenu()
    {
        $activeId = $this->input->post('activeId');
        $templateId = $this->input->post('templateId');
        $this->menu->getActivetMenu($activeId, $templateId);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
        $this->_disableCheck();
    }

    public function edit_menu()
    {
        $output = array();
        $editId = $this->input->post('editDataId');
        $data = $this->menu->getShowEditMenu($editId);
        foreach ($data as $m) {
            $output['id_menu'] = $m['id'];
            $output['template_id'] = $m['template_id'];
            $output['title_menu'] = $m['title'];
            $output['menu_menu'] = $m['menu_template'];
            $output['icon_menu'] = $m['icon'];
        }
        echo json_encode($output);
    }

    public function update_menu()
    {
        $updateID = $this->input->post('show_id');
        $UpdateTitle = $this->input->post('show_title');
        $UpdateIcon = $this->input->post('show_icon');

        if ($UpdateTitle == "") {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">The Title field is required.</div>');
        } else if ($UpdateIcon == "") {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">The icon field is required.</div>');
        } else {
            $this->menu->getUpdate($updateID, $UpdateTitle, $UpdateIcon);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Data Success!</div>');
        }
    }

    public function delete()
    {
        $deleteId = $this->input->post('deleteId');
        $templateId = $this->input->post('templateId');

        $this->db->where('template_id', $templateId);
        $queryIdMenu = $this->db->get('user_sub_menu')->row_array();
        $querySelect = $this->db->get('user_select_subtitle')->result_array();


        foreach ($querySelect as $m) {
            if ($queryIdMenu['template_id'] == 1) {
                $this->menu->getdeleteDataSubtitle($m['id']);
                $this->menu->getdeleteDataSosmet();
                $this->menu->getdeleteDataHome();
                $this->menu->getDelete($deleteId, $templateId);
                $this->_disableCheck();
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Data Success!</div>');
            }
        }

        $this->menu->getDelete($deleteId, $templateId);
        $this->_disableCheck();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Data Success!</div>');
    }

    public function edit_icon()
    {
        $output = array();
        $iconId = $this->input->post('edit_iconId');
        $data = $this->menu->getShowDefaultIcon($iconId);
        foreach ($data as $m) {
            $output['title_menu'] = $m['icon_default'];
        }
        echo json_encode($output);
    }

    private function _disableCheck()
    {
        $cData = $this->menu->getDisableDataCek();
        $md = $cData['COUNT(is_active)'];
        for ($i = 0; $i <= count($md); $i++) {
            $whereDis = $cData['id'];
            $whereEnb = $cData['menu_id'];
            if ($md == 1) {
                var_dump($md);
                $mEvent = ['event' => 'disabled'];
                $this->db->where('id', $whereDis);
                $this->db->update('user_sub_menu', $mEvent);
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Unlock Access Menu</div>');
            } else {
                $mEvent = ['event' => 'enable'];
                $this->db->where('menu_id', $whereEnb);
                $this->db->update('user_sub_menu', $mEvent);
            }
        }
    }
}
