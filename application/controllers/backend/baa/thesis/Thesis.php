<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thesis extends CI_Controller {

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
		if($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 2)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
    $this->load->model('backend/baa/master/gelombang_model','gelombang');
    $this->load->model('backend/dosen/master/dosen_model','dosen');
    $this->load->model('backend/baa/thesis/thesis_model','thesis');
    $this->load->model('backend/administrator/master/ruang_model','ruang');
    $this->load->model('backend/administrator/master/jam_model','jam');
    $this->load->model('backend/baa/master/mahasiswa_model','mahasiswa');
	//END MODEL
	}

	public function index()
	{
        $data=array(
        // PAGE //
        'title'		=> 'Thesis',
        'subtitle'	=> 'Data Thesis',
        'section'	=> 'backend/baa/thesis/thesis',
        // DATA //
        'thesis'  => $this->thesis->read()
        );

        $this->load->view('backend/index_sidebar',$data);	
    }

    public function add()
    {
        $data=array(
            // PAGE //
            'title'		=> 'Tambah Thesis',
            'subtitle'	=> 'Tambah Data Thesis',
            'section'	=> 'backend/baa/thesis/thesis_add',
            // DATA //
            'gelombang' => $this->gelombang->read_berjalan()
            );
    
            $this->load->view('backend/index_sidebar',$data);	
    }


    
       public function save()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
			$datas = array(
                'id_gelombang' => $this->input->post('id_gelombang',TRUE),
                'nim'   => $this->input->post('nim',TRUE),
                'id_departemen' => '1',
                'jenis' => '3',
            );
            $this->thesis->save_skripsi($datas);
            $last_id = $this->db->insert_id();

            // save tabel mhs
            $datam = array(
                'nim' => $this->input->post('nim',TRUE),
                'nama'=> $this->input->post('nama',TRUE),
            );
            $nim = $this->input->post('nim',TRUE);
            $cekmhs = $this->thesis->cek_mahasiswan($nim);
            if($cekmhs)
            {
                
            }
            else
            {
                $this->thesis->save_mahasiswa($datam);
            }
            
            //

            $dataj = array(
                'id_skripsi' => $last_id,
                'judul' => $this->input->post('judul',TRUE)
            );
            $this->thesis->save_judul($dataj);

            $datau = array(
                'id_skripsi' => $last_id,
                'jenis_ujian'=> '3',
                'status' => '1',
                'status_ujian' => '1'
            );
            $this->thesis->save_ujian($datau);

            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Tambah data thesis berhasil');
			redirect('dashboardb/thesis/thesis');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/thesis/thesis');
		}
    }


    public function setting()
    {
        $id_skripsi = $this->uri->segment(5); 
        $data=array(
        // PAGE //
        'title'		=> 'Modul (Mahasiswa)',
        'subtitle'	=> 'Bimbingan Skripsi',
        'section'	=> 'backend/baa/thesis/thesis_detail',
        // DATA //
        'thesis'  => $this->thesis->detail($id_skripsi),
        'ujian'     => $this->thesis->read_ujian($id_skripsi),
        'mruang'    => $this->ruang->read_aktif(),
        'mjam'  => $this->jam->read_aktif(),
        'mdosen'    => $this->dosen->read_aktif_alldep()
        );

        if($data['thesis'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboardb/thesis/thesis';
            $this->load->view('backend/index_sidebar',$data);	
        }		
    }

    public function ujian_save()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
			$id_skripsi = $this->input->post('id_skripsi',TRUE);
            $ujian     = $this->thesis->read_ujian($id_skripsi);
                
            if($ujian) // JIKA SUDAH ADA
            {
                $id_ujian = $this->input->post('id_ujian');

                $data = array(
                    'id_skripsi'=> $id_skripsi,
                    'id_ruang'  => $this->input->post('id_ruang',TRUE),
                    'id_jam'    => $this->input->post('id_jam',TRUE),
                    'tanggal'   => todb($this->input->post('tanggal', TRUE)),
                );
                    
                $cek_jadwal = $this->thesis->cek_ruang_terpakai($data);
                //stop here
                if($cek_jadwal)
                {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                    }
                    else
                    {
                        $penguji = $this->thesis->read_penguji($id_ujian);
                        
                        if($penguji)
                        {
                            foreach($penguji as $list)
                            {
                                $bentrok = $this->thesis->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                                break;
                            }
                            
                            if($bentrok)
                            {
        
                                $this->session->set_flashdata('msg-title', 'alert-danger');
                                $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                                redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                            }
                            else
                            {
                                $this->thesis->update_ujian($data, $id_ujian);
        
                                $this->session->set_flashdata('msg-title', 'alert-success');
                                $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                                redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                            }
                        }
                        else //langsung update
                        {
                            $this->thesis->update_ujian($data, $id_ujian);
        
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
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
                        'jenis_ujian' => 3,
                        'status'    => 1,
                        'status_ujian' => 1
                    );
                    
                    $cek_jadwal = $this->thesis->cek_ruang_terpakai($data);

                    if($cek_jadwal)
                    {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                    }
                    else
                    {
                        $this->thesis->save_ujian($data);
        
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                        redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                    }
                        
                }

		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/thesis/thesis');
		}
    }

    public function penguji_save()
    {
        $hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $id_ujian = $this->input->post('id_ujian',TRUE);
            $nip = $this->input->post('nip',TRUE);

            $data = array(
                'id_ujian' => $id_ujian,
                'nip'	=> $this->input->post('nip',TRUE),
                'status_tim' => 2,
                'status'    => 2
                );

            $cekpenguji = $this->thesis->cek_penguji($data);
            if($cekpenguji)
            {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
                redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
            }
            else
            {
                $ujian = $this->thesis->read_ujian($id_skripsi);
                $tanggal = $ujian->tanggal;
                $id_jam  = $ujian->id_jam;
                $pengujibentrok = $this->thesis->read_pengujibentrok($tanggal, $id_jam, $nip);
                
                if($pengujibentrok)
                {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                }
                else
                {
                    $jumlah_penguji = $this->thesis->count_penguji($id_ujian);
                    if($jumlah_penguji < '10')
                    {

                        // START EMAIL
                        /*$this->load->library('email');

							$config['protocol'] = 'smtp';
							$config['smtp_host'] = 'ssl://smtp.gmail.com';
							$config['smtp_port'] = '465';
							$config['smtp_user'] = 'usifhua@gmail.com';  //change it
							$config['smtp_pass'] = 'hukum2012'; //change it
							$config['charset'] = 'utf-8';
							$config['newline'] = "\r\n";
							$config['mailtype'] = 'html';
							$config['wordwrap'] = TRUE;
							$this->email->initialize($config);

							$this->email->set_newline("\r\n");
							$this->email->from('usifhua@gmail.com', 'IURIS');
							//CHANGE
							//$this->email->to('icocspa@fisip.unair.ac.id');
							$this->email->to('rachmadkuncoro@gmail.com');
							$this->email->subject('Ada Permintaan IURIS');

							$msg = "Yth. Dosen<br>Mohon untuk membuka aplikasi iuris anda. Terdapat Penunjukan Penguji Skripsi.<br><br>Tertanda<br>Wakil Dekan I";

							$this->email->message($msg);

							if($this->email->send()) // IF EMAIL SUCCESS SEND
							{
								$mesg = 'Berhasil set penguji. Email berhasil dikirim.';
							}
							else // IF EMAIL GAGAL
							{
								$mesg = 'Berhasil set penguji. Email gagal dikirim.';
                            }
                        */
                        
                        $this->thesis->save_penguji($data);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', $mesg);
                        redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                    }
                    else
                    if($jumlah_penguji >= '10')
                    {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji');
                        redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
                    }
                }
            }
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd/proposal/kadep_diterima');
		}
    }
    
    public function penguji_delete()
    {
        $hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $id_penguji = $this->input->post('id_penguji',TRUE);

            $data = array(
                'status' => 0,
                );

            $this->thesis->update_penguji($data, $id_penguji);
            
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('dashboardb/thesis/thesis/setting/'.$id_skripsi);
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/thesis/thesis');
		}
    }

}
?>