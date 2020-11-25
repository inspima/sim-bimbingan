<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 * Custom Constant Variable
 */

define('APPLICATION_VERSION', '3.0');
define('MAX_SIZE_FILE_UPLOAD', 10000);
define('MAX_SIZE_FILE_UPLOAD_DESCRIPTION', '10 MB');
// USER
define('ROLE_MAHASISWA_S2', 5);
define('ROLE_MAHASISWA_S3', 6);
// STRUKTUR DOSEN
define('STRUKTUR_DEKAN', 1);
define('STRUKTUR_WADEK_1', 2);
define('STRUKTUR_WADEK_2', 3);
define('STRUKTUR_WADEK_3', 4);
define('STRUKTUR_KADEP', 5);
define('STRUKTUR_SPS', 7);
define('STRUKTUR_KPS_S1', 6);
define('STRUKTUR_KPS_S2', 8);
define('STRUKTUR_KPS_S3', 9);

// TAHAPAN PROSES DISERTASI
define('TAHAPAN_DISERTASI_KUALIFIKASI', 1);
define('TAHAPAN_DISERTASI_MPKK', 2);
define('TAHAPAN_DISERTASI_PROPOSAL', 3);
define('TAHAPAN_DISERTASI_MKPD', 4);
define('TAHAPAN_DISERTASI_KELAYAKAN', 5);
define('TAHAPAN_DISERTASI_TERTUTUP', 6);
define('TAHAPAN_DISERTASI_TERBUKA', 7);

// JENIS UJIAN DISERTASI
define('UJIAN_DISERTASI_KUALIFIKASI', 1);
define('UJIAN_DISERTASI_PROPOSAL', 2);
define('UJIAN_DISERTASI_KELAYAKAN', 3);
define('UJIAN_DISERTASI_TERTUTUP', 4);
define('UJIAN_DISERTASI_TERBUKA', 5);

// STATUS TAHAPAN PROSES DISERTASI
define('STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN', 1);
define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PA', 2);
define('STATUS_DISERTASI_KUALIFIKASI_DIJADWALKAN', 3);
define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI', 4);
define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_SPS', 5);
define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS', 6);
define('STATUS_DISERTASI_KUALIFIKASI_UJIAN', 7);
define('STATUS_DISERTASI_KUALIFIKASI_UJIAN_SELESAI', 8);
define('STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN_PROMOTOR', 9);
define('STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PROMOTOR', 10);
define('STATUS_DISERTASI_KUALIFIKASI_SELESAI', 11);

// STATUS TAHAPAN PROSES MPKK
define('STATUS_DISERTASI_MPKK_PENGAJUAN', 1);
define('STATUS_DISERTASI_MPKK_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_MPKK_SETUJUI_SPS', 3);
define('STATUS_DISERTASI_MPKK_SETUJUI_KPS', 4);
define('STATUS_DISERTASI_MPKK_SELESAI', 5);

// STATUS TAHAPAN PROSES UJIAN PROPOSAL
define('STATUS_DISERTASI_PROPOSAL_PENGAJUAN', 1);
define('STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_PROPOSAL_DIJADWALKAN', 3);
define('STATUS_DISERTASI_PROPOSAL_SETUJUI_PENGUJI', 4);
define('STATUS_DISERTASI_PROPOSAL_SETUJUI_SPS', 5);
define('STATUS_DISERTASI_PROPOSAL_SETUJUI_KPS', 6);
define('STATUS_DISERTASI_PROPOSAL_UJIAN', 7);
define('STATUS_DISERTASI_PROPOSAL_SELESAI', 8);

// STATUS TAHAPAN PROSES MKPD
define('STATUS_DISERTASI_MKPD_PENGAJUAN', 1);
define('STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_MKPD_SETUJUI_SPS', 3);
define('STATUS_DISERTASI_MKPD_SETUJUI_KPS', 4);
define('STATUS_DISERTASI_MKPD_SELESAI', 5);

// STATUS TAHAPAN PROSES UJIAN KELAYAKAN
define('STATUS_DISERTASI_KELAYAKAN_PENGAJUAN', 1);
define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_KELAYAKAN_DIJADWALKAN', 3);
define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_PENGUJI', 4);
define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_SPS', 5);
define('STATUS_DISERTASI_KELAYAKAN_SETUJUI_KPS', 6);
define('STATUS_DISERTASI_KELAYAKAN_UJIAN', 7);
define('STATUS_DISERTASI_KELAYAKAN_SELESAI', 8);

// STATUS TAHAPAN PROSES UJIAN TERTUTUP
define('STATUS_DISERTASI_TERTUTUP_PENGAJUAN', 1);
define('STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_TERTUTUP_DIJADWALKAN', 3);
define('STATUS_DISERTASI_TERTUTUP_SETUJUI_PENGUJI', 4);
define('STATUS_DISERTASI_TERTUTUP_SETUJUI_SPS', 5);
define('STATUS_DISERTASI_TERTUTUP_SETUJUI_KPS', 6);
define('STATUS_DISERTASI_TERTUTUP_UJIAN', 7);
define('STATUS_DISERTASI_TERTUTUP_SELESAI', 8);

// STATUS TAHAPAN PROSES UJIAN TERBUKA
define('STATUS_DISERTASI_TERBUKA_PENGAJUAN', 1);
define('STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR', 2);
define('STATUS_DISERTASI_TERBUKA_DIJADWALKAN', 3);
define('STATUS_DISERTASI_TERBUKA_SETUJUI_PENGUJI', 4);
define('STATUS_DISERTASI_TERBUKA_SETUJUI_SPS', 5);
define('STATUS_DISERTASI_TERBUKA_SETUJUI_KPS', 6);
define('STATUS_DISERTASI_TERBUKA_UJIAN', 7);
define('STATUS_DISERTASI_TERBUKA_SELESAI', 8);
