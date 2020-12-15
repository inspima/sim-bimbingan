<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tesis extends CI_Model {

    // Tesis

    public function cek_prodi($id) {
        $this->db->select('s.*,m.*');
        $this->db->from('tesis s');
        $this->db->join('mahasiswa m', 'm.nim = s.nim', 'left');
        $this->db->where('s.id_tesis', $id);

        $query = $this->db->get();
        return $query->row()->id_prodi;
    }

    public function read_mahasiswa($username) {
        $this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function read_proposal_mahasiswa($username) {
        $this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua,
            d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal() {
        $this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal_prodi($id) {
        $this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_proposal >', 0);
        $this->db->where('m.id_prodi =', $id);
        $this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_prodi_s2() {
        $this->db->select('j.*, ps.*');
        $this->db->from('prodi ps');
        $this->db->join('jenjang j', 'j.id_jenjang = ps.id_jenjang', 'left');
        $this->db->where('j.id_jenjang =', 2);
        $this->db->order_by('ps.id_prodi', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_max_prodi_s2() {
        $this->db->select('max(ps.id_prodi) as id_prodi');
        $this->db->from('prodi ps');
        $this->db->join('jenjang j', 'j.id_jenjang = ps.id_jenjang', 'left');
        $this->db->where('j.id_jenjang =', 2);
        $this->db->order_by('ps.id_prodi', 'desc');

        $query = $this->db->get();
        return $query->row()->id_prodi;
    }

    public function read_ujian_mahasiswa($username) {
        $this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_tesis >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_ujian() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_tesis >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_ujian_prodi($id) {
        $this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_tesis >', 0);
        $this->db->where('m.id_prodi =', $id);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function approval_proposal($id_tesis)
    {
        $data = array(
            'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_SPS
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }
    
    function batal_proposal($id_tesis)
    {
        $data = array(
            'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }

    function reject_proposal($id_tesis)
    {
        $data = array(
            'status_proposal' => '4'
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }

    function approval_pembimbing_proposal($id_tesis)
    {
        $this->db->select('tesis.*');
        $this->db->from('tesis');
        $this->db->where('id_tesis', $id_tesis);
        $query = $this->db->get();
        $tesis = $query->row();

        if($tesis->nip_pembimbing_satu == $this->session_data['username']){
            $data = array(
                'status_pembimbing_satu' => '1'
            );
        }
        else if($tesis->nip_pembimbing_dua == $this->session_data['username']){
            $data = array(
                'status_pembimbing_dua' => '1'
            );
        }

        $this->db->update('tesis', $data);
    }
    
    function reject_pembimbing_proposal($id_tesis)
    {
        $this->db->select('tesis.*');
        $this->db->from('tesis');
        $this->db->where('id_tesis', $id_tesis);
        $query = $this->db->get();
        $tesis = $query->row();

        if($tesis->nip_pembimbing_satu == $this->session_data['username']){
            $data = array(
                'status_pembimbing_satu' => '2'
            );
        }
        else if($tesis->nip_pembimbing_dua == $this->session_data['username']){
            $data = array(
                'status_pembimbing_dua' => '2'
            );
        }

        $this->db->update('tesis', $data);
    }

    function batal_pembimbing_proposal($id_tesis)
    {
        $this->db->select('tesis.*');
        $this->db->from('tesis');
        $this->db->where('id_tesis', $id_tesis);
        $query = $this->db->get();
        $tesis = $query->row();

        if($tesis->nip_pembimbing_satu == $this->session_data['username']){
            $data = array(
                'status_pembimbing_satu' => NULL
            );
        }
        else if($tesis->nip_pembimbing_dua == $this->session_data['username']){
            $data = array(
                'status_pembimbing_dua' => NULL
            );
        }

        $this->db->update('tesis', $data);
    }

    function reject_penguji_temp_proposal($id_tesis, $nip, $status)
    {
        $data = array(
            'status' => $status
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $nip);
        $this->db->update('penguji_tesis_temp', $data);
    }

    function approval_penguji_proposal($id_tesis, $id_ujian, $username)
    {
        /*$this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();*/

        $data = array(
            'status' => '2'
        );
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('nip', $username);
        $this->db->update('penguji_tesis', $data);

        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where_not_in('p.status', $stts);
        $this->db->where('p.id_ujian', $id_ujian);

        $hitung = $this->db->count_all_results();

        if($hitung == 0)
        {
            $data = array(
                'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN
            );

            $this->db->update('tesis', $data);
        }
        else if($hitung > 0){
            $data = array(
                'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI
            );

            $this->db->update('tesis', $data);
        }
    }
    
    /*function reject_penguji_proposal($id_tesis, $username)
    {
        $this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();

        $data = array(
            'status' => '3'
        );
        $this->db->where('id_ujian', $tesis->id_ujian);
        $this->db->where('nip', $tesis->nip);
        $this->db->update('penguji_tesis', $data);
    }*/

    function batal_penguji_proposal($id_tesis, $id_ujian, $username)
    {
        /*$this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();*/

        $data = array(
            'status' => '1'
        );
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('nip', $username);
        $this->db->update('penguji_tesis', $data);

        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where_not_in('p.status', $stts);
        $this->db->where('p.id_ujian', $id_ujian);

        $hitung = $this->db->count_all_results();

        if($hitung == 0)
        {
            $data = array(
                'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN
            );

            $this->db->update('tesis', $data);
        }
        else if($hitung > 0){
            $data = array(
                'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI
            );

            $this->db->update('tesis', $data);
        }
    }

    function approval_penguji_tesis($id_tesis, $id_ujian, $username)
    {
        /*$this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();*/

        $data = array(
            'status' => '2'
        );
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('nip', $username);
        $this->db->update('penguji_tesis', $data);

        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where_not_in('p.status', $stts);
        $this->db->where('p.id_ujian', $id_ujian);

        $hitung = $this->db->count_all_results();

        if($hitung == 0)
        {
            $data = array(
                'status_tesis' => STATUS_TESIS_UJIAN
            );

            $this->db->update('tesis', $data);
        }
        else if($hitung > 0){
            $data = array(
                'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI
            );

            $this->db->update('tesis', $data);
        }
    }
    
    /*function reject_penguji_tesis($id_tesis, $username)
    {
        $this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();

        $data = array(
            'status' => '3'
        );
        $this->db->where('id_ujian', $tesis->id_ujian);
        $this->db->where('nip', $tesis->nip);
        $this->db->update('penguji_tesis', $data);
    }*/

    function batal_penguji_tesis($id_tesis, $id_ujian, $username)
    {
        /*$this->db->select('ujian_tesis.*, pt.*');
        $this->db->from('ujian_tesis');
        $this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
        $this->db->where('id_tesis', $id_tesis);
        $this->db->where('nip', $username);
        $query = $this->db->get();
        $tesis = $query->row();*/

        $data = array(
            'status' => '1'
        );
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('nip', $username);
        $this->db->update('penguji_tesis', $data);

        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where_not_in('p.status', $stts);
        $this->db->where('p.id_ujian', $id_ujian);

        $hitung = $this->db->count_all_results();

        if($hitung == 0)
        {
            $data = array(
                'status_tesis' => STATUS_TESIS_UJIAN
            );

            $this->db->update('tesis', $data);
        }
        else if($hitung > 0){
            $data = array(
                'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI
            );

            $this->db->update('tesis', $data);
        }
    }

    function approval_tesis($id_tesis)
    {
        $data = array(
            'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_BAA
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }
    
    function batal_tesis($id_tesis)
    {
        $data = array(
            'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }

    function reject_tesis($id_tesis)
    {
        $data = array(
            'status_tesis' => '4'
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }

    /*public function read_proposal_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }*/

    /*public function read_proposal() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }*/

    function batal_verifikasi_jadwal_proposal($id_tesis)
    {
        $data = array(
            'status_apv_kaprodi' => NULL
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('ujian_tesis', $data);

        $data_tesis = array(
            'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_SPS
        );
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data_tesis);
    }

    public function read_mkpd_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpd() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read($username) {
        $this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal,  s.berkas_proposal, d.departemen');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.id_tesis', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function read_aktif($username) {
        $stts = array('1', '2');
        $this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal, s.berkas_proposal, d.departemen');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->where_in('s.status_proposal', $stts);
        $this->db->limit(1);
        $this->db->order_by('s.id_tesis', 'desc');

        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert('tesis', $data);
    }

    function detail($id) {
        $this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            dn.departemen, m.nim, m.nama,jd.judul,pr.nm_prodi,jn.jenjang');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen', 'left');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        //$this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->join('prodi pr', 'pr.id_prodi= m.id_prodi', 'left');
        $this->db->join('jenjang jn', 'jn.id_jenjang= m.id_jenjang', 'left');
        $this->db->where('s.id_tesis', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function update($data, $id_tesis) {
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('tesis', $data);
    }

    // JUDUL TESIS

    public function read_judul($id_tesis) {
        $this->db->select('j.judul');
        $this->db->from('judul_tesis j');
        $this->db->join('tesis s', 'j.id_tesis = s.id_tesis');
        $this->db->where('j.id_tesis', $id_tesis);
        $this->db->order_by('j.id_judul', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_judul($data) {
        $this->db->insert('judul_tesis', $data);
    }

    function update_judul($data, $id_tesis) {
        $this->db->where('id_tesis', $id_tesis);
        $this->db->update('judul_tesis', $data);
    }

    // PENGUJI

    public function read_permintaan_penguji($username, $jenis) {
        $this->db->select('s.*, pt.status as status_penguji,jd.judul, pt.status, d.departemen ,m.nama,uj.id_ujian');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
        $this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian', 'left');
        $this->db->where('uj.jenis_ujian', $jenis);
        $this->db->where('`nip`=\'' . $username . '\'', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_permintaan_penguji_prodi($username, $jenis, $id) {
        $this->db->select('s.*, pt.status as status_penguji,jd.judul, pt.status, d.departemen ,m.nama,uj.id_ujian');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
        $this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian', 'left');
        $this->db->where('m.id_prodi', $id);
        $this->db->where('uj.jenis_ujian', $jenis);
        $this->db->where('`nip`=\'' . $username . '\'', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penguji_temp($id_tesis) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status, pg.nama');
        $this->db->from('penguji_tesis_temp p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_tesis', $id_tesis);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penguji_temp_belum_resmi($id_tesis, $jenis_ujian, $id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status, pg.nama');
        $this->db->from('penguji_tesis_temp p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_tesis u', 'u.id_tesis = p.id_tesis', 'left'); 
        $this->db->join('penguji_tesis pt', 'pt.id_ujian = u.id_ujian and p.nip = pt.nip', 'left'); 
        $this->db->where('p.id_tesis', $id_tesis);
        $this->db->where('pt.nip', NULL);
        $this->db->where('u.jenis_ujian', $jenis_ujian);
        if($id_ujian != ''){
            $this->db->where('u.id_ujian', $id_ujian);
        }
        $this->db->where_in('p.status', $stts);
        $this->db->group_by('p.id_penguji, p.nip, p.status, pg.nama');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_penguji($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji_tesis p');
        $this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
        $this->db->where('u.id_ujian', $data['id_ujian']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_ketua($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('id_penguji');
        $this->db->from('penguji_tesis');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim', 1);
        $this->db->where_in('status', $stts);

        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_anggota($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('id_penguji');
        $this->db->from('penguji_tesis');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim', 2);
        $this->db->where_in('status', $stts);

        $query = $this->db->get();
        return $query->row();
    }

    public function read_pengujibentrok($tanggal, $id_jam, $nip) {
        $stts = array('1', '2');
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal', $tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip', $nip);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $s1 = $this->db->get();
        $s1->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal', $tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip', $nip);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $s2 = $this->db->get();
        $s2->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal', $tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip', $nip);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $s3 = $this->db->get();
        $s3->row();

        if (empty($s1) && empty($s2) && empty($s3)) {
            return true;
        } else {
            return false;
        }
    }

    public function count_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.id_ujian', $id_ujian);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function count_penguji_temp($id_tesis) {
        $stts = array('1', '2');
        $this->db->from('penguji_tesis_temp p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where_in('p.status', $stts);
        $this->db->where('p.id_tesis', $id_tesis);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function semua_penguji_setuju($id_ujian) {

        $jumlah_penguji = $this->count_penguji($id_ujian);
        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.id_ujian', $id_ujian);
        $jumlah_setuju = $this->db->count_all_results();
        if ($jumlah_penguji == $jumlah_setuju) {
            return true;
        } else {
            return false;
        }
    }

    public function save_penguji($data) {
        $this->db->insert('penguji_tesis', $data);
    }

    public function save_penguji_temp($data) {
        $this->db->insert('penguji_tesis_temp', $data);
    }

    public function update_penguji($data, $id_penguji) {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji_tesis', $data);
    }

    public function update_penguji_temp($data, $id_penguji) {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji_tesis_temp', $data);
    }


    public function read_permintaan_pembimbing($username) {
        $this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('(s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_satu=\'' . $username . '\') OR s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_dua=\'' . $username . '\'))', NULL, FALSE);
        $this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_permintaan_pembimbing_prodi($username, $id) {
        $this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('m.id_prodi =', $id);
        $this->db->where('(s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_satu=\'' . $username . '\') OR s.id_tesis IN (SELECT `id_tesis` from `tesis` where nip_pembimbing_dua=\'' . $username . '\'))', NULL, FALSE);
        $this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penjadwalan($username) {
        $this->db->select('struktural.*');
        $this->db->from('struktural');
        $this->db->where('struktural.nip', $username);
        $query_s = $this->db->get();
        $struktural = $query_s->row();

        $this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('`m`.`id_prodi` =\'' . $struktural->id_prodi . '\'', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penjadwalan_prodi($username, $id) {
        /*$this->db->select('struktural.*');
        $this->db->from('struktural');
        $this->db->where('struktural.nip', $username);
        $query_s = $this->db->get();
        $struktural = $query_s->row();*/

        $this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
        $this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('m.id_prodi', $id);
        $this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    // Promotor

    public function read_permintaan_promotor($username) {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('`s`.`id_disertasi` IN (SELECT `id_disertasi` from `promotor` where `status` in (1,2) and `nip`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_promotor_kopromotor($id_disertasi) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_disertasi', $id_disertasi);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_status_promotor($id_disertasi, $nip) {
        $stts = array('1', '2');
        $this->db->select('p.*');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $id_disertasi);
        $this->db->where('p.nip', $nip);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_ada($id_disertasi) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $id_disertasi);
        $this->db->where('p.status_tim', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_kopromotor($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $data['id_disertasi']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function count_promotor($id_disertasi) {
        $stts = array('1', '2');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('disertasi d', 'p.id_disertasi = d.id_disertasi');
        $this->db->where_in('p.status', $stts);
        $this->db->where('d.id_disertasi', $id_disertasi);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function save_promotor($data) {
        $this->db->insert('promotor', $data);
    }

    public function update_promotor($data, $id_promotor) {
        $this->db->where('id_promotor', $id_promotor);
        $this->db->update('promotor', $data);
    }

    public function semua_promotor_setujui($id_disertasi) {
        $jumlah_promotor = $this->count_promotor($id_disertasi);
        $stts = array('2');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('disertasi u', 'p.id_disertasi = u.id_disertasi');
        $this->db->where_in('p.status', $stts);
        $jumlah_setuju = $this->db->count_all_results();
        if ($jumlah_promotor == $jumlah_setuju) {
            return true;
        } else {
            return false;
        }
    }

    // JADWAL

    public function read_jadwal($id_tesis, $jenis_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_tesis', $id_tesis);
        $this->db->where('u.jenis_ujian', $jenis_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_ruang_terpakai($data) {
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status', 1);
        $s1 = $this->db->get();
        $s1->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status', 1);
        $s2 = $this->db->get();
        $s2->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status', 1);
        $s3 = $this->db->get();
        $s3->row();

        if (empty($s1) && empty($s2) && empty($s3)) {
            return true;
        } else {
            return false;
        }
    }

    // UJIAN

    public function detail_ujian_by_tesis($id_tesis, $jenis) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_tesis', $id_tesis);
        $this->db->where('u.jenis_ujian', $jenis);
        $query = $this->db->get();
        return $query->row();
    }

    public function detail_ujian($id_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_ujian', $id_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_ujian($data) {
        $this->db->insert('ujian_tesis', $data);
    }

    public function update_ujian($data, $id_ujian) {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian_tesis', $data);
    }

    public function read_status_ujian($jenis) {
        if ($jenis == UJIAN_TESIS_PROPOSAL) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Layak'],
                ['value' => '2', 'text' => 'Layak dengan Catatan'],
                ['value' => '3', 'text' => 'Tidak Layak'],
            ];
        } else if ($jenis == UJIAN_TESIS_UJIAN) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Layak'],
                ['value' => '2', 'text' => 'Layak dengan Catatan'],
                ['value' => '3', 'text' => 'Tidak Layak'],
            ];
        }
    }

    public function get_status_ujian($status_ujian, $jenis) {
        $result = '';
        $status_ujians = $this->read_status_ujian($jenis);
        foreach ($status_ujians as $s) {
            if ($s['value'] == $status_ujian) {
                $result = $s['text'];
            }
        }
        return $result;
    }

    public function read_status_tahapan($urutan) {
        if ($urutan == TAHAPAN_TESIS_PROPOSAL) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_SETUJUI_SPS,
                    'text' => 'Disetujui Sekretaris Prodi',
                    'keterangan' => 'Disetujui oleh Sekretaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    'text' => 'Dijadwalkan Kaprodi',
                    'keterangan' => 'Dijadwalkan Oleh Kaprodi',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui Dosen Penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_PROPOSAL_UJIAN_SELESAI,
                    'text' => 'Ujian Selesai',
                    'keterangan' => 'Telah menyelesaikan Ujian',
                    'color' => 'bg-green'
                ],
                /*[
                    'value' => STATUS_TESIS_PROPOSAL_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-purple'
                ],*/
            ];
        }
        /*if ($urutan == 1) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => 1,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => 2,
                    'text' => 'Disetujui Dosen Pembimbing',
                    'keterangan' => 'Disetujui oleh Dosen Pembimbing',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 3,
                    'text' => 'Disetujui Sekertaris Prodi',
                    'keterangan' => 'Disetujui oleh Sekertaris Prodi',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => 4,
                    'text' => 'Ditolak Sekertaris Prodi',
                    'keterangan' => 'Ditolak oleh Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 5,
                    'text' => 'Dijadwalkan Ketua Program Studi',
                    'keterangan' => 'Dijadwalkan oleh Ketua Program Studi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 6,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => 7,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        }*/ 
        else if ($urutan == TAHAPAN_TESIS_UJIAN) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN_SETUJUI_BAA,
                    'text' => 'Disetujui BAA',
                    'keterangan' => 'Disetujui oleh BAA',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN_DIJADWALKAN_KPS,
                    'text' => 'Dijadwalkan Kaprodi',
                    'keterangan' => 'Dijadwalkan Oleh Kaprodi',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui Dosen Penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_TESIS_UJIAN_SELESAI,
                    'text' => 'Ujian Selesai',
                    'keterangan' => 'Telah menyelesaikan Ujian',
                    'color' => 'bg-green'
                ],
            ];
        }
    }

    public function get_status_tahapan($status_tahapan, $jenis) {
        $result = '';
        $statuses = $this->read_status_tahapan($jenis);
        foreach ($statuses as $status) {
            if ($status['value'] == $status_tahapan) {
                $result = $status;
            }
        }
        return $result;
    }

}

?>