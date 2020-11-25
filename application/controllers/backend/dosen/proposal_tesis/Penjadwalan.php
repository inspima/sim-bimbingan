<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjadwalan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	//START SESS
	$this->session_data = $this->session->userdata('logged_in');
	
	if(!$this->session_data)
	{		
		redirect('logout','refresh');
	}
	else
	{
		if($this->session_data['sebagai'] != 1)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
    $this->load->model('backend/administrator/master/struktural_model','struktural');
    $this->load->model('backend/administrator/master/departemen_model','departemen');
    $this->load->model('backend/administrator/master/tesis_model','proposal');
    $this->load->model('backend/administrator/master/ruang_model','ruang');
    $this->load->model('backend/administrator/master/jam_model','jam');
    $this->load->model('backend/dosen/master/Dosen_model','dosen');
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        var_dump ($id_prodi);
        if($struktural->id_struktur == '8') //KPS S2
            
        {

            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal Tesis (Modul Sekertaris Prodi)',
                'subtitle'	=> 'Data Pengajuan Proposal Tesis',
                'section'	=> 'backend/dosen/proposal_tesis/penjadwalan',
                // DATA //
                'proposal'  => $this->proposal->read_proposal_acc($id_prodi)
                );
                //print_r($data['proposal']);die();
                $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd');
        }
    }
    
    public function detail()
    {
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '8') //KPS S2
        {
            $id_skripsi = $this->uri->segment('5');
            
            $data=array(
                // PAGE //
                'title'	=> 'Setting Proposal Tesis (Modul Ketua Program Studi)',
                'subtitle'	=> 'Setting Ujian',
                'section'	=> 'backend/dosen/proposal_tesis/detail',
                // DATA //
                'proposal'  => $this->proposal->detail_proposal($id_skripsi),
                'mruang'    => $this->ruang->read_aktif(),
                'mjam'      => $this->jam->read_aktif(),
                'mdosen'    => $this->dosen->read_aktif_alldep(),
                'ujian'     => $this->proposal->read_ujian($id_skripsi),
                'pembimbing'    => $this->proposal->read_pembimbing($id_skripsi),
            );
            if($data['proposal'])
            {
                $this->load->view('backend/index_sidebar',$data);	
            }
            else
            {
                $data['section'] = 'backend/notification/danger';
                $data['msg']	 = 'Tidak ditemukan';
                $data['linkback']= 'dashboardd/proposal_tesis/penjadwalan';
                $this->load->view('backend/index_sidebar',$data);	
            }	
                
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd');
        }
    }
    
    public function pembimbing_save()
    {
        $hand = $this->input->post('hand',TRUE);
        
        //var_dump($hand);
        
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $nip = $this->input->post('nip',TRUE);

            $datap = array(
                'id_skripsi' => $id_skripsi,
                'nip'	=> $nip,
                'status' => 2,
                'status_bimbingan' => 2,
                'id_jenjang' => 2
            );
            
            $this->proposal->save_pembimbing($datap);
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
            redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);  
            /*
           $hitungbimbingan = $this->proposal->hitung_bimbingan_aktif($nip);

            if($hitungbimbingan < '10')
            {
                $cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);
            
                if($cekpembimbing)
                {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah ada.');
                    redirect('dashboardd/proposal/kadep_diterima/plot/'.$id_skripsi);
                }
                else
                {
                    $this->proposal->save_pembimbing($datap);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
                    redirect('dashboardd/proposal/kadep_diterima/plot/'.$id_skripsi);  
                }
            }
            else
            if($hitungbimbingan >= '10')
            {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah aktif 10 bimbingan.');
                redirect('dashboardd/proposal/kadep_diterima/plot/'.$id_skripsi);
            }
             * 
             */

	}
    }
    
      public function ujian_save()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
            $id_departemen = $struktural->id_departemen;
            if($struktural->id_struktur == '8') //KPS S2
            {
                $id_skripsi = $this->input->post('id_skripsi',TRUE);
                $ujian     = $this->proposal->read_ujian($id_skripsi);
                
                if($ujian) // JIKA SUDAH ADA
                {
                    //echo 'jadwal sudah ada. tambah script update';  die();
                    $id_ujian = $this->input->post('id_ujian');

                    $data = array(
                        'id_skripsi'=> $id_skripsi,
                        'id_ruang'  => $this->input->post('id_ruang',TRUE),
                        'id_jam'    => $this->input->post('id_jam',TRUE),
                        'tanggal'   => todb($this->input->post('tanggal', TRUE)),
                        'status'    => 1,
                        'status_ujian' => 1,
                        'id_jenjang' => 2
                    );
                    
                    $cek_jadwal = $this->proposal->cek_ruang_terpakai($data);

                    if($cek_jadwal)
                    {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                    }
                    else
                    {
                        $penguji = $this->proposal->read_penguji($id_ujian);
                        
                        if($penguji)
                        {
                            foreach($penguji as $list)
                            {
                                $bentrok = $this->proposal->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                                break;
                            }
                            
                            if($bentrok)
                            {
        
                                $this->session->set_flashdata('msg-title', 'alert-danger');
                                $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                                redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                            }
                            else
                            {
                                $this->proposal->update_ujian($data, $id_ujian);
        
                                $this->session->set_flashdata('msg-title', 'alert-success');
                                $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                                redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                            }
                        }
                        else //langsung update
                        {
                            $this->proposal->update_ujian($data, $id_ujian);
        
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                        }
                    }
                }
                else //JIKA BELUM ADA SAVE BARU
                {
                    $data = array(
                        'id_skripsi'=> $id_skripsi,
                        'id_ruang'  => $this->input->post('id_ruang',TRUE),
                        'id_jam'    => $this->input->post('id_jam',TRUE),
                        'tanggal'   => todb($this->input->post('tanggal', TRUE)),
                        'jenis_ujian' => 1,
                        'status'    => 1,
                        'status_ujian' => 1,
                        'id_jenjang' => 2
                    );
                    
                    $cek_jadwal = $this->proposal->cek_ruang_terpakai($data);

                    if($cek_jadwal)
                    {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                    }
                    else
                    {
                        $this->proposal->save_ujian($data);
        
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                        redirect('dashboardd/proposal_tesis/penjadwalan/detail/'.$id_skripsi);
                    }
                        
                }
                
            }
            else
            {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Terjadi Kesalahan hak akses');
                redirect('dashboardd');
            }
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan 2');
            redirect('dashboardd');
        }
    }
    
    

}
?>