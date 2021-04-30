<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_model extends CI_Model {

	public function ujian_s1($id_semester, $id_departemen)
	{
        $sql = "
                SELECT  b.nama, b.nim, e.judul, d.tanggal, a.nilai, a.id_Skripsi, d.jenis_ujian
                FROM skripsi a
                LEFT JOIN mahasiswa b ON a.nim = b.nim
                LEFT JOIN gelombang_skripsi c ON a.id_gelombang = c.id_gelombang
                LEFT JOIN ujian d ON a.id_skripsi = d.id_skripsi
                LEFT JOIN judul e ON e.id_skripsi = a.id_skripsi
                WHERE  c.id_semester = '$id_semester'
                AND e.persetujuan = '1'
                AND (d.jenis_ujian = '2' OR d.jenis_ujian = '1') AND a.id_departemen = '$id_departemen'";
        
            return $this->db->query($sql)->result();
         }
         
         public function ujian_s2($start, $end)
	{
        $sql = "
                SELECT   b.nama, b.nim, e.judul as proposal, f.judul as mkpt, g.judul as tesis,  a.nilai, a.id_tesis, a.tgl_pengajuan as tanggal
                FROM tesis a
                LEFT JOIN mahasiswa b ON a.nim = b.nim
		LEFT JOIN (SELECT * FROM judul_tesis jtp WHERE jtp.jenis = '2')e ON e.id_tesis = a.id_tesis
		LEFT JOIN (SELECT * FROM judul_tesis jtm WHERE jtm.jenis = '3')f ON f.id_tesis = a.id_tesis
		LEFT JOIN (SELECT * FROM judul_tesis jtt WHERE jtt.jenis = '4')g ON g.id_tesis = a.id_tesis
		WHERE DATE_FORMAT(a.tgl_pengajuan,'%Y-%m-%d') <= DATE_FORMAT('$end','%Y-%m-%d')
		AND DATE_FORMAT(a.tgl_pengajuan,'%Y-%m-%d') >= DATE_FORMAT('$start','%Y-%m-%d')
		AND e.`status` = '1'";
        
            return $this->db->query($sql)->result();
         }

         public function bimbingan()
	{
        $sql = "SELECT a.nip, b.nama, count(*) as jumlah
                FROM pembimbing a
		LEFT JOIN pegawai b ON a.nip = b.nip
		JOIN (SELECT m.nama, m.nim, p.id_skripsi
                FROM pembimbing p
                LEFT JOIN skripsi s ON p.id_skripsi = s.id_skripsi
                LEFT JOIN mahasiswa m ON s.nim = m.nim
                GROUP BY m.nim) c ON c.id_skripsi = a.id_skripsi
               GROUP BY a.nip
               ORDER BY b.nama";
        
            return $this->db->query($sql)->result();
         }
         
         public function detail_bimbingan($nip)
	{
        $sql = "SELECT c.nama, c.nim, d.judul
                FROM pembimbing a
                LEFT JOIN skripsi b ON a.id_skripsi = b.id_skripsi
                LEFT JOIN mahasiswa c ON b.nim = c.nim
                LEFT JOIN judul d ON d.id_skripsi = b.id_skripsi
                WHERE a.nip = '$nip'
                GROUP BY b.nim";
        
            return $this->db->query($sql)->result();
         }

  
    
}
?>