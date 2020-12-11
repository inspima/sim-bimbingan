<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    function login($username) {
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.username', $username);
        $this->db->where('u.status', 1);
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function read_tendikdosen($username) {
        $this->db->select('u.id_user, u.username, u.sebagai, u.role, u.password,u.no_hp, p.*');
        $this->db->from('user u');
        $this->db->join('pegawai p', 'p.nip = u.username');
        $this->db->where('u.username', $username);
        $this->db->where('u.status', 1);
        $this->db->where('p.status', 1);
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function read_mhs($username) {
        $this->db->select('u.id_user, u.username, u.sebagai, u.role, u.password,u.no_hp,u.verifikasi, m.nama, m.email');
        $this->db->from('user u');
        $this->db->join('mahasiswa m', 'm.nim = u.username');
        $this->db->where('u.username', $username);
        $this->db->where('u.status', 1);
        $this->db->where('m.status', 1);
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function read_user_by_id($id) {
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->where('u.id_user', $id);
        $this->db->where('u.status', 1);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    function read_user($username) {
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->where('u.username', $username);
        $this->db->where('u.status', 1);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    function read_mhs_verifikasi() {
        $this->db->select('u.*,m.id_mahasiswa, m.nama, m.email,m.nim,m.sks,m.alamat,m.telp,m.berkas_verifikasi,p.nm_prodi,j.jenjang');
        $this->db->from('user u');
        $this->db->join('mahasiswa m', 'm.nim = u.username');
        $this->db->join('prodi p', 'm.id_prodi = p.id_prodi');
        $this->db->join('jenjang j', 'j.id_jenjang= p.id_jenjang');
        $this->db->where('u.verifikasi', '0');
        $this->db->where('m.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function read_mhs_cari($search) {
        $this->db->select('u.*,m.id_mahasiswa, m.nama, m.email,m.nim,m.sks,m.alamat,m.telp,m.berkas_verifikasi,p.nm_prodi,j.jenjang');
        $this->db->from('user u');
        $this->db->join('mahasiswa m', 'm.nim = u.username');
        $this->db->join('prodi p', 'm.id_prodi = p.id_prodi', 'left');
        $this->db->join('jenjang j', 'j.id_jenjang= p.id_jenjang', 'left');
        $this->db->where('m.status', 1);
        $this->db->like('m.nama', $search);
        $this->db->or_like('m.nim', $search);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_p($datap, $id_user) {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $datap);
    }

    function create($data) {
        $this->db->insert('user', $data);
    }

    function create_mahasiswa($data) {
        $this->db->insert('mahasiswa', $data);
    }

    function update_mahasiswa($data, $id_mhs) {
        $this->db->where('id_mahasiswa', $id_mhs);
        $this->db->update('mahasiswa', $data);
    }

    function update_pegawai($data, $nip) {
        $this->db->where('nip', $nip);
        $this->db->update('pegawai', $data);
    }

}

?>