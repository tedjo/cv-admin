<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends CI_Model
{
    public function getSocialMedia()
    {
        // $this->db->select('id,title, icon,url, is_active');
        $this->db->from('user_sosmet');
        return $this->db->get()->result_array();
    }

    public function getAllOverSubtitle()
    {
        $this->db->select('COUNT(id)');
        return $this->db->get('user_select_subtitle')->row_array();
    }

    public function getAllSubTitle()
    {
        return $this->db->get('user_select_subtitle')->result_array();
    }

    public function getInsertSubTitle()
    {
        $dataDB = [
            'sub_title' => "",
            'is_readonly' => ""
        ];
        return $this->db->insert('user_select_subtitle', $dataDB);
    }

    public function getDeleteSubtitle($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('user_select_subtitle');
    }

    public function getAutoincrementReset()
    {
        $query2 = "ALTER TABLE user_select_subtitle AUTO_INCREMENT =1;";
        return $this->db->query($query2);
    }

    public function getUpdateSubtitle($id, $title)
    {
        $data = [
            'sub_title' => $title,
            'is_readonly' => "readonly"
        ];
        $this->db->where('id', $id);
        return $this->db->update('user_select_subtitle', $data);
    }

    public function getAllsubHome()
    {
        return $this->db->get('user_template_home')->row_array();
    }

    public function getInsertAllsubHome($title, $desc, $speed, $upload_image)
    {
        $data = [
            'title' => $title,
            'des_title' => $desc,
            'speed_animasi' => $speed
        ];

        $this->uploadImage($upload_image);
        $this->db->set($data);
        return $this->db->insert('user_template_home');
    }

    public function getUpdateAllsubHome($title, $desc, $speed, $upload_image)
    {
        $data = [
            'title' => $title,
            'des_title' => $desc,
            'speed_animasi' => $speed
        ];

        $this->uploadImage($upload_image);
        $this->db->set($data);
        return $this->db->update('user_template_home');
    }

    public function uploadImage($upload_image)
    {
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png';
            // $config['max_size']      = '2048';
            $config['upload_path'] = './assets/img/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                $dataImage = $this->getAllsubHome();
                if ($dataImage['image'] != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/' . $dataImage['image']);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->dispay_errors();
            }
        }
    }

    public function getCheckSosmet($id, $acun, $active)
    {
        $dataSosmetTrue = [
            'acun_sosmet' => $acun,
            'is_active' => 1,
            'is_readonly' => 'readonly'
        ];

        $dataSosmetFalse = [
            'acun_sosmet' => $acun,
            'is_active' => 0,
            'is_readonly' => ''
        ];

        if ($active != 0) {
            $this->db->where('id', $id);
            $this->db->update('user_sosmet', $dataSosmetFalse);
        } else {
            $this->db->where('id', $id);
            $this->db->update('user_sosmet', $dataSosmetTrue);
        }
    }
}
