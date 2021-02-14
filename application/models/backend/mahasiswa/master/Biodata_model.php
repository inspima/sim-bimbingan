<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Biodata_model extends CI_Model {

    public function detail($username) {
        $this->db->select("m.*, u.id_user,u.no_hp, j.nm_jenjang, j.id_jenjang, concat(jp.jenjang,' ',p.nm_prodi) nm_prodi");
        $this->db->from('mahasiswa m');
        $this->db->join('user u', 'm.nim = u.username');
        $this->db->join('jenjang j', 'j.id_jenjang = m.id_jenjang', 'left');
        $this->db->join('prodi p', 'p.id_prodi = m.id_prodi', 'left');
		$this->db->join('jenjang jp', 'jp.id_jenjang = p.id_jenjang', 'left');
        $this->db->where('m.status', 1);
        $this->db->where('m.nim', $username);

        $query = $this->db->get();
        return $query->row();
    }

}

?>
