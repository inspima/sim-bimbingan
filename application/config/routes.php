<?php


	defined('BASEPATH') or exit('No direct script access allowed');


	/*

	  | -------------------------------------------------------------------------

	  | URI ROUTING

	  | -------------------------------------------------------------------------

	  | This file lets you re-map URI requests to specific controller functions.

	  |

	  | Typically there is a one-to-one relationship between a URL string

	  | and its corresponding controller class/method. The segments in a

	  | URL normally follow this pattern:

	  |

	  |	example.com/class/method/id/

	  |

	  | In some instances, however, you may want to remap this relationship

	  | so that a different class/function is called than the one

	  | corresponding to the URL.

	  |

	  | Please see the user guide for complete details:

	  |

	  |	https://codeigniter.com/user_guide/general/routing.html

	  |

	  | -------------------------------------------------------------------------

	  | RESERVED ROUTES

	  | -------------------------------------------------------------------------

	  |

	  | There are three reserved routes:

	  |

	  |	$route['default_controller'] = 'welcome';

	  |

	  | This route indicates which controller class should be loaded if the

	  | URI contains no data. In the above example, the "welcome" class

	  | would be loaded.

	  |

	  |	$route['404_override'] = 'errors/page_missing';

	  |

	  | This route will tell the Router which controller/method to use if those

	  | provided in the URL cannot be matched to a valid route.

	  |

	  |	$route['translate_uri_dashes'] = FALSE;

	  |

	  | This is not exactly a route, but allows you to automatically route

	  | controller and method names that contain dashes. '-' isn't a valid

	  | class or method name character, so it requires translation.

	  | When you set this option to TRUE, it will replace ALL dashes in the

	  | controller and method URI segments.

	  |

	  | Examples:	my-controller/index	-> my_controller/index

	  |		my-controller/my-method	-> my_controller/my_method

	 */

	$route['default_controller'] = 'welcome';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = false;


	$route['login'] = 'backend/login';
	$route['login/gen'] = 'backend/login/gen';
	$route['login/auth'] = 'backend/login/auth';
	$route['logout'] = 'backend/login/logout';

	$route['register'] = 'backend/auth/register';
	$route['reset-account'] = 'backend/auth/reset_account';

	$route['auth/register'] = 'backend/auth/register';
	$route['auth/verifikasi'] = 'backend/auth/verifikasi';
	$route['auth/reset-account'] = 'backend/auth/reset_account';
	$route['auth/captcha/refresh'] = 'backend/auth/captcha_refresh';

	$route['utility'] = 'backend/utility';
	$route['utility/change_password'] = 'backend/utility/change_password';

	$route['profile'] = 'backend/profile';
	$route['profile/password'] = 'backend/profile/change_password';
	$route['profile/password/save'] = 'backend/profile/change_password_save';
	$route['profile/signature'] = 'backend/profile/signature';
	$route['profile/phone/save'] = 'backend/profile/phone_save';
	$route['profile/signature/change'] = 'backend/profile/signature_change';
	$route['profile/signature/view'] = 'backend/profile/signature_view';
	$route['profile/signature/upload'] = 'backend/profile/signature_upload';

	/* API */
	$route['api/profile/signature/save'] = 'backend/profile/signature_save';


	//1. Dashboard Admin
	$route['dashboarda'] = 'backend/administrator/home';
	$route['dashboarda/master/user'] = 'backend/administrator/master/admin_user';
	$route['dashboarda/master/user/add_pegawai'] = 'backend/administrator/master/admin_user/add_pegawai';
	$route['dashboarda/master/user/add_dosen'] = 'backend/administrator/master/admin_user/add_dosen';
	$route['dashboarda/master/user/edit_pegawai/(:num)/(:num)'] = 'backend/administrator/master/admin_user/edit_pegawai/$1/$2';
	$route['dashboarda/master/user/save_pegawai'] = 'backend/administrator/master/admin_user/save_pegawai';
	$route['dashboarda/master/user/save_dosen'] = 'backend/administrator/master/admin_user/save_dosen';
	$route['dashboarda/master/user/update_pegawai'] = 'backend/administrator/master/admin_user/update_pegawai';
	$route['dashboarda/master/user/detail/(:num)'] = 'backend/administrator/master/admin_user/detail/$1';
	$route['dashboarda/master/user/update_password'] = 'backend/administrator/master/admin_user/update_password';
	$route['dashboarda/master/user/direct_login'] = 'backend/administrator/master/admin_user/direct_login';
	$route['dashboarda/master/user/reset_verifikasi'] = 'backend/administrator/master/admin_user/reset_verifikasi';

	$route['dashboarda/master/struktural'] = 'backend/administrator/master/struktural';
	$route['dashboarda/master/struktural/detail/(:num)'] = 'backend/administrator/master/struktural/detail/$1';
	$route['dashboarda/master/struktural/update'] = 'backend/administrator/master/struktural/update';

	//2. Dashboard BAA
	$route['dashboardb'] = 'backend/baa/home';


	$route['dashboardb/master/semester'] = 'backend/baa/master/semester';
	$route['dashboardb/master/semester/add'] = 'backend/baa/master/semester/add';
	$route['dashboardb/master/semester/save'] = 'backend/baa/master/semester/save';
	$route['dashboardb/master/semester/edit/(:num)'] = 'backend/baa/master/semester/edit/$1';
	$route['dashboardb/master/semester/update'] = 'backend/baa/master/semester/update';
	$route['dashboardb/master/semester/update_berjalan'] = 'backend/baa/master/semester/update_berjalan';

	$route['dashboardb/master/gelombang'] = 'backend/baa/master/gelombang';
	$route['dashboardb/master/gelombang/add'] = 'backend/baa/master/gelombang/add';
	$route['dashboardb/master/gelombang/save'] = 'backend/baa/master/gelombang/save';
	$route['dashboardb/master/gelombang/edit/(:num)'] = 'backend/baa/master/gelombang/edit/$1';
	$route['dashboardb/master/gelombang/update'] = 'backend/baa/master/gelombang/update';
	$route['dashboardb/master/gelombang/update_berjalan'] = 'backend/baa/master/gelombang/update_berjalan';

	$route['dashboardb/master/dosen'] = 'backend/baa/master/dosen';
	$route['dashboardb/master/dosen/update_berjalan'] = 'backend/baa/master/dosen/update_berjalan';

	$route['dashboardb/master/mahasiswa'] = 'backend/baa/master/mahasiswa';
	$route['dashboardb/master/mahasiswa/add'] = 'backend/baa/master/mahasiswa/add';
	$route['dashboardb/master/mahasiswa/save'] = 'backend/baa/master/mahasiswa/save';
	$route['dashboardb/master/mahasiswa/edit/(:num)'] = 'backend/baa/master/mahasiswa/edit/$1';
	$route['dashboardb/master/mahasiswa/update'] = 'backend/baa/master/mahasiswa/update';
	$route['dashboardb/master/mahasiswa/update_password'] = 'backend/baa/master/mahasiswa/update_password';
	$route['dashboardb/master/mahasiswa/import'] = 'backend/baa/master/mahasiswa/import';
	$route['dashboardb/master/mahasiswa/download_excel'] = 'backend/baa/master/mahasiswa/download_excel';
	$route['dashboardb/master/mahasiswa/import_save'] = 'backend/baa/master/mahasiswa/import_save';
	$route['dashboardb/master/mahasiswa/aktifkan'] = 'backend/baa/master/mahasiswa/aktifkan';
	$route['dashboardb/master/mahasiswa/aktifkan_save'] = 'backend/baa/master/mahasiswa/aktifkan_save';

	$route['dashboardb/modul/berita'] = 'backend/baa/modul/berita';
	$route['dashboardb/modul/berita/add'] = 'backend/baa/modul/berita/add';
	$route['dashboardb/modul/berita/save'] = 'backend/baa/modul/berita/save';
	$route['dashboardb/modul/berita/edit/(:num)'] = 'backend/baa/modul/berita/edit/$1';
	$route['dashboardb/modul/berita/update'] = 'backend/baa/modul/berita/update';
	$route['dashboardb/modul/berita/update_status'] = 'backend/baa/modul/berita/update_status';

	$route['dashboardb/proposal/proposal_pengajuan'] = 'backend/baa/proposal/proposal_pengajuan';
	$route['dashboardb/proposal/proposal_diterima'] = 'backend/baa/proposal/proposal_diterima';
	$route['dashboardb/proposal/proposal_diterima/cetak_surat_tugas'] = 'backend/baa/proposal/proposal_diterima/cetak_surat_tugas';
	$route['dashboardb/proposal/proposal_diterima/cetak_undangan'] = 'backend/baa/proposal/proposal_diterima/cetak_undangan';
	$route['dashboardb/proposal/proposal_diterima/cetak_berita'] = 'backend/baa/proposal/proposal_diterima/cetak_berita';
	$route['dashboardb/proposal/proposal_diterima/cetak_absensi'] = 'backend/baa/proposal/proposal_diterima/cetak_absensi';

	$route['dashboardb/proposal/proposal_selesai'] = 'backend/baa/proposal/proposal_selesai';
	$route['dashboardb/proposal/penguji_pengajuan'] = 'backend/baa/proposal/penguji_pengajuan';

	$route['dashboardb/skripsi/skripsi_belum_daftar'] = 'backend/baa/skripsi/skripsi_belum_daftar';

	$route['dashboardb/skripsi/skripsi_pengajuan'] = 'backend/baa/skripsi/skripsi_pengajuan';
	$route['dashboardb/skripsi/skripsi_pengajuan/bimbingan/(:num)'] = 'backend/baa/skripsi/skripsi_pengajuan/bimbingan/$1';
	$route['dashboardb/skripsi/skripsi_pengajuan/approve'] = 'backend/baa/skripsi/skripsi_pengajuan/approve';

	$route['dashboardb/skripsi/skripsi_diterima'] = 'backend/baa/skripsi/skripsi_diterima';
	$route['dashboardb/skripsi/skripsi_diterima/bimbingan/(:num)'] = 'backend/baa/skripsi/skripsi_diterima/bimbingan/$1';
	$route['dashboardb/skripsi/skripsi_diterima/update_berkas'] = 'backend/baa/skripsi/skripsi_diterima/update_berkas';

	$route['dashboardb/skripsi/skripsi_ujian'] = 'backend/baa/skripsi/skripsi_ujian';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_surat_tugas'] = 'backend/baa/skripsi/skripsi_ujian/cetak_surat_tugas';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_berita'] = 'backend/baa/skripsi/skripsi_ujian/cetak_berita';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_pemberitahuan'] = 'backend/baa/skripsi/skripsi_ujian/cetak_pemberitahuan';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_penilaian'] = 'backend/baa/skripsi/skripsi_ujian/cetak_penilaian';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_rekapitulasi'] = 'backend/baa/skripsi/skripsi_ujian/cetak_rekapitulasi';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_perbaikan'] = 'backend/baa/skripsi/skripsi_ujian/cetak_perbaikan';
	$route['dashboardb/skripsi/skripsi_ujian/cetak_absensi'] = 'backend/baa/skripsi/skripsi_ujian/cetak_absensi';
	$route['dashboardb/skripsi/skripsi_penguji_pengajuan'] = 'backend/baa/skripsi/skripsi_penguji_pengajuan';


	$route['dashboardb/thesis/thesis'] = 'backend/baa/thesis/thesis';
	$route['dashboardb/thesis/thesis/add'] = 'backend/baa/thesis/thesis/add';
	$route['dashboardb/thesis/thesis/save'] = 'backend/baa/thesis/thesis/save';
	$route['dashboardb/thesis/thesis/setting/(:num)'] = 'backend/baa/thesis/thesis/setting/$1';
	$route['dashboardb/thesis/thesis/ujian_save'] = 'backend/baa/thesis/thesis/ujian_save';
	$route['dashboardb/thesis/thesis/penguji_save'] = 'backend/baa/thesis/thesis/penguji_save';
	$route['dashboardb/thesis/thesis/penguji_delete'] = 'backend/baa/thesis/thesis/penguji_delete';

	$route['dashboardb/monitoring/jadwal'] = 'backend/baa/monitoring/jadwal';
	$route['dashboardb/monitoring/jadwal/show'] = 'backend/baa/monitoring/jadwal/show';


	//3. Dashboard Mahasiswa S1

	$route['dashboardm'] = 'backend/mahasiswa/home';

	$route['dashboardm/modul/proposal'] = 'backend/mahasiswa/modul/proposal';
	$route['dashboardm/modul/proposal/add'] = 'backend/mahasiswa/modul/proposal/add';
	$route['dashboardm/modul/proposal/save'] = 'backend/mahasiswa/modul/proposal/save';
	$route['dashboardm/modul/proposal/edit/(:num)'] = 'backend/mahasiswa/modul/proposal/edit/$1';
	$route['dashboardm/modul/proposal/update'] = 'backend/mahasiswa/modul/proposal/update';
	$route['dashboardm/modul/proposal/update_file'] = 'backend/mahasiswa/modul/proposal/update_file';
	$route['dashboardm/modul/proposal/ujian/(:num)'] = 'backend/mahasiswa/modul/proposal/ujian/$1';

	$route['dashboardm/modul/skripsi'] = 'backend/mahasiswa/modul/skripsi';
	$route['dashboardm/modul/skripsi/syarat/(:num)'] = 'backend/mahasiswa/modul/skripsi/syarat/$1';
	$route['dashboardm/modul/skripsi/syarat_upload'] = 'backend/mahasiswa/modul/skripsi/syarat_upload';
	$route['dashboardm/modul/skripsi/save_judul'] = 'backend/mahasiswa/modul/skripsi/save_judul';
	$route['dashboardm/modul/skripsi/ujian/(:num)'] = 'backend/mahasiswa/modul/skripsi/ujian/$1';
	$route['dashboardm/modul/skripsi/update_toefl'] = 'backend/mahasiswa/modul/skripsi/update_toefl';
	$route['dashboardm/modul/skripsi/bimbingan/(:num)'] = 'backend/mahasiswa/modul/skripsi/bimbingan/$1';
	$route['dashboardm/modul/skripsi/bimbingan_save'] = 'backend/mahasiswa/modul/skripsi/bimbingan_save';
	$route['dashboardm/modul/skripsi/bimbingan_delete'] = 'backend/mahasiswa/modul/skripsi/bimbingan_delete';
	$route['dashboardm/modul/skripsi/daftar'] = 'backend/mahasiswa/modul/skripsi/daftar';


	//3a. Dashboard Mahasiswa S2

	$route['dashboardm'] = 'backend/mahasiswa/home';

	$route['dashboardm/magister/proposal_tesis'] = 'backend/mahasiswa/magister/proposal_tesis';
	$route['dashboardm/magister/proposal_tesis/add'] = 'backend/mahasiswa/magister/proposal_tesis/add';
	$route['dashboardm/magister/proposal_tesis/save'] = 'backend/mahasiswa/magister/proposal_tesis/save';
	$route['dashboardm/magister/proposal_tesis/edit/(:num)'] = 'backend/mahasiswa/magister/proposal_tesis/edit/$1';
	$route['dashboardm/magister/proposal_tesis/update'] = 'backend/mahasiswa/magister/proposal_tesis/update';
	$route['dashboardm/magister/proposal_tesis/update_file'] = 'backend/mahasiswa/magister/proposal_tesis/update_file';
	$route['dashboardm/magister/proposal_tesis/ujian/(:num)'] = 'backend/mahasiswa/magister/proposal_tesis/ujian/$1';


	//4. Dashboard Dosen

	$route['dashboardd'] = 'backend/dosen/home';

	$route['dashboardd/proposal/kadep_pengajuan'] = 'backend/dosen/proposal/kadep_pengajuan';
	$route['dashboardd/proposal/kadep_pengajuan/edit/(:num)'] = 'backend/dosen/proposal/kadep_pengajuan/edit/$1';
	$route['dashboardd/proposal/kadep_pengajuan/update_departemen'] = 'backend/dosen/proposal/kadep_pengajuan/update_departemen';
	$route['dashboardd/proposal/kadep_pengajuan/update_proses'] = 'backend/dosen/proposal/kadep_pengajuan/update_proses';
	$route['dashboardd/proposal/kadep_diterima'] = 'backend/dosen/proposal/kadep_diterima';
	$route['dashboardd/proposal/kadep_diterima/edit/(:num)'] = 'backend/dosen/proposal/kadep_diterima/edit/$1';
	$route['dashboardd/proposal/kadep_diterima/plot/(:num)'] = 'backend/dosen/proposal/kadep_diterima/plot/$1';
	$route['dashboardd/proposal/kadep_diterima/ujian_save'] = 'backend/dosen/proposal/kadep_diterima/ujian_save';
	$route['dashboardd/proposal/kadep_diterima/penguji_save'] = 'backend/dosen/proposal/kadep_diterima/penguji_save';
	$route['dashboardd/proposal/kadep_diterima/penguji_delete'] = 'backend/dosen/proposal/kadep_diterima/penguji_delete';
	$route['dashboardd/proposal/kadep_diterima/penguji_update_statustim'] = 'backend/dosen/proposal/kadep_diterima/penguji_update_statustim';
	$route['dashboardd/proposal/kadep_diterima/pembimbing_save'] = 'backend/dosen/proposal/kadep_diterima/pembimbing_save';
	$route['dashboardd/proposal/kadep_diterima/update_status_ujian'] = 'backend/dosen/proposal/kadep_diterima/update_status_ujian';
	$route['dashboardd/proposal/kadep_selesai'] = 'backend/dosen/proposal/kadep_selesai';
	$route['dashboardd/proposal/kadep_selesai/edit/(:num)'] = 'backend/dosen/proposal/kadep_selesai/edit/$1';
	$route['dashboardd/proposal/kadep_ditolak'] = 'backend/dosen/proposal/kadep_ditolak';
	$route['dashboardd/proposal/kadep_ditolak/edit/(:num)'] = 'backend/dosen/proposal/kadep_ditolak/edit/$1';
	$route['dashboardd/proposal/kadep_ditolak/update_proses'] = 'backend/dosen/proposal/kadep_ditolak/update_proses';

	$route['dashboardd/monitoring/jadwal'] = 'backend/dosen/monitoring/jadwal';
	$route['dashboardd/monitoring/jadwal/show'] = 'backend/dosen/monitoring/jadwal/show';
	$route['dashboardd/monitoring/pembimbing'] = 'backend/dosen/monitoring/pembimbing';

	$route['dashboardd/proposal/kps_proposal'] = 'backend/dosen/proposal/kps_proposal';
	$route['dashboardd/proposal/kps_proposal/gelombang'] = 'backend/dosen/proposal/kps_proposal/gelombang';
	$route['dashboardd/proposal/penguji_pengajuan'] = 'backend/dosen/proposal/penguji_pengajuan';
	$route['dashboardd/proposal/penguji_pengajuan/update_penguji'] = 'backend/dosen/proposal/penguji_pengajuan/update_penguji';
	$route['dashboardd/proposal/penguji_approve'] = 'backend/dosen/proposal/penguji_approve';


	$route['dashboardd/skripsi/pembimbing_pengajuan'] = 'backend/dosen/skripsi/pembimbing_pengajuan';
	$route['dashboardd/skripsi/pembimbing_pengajuan/update_pembimbing'] = 'backend/dosen/skripsi/pembimbing_pengajuan/update_pembimbing';
	$route['dashboardd/skripsi/pembimbing_approve'] = 'backend/dosen/skripsi/pembimbing_approve';
	$route['dashboardd/skripsi/pembimbing_approve/bimbingan/(:num)'] = 'backend/dosen/skripsi/pembimbing_approve/bimbingan/$1';
	$route['dashboardd/skripsi/pembimbing_approve/bimbingan_update'] = 'backend/dosen/skripsi/pembimbing_approve/bimbingan_update';
	$route['dashboardd/skripsi/pembimbing_approve/save_penguji'] = 'backend/dosen/skripsi/pembimbing_approve/save_penguji';
	$route['dashboardd/skripsi/pembimbing_approve/approve_skripsi'] = 'backend/dosen/skripsi/pembimbing_approve/approve_skripsi';

	$route['dashboardd/skripsi/kadep_blm_skripsi'] = 'backend/dosen/skripsi/kadep_blm_skripsi';
	$route['dashboardd/skripsi/kadep_blm_skripsi/ujian/(:num)'] = 'backend/dosen/skripsi/kadep_blm_skripsi/ujian/$1';
	$route['dashboardd/skripsi/kadep_blm_skripsi/ujian_simpan'] = 'backend/dosen/skripsi/kadep_blm_skripsi/ujian_simpan';
	$route['dashboardd/skripsi/kadep_blm_skripsi/ujian_plot/(:num)/(:num)'] = 'backend/dosen/skripsi/kadep_blm_skripsi/ujian_plot/$1/$1';
	$route['dashboardd/skripsi/kadep_blm_skripsi/ujian_plot_save'] = 'backend/dosen/skripsi/kadep_blm_skripsi/ujian_plot_save';
	$route['dashboardd/skripsi/kadep_blm_skripsi/penguji_plot_save'] = 'backend/dosen/skripsi/kadep_blm_skripsi/penguji_plot_save';
	$route['dashboardd/skripsi/kadep_blm_skripsi/penguji_delete'] = 'backend/dosen/skripsi/kadep_blm_skripsi/penguji_delete';
	$route['dashboardd/skripsi/kadep_blm_skripsi/update_pembimbing'] = 'backend/dosen/skripsi/kadep_blm_skripsi/update_pembimbing';
	$route['dashboardd/skripsi/kadep_blm_skripsi/penguji_update_statustim'] = 'backend/dosen/skripsi/kadep_blm_skripsi/penguji_update_statustim';


	//yg sudah skripsi

	$route['dashboardd/skripsi/kadep_skripsi'] = 'backend/dosen/skripsi/kadep_skripsi';
	$route['dashboardd/skripsi/kps_skripsi'] = 'backend/dosen/skripsi/kps_skripsi';

	//$route['dashboardd/skripsi/kps_skripsi/kps_skripsi_data'] = 'backend/dosen/skripsi/kps_skripsi/kps_skripsi_data';
	$route['dashboardd/skripsi/kps_skripsi/approve'] = 'backend/dosen/skripsi/kps_skripsi/approve';
	$route['dashboardd/skripsi/kps_skripsi/filter_tahun'] = 'backend/dosen/skripsi/kps_skripsi/filter_tahun';
	$route['dashboardd/skripsi/penguji_pengajuan'] = 'backend/dosen/skripsi/penguji_pengajuan';
	$route['dashboardd/skripsi/penguji_pengajuan/update_penguji'] = 'backend/dosen/skripsi/penguji_pengajuan/update_penguji';
	$route['dashboardd/skripsi/penguji_approve'] = 'backend/dosen/skripsi/penguji_approve';
	$route['dashboardd/skripsi/penguji_approve/update_nilai'] = 'backend/dosen/skripsi/penguji_approve/update_nilai';

	//Proposal Tesis
	$route['dashboardd/proposal_tesis/pengajuan'] = 'backend/dosen/proposal_tesis/pengajuan';
	$route['dashboardd/proposal_tesis/pengajuan/approve/(:num)'] = 'backend/dosen/proposal_tesis/pengajuan/approve/$1';
	$route['dashboardd/proposal_tesis/pengajuan/reject/(:num)'] = 'backend/dosen/proposal_tesis/pengajuan/reject/$1';
	$route['dashboardd/proposal_tesis/penjadwalan'] = 'backend/dosen/proposal_tesis/penjadwalan';
	$route['dashboardd/proposal_tesis/penjadwalan/detail/(:num)'] = 'backend/dosen/proposal_tesis/penjadwalan/detail/$1';
	$route['dashboardd/proposal_tesis/penjadwalan/pembimbing_save'] = 'backend/dosen/proposal_tesis/penjadwalan/pembimbing_save';
	$route['dashboardd/proposal_tesis/penguji'] = 'backend/dosen/proposal_tesis/penguji';
	$route['dashboardd/proposal_tesis/pembimbing'] = 'backend/dosen/proposal_tesis/pembimbing';
	/*
	 * JENJANG SARJANA
	 */
	// Proposal

	// Kadep
	$route['dosen/sarjana/kadep/proposal/pengajuan'] = 'backend/dosen/skripsi/kadep_proposal/pengajuan';
	$route['dosen/sarjana/kadep/proposal/diterima'] = 'backend/dosen/skripsi/kadep_proposal/diterima';
	$route['dosen/sarjana/kadep/proposal/edit/(:num)'] = 'backend/dosen/skripsi/kadep_proposal/edit';
	$route['dosen/sarjana/kadep/proposal/plot/(:num)'] = 'backend/dosen/skripsi/kadep_proposal/plot';
	$route['dosen/sarjana/kadep/proposal/plot_pembimbing/(:num)'] = 'backend/dosen/skripsi/kadep_proposal/plot_pembimbing';
	$route['dosen/sarjana/kadep/proposal/plot_ulang/(:num)'] = 'backend/dosen/skripsi/kadep_proposal/plot_ulang';
	$route['dosen/sarjana/kadep/proposal/selesai'] = 'backend/dosen/skripsi/kadep_proposal/selesai';
	$route['dosen/sarjana/kadep/proposal/ditolak'] = 'backend/dosen/skripsi/kadep_proposal/ditolak';
	$route['dosen/sarjana/kadep/proposal/update_departemen'] = 'backend/dosen/skripsi/kadep_proposal/update_departemen';
	$route['dosen/sarjana/kadep/proposal/update_proses'] = 'backend/dosen/skripsi/kadep_proposal/update_proses';
	$route['dosen/sarjana/kadep/proposal/ujian_save'] = 'backend/dosen/skripsi/kadep_proposal/ujian_save';
	$route['dosen/sarjana/kadep/proposal/ujian_ulang_save'] = 'backend/dosen/skripsi/kadep_proposal/ujian_ulang_save';
	$route['dosen/sarjana/kadep/proposal/penguji_save'] = 'backend/dosen/skripsi/kadep_proposal/penguji_save';
	$route['dosen/sarjana/kadep/proposal/penguji_delete'] = 'backend/dosen/skripsi/kadep_proposal/penguji_delete';
	$route['dosen/sarjana/kadep/proposal/penguji_update_statustim'] = 'backend/dosen/skripsi/kadep_proposal/penguji_update_statustim';
	$route['dosen/sarjana/kadep/proposal/update_status_ujian'] = 'backend/dosen/skripsi/kadep_proposal/update_status_ujian';
	$route['kadep/sarjana/kadep/proposal/kirim_whatsapp'] = 'backend/dosen/skripsi/kadep_proposal/penguji_kirim_whatsapp';
	$route['kadep/sarjana/kadep/proposal/pembimbing_save'] = 'backend/dosen/skripsi/kadep_proposal/pembimbing_save';
	$route['kadep/sarjana/kadep/proposal/pembimbing_delete'] = 'backend/dosen/skripsi/kadep_proposal/pembimbing_delete';
	$route['kadep/sarjana/kadep/proposal/pembimbing_konfirm'] = 'backend/dosen/skripsi/kadep_proposal/pembimbing_konfirm';

	//Dosen
	$route['dosen/sarjana/proposal/penguji_pengajuan'] = 'backend/dosen/skripsi/penguji_skripsi/index_proposal';
	$route['dosen/sarjana/proposal/penguji_riwayat'] = 'backend/dosen/skripsi/penguji_skripsi/riwayat_proposal';
	$route['dosen/sarjana/skripsi/penguji_pengajuan'] = 'backend/dosen/skripsi/penguji_skripsi/index_skripsi';
	$route['dosen/sarjana/skripsi/penguji_riwayat'] = 'backend/dosen/skripsi/penguji_skripsi/riwayat_skripsi';
	$route['dosen/sarjana/skripsi/penguji_riwayat/update_nilai'] = 'backend/dosen/skripsi/penguji_skripsi/update_nilai';

	// BAA
	$route['baa/sarjanah/proposal/index'] = 'backend/baa/sarjanah/proposal';
	$route['baa/sarjanah/proposal/diterima'] = 'backend/baa/sarjanah/proposal/diterima';
	$route['baa/sarjanah/proposal/selesai'] = 'backend/baa/sarjanah/proposal/selesai';
	$route['baa/sarjanah/proposal/ditolak'] = 'backend/baa/sarjanah/proposal/ditolak';
	$route['baa/sarjanah/proposal/belum_approve'] = 'backend/baa/sarjanah/proposal/belum_approve';
	$route['baa/sarjanah/proposal/cetak_surat_tugas'] = 'backend/baa/sarjanah/proposal/cetak_surat_tugas';
	$route['baa/sarjanah/proposal/cetak_undangan'] = 'backend/baa/sarjanah/proposal/cetak_undangan';
	$route['baa/sarjanah/proposal/cetak_berita'] = 'backend/baa/sarjanah/proposal/cetak_berita';
	$route['baa/sarjanah/proposal/cetak_berita_ulang'] = 'backend/baa/sarjanah/proposal/cetak_berita_ulang';
	$route['baa/sarjanah/proposal/cetak_absensi'] = 'backend/baa/sarjanah/proposal/cetak_absensi';

	$route['baa/sarjanah/skripsi/index'] = 'backend/baa/sarjanah/skripsi_baa';
	$route['baa/sarjanah/skripsi/pengajuan'] = 'backend/baa/sarjanah/skripsi_baa/pengajuan';
	$route['baa/sarjanah/skripsi/diterima'] = 'backend/baa/sarjanah/skripsi_baa/diterima';
	$route['baa/sarjanah/skripsi/ujian'] = 'backend/baa/sarjanah/skripsi_baa/ujian';
	$route['baa/sarjanah/skripsi/belum_approve'] = 'backend/baa/sarjanah/skripsi_baa/belum_approve';
	$route['baa/sarjanah/skripsi/cetak_surat_tugas'] = 'backend/baa/sarjanah/skripsi_baa/cetak_surat_tugas';
	$route['baa/sarjanah/skripsi/cetak_berita'] = 'backend/baa/sarjanah/skripsi_baa/cetak_berita';
	$route['baa/sarjanah/skripsi/cetak_berita_ulang'] = 'backend/baa/sarjanah/skripsi_baa/cetak_berita_ulang';

	/*
	 * JENJANG DOKTOR
	 */

	// BAA
	$route['baa/tesis/ujian'] = 'backend/baa/tesis/ujian';
	$route['baa/tesis/ujian/index/(:num)'] = 'backend/baa/tesis/ujian/index';
	$route['baa/tesis/ujian/approve/(:num)'] = 'backend/baa/tesis/ujian/approve';
	$route['baa/tesis/ujian/reject/(:num)'] = 'backend/baa/tesis/ujian/reject';
	$route['baa/tesis/ujian/batal/(:num)'] = 'backend/baa/tesis/ujian/batal';
	$route['baa/tesis/ujian/nilai_ujian/(:num)/(:num)'] = 'backend/baa/tesis/ujian/nilai_ujian';
	$route['baa/tesis/ujian/nilai_ujian_save'] = 'backend/baa/tesis/ujian/nilai_ujian_save';

	$route['baa/magister/tesis/proposal'] = 'backend/baa/magister/tesis_proposal';
	$route['baa/magister/tesis/proposal/cetak_undangan'] = 'backend/baa/magister/tesis_proposal/cetak_undangan';
	$route['baa/magister/tesis/proposal/cetak_berita'] = 'backend/baa/magister/tesis_proposal/cetak_berita';
	$route['baa/magister/tesis/proposal/cetak_penilaian'] = 'backend/baa/magister/tesis_proposal/cetak_penilaian';
	$route['baa/magister/tesis/proposal/cetak_absensi'] = 'backend/baa/magister/tesis_proposal/cetak_absensi';

	$route['baa/magister/tesis/ujian'] = 'backend/baa/magister/tesis_ujian';
	$route['baa/magister/tesis/ujian/cetak_undangan'] = 'backend/baa/magister/tesis_ujian/cetak_undangan';
	$route['baa/magister/tesis/ujian/cetak_berita'] = 'backend/baa/magister/tesis_ujian/cetak_berita';
	$route['baa/magister/tesis/ujian/cetak_penilaian'] = 'backend/baa/magister/tesis_ujian/cetak_penilaian';
	$route['baa/magister/tesis/ujian/cetak_absensi'] = 'backend/baa/magister/tesis_ujian/cetak_absensi';
	$route['baa/magister/tesis/ujian/nilai_ujian/(:num)/(:num)'] = 'backend/baa/magister/tesis_ujian/nilai_ujian';
	$route['baa/magister/tesis/ujian/nilai_ujian_save'] = 'backend/baa/magister/tesis_ujian/nilai_ujian_save';

	$route['baa/master/pekan'] = 'backend/baa/master/pekan/index';
	$route['baa/master/pekan/add'] = 'backend/baa/master/pekan/add';
	$route['baa/master/pekan/save'] = 'backend/baa/master/pekan/save';
	$route['baa/master/pekan/edit/(:num)'] = 'backend/baa/master/pekan/edit';
	$route['baa/master/pekan/update'] = 'backend/baa/master/pekan/update';

	$route['baa/master/dosen'] = 'backend/baa/master/dosen/index';
	$route['baa/master/dosen/edit/(:num)'] = 'backend/baa/master/dosen/edit';
	$route['baa/master/dosen/update'] = 'backend/baa/master/dosen/update';

	$route['baa/utility/registrasi'] = 'backend/baa/utility/registrasi';
	$route['baa/utility/registrasi/verifikasi'] = 'backend/baa/utility/registrasi/verifikasi';
	$route['baa/utility/pencarian'] = 'backend/baa/utility/pencarian';

	$route['baa/report/skripsi'] = 'backend/baa/report/skripsi';
	$route['baa/report/skripsi/bimbingan'] = 'backend/baa/report/skripsi/bimbingan';
	$route['baa/report/skripsi/detail_bimbingan'] = 'backend/baa/report/skripsi/detail_bimbingan';

	// KPS & SPS & PROMOTOR
	$route['dosen/disertasi/kualifikasi'] = 'backend/dosen/disertasi/kualifikasi';
	$route['dosen/disertasi/kualifikasi/terima'] = 'backend/dosen/disertasi/kualifikasi/terima';
	$route['dosen/disertasi/kualifikasi/setting/(:num)'] = 'backend/dosen/disertasi/kualifikasi/setting';
	$route['dosen/disertasi/kualifikasi/promotor/(:num)'] = 'backend/dosen/disertasi/kualifikasi/promotor';
	$route['dosen/disertasi/kualifikasi/terima'] = 'backend/dosen/disertasi/kualifikasi/terima';
	$route['dosen/disertasi/kualifikasi/jadwal_save'] = 'backend/dosen/disertasi/kualifikasi/jadwal_save';
	$route['dosen/disertasi/kualifikasi/penguji_save'] = 'backend/dosen/disertasi/kualifikasi/penguji_save';
	$route['dosen/disertasi/kualifikasi/penguji_update_statustim'] = 'backend/dosen/disertasi/kualifikasi/penguji_update_statustim';
	$route['dosen/disertasi/kualifikasi/penguji_delete'] = 'backend/dosen/disertasi/kualifikasi/penguji_delete';
	$route['dosen/disertasi/kualifikasi/update_status_ujian'] = 'backend/dosen/disertasi/kualifikasi/update_status_ujian';
	$route['dosen/disertasi/kualifikasi/penguji/kirim_whatsapp'] = 'backend/dosen/disertasi/kualifikasi/penguji_kirim_whatsapp';

	$route['dosen/disertasi/promotor'] = 'backend/dosen/disertasi/promotor';
	$route['dosen/disertasi/promotor/setting/(:num)'] = 'backend/dosen/disertasi/promotor/setting';
	$route['dosen/disertasi/promotor/setujui'] = 'backend/dosen/disertasi/promotor/setujui';
	$route['dosen/disertasi/promotor/kirim_whatsapp'] = 'backend/dosen/disertasi/promotor/kirim_whatsapp';
	$route['dosen/disertasi/promotor/save'] = 'backend/dosen/disertasi/promotor/promotor_save';
	$route['dosen/disertasi/promotor/delete'] = 'backend/dosen/disertasi/promotor/promotor_delete';

	$route['dosen/disertasi/penilaian'] = 'backend/dosen/disertasi/penilaian/mkpkk';
	$route['dosen/disertasi/penilaian/mkpkk/input/(:num)'] = 'backend/dosen/disertasi/penilaian/mkpkk_input';
	$route['dosen/disertasi/penilaian/mkpkk/save'] = 'backend/dosen/disertasi/penilaian/mkpkk_save';
	$route['dosen/disertasi/penilaian/mkpkk/publish_nilai'] = 'backend/dosen/disertasi/penilaian/mkpkk_publish_nilai';
	$route['dosen/disertasi/penilaian/mkpkk/cetak'] = 'backend/dosen/disertasi/penilaian/mkpkk_cetak';
	$route['dosen/disertasi/penilaian/mkpd'] = 'backend/dosen/disertasi/penilaian/mkpd';
	$route['dosen/disertasi/penilaian/mkpd/input/(:num)'] = 'backend/dosen/disertasi/penilaian/mkpd_input';
	$route['dosen/disertasi/penilaian/mkpd/save'] = 'backend/dosen/disertasi/penilaian/mkpd_save';
	$route['dosen/disertasi/penilaian/mkpd/publish_nilai'] = 'backend/dosen/disertasi/penilaian/mkpd_publish_nilai';
	$route['dosen/disertasi/penilaian/mkpd/cetak'] = 'backend/dosen/disertasi/penilaian/mkpd_cetak';


	$route['dosen/disertasi/mpkk'] = 'backend/dosen/disertasi/mpkk';
	$route['dosen/disertasi/mpkk/terima'] = 'backend/dosen/disertasi/mpkk/terima';

	$route['dosen/disertasi/proposal'] = 'backend/dosen/disertasi/proposal';
	$route['dosen/disertasi/proposal/terima'] = 'backend/dosen/disertasi/proposal/terima';
	$route['dosen/disertasi/proposal/setting/(:num)'] = 'backend/dosen/disertasi/proposal/setting/(:num)';
	$route['dosen/disertasi/proposal/terima'] = 'backend/dosen/disertasi/proposal/terima';
	$route['dosen/disertasi/proposal/jadwal_save'] = 'backend/dosen/disertasi/proposal/jadwal_save';
	$route['dosen/disertasi/proposal/penguji_save'] = 'backend/dosen/disertasi/proposal/penguji_save';
	$route['dosen/disertasi/proposal/penguji_promotor_save'] = 'backend/dosen/disertasi/proposal/penguji_promotor_save';
	$route['dosen/disertasi/proposal/penguji_update_statustim'] = 'backend/dosen/disertasi/proposal/penguji_update_statustim';
	$route['dosen/disertasi/proposal/penguji_delete'] = 'backend/dosen/disertasi/proposal/penguji_delete';
	$route['dosen/disertasi/proposal/penguji/kirim_whatsapp'] = 'backend/dosen/disertasi/proposal/penguji_kirim_whatsapp';

	$route['dosen/disertasi/proposal/update_status_ujian'] = 'backend/dosen/disertasi/proposal/update_status_ujian';
	$route['dosen/disertasi/proposal/promotor_save'] = 'backend/dosen/disertasi/proposal/promotor_save';
	$route['dosen/disertasi/proposal/promotor_delete'] = 'backend/dosen/disertasi/proposal/promotor_delete';

	$route['dosen/disertasi/mkpd'] = 'backend/dosen/disertasi/mkpd';
	$route['dosen/disertasi/mkpd/terima'] = 'backend/dosen/disertasi/mkpd/terima';

	$route['dosen/disertasi/kelayakan'] = 'backend/dosen/disertasi/kelayakan';
	$route['dosen/disertasi/kelayakan/terima'] = 'backend/dosen/disertasi/kelayakan/terima';
	$route['dosen/disertasi/kelayakan/setting/(:num)'] = 'backend/dosen/disertasi/kelayakan/setting/(:num)';
	$route['dosen/disertasi/kelayakan/terima'] = 'backend/dosen/disertasi/kelayakan/terima';
	$route['dosen/disertasi/kelayakan/jadwal_save'] = 'backend/dosen/disertasi/kelayakan/jadwal_save';
	$route['dosen/disertasi/kelayakan/penguji_save'] = 'backend/dosen/disertasi/kelayakan/penguji_save';
	$route['dosen/disertasi/kelayakan/penguji_promotor_save'] = 'backend/dosen/disertasi/kelayakan/penguji_promotor_save';
	$route['dosen/disertasi/kelayakan/penguji_update_statustim'] = 'backend/dosen/disertasi/kelayakan/penguji_update_statustim';
	$route['dosen/disertasi/kelayakan/penguji_delete'] = 'backend/dosen/disertasi/kelayakan/penguji_delete';
	$route['dosen/disertasi/kelayakan/penguji/kirim_whatsapp'] = 'backend/dosen/disertasi/kelayakan/penguji_kirim_whatsapp';
	$route['dosen/disertasi/kelayakan/update_status_ujian'] = 'backend/dosen/disertasi/kelayakan/update_status_ujian';
	$route['dosen/disertasi/kelayakan/promotor_save'] = 'backend/dosen/disertasi/kelayakan/promotor_save';
	$route['dosen/disertasi/kelayakan/promotor_delete'] = 'backend/dosen/disertasi/kelayakan/promotor_delete';

	$route['dosen/disertasi/tertutup'] = 'backend/dosen/disertasi/tertutup';
	$route['dosen/disertasi/tertutup/terima'] = 'backend/dosen/disertasi/tertutup/terima';
	$route['dosen/disertasi/tertutup/setting/(:num)'] = 'backend/dosen/disertasi/tertutup/setting/(:num)';
	$route['dosen/disertasi/tertutup/terima'] = 'backend/dosen/disertasi/tertutup/terima';
	$route['dosen/disertasi/tertutup/jadwal_save'] = 'backend/dosen/disertasi/tertutup/jadwal_save';
	$route['dosen/disertasi/tertutup/penguji_save'] = 'backend/dosen/disertasi/tertutup/penguji_save';
	$route['dosen/disertasi/tertutup/penguji_promotor_save'] = 'backend/dosen/disertasi/tertutup/penguji_promotor_save';
	$route['dosen/disertasi/tertutup/penguji_update_statustim'] = 'backend/dosen/disertasi/tertutup/penguji_update_statustim';
	$route['dosen/disertasi/tertutup/penguji_delete'] = 'backend/dosen/disertasi/tertutup/penguji_delete';
	$route['dosen/disertasi/tertutup/penguji/kirim_whatsapp'] = 'backend/dosen/disertasi/tertutup/penguji_kirim_whatsapp';
	$route['dosen/disertasi/tertutup/update_status_ujian'] = 'backend/dosen/disertasi/tertutup/update_status_ujian';
	$route['dosen/disertasi/tertutup/promotor_save'] = 'backend/dosen/disertasi/tertutup/promotor_save';
	$route['dosen/disertasi/tertutup/promotor_delete'] = 'backend/dosen/disertasi/tertutup/promotor_delete';

	$route['dosen/disertasi/terbuka'] = 'backend/dosen/disertasi/terbuka';
	$route['dosen/disertasi/terbuka/terima'] = 'backend/dosen/disertasi/terbuka/terima';
	$route['dosen/disertasi/terbuka/setting/(:num)'] = 'backend/dosen/disertasi/terbuka/setting/(:num)';
	$route['dosen/disertasi/terbuka/terima'] = 'backend/dosen/disertasi/terbuka/terima';
	$route['dosen/disertasi/terbuka/jadwal_save'] = 'backend/dosen/disertasi/terbuka/jadwal_save';
	$route['dosen/disertasi/terbuka/penguji_save'] = 'backend/dosen/disertasi/terbuka/penguji_save';
	$route['dosen/disertasi/terbuka/penguji_rekomendasi_save'] = 'backend/dosen/disertasi/terbuka/penguji_rekomendasi_save';
	$route['dosen/disertasi/terbuka/penguji_promotor_save'] = 'backend/dosen/disertasi/terbuka/penguji_promotor_save';
	$route['dosen/disertasi/terbuka/penguji_update_statustim'] = 'backend/dosen/disertasi/terbuka/penguji_update_statustim';
	$route['dosen/disertasi/terbuka/penguji_delete'] = 'backend/dosen/disertasi/terbuka/penguji_delete';
	$route['dosen/disertasi/terbuka/penguji/kirim_whatsapp'] = 'backend/dosen/disertasi/terbuka/penguji_kirim_whatsapp';
	$route['dosen/disertasi/terbuka/update_status_ujian'] = 'backend/dosen/disertasi/terbuka/update_status_ujian';
	$route['dosen/disertasi/terbuka/promotor_save'] = 'backend/dosen/disertasi/terbuka/promotor_save';
	$route['dosen/disertasi/terbuka/promotor_delete'] = 'backend/dosen/disertasi/terbuka/promotor_delete';

	// DOSEN
	$route['dosen/disertasi/permintaan/penguji'] = 'backend/dosen/disertasi/permintaan/penguji_kualifikasi';
	$route['dosen/disertasi/permintaan/penguji/proposal'] = 'backend/dosen/disertasi/permintaan/penguji_proposal';
	$route['dosen/disertasi/permintaan/penguji/kelayakan'] = 'backend/dosen/disertasi/permintaan/penguji_kelayakan';
	$route['dosen/disertasi/permintaan/penguji/tertutup'] = 'backend/dosen/disertasi/permintaan/penguji_tertutup';
	$route['dosen/disertasi/permintaan/penguji/terbuka'] = 'backend/dosen/disertasi/permintaan/penguji_terbuka';
	$route['dosen/disertasi/permintaan/penguji/setujui'] = 'backend/dosen/disertasi/permintaan/penguji_setujui';
	$route['dosen/disertasi/permintaan/penasehat'] = 'backend/dosen/disertasi/permintaan/penasehat';
	$route['dosen/disertasi/permintaan/penasehat/setujui'] = 'backend/dosen/disertasi/permintaan/penasehat_setujui';
	$route['dosen/disertasi/permintaan/promotor'] = 'backend/dosen/disertasi/permintaan/promotor';
	$route['dosen/disertasi/permintaan/promotor/mkpkk/detail/(:num)'] = 'backend/dosen/disertasi/permintaan/promotor_mkpkk';
	$route['dosen/disertasi/permintaan/promotor/mkpkk/save'] = 'backend/dosen/disertasi/permintaan/promotor_mkpkk_save';
	$route['dosen/disertasi/permintaan/promotor/mpkk/setujui'] = 'backend/dosen/disertasi/permintaan/mpkk_setujui';
	$route['dosen/disertasi/permintaan/promotor/setujui'] = 'backend/dosen/disertasi/permintaan/promotor_setujui';
	$route['dosen/disertasi/permintaan/promotor/proposal/setujui'] = 'backend/dosen/disertasi/permintaan/proposal_setujui';
	$route['dosen/disertasi/permintaan/promotor/mkpd/setujui'] = 'backend/dosen/disertasi/permintaan/mkpd_setujui';
	$route['dosen/disertasi/permintaan/promotor/mkpd/detail/(:num)'] = 'backend/dosen/disertasi/permintaan/mkpd_detail';
	$route['dosen/disertasi/permintaan/promotor/mkpd/update'] = 'backend/dosen/disertasi/permintaan/mkpd_update';
	$route['dosen/disertasi/permintaan/promotor/mkpd/set_pjmk'] = 'backend/dosen/disertasi/permintaan/mkpd_set_pjmk';
	$route['dosen/disertasi/permintaan/promotor/kelayakan/setujui'] = 'backend/dosen/disertasi/permintaan/kelayakan_setujui';
	$route['dosen/disertasi/permintaan/promotor/tertutup/setujui'] = 'backend/dosen/disertasi/permintaan/tertutup_setujui';
	$route['dosen/disertasi/permintaan/promotor/terbuka/setujui'] = 'backend/dosen/disertasi/permintaan/terbuka_setujui';

	// TESIS - JUDUL
	$route['dosen/tesis/judul'] = 'backend/dosen/tesis/judul';
	$route['dosen/tesis/judul/index'] = 'backend/dosen/tesis/judul/index';
	$route['dosen/tesis/judul/disetujui'] = 'backend/dosen/tesis/judul/disetujui';
	$route['dosen/tesis/judul/ditolak'] = 'backend/dosen/tesis/judul/ditolak';
	$route['dosen/tesis/judul/approve/(:num)'] = 'backend/dosen/tesis/judul/approve';
	$route['dosen/tesis/judul/reject/(:num)'] = 'backend/dosen/tesis/judul/reject';
	$route['dosen/tesis/judul/batal/(:num)'] = 'backend/dosen/tesis/judul/batal';
	$route['dosen/tesis/judul/index_kabag'] = 'backend/dosen/tesis/judul/index_kabag';
	$route['dosen/tesis/judul/index_kabag_pembimbing'] = 'backend/dosen/tesis/judul/index_kabag_pembimbing';
	$route['dosen/tesis/judul/index_kps'] = 'backend/dosen/tesis/judul/index_kps';
	$route['dosen/tesis/judul/index_kps_pembimbing'] = 'backend/dosen/tesis/judul/index_kps_pembimbing';
	$route['dosen/tesis/judul/setting_pembimbing/(:num)'] = 'backend/dosen/tesis/judul/setting_pembimbing';
	$route['dosen/tesis/judul/setting_pembimbing_save'] = 'backend/dosen/tesis/judul/setting_pembimbing_save';
	$route['dosen/tesis/judul/setting_pembimbing_kedua/(:num)'] = 'backend/dosen/tesis/judul/setting_pembimbing_kedua';
	$route['dosen/tesis/judul/setting_pembimbing_kedua_save'] = 'backend/dosen/tesis/judul/setting_pembimbing_kedua_save';
	$route['dosen/tesis/judul/batal_pembimbing_utama/(:num)'] = 'backend/dosen/tesis/judul/batal_pembimbing_utama';

	$route['dosen/tesis/permintaan/pembimbing'] = 'backend/dosen/tesis/permintaan/pembimbing';
	$route['dosen/tesis/permintaan/pembimbing/(:num)'] = 'backend/dosen/tesis/permintaan/pembimbing';

	$route['dosen/tesis/permintaan/approve_pembimbing/(:num)'] = 'backend/dosen/tesis/permintaan/approve_pembimbing';
	$route['dosen/tesis/permintaan/reject_pembimbing/(:num)'] = 'backend/dosen/tesis/permintaan/reject_pembimbing';
	$route['dosen/tesis/permintaan/batal_pembimbing/(:num)'] = 'backend/dosen/tesis/permintaan/batal_pembimbing';

	// TESIS - PROPOSAL
	$route['dosen/tesis/proposal'] = 'backend/dosen/tesis/proposal';
	$route['dosen/tesis/proposal/index'] = 'backend/dosen/tesis/proposal/index';
	$route['dosen/tesis/proposal/disetujui'] = 'backend/dosen/tesis/proposal/disetujui';
	$route['dosen/tesis/proposal/ditolak'] = 'backend/dosen/tesis/proposal/ditolak';
	$route['dosen/tesis/proposal/approve/(:num)'] = 'backend/dosen/tesis/proposal/approve';
	$route['dosen/tesis/proposal/reject/(:num)'] = 'backend/dosen/tesis/proposal/reject';
	$route['dosen/tesis/proposal/batal/(:num)'] = 'backend/dosen/tesis/proposal/batal';

	$route['dosen/tesis/proposal/pembimbing'] = 'backend/dosen/tesis/proposal/pembimbing';
	$route['dosen/tesis/proposal/pembimbing/(:num)'] = 'backend/dosen/tesis/proposal/pembimbing';
	$route['dosen/tesis/proposal/kirim_whatsapp'] = 'backend/dosen/tesis/proposal/penguji_kirim_whatsapp';

	//$route['dosen/tesis/proposal/approve/(:num)'] = 'backend/dosen/tesis/proposal/approve';

	//$route['dosen/tesis/proposal/reject/(:num)'] = 'backend/dosen/tesis/proposal/reject';

	//$route['dosen/tesis/proposal/batal/(:num)'] = 'backend/dosen/tesis/proposal/batal';

	$route['dosen/tesis/proposal/approve_pembimbing/(:num)'] = 'backend/dosen/tesis/proposal/approve_pembimbing';
	$route['dosen/tesis/proposal/reject_pembimbing/(:num)'] = 'backend/dosen/tesis/proposal/reject_pembimbing';
	$route['dosen/tesis/proposal/batal_pembimbing/(:num)'] = 'backend/dosen/tesis/proposal/batal_pembimbing';
	$route['dosen/tesis/proposal/pengajuan_baru'] = 'backend/dosen/tesis/proposal/pengajuan_baru';
	$route['dosen/tesis/proposal/penjadwalan'] = 'backend/dosen/tesis/proposal/penjadwalan';
	$route['dosen/tesis/proposal/penjadwalan_sudah'] = 'backend/dosen/tesis/proposal/penjadwalan_sudah';
	$route['dosen/tesis/proposal/penjadwalan_selesai_proposal'] = 'backend/dosen/tesis/proposal/penjadwalan_selesai_proposal';
	//$route['dosen/tesis/proposal/penjadwalan/(:num)'] = 'backend/dosen/tesis/proposal/penjadwalan';
	$route['dosen/tesis/proposal/jadwal_pembimbing/(:num)'] = 'backend/dosen/tesis/proposal/jadwal_pembimbing';
	$route['dosen/tesis/proposal/jadwal_pembimbing_save'] = 'backend/dosen/tesis/proposal/jadwal_pembimbing_save';
	$route['dosen/tesis/proposal/setting/(:num)'] = 'backend/dosen/tesis/proposal/setting';
	$route['dosen/tesis/proposal/setting_penguji/(:num)'] = 'backend/dosen/tesis/proposal/setting_penguji';

	$route['dosen/tesis/proposal/penguji_setting_penguji/(:num)'] = 'backend/dosen/tesis/proposal/penguji_setting_penguji';
	$route['dosen/tesis/proposal/jadwal_save'] = 'backend/dosen/tesis/proposal/jadwal_save';
	$route['dosen/tesis/proposal/batal_verifikasi_jadwal/(:num)'] = 'backend/dosen/tesis/proposal/batal_verifikasi_jadwal';
	$route['dosen/tesis/proposal/penguji_save'] = 'backend/dosen/tesis/proposal/penguji_save';
	$route['dosen/tesis/proposal/penguji_update_statustim'] = 'backend/dosen/tesis/proposal/penguji_update_statustim';
	$route['dosen/tesis/proposal/penguji_delete'] = 'backend/dosen/tesis/proposal/penguji_delete';
	$route['dosen/tesis/proposal/penguji_usulan_save'] = 'backend/dosen/tesis/proposal/penguji_usulan_save';
	$route['dosen/tesis/proposal/penguji_usulan_penguji_save'] = 'backend/dosen/tesis/proposal/penguji_usulan_penguji_save';
	$route['dosen/tesis/proposal/penguji_usulan_save_kps'] = 'backend/dosen/tesis/proposal/penguji_usulan_save_kps';
	$route['dosen/tesis/proposal/penguji_usulan_delete'] = 'backend/dosen/tesis/proposal/penguji_usulan_delete';
	$route['dosen/tesis/proposal/status_ujian/(:num)'] = 'backend/dosen/tesis/proposal/status_ujian';

	$route['dosen/tesis/proposal/penguji'] = 'backend/dosen/tesis/proposal/penguji';
	$route['dosen/tesis/proposal/penguji/(:num)'] = 'backend/dosen/tesis/proposal/penguji';
	$route['dosen/tesis/proposal/approve_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/proposal/approve_penguji';
	$route['dosen/tesis/proposal/reject_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/proposal/reject_penguji';

	$route['dosen/tesis/proposal/batal_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/proposal/batal_penguji';
	$route['dosen/tesis/proposal/update_status_ujian'] = 'backend/dosen/tesis/proposal/update_status_ujian';
	$route['dosen/tesis/proposal/update_status_ujian_ketua'] = 'backend/dosen/tesis/proposal/update_status_ujian_ketua';
	$route['dosen/tesis/proposal/kirim_berita_acara'] = 'backend/dosen/tesis/proposal/kirim_berita_acara';

	// TESIS - MKPT
	$route['dosen/tesis/mkpt/pengampu'] = 'backend/dosen/tesis/mkpt/pengampu';
	$route['dosen/tesis/mkpt/pengampu/(:num)'] = 'backend/dosen/tesis/mkpt/pengampu';
	$route['dosen/tesis/mkpt/setting_pengampu/(:num)'] = 'backend/dosen/tesis/mkpt/setting_pengampu';
	$route['dosen/tesis/mkpt/save'] = 'backend/dosen/tesis/mkpt/save';
	$route['dosen/tesis/mkpt/approve_pengampu/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/approve_pengampu';
	$route['dosen/tesis/mkpt/reject_pengampu/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/reject_pengampu';
	$route['dosen/tesis/mkpt/batal_pengampu/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/batal_pengampu';
	$route['dosen/tesis/mkpt/setting/(:num)'] = 'backend/dosen/tesis/mkpt/setting';
	$route['dosen/tesis/mkpt/jadwal_save'] = 'backend/dosen/tesis/mkpt/jadwal_save';
	$route['dosen/tesis/mkpt/nilai/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/nilai';
	$route['dosen/tesis/mkpt/nilai_save'] = 'backend/dosen/tesis/mkpt/nilai_save';
	$route['dosen/tesis/mkpt/publish_nilai/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/publish_nilai';
	$route['dosen/tesis/mkpt/batal_publish_nilai/(:num)/(:num)'] = 'backend/dosen/tesis/mkpt/batal_publish_nilai';
	$route['dosen/tesis/mkpt/update_status_ujian'] = 'backend/dosen/tesis/mkpt/update_status_ujian';

	// TESIS - UJIAN
	$route['dosen/tesis/ujian'] = 'backend/dosen/tesis/ujian';
	$route['dosen/tesis/ujian/index/(:num)'] = 'backend/dosen/tesis/ujian/index';
	$route['dosen/tesis/ujian/approve/(:num)'] = 'backend/dosen/tesis/ujian/approve';
	$route['dosen/tesis/ujian/reject/(:num)'] = 'backend/dosen/tesis/ujian/reject';
	$route['dosen/tesis/ujian/batal/(:num)'] = 'backend/dosen/tesis/ujian/batal';

	//$route['dosen/tesis/ujian/approve/(:num)'] = 'backend/dosen/tesis/ujian/approve';

	//$route['dosen/tesis/ujian/reject/(:num)'] = 'backend/dosen/tesis/ujian/reject';


	$route['dosen/tesis/ujian/pembimbing'] = 'backend/dosen/tesis/ujian/pembimbing';
	$route['dosen/tesis/ujian/pembimbing/(:num)'] = 'backend/dosen/tesis/ujian/pembimbing';

	//$route['dosen/tesis/ujian/approve/(:num)'] = 'backend/dosen/tesis/ujian/approve';

	//$route['dosen/tesis/ujian/reject/(:num)'] = 'backend/dosen/tesis/ujian/reject';

	//$route['dosen/tesis/ujian/batal/(:num)'] = 'backend/dosen/tesis/ujian/batal';

	$route['dosen/tesis/ujian/approve_pembimbing/(:num)'] = 'backend/dosen/tesis/ujian/approve_pembimbing';
	$route['dosen/tesis/ujian/reject_pembimbing/(:num)'] = 'backend/dosen/tesis/ujian/reject_pembimbing';
	$route['dosen/tesis/ujian/batal_pembimbing/(:num)'] = 'backend/dosen/tesis/ujian/batal_pembimbing';

	$route['dosen/tesis/ujian/penjadwalan'] = 'backend/dosen/tesis/ujian/penjadwalan';
	$route['dosen/tesis/ujian/penjadwalan/(:num)'] = 'backend/dosen/tesis/ujian/penjadwalan';
	$route['dosen/tesis/ujian/jadwal_pembimbing/(:num)'] = 'backend/dosen/tesis/ujian/jadwal_pembimbing';
	$route['dosen/tesis/ujian/jadwal_pembimbing_save'] = 'backend/dosen/tesis/ujian/jadwal_pembimbing_save';
	$route['dosen/tesis/ujian/setting/(:num)'] = 'backend/dosen/tesis/ujian/setting';
	$route['dosen/tesis/ujian/setting_penguji/(:num)'] = 'backend/dosen/tesis/ujian/setting_penguji';
	$route['dosen/tesis/ujian/penguji_setting_penguji/(:num)'] = 'backend/dosen/tesis/ujian/penguji_setting_penguji';
	$route['dosen/tesis/ujian/nilai/(:num)/(:num)'] = 'backend/dosen/tesis/ujian/nilai';
	$route['dosen/tesis/ujian/jadwal_save'] = 'backend/dosen/tesis/ujian/jadwal_save';
	$route['dosen/tesis/ujian/batal_verifikasi_jadwal/(:num)'] = 'backend/dosen/tesis/ujian/batal_verifikasi_jadwal';
	$route['dosen/tesis/ujian/penguji_save'] = 'backend/dosen/tesis/ujian/penguji_save';
	$route['dosen/tesis/ujian/penguji_update_statustim'] = 'backend/dosen/tesis/ujian/penguji_update_statustim';
	$route['dosen/tesis/ujian/penguji_delete'] = 'backend/dosen/tesis/ujian/penguji_delete';
	$route['dosen/tesis/ujian/penguji_usulan_save'] = 'backend/dosen/tesis/ujian/penguji_usulan_save';
	$route['dosen/tesis/ujian/penguji_nilai_save'] = 'backend/dosen/tesis/ujian/penguji_nilai_save';
	$route['dosen/tesis/ujian/penguji_usulan_save_kps'] = 'backend/dosen/tesis/ujian/penguji_usulan_save_kps';
	$route['dosen/tesis/ujian/penguji_usulan_delete'] = 'backend/dosen/tesis/ujian/penguji_usulan_delete';
	$route['dosen/tesis/ujian/status_ujian/(:num)'] = 'backend/dosen/tesis/ujian/status_ujian';
	$route['dosen/tesis/ujian/penguji'] = 'backend/dosen/tesis/ujian/penguji';
	$route['dosen/tesis/ujian/penguji/(:num)'] = 'backend/dosen/tesis/ujian/penguji';
	$route['dosen/tesis/ujian/approve_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/ujian/approve_penguji';
	$route['dosen/tesis/ujian/reject_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/ujian/reject_penguji';

	$route['dosen/tesis/ujian/batal_penguji/(:num)/(:num)'] = 'backend/dosen/tesis/ujian/batal_penguji';

	$route['dosen/tesis/ujian/update_status_ujian'] = 'backend/dosen/tesis/ujian/update_status_ujian';
	$route['dosen/tesis/ujian/update_status_ujian_ketua'] = 'backend/dosen/tesis/ujian/update_status_ujian_ketua';

	// DOKUMEN PERSETUJUAN
	$route['dosen/dokumen/berita_acara'] = 'backend/dosen/dokumen/berita_acara';
	$route['dosen/dokumen/berita_acara/riwayat'] = 'backend/dosen/dokumen/berita_acara/riwayat';
	$route['dosen/dokumen/berita_acara/persetujuan/(:num)'] = 'backend/dosen/dokumen/berita_acara/persetujuan';
	$route['dosen/dokumen/berita_acara/persetujuan/save'] = 'backend/dosen/dokumen/berita_acara/persetujuan_save';
	$route['dosen/dokumen/undangan'] = 'backend/dosen/dokumen/undangan';
	$route['dosen/dokumen/undangan/riwayat'] = 'backend/dosen/dokumen/undangan/riwayat';

	// ADMIN PRODI
	$route['prodi/dashboard'] = 'backend/prodi/prodi_page/dashboard';
	$route['prodi/doktoral/disertasi/cetak_sk'] = 'backend/prodi/prodi_doktoral/cetak_sk';

	$route['prodi/doktoral/disertasi/kualifikasi'] = 'backend/prodi/doktoral/disertasi_kualifikasi';
	$route['prodi/doktoral/disertasi/kualifikasi/setting/(:num)'] = 'backend/prodi/doktoral/disertasi_kualifikasi/setting';
	$route['prodi/doktoral/disertasi/kualifikasi/penasehat_update'] = 'backend/prodi/doktoral/disertasi_kualifikasi/penasehat_update';
	$route['prodi/doktoral/disertasi/kualifikasi/cetak_sk_penasehat'] = 'backend/prodi/doktoral/disertasi_kualifikasi/cetak_sk_penasehat';
	$route['prodi/doktoral/disertasi/kualifikasi/cetak_undangan'] = 'backend/prodi/doktoral/disertasi_kualifikasi/cetak_undangan';
	$route['prodi/doktoral/disertasi/kualifikasi/cetak_berita'] = 'backend/prodi/doktoral/disertasi_kualifikasi/cetak_berita';
	$route['prodi/doktoral/disertasi/kualifikasi/cetak_penilaian'] = 'backend/prodi/doktoral/disertasi_kualifikasi/cetak_penilaian';
	$route['prodi/doktoral/disertasi/kualifikasi/cetak_absensi'] = 'backend/prodi/doktoral/disertasi_kualifikasi/cetak_absensi';

	$route['prodi/doktoral/disertasi/promotor'] = 'backend/prodi/doktoral/disertasi_promotor';
	$route['prodi/doktoral/disertasi/promotor/cetak_sk'] = 'backend/prodi/doktoral/disertasi_promotor/cetak_sk_promotor';

	$route['prodi/doktoral/disertasi/mkpkk'] = 'backend/prodi/doktoral/disertasi_mkpkk';
	$route['prodi/doktoral/disertasi/mkpkk/cetak'] = 'backend/prodi/doktoral/disertasi_mkpkk/cetak';
	$route['prodi/doktoral/disertasi/mkpkk/cetak-sk'] = 'backend/prodi/doktoral/disertasi_mkpkk/cetak_sk';

	$route['prodi/doktoral/disertasi/proposal'] = 'backend/prodi/doktoral/disertasi_proposal';
	$route['prodi/doktoral/disertasi/proposal/terima'] = 'backend/prodi/doktoral/disertasi_proposal/terima';
	$route['prodi/doktoral/disertasi/proposal/cetak_undangan'] = 'backend/prodi/doktoral/disertasi_proposal/cetak_undangan';
	$route['prodi/doktoral/disertasi/proposal/cetak_berita'] = 'backend/prodi/doktoral/disertasi_proposal/cetak_berita';
	$route['prodi/doktoral/disertasi/proposal/cetak_penilaian'] = 'backend/prodi/doktoral/disertasi_proposal/cetak_penilaian';
	$route['prodi/doktoral/disertasi/proposal/cetak_absensi'] = 'backend/prodi/doktoral/disertasi_proposal/cetak_absensi';

	$route['prodi/doktoral/disertasi/mkpd'] = 'backend/prodi/doktoral/disertasi_mkpd';
	$route['prodi/doktoral/disertasi/mkpd/cetak'] = 'backend/prodi/doktoral/disertasi_mkpd/cetak';
	$route['prodi/doktoral/disertasi/mkpd/cetak-sk'] = 'backend/prodi/doktoral/disertasi_mkpd/cetak_sk';

	$route['prodi/doktoral/disertasi/kelayakan'] = 'backend/prodi/doktoral/disertasi_kelayakan';
	$route['prodi/doktoral/disertasi/kelayakan/cetak_undangan'] = 'backend/prodi/doktoral/disertasi_kelayakan/cetak_undangan';
	$route['prodi/doktoral/disertasi/kelayakan/cetak_berita'] = 'backend/prodi/doktoral/disertasi_kelayakan/cetak_berita';
	$route['prodi/doktoral/disertasi/kelayakan/cetak_penilaian'] = 'backend/prodi/doktoral/disertasi_kelayakan/cetak_penilaian';
	$route['prodi/doktoral/disertasi/kelayakan/cetak_absensi'] = 'backend/prodi/doktoral/disertasi_kelayakan/cetak_absensi';

	$route['prodi/doktoral/disertasi/tertutup'] = 'backend/prodi/doktoral/disertasi_tertutup';
	$route['prodi/doktoral/disertasi/tertutup/cetak_undangan'] = 'backend/prodi/doktoral/disertasi_tertutup/cetak_undangan';
	$route['prodi/doktoral/disertasi/tertutup/cetak_berita'] = 'backend/prodi/doktoral/disertasi_tertutup/cetak_berita';
	$route['prodi/doktoral/disertasi/tertutup/cetak_penilaian'] = 'backend/prodi/doktoral/disertasi_tertutup/cetak_penilaian';
	$route['prodi/doktoral/disertasi/tertutup/cetak_absensi'] = 'backend/prodi/doktoral/disertasi_tertutup/cetak_absensi';

	$route['prodi/doktoral/disertasi/terbuka'] = 'backend/prodi/doktoral/disertasi_terbuka';
	$route['prodi/doktoral/disertasi/terbuka/terima'] = 'backend/prodi/doktoral/disertasi_terbuka/terima';
	$route['prodi/doktoral/disertasi/terbuka/cetak_undangan'] = 'backend/prodi/doktoral/disertasi_terbuka/cetak_undangan';
	$route['prodi/doktoral/disertasi/terbuka/cetak_berita'] = 'backend/prodi/doktoral/disertasi_terbuka/cetak_berita';
	$route['prodi/doktoral/disertasi/terbuka/cetak_penilaian'] = 'backend/prodi/doktoral/disertasi_terbuka/cetak_penilaian';
	$route['prodi/doktoral/disertasi/terbuka/cetak_absensi'] = 'backend/prodi/doktoral/disertasi_terbuka/cetak_absensi';

	$route['prodi/tesis/ujian'] = 'backend/prodi/tesis/ujian';
	$route['prodi/tesis/ujian/index/(:num)'] = 'backend/prodi/tesis/ujian/index';
	$route['prodi/tesis/ujian/approve/(:num)'] = 'backend/prodi/tesis/ujian/approve';
	$route['prodi/tesis/ujian/reject/(:num)'] = 'backend/prodi/tesis/ujian/reject';
	$route['prodi/tesis/ujian/batal/(:num)'] = 'backend/prodi/tesis/ujian/batal';
	$route['prodi/tesis/ujian/nilai_ujian/(:num)/(:num)'] = 'backend/prodi/tesis/ujian/nilai_ujian';
	$route['prodi/tesis/ujian/nilai_ujian_save'] = 'backend/prodi/tesis/ujian/nilai_ujian_save';

	$route['prodi/magister/tesis/proposal'] = 'backend/prodi/magister/tesis/tesis_proposal';
	$route['prodi/magister/tesis/proposal/cetak_sk_proposal'] = 'backend/prodi/magister/tesis/tesis_proposal/cetak_sk_proposal';
	$route['prodi/magister/tesis/proposal/cetak_berita'] = 'backend/prodi/magister/tesis/tesis_proposal/cetak_berita';
	$route['prodi/magister/tesis/proposal/cetak_daftar_hadir'] = 'backend/prodi/magister/tesis/tesis_proposal/cetak_daftar_hadir';
	$route['prodi/magister/tesis/proposal/cetak_undangan'] = 'backend/prodi/magister/tesis/tesis_proposal/cetak_undangan';

	$route['prodi/magister/tesis/ujian'] = 'backend/prodi/magister/tesis/tesis_ujian';
	//$route['prodi/magister/tesis/ujian/cetak_undangan'] = 'backend/prodi/magister/tesis/tesis_ujian/cetak_undangan';
	$route['prodi/magister/tesis/ujian/cetak_berita'] = 'backend/prodi/magister/tesis/tesis_ujian/cetak_berita';
	$route['prodi/magister/tesis/ujian/cetak_sk_tesis'] = 'backend/prodi/magister/tesis/tesis_ujian/cetak_sk_tesis';
	//$route['prodi/magister/tesis/ujian/cetak_penilaian'] = 'backend/prodi/magister/tesis/tesis_ujian/cetak_penilaian';
	//$route['prodi/magister/tesis/ujian/cetak_absensi'] = 'backend/prodi/magister/tesis/tesis_ujian/cetak_absensi';
	//$route['prodi/magister/tesis/ujian/nilai_ujian/(:num)/(:num)'] = 'backend/prodi/magister/tesis/tesis_ujian/nilai_ujian';
	//$route['prodi/magister/tesis/ujian/nilai_ujian_save'] = 'backend/prodi/magister/tesis/tesis_ujian/nilai_ujian_save';

	$route['prodi/magister/tesis/judul'] = 'backend/prodi/magister/tesis/tesis_judul';
	$route['prodi/magister/tesis/judul/cetak_surat_tugas_pembimbing'] = 'backend/prodi/magister/tesis/tesis_judul/cetak_surat_tugas_pembimbing';

	$route['prodi/magister/tesis/mkpt'] = 'backend/prodi/magister/tesis/tesis_mkpt';
	$route['prodi/magister/tesis/mkpt/cetak_surat_tugas_pengampu'] = 'backend/prodi/magister/tesis/tesis_mkpt/cetak_surat_tugas_pengampu';

	// UP4i
	$route['up4i/dashboard'] = 'backend/up4i/home/index';
	$route['up4i/doktoral/jurnal/index'] = 'backend/up4i/jurnal_doktoral/index';
	$route['up4i/doktoral/jurnal/validasi'] = 'backend/up4i/jurnal_doktoral/validasi';

	// MAHASISWA

	// DOKTORAL
	$route['mahasiswa/disertasi/kualifikasi'] = 'backend/mahasiswa/disertasi/kualifikasi';
	$route['mahasiswa/disertasi/kualifikasi/add'] = 'backend/mahasiswa/disertasi/kualifikasi/add';
	$route['mahasiswa/disertasi/kualifikasi/save'] = 'backend/mahasiswa/disertasi/kualifikasi/save';
	$route['mahasiswa/disertasi/kualifikasi/info/(:num)'] = 'backend/mahasiswa/disertasi/kualifikasi/info';
	$route['mahasiswa/disertasi/kualifikasi/cetak-pengajuan'] = 'backend/mahasiswa/disertasi/kualifikasi/cetak_pengajuan';

	$route['mahasiswa/disertasi/promotor'] = 'backend/mahasiswa/disertasi/promotor';
	$route['mahasiswa/disertasi/promotor/info/(:num)'] = 'backend/mahasiswa/disertasi/promotor/info';
	$route['mahasiswa/disertasi/promotor/save'] = 'backend/mahasiswa/disertasi/promotor/promotor_save';
	$route['mahasiswa/disertasi/promotor/delete'] = 'backend/mahasiswa/disertasi/promotor/promotor_delete';

	$route['mahasiswa/disertasi/mpkk'] = 'backend/mahasiswa/disertasi/mpkk';
	$route['mahasiswa/disertasi/mpkk/add/(:num)'] = 'backend/mahasiswa/disertasi/mpkk/add';
	$route['mahasiswa/disertasi/mpkk/save'] = 'backend/mahasiswa/disertasi/mpkk/save';
	$route['mahasiswa/disertasi/mpkk/info/(:num)'] = 'backend/mahasiswa/disertasi/mpkk/info';

	$route['mahasiswa/disertasi/proposal'] = 'backend/mahasiswa/disertasi/proposal';
	$route['mahasiswa/disertasi/proposal/add/(:num)'] = 'backend/mahasiswa/disertasi/proposal/add';
	$route['mahasiswa/disertasi/proposal/save'] = 'backend/mahasiswa/disertasi/proposal/save';
	$route['mahasiswa/disertasi/proposal/info/(:num)'] = 'backend/mahasiswa/disertasi/proposal/info';
	$route['mahasiswa/disertasi/proposal/cetak-pengajuan'] = 'backend/mahasiswa/disertasi/proposal/cetak_pengajuan';

	$route['mahasiswa/disertasi/mkpd'] = 'backend/mahasiswa/disertasi/mkpd';
	$route['mahasiswa/disertasi/mkpd/add/(:num)'] = 'backend/mahasiswa/disertasi/mkpd/add';
	$route['mahasiswa/disertasi/mkpd/save'] = 'backend/mahasiswa/disertasi/mkpd/save';
	$route['mahasiswa/disertasi/mkpd/info/(:num)'] = 'backend/mahasiswa/disertasi/mkpd/info';

	$route['mahasiswa/disertasi/kelayakan'] = 'backend/mahasiswa/disertasi/kelayakan';
	$route['mahasiswa/disertasi/kelayakan/add/(:num)'] = 'backend/mahasiswa/disertasi/kelayakan/add';
	$route['mahasiswa/disertasi/kelayakan/save'] = 'backend/mahasiswa/disertasi/kelayakan/save';
	$route['mahasiswa/disertasi/kelayakan/info/(:num)'] = 'backend/mahasiswa/disertasi/kelayakan/info';

	$route['mahasiswa/disertasi/tertutup'] = 'backend/mahasiswa/disertasi/tertutup';
	$route['mahasiswa/disertasi/tertutup/add/(:num)'] = 'backend/mahasiswa/disertasi/tertutup/add';
	$route['mahasiswa/disertasi/tertutup/save'] = 'backend/mahasiswa/disertasi/tertutup/save';
	$route['mahasiswa/disertasi/tertutup/info/(:num)'] = 'backend/mahasiswa/disertasi/tertutup/info';

	$route['mahasiswa/disertasi/terbuka'] = 'backend/mahasiswa/disertasi/terbuka';
	$route['mahasiswa/disertasi/terbuka/add/(:num)'] = 'backend/mahasiswa/disertasi/terbuka/add';
	$route['mahasiswa/disertasi/terbuka/save'] = 'backend/mahasiswa/disertasi/terbuka/save';
	$route['mahasiswa/disertasi/terbuka/info/(:num)'] = 'backend/mahasiswa/disertasi/terbuka/info';

	// MAGISTER
	$route['mahasiswa/tesis/judul'] = 'backend/mahasiswa/tesis/judul';
	$route['mahasiswa/tesis/judul/add'] = 'backend/mahasiswa/tesis/judul/add';
	$route['mahasiswa/tesis/judul/edit/(:num)'] = 'backend/mahasiswa/tesis/judul/edit';
	$route['mahasiswa/tesis/judul/save'] = 'backend/mahasiswa/tesis/judul/save';
	$route['mahasiswa/tesis/judul/update'] = 'backend/mahasiswa/tesis/judul/update';

	$route['mahasiswa/tesis/proposal'] = 'backend/mahasiswa/tesis/proposal';
	//$route['mahasiswa/tesis/proposal/add'] = 'backend/mahasiswa/tesis/proposal/add';
	$route['mahasiswa/tesis/proposal/add/(:num)'] = 'backend/mahasiswa/tesis/proposal/add';
	$route['mahasiswa/tesis/proposal/edit/(:num)'] = 'backend/mahasiswa/tesis/proposal/edit';
	$route['mahasiswa/tesis/proposal/save'] = 'backend/mahasiswa/tesis/proposal/save';
	$route['mahasiswa/tesis/proposal/update'] = 'backend/mahasiswa/tesis/proposal/update';
	$route['mahasiswa/tesis/proposal/info/(:num)'] = 'backend/mahasiswa/tesis/proposal/info';
	$route['mahasiswa/tesis/proposal/jadwal/(:num)'] = 'backend/mahasiswa/tesis/proposal/jadwal';
	$route['mahasiswa/tesis/proposal/jadwal_save'] = 'backend/mahasiswa/tesis/proposal/jadwal_save';

	$route['mahasiswa/tesis/mkpt'] = 'backend/mahasiswa/tesis/mkpt';
	$route['mahasiswa/tesis/mkpt/add/(:num)'] = 'backend/mahasiswa/tesis/mkpt/add';
	$route['mahasiswa/tesis/mkpt/edit/(:num)'] = 'backend/mahasiswa/tesis/mkpt/edit';
	$route['mahasiswa/tesis/mkpt/save'] = 'backend/mahasiswa/tesis/mkpt/save';
	$route['mahasiswa/tesis/mkpt/update'] = 'backend/mahasiswa/tesis/mkpt/update';
	$route['mahasiswa/tesis/mkpt/info/(:num)'] = 'backend/mahasiswa/tesis/mkpt/info';
	$route['mahasiswa/tesis/mkpt/jadwal/(:num)'] = 'backend/mahasiswa/tesis/mkpt/jadwal';
	$route['mahasiswa/tesis/mkpt/jadwal_save'] = 'backend/mahasiswa/tesis/mkpt/jadwal_save';


	$route['mahasiswa/tesis/ujian'] = 'backend/mahasiswa/tesis/ujian';
	$route['mahasiswa/tesis/ujian/add/(:num)'] = 'backend/mahasiswa/tesis/ujian/add';
	$route['mahasiswa/tesis/ujian/edit/(:num)'] = 'backend/mahasiswa/tesis/ujian/edit';
	$route['mahasiswa/tesis/ujian/save'] = 'backend/mahasiswa/tesis/ujian/save';
	$route['mahasiswa/tesis/ujian/update'] = 'backend/mahasiswa/tesis/ujian/update';
	$route['mahasiswa/tesis/ujian/info/(:num)'] = 'backend/mahasiswa/tesis/ujian/info';
	$route['mahasiswa/tesis/ujian/jadwal/(:num)'] = 'backend/mahasiswa/tesis/ujian/jadwal';
	$route['mahasiswa/tesis/ujian/jadwal_save'] = 'backend/mahasiswa/tesis/ujian/jadwal_save';

	/*

	 * DOKUMENT PUBLIC VIEW

	 */

	$route['document/lihat'] = 'document/lihat';
	$route['document/persetujuan'] = 'document/persetujuan';
	$route['document/persetujuan/save'] = 'document/persetujuan_save';
	$route['document/cetak'] = 'document/cetak';

	$route['document/lihat_skripsi'] = 'document/lihat_skripsi';
	$route['document/cetak_skripsi'] = 'document/cetak_skripsi';
	$route['document/lihat_skripsi_ujian'] = 'document/lihat_skripsi_ujian';
	$route['document/cetak_skripsi_ujian'] = 'document/cetak_skripsi_ujian';
	$route['document/persetujuan/skripsi'] = 'document/persetujuan_skripsi';
	$route['document/persetujuan/skripsi/save'] = 'document/persetujuan_skripsi_save';

	$route['document/lihat_proposal_skripsi_surat_tugas'] = 'document/lihat_proposal_skripsi_surat_tugas';
	$route['document/cetak_proposal_skripsi_surat_tugas'] = 'document/cetak_proposal_skripsi_surat_tugas';
	$route['document/lihat_proposal_skripsi_undangan'] = 'document/lihat_proposal_skripsi_undangan';
	$route['document/cetak_proposal_skripsi_undangan'] = 'document/cetak_proposal_skripsi_undangan';
	$route['document/lihat_skripsi_surat_tugas'] = 'document/lihat_skripsi_surat_tugas';
	$route['document/cetak_skripsi_surat_tugas'] = 'document/cetak_skripsi_surat_tugas';

	$route['document/lihat_tesis'] = 'document/lihat_tesis';
	$route['document/cetak_tesis'] = 'document/cetak_tesis';

	// Dashboard
	$route['dashboard/jadwal-kalender'] = 'dashboard/jadwal_kalender';
	$route['dashboard/jadwal-tabel'] = 'dashboard/jadwal_tabel';
	// API
	$route['api/jadwal/get-data-kalender'] = 'api/jadwal_get_data_kalender';
	$route['api/jadwal/get-detail/(:num)/(:num)'] = 'api/jadwal_get_detail/$1/$2';

