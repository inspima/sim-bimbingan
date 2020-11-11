<?php
$session_data = $this->session->userdata('logged_in');
$role       = $session_data['role'];
$sebagai    = $session_data['sebagai'];

if($sebagai)
{
    if($sebagai == '1') // dosen
    {
        redirect('dashboardd', 'refresh');
    }
    else
    if($sebagai == '2') // tendik
    {
        if($role == '1') // Admin
        {
            redirect('dashboarda','refresh');
        }
        else
        if($role == '2') // BAA
        {
            redirect('dashboardb','refresh');
        }
    }
    else
    if($sebagai == '3') // mahasiswa
    {
        redirect('dashboardm','refresh');
    }
}
else
{
	$this->load->view('backend/incl/sess_dest');
}
?>
