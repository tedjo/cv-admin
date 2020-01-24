<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Post_model', 'pos');
    }

    public function index()
    {
        $data['title'] = 'Home';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();
        $data['sosmet'] = $this->pos->getSocialMedia();
        $data['over_query_subtitle'] =  $this->pos->getAllOverSubtitle();
        $data['all_query_subtitle'] =  $this->pos->getAllSubTitle();
        $data['all_query_home'] =  $this->pos->getAllsubHome();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/home', $data);
        $this->load->view('admin/footer');
    }

    public function insertSubtitle()
    {
        $this->pos->getInsertSubTitle();
    }

    public function deleteSubtitle()
    {
        $id = $this->input->post('id_title');
        $this->pos->getDeleteSubtitle($id);
        $this->pos->getAutoincrementReset();
    }

    public function updateSubtitle()
    {
        $id = $this->input->post('id_title');
        $title = $this->input->post('sub_title');
        $dataQuery = $this->pos->getAllSubTitle();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Save Data Success!</div>');
        if ($id != '') {
            foreach ($dataQuery as $mQuery) {
                if ($title != '') {
                    if ($title != $mQuery['sub_title']) {
                        $this->pos->getUpdateSubtitle($id, $title);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Save Data Success!</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data already available!</div>');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Empet!</div>');
                }
            }
        }
    }

    public function saveDataHome()
    {
        $title_home = $this->input->post('title_home');
        $description_home = $this->input->post('description_home');
        $speed_animal = $this->input->post('speed_animal');
        $upload_image = $_FILES['gambar']['name'];

        $this->form_validation->set_rules('title_home', 'title', 'required|trim');
        $this->form_validation->set_rules('description_home', 'description', 'required|trim');
        $this->form_validation->set_rules('speed_animal', 'speed', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Home';
            $data['kategori'] = 'Menu';
            $data['user'] = $this->user->getUser();
            $data['sosmet'] = $this->pos->getSocialMedia();
            $data['over_query_subtitle'] =  $this->pos->getAllOverSubtitle();
            $data['all_query_subtitle'] =  $this->pos->getAllSubTitle();
            $data['all_query_home'] =  $this->pos->getAllsubHome();

            $this->load->view('admin/header', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('menu/home', $data);
            $this->load->view('admin/footer');
            redirect('menu');
        } else {
            $queryHome =  $this->pos->getAllsubHome();
            if (!$queryHome) {
                $this->pos->getInsertAllsubHome($title_home, $description_home, $speed_animal, $upload_image);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Save Data Success!</div>');
            } else {
                $this->pos->getUpdateAllsubHome($title_home, $description_home, $speed_animal, $upload_image);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Save Data Success!</div>');
            }

            redirect('menu');
        }
    }

    public function checkSosmet()
    {
        $id_sosmet = $this->input->post('id_sosmet');
        $acun_sosmet = $this->input->post('acun_sosmet');
        $check_sosmet = $this->input->post('check_sosmet');

        $this->pos->getCheckSosmet($id_sosmet, $acun_sosmet, $check_sosmet);
    }

    public function about()
    {
        $data['title'] = 'About';
        $data['sub_title'] = 'Sub Menu About';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/about', $data);
        $this->load->view('admin/footer');
    }
    public function experience()
    {
        $data['title'] = 'Experience';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/experience', $data);
        $this->load->view('admin/footer');
    }
    public function education()
    {
        $data['title'] = 'Education';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/education', $data);
        $this->load->view('admin/footer');
    }
    public function skills()
    {
        $data['title'] = 'Skills';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/skills', $data);
        $this->load->view('admin/footer');
    }
    public function interests()
    {
        $data['title'] = 'Interests';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/interests', $data);
        $this->load->view('admin/footer');
    }
    public function awards()
    {
        $data['title'] = 'Awards';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/awards', $data);
        $this->load->view('admin/footer');
    }
    public function blog()
    {
        $data['title'] = 'Blog';
        $data['kategori'] = 'Menu';
        $data['user'] = $this->user->getUser();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('menu/blog', $data);
        $this->load->view('admin/footer');
    }
}
