<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	/*
	  |--------------------------------------------------------------------------
	  | Display Debug backtrace
	  |--------------------------------------------------------------------------
	  |
	  | If set to TRUE, a backtrace will be displayed along with php errors. If
	  | error_reporting is disabled, the backtrace will not display, regardless
	  | of this setting
	  |
	 */
	defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

	/*
	  |--------------------------------------------------------------------------
	  | File and Directory Modes
	  |--------------------------------------------------------------------------
	  |
	  | These prefs are used when checking and setting modes when working
	  | with the file system.  The defaults are fine on servers with proper
	  | security, but you may wish (or even need) to change the values in
	  | certain environments (Apache running a separate process for each
	  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
	  | always be used to set the mode correctly.
	  |
	 */
	defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
	defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
	defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
	defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

	/*
	  |--------------------------------------------------------------------------
	  | File Stream Modes
	  |--------------------------------------------------------------------------
	  |
	  | These modes are used when working with fopen()/popen()
	  |
	 */
	defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
	defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
	defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
	defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
	defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
	defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
	defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
	defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

	/*
	  |--------------------------------------------------------------------------
	  | Exit Status Codes
	  |--------------------------------------------------------------------------
	  |
	  | Used to indicate the conditions under which the script is exit()ing.
	  | While there is no universal standard for error codes, there are some
	  | broad conventions.  Three such conventions are mentioned below, for
	  | those who wish to make use of them.  The CodeIgniter defaults were
	  | chosen for the least overlap with these conventions, while still
	  | leaving room for others to be defined in future versions and user
	  | applications.
	  |
	  | The three main conventions used for determining exit status codes
	  | are as follows:
	  |
	  |    Standard C/C++ Library (stdlibc):
	  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
	  |       (This link also contains other GNU-specific conventions)
	  |    BSD sysexits.h:
	  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
	  |    Bash scripting:
	  |       http://tldp.org/LDP/abs/html/exitcodes.html
	  |
	 */
	defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
	defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
	defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
	defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
	defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
	defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
	defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
	defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
	defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
	defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

	/*
	 * Custom Constant Variable
	 */
	// SYSTEM
	define('APPLICATION_VERSION', '3.0');
	define('VIEW_ERROR_404', 'errors/html/error_404');
	define('VIEW_ERROR_GENERAL', 'errors/html/error_general');

	// LOCALE
	define('PREFIX_PHONE_NUMBER', '+62');

	// FILE UPLOAD
	define('MAX_SIZE_FILE_UPLOAD', 10000);
	define('MAX_SIZE_FILE_UPLOAD_DESCRIPTION', '10 MB');
	define('PATH_FILE_DISERTASI_KUALIFIKASI', 'assets/upload/mahasiswa/disertasi/kualifikasi');
	define('PATH_FILE_DISERTASI_MPKK', 'assets/upload/mahasiswa/disertasi/mpkk');
	define('PATH_FILE_DISERTASI_PROPOSAL', 'assets/upload/mahasiswa/disertasi/proposal');
	define('PATH_FILE_DISERTASI_MKPD', 'assets/upload/mahasiswa/disertasi/mkpd');
	define('PATH_FILE_DISERTASI_KELAYAKAN', 'assets/upload/mahasiswa/disertasi/kelayakan');
	define('PATH_FILE_DISERTASI_TERTUTUP', 'assets/upload/mahasiswa/disertasi/tertutup');
	define('PATH_FILE_DISERTASI_TERBUKA', 'assets/upload/mahasiswa/disertasi/terbuka');

	// DOCUMENT
	define('CODE_DELIMITER', '/');
	define('FILE_NAME_DELIMITER', '_');
	define('REAL_PATH_FILE_QR', './assets/img/qr/');
	define('PATH_FILE_QR', 'assets/img/qr/');

	// NOTIFICATION
	define('WA_LINE_BREAK', '
');

	// TIPE DOKUMEN
	define('DOKUMEN_BERITA_ACARA_STR', 'berita-acara');
	define('DOKUMEN_UNDANGAN_STR', 'undangan');

	// JENIS DOKUMEN
	/// S1
	define('DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR', 'skripsi_proposal');
	define('DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR', 'skripsi');
	// S2
	define('DOKUMEN_JENIS_TESIS_UJIAN_PROPOSAL_STR', 'tesis_proposal');
	define('DOKUMEN_JENIS_TESIS_UJIAN_SKRIPSI_STR', 'tesis');
	// S3
	define('DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR', 'kualifikasi');
	define('DOKUMEN_JENIS_DISERTASI_UJIAN_PROPOSAL_STR', 'disertasi_proposal');
	define('DOKUMEN_JENIS_DISERTASI_UJIAN_KELAYAKAN_STR', 'kelayakan');
	define('DOKUMEN_JENIS_DISERTASI_UJIAN_TERBUKA_STR', 'terbua');
	define('DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR', 'tertutup');

	// PROCESS VARIABLE
	define('MAX_PENGUJI_S3', 6);

	// PRODI & JENJANG
	define('JENJANG_S1', 1);
	define('JENJANG_S2', 2);
	define('JENJANG_S3', 3);

	define('S2_ILMU_HUKUM', 2);
	define('S2_KENOTARIATAN', 3);

	// USER
	define('ROLE_MAHASISWA_S2', 5);
	define('ROLE_MAHASISWA_S3', 6);
	define('ROLE_ADMINISTRATOR', 1);
	define('ROLE_BAA', 2);
	define('ROLE_ADMIN_PRODI', 3);

	// STRUKTUR DOSEN
	define('STRUKTUR_DEKAN', 1);
	define('STRUKTUR_WADEK_1', 2);
	define('STRUKTUR_WADEK_2', 3);
	define('STRUKTUR_WADEK_3', 4);
	define('STRUKTUR_KETUA_BAGIAN', 5);
	define('STRUKTUR_SPS', 7);
	define('STRUKTUR_KPS_S1', 6);
	define('STRUKTUR_KPS_S2', 8);
	define('STRUKTUR_KPS_S3', 9);

	// TAHAPAN PROSES SKRIPSI
	define('TAHAPAN_SKRIPSI_PROPOSAL', 1);
	define('TAHAPAN_SKRIPSI_UJIAN', 2);

	define('TAHAPAN_SKRIPSI_PROPOSAL_STR', 'proposal');
	define('TAHAPAN_SKRIPSI_UJIAN_STR', 'ujian');

	// JENIS UJIAN TESIS
	define('UJIAN_SKRIPSI_PROPOSAL', 1);
	define('UJIAN_SKRIPSI_UJIAN', 2);

	// STATUS TAHAPAN PROSES SKRIPSI PROPOSAL
	define('STATUS_SKRIPSI_PROPOSAL_PENGAJUAN', 1);
	define('STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP', 2);
	define('STATUS_SKRIPSI_PROPOSAL_DIJADWALKAN', 3);
	define('STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI', 4);
	define('STATUS_SKRIPSI_PROPOSAL_UJIAN', 5);
	define('STATUS_SKRIPSI_PROPOSAL_SELESAI', 6);
	define('STATUS_SKRIPSI_PROPOSAL_DITOLAK', 21);

	// STATUS TAHAPAN PROSES SKRIPSI UJIAN
	define('STATUS_SKRIPSI_UJIAN_PENGAJUAN', 1);
	define('STATUS_SKRIPSI_UJIAN_SETUJUI_BAA', 2);
	define('STATUS_SKRIPSI_UJIAN_SETUJUI_PEMBIMMBING', 3);
	define('STATUS_SKRIPSI_UJIAN_DIJADWALKAN', 4);
	define('STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI', 5);
	define('STATUS_SKRIPSI_UJIAN_SETUJUI_KPS', 6);
	define('STATUS_SKRIPSI_UJIAN_UJIAN', 7);
	define('STATUS_SKRIPSI_UJIAN_SELESAI', 8);

	// TAHAPAN PROSES TESIS
	define('TAHAPAN_TESIS_JUDUL', 1);
	define('TAHAPAN_TESIS_PROPOSAL', 2);
	define('TAHAPAN_TESIS_MKPT', 3);
	define('TAHAPAN_TESIS_UJIAN', 4);

	define('TAHAPAN_TESIS_PROPOSAL_STR', 'proposal_tesis');
	define('TAHAPAN_TESIS_UJIAN_STR', 'ujian_tesis');

	// JENIS UJIAN TESIS
	define('UJIAN_TESIS_PROPOSAL', 1);
	define('UJIAN_TESIS_MKPT', 2);
	define('UJIAN_TESIS_UJIAN', 3);

	// STATUS TAHAPAN PROSES TESIS JUDUL PROPOSAL
	define('STATUS_TESIS_JUDUL_PENGAJUAN', 1);
	define('STATUS_TESIS_JUDUL_SETUJUI_SPS', 2);
	define('STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING', 3);
	define('STATUS_TESIS_JUDUL_DITOLAK', 4);

	// STATUS TAHAPAN PROSES TESIS PROPOSAL
	define('STATUS_TESIS_PROPOSAL_PENGAJUAN', 1);
	define('STATUS_TESIS_PROPOSAL_DIJADWALKAN', 2);
	define('STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI', 3);
	define('STATUS_TESIS_PROPOSAL_UJIAN', 4);
	define('STATUS_TESIS_PROPOSAL_UJIAN_SELESAI', 5);

	// STATUS TAHAPAN PROSES TESIS MKPT
	define('STATUS_TESIS_MKPT_PENGAJUAN', 1);
	define('STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT', 2);
	//define('STATUS_TESIS_MKPT_DIJADWALKAN', 3);
	//define('STATUS_TESIS_MKPT_SETUJUI_PENGUJI', 4);
	define('STATUS_TESIS_MKPT_UJIAN', 3);
	define('STATUS_TESIS_MKPT_UJIAN_SELESAI', 4);

	// STATUS TAHAPAN PROSES TESIS UJIAN
	define('STATUS_TESIS_UJIAN_PENGAJUAN', 1);
	define('STATUS_TESIS_UJIAN_SETUJUI_BAA', 2);
	define('STATUS_TESIS_UJIAN_DIJADWALKAN', 3);
	define('STATUS_TESIS_UJIAN_SETUJUI_PENGUJI', 4);
	define('STATUS_TESIS_UJIAN', 5);
	define('STATUS_TESIS_UJIAN_SELESAI', 6);
	define('STATUS_TESIS_UJIAN_DITOLAK', 7);
	//define('STATUS_TESIS_UJIAN_SELESAI', 7);
	// TAHAPAN PROSES DISERTASI
	define('TAHAPAN_DISERTASI_KUALIFIKASI', 1);
	define('TAHAPAN_DISERTASI_PROMOTOR', 2);
	define('TAHAPAN_DISERTASI_MPKK', 3);
	define('TAHAPAN_DISERTASI_PROPOSAL', 4);
	define('TAHAPAN_DISERTASI_MKPD', 5);
	define('TAHAPAN_DISERTASI_KELAYAKAN', 6);
	define('TAHAPAN_DISERTASI_TERTUTUP', 7);
	define('TAHAPAN_DISERTASI_TERBUKA', 8);

	define('TAHAPAN_DISERTASI_KUALIFIKASI_STR', 'kualifikasi');
	define('TAHAPAN_DISERTASI_PROPOSAL_STR', 'disertasi_proposal');
	define('TAHAPAN_DISERTASI_KELAYAKAN_STR', 'kelayakan');
	define('TAHAPAN_DISERTASI_TERTUTUP_STR', 'tertutup');
	define('TAHAPAN_DISERTASI_TERBUKA_STR', 'terbuka');

	// JENIS UJIAN DISERTASI
	define('UJIAN_DISERTASI_KUALIFIKASI', 1);
	define('UJIAN_DISERTASI_PROPOSAL', 2);
	define('UJIAN_DISERTASI_KELAYAKAN', 3);
	define('UJIAN_DISERTASI_TERTUTUP', 4);
	define('UJIAN_DISERTASI_TERBUKA', 5);

	// STATUS TAHAPAN PROSES DISERTASI
	define('STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN', 1);
	define('STATUS_DISERTASI_KUALIFIKASI_CETAK_SK_PENASEHAT', 2);
	define('STATUS_DISERTASI_KUALIFIKASI_DIJADWALKAN', 3);
	define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI', 4);
	define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_SPS', 5);
	define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS', 6);
	define('STATUS_DISERTASI_KUALIFIKASI_UJIAN', 7);
	define('STATUS_DISERTASI_KUALIFIKASI_CETAK_DOKUMEN', 8);
	define('STATUS_DISERTASI_KUALIFIKASI_SELESAI', 9);

	// STATUS TAHAPAN PROSES PENGAJUAN PROMOTOR
	define('STATUS_DISERTASI_PROMOTOR_PENGAJUAN', 1);
	define('STATUS_DISERTASI_PROMOTOR_SETUJUI', 2);
	define('STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS', 3);
	define('STATUS_DISERTASI_PROMOTOR_CETAK_SK', 4);
	define('STATUS_DISERTASI_PROMOTOR_SELESAI', 5);

	// STATUS TAHAPAN PROSES MPKK
	define('STATUS_DISERTASI_MPKK_PENGAJUAN', 1);
	define('STATUS_DISERTASI_MPKK_SETUJUI_PROMOTOR', 2);
	define('STATUS_DISERTASI_MPKK_SETUJUI_KPS', 3);
	define('STATUS_DISERTASI_MPKK_CETAK_SK', 4);
	define('STATUS_DISERTASI_MPKK_PENILAIAN', 5);
	define('STATUS_DISERTASI_MPKK_SELESAI', 6);

	// STATUS TAHAPAN PROSES UJIAN PROPOSAL
	define('STATUS_DISERTASI_PROPOSAL_PENGAJUAN', 1);
	define('STATUS_DISERTASI_PROPOSAL_SETUJUI_PRODI', 2);
	define('STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR', 3);
	define('STATUS_DISERTASI_PROPOSAL_DIJADWALKAN', 4);
	define('STATUS_DISERTASI_PROPOSAL_SETUJUI_PENGUJI', 5);
	define('STATUS_DISERTASI_PROPOSAL_SETUJUI_SPS', 6);
	define('STATUS_DISERTASI_PROPOSAL_SETUJUI_KPS', 7);
	define('STATUS_DISERTASI_PROPOSAL_UJIAN', 8);
	define('STATUS_DISERTASI_PROPOSAL_CETAK_DOKUMEN', 9);
	define('STATUS_DISERTASI_PROPOSAL_SELESAI', 10);

	// STATUS TAHAPAN PROSES MKPD
	define('STATUS_DISERTASI_MKPD_PENGAJUAN', 1);
	define('STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR', 2);
	define('STATUS_DISERTASI_MKPD_SETUJUI_KPS', 3);
	define('STATUS_DISERTASI_MKPD_CETAK_SK', 4);
	define('STATUS_DISERTASI_MKPD_PENILAIAN', 5);
	define('STATUS_DISERTASI_MKPD_SELESAI', 6);

	// STATUS TAHAPAN PROSES UJIAN KELAYAKAN
	define('STATUS_DISERTASI_KELAYAKAN_PENGAJUAN', 1);
	define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR', 2);
	define('STATUS_DISERTASI_KELAYAKAN_DIJADWALKAN', 3);
	define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_PENGUJI', 4);
	define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_SPS', 5);
	define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_KPS', 6);
	define('STATUS_DISERTASI_KELAYAKAN_UJIAN', 7);
	define('STATUS_DISERTASI_KELAYAKAN_CETAK_DOKUMEN', 8);
	define('STATUS_DISERTASI_KELAYAKAN_SELESAI', 9);

	// STATUS TAHAPAN PROSES UJIAN TERTUTUP
	define('STATUS_DISERTASI_TERTUTUP_PENGAJUAN', 1);
	define('STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR', 2);
	define('STATUS_DISERTASI_TERTUTUP_DIJADWALKAN', 3);
	define('STATUS_DISERTASI_TERTUTUP_SETUJUI_PENGUJI', 4);
	define('STATUS_DISERTASI_TERTUTUP_SETUJUI_SPS', 5);
	define('STATUS_DISERTASI_TERTUTUP_SETUJUI_KPS', 6);
	define('STATUS_DISERTASI_TERTUTUP_UJIAN', 7);
	define('STATUS_DISERTASI_TERTUTUP_CETAK_DOKUMEN', 8);
	define('STATUS_DISERTASI_TERTUTUP_SELESAI', 9);

	// STATUS TAHAPAN PROSES UJIAN TERBUKA
	define('STATUS_DISERTASI_TERBUKA_PENGAJUAN', 1);
	define('STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR', 2);
	define('STATUS_DISERTASI_TERBUKA_DIJADWALKAN', 3);
	define('STATUS_DISERTASI_TERBUKA_SETUJUI_PENGUJI', 4);
	define('STATUS_DISERTASI_TERBUKA_SETUJUI_SPS', 5);
	define('STATUS_DISERTASI_TERBUKA_SETUJUI_KPS', 6);
	define('STATUS_DISERTASI_TERBUKA_UJIAN', 7);
	define('STATUS_DISERTASI_TERBUKA_CETAK_DOKUMEN', 8);
	define('STATUS_DISERTASI_TERBUKA_SELESAI', 9);
