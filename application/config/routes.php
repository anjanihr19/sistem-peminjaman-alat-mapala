<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin Login
$route['admin/login']                           = 'admin/Admin_Login/index';
$route['admin/login/proses_login']              = 'admin/Admin_Login/proses_login';

// Admin Dashboard
$route['admin/dashboard']                       = 'admin/Admin_Dashboard/index';
$route['admin/dashboard/update_akun']           = 'admin/Admin_Dashboard/update_akun';

// Admin Alat
$route['admin/alat']                            = 'admin/Admin_Alat/index';
$route['admin/alat/tambah']                     = 'admin/Admin_Alat/tambah';
$route['admin/alat/simpan']                     = 'admin/Admin_Alat/simpan';
$route['admin/alat/export']                     = 'admin/Admin_Alat/export';
$route['admin/alat/edit/(:num)']                = 'admin/Admin_Alat/edit/$1';
$route['admin/alat/update/(:num)']              = 'admin/Admin_Alat/update/$1';
$route['admin/alat/hapus/(:num)']               = 'admin/Admin_Alat/hapus/$1';

// Admin Peminjam
$route['admin/peminjam']                        = 'admin/Admin_Peminjam/index';
$route['admin/peminjam/edit/(:num)']            = 'admin/Admin_Peminjam/edit/$1';
$route['admin/peminjam/update/(:num)']          = 'admin/Admin_Peminjam/update/$1';
$route['admin/peminjam/hapus/(:num)']           = 'admin/Admin_Peminjam/hapus/$1';

// Admin — kode undangan
$route['admin/peminjam/kode_undangan']          = 'admin/Admin_Peminjam/kode_undangan';
$route['admin/peminjam/generate_kode']          = 'admin/Admin_Peminjam/generate_kode';

// Admin — reset password & aktivasi akun
$route['admin/peminjam/reset_password/(:num)']  = 'admin/Admin_Peminjam/reset_password/$1';
$route['admin/peminjam/aktivasi/(:num)']        = 'admin/Admin_Peminjam/aktivasi/$1';
$route['admin/peminjam/nonaktif/(:num)']        = 'admin/Admin_Peminjam/nonaktif/$1';

// Admin — ajukan perubahan peminjaman
$route['admin/peminjaman/ajukan_perubahan/(:num)'] = 'admin/Admin_Peminjaman/ajukan_perubahan/$1';

// Admin Peminjaman
$route['admin/peminjaman/export']               = 'admin/Admin_Peminjaman/export';
$route['admin/peminjaman']                          = 'admin/Admin_Peminjaman/index';
$route['admin/peminjaman/update_status/(:num)']     = 'admin/Admin_Peminjaman/update_status/$1';
$route['user/peminjaman/batal/(:num)'] = 'user/Peminjaman/batal/$1';
$route['admin/peminjaman'] = 'admin/admin_peminjaman';
$route['admin/peminjaman/edit/(:num)'] = 'admin/admin_peminjaman/edit/$1';
$route['admin/peminjaman/ajukan_perubahan/(:num)'] = 'admin/admin_peminjaman/ajukan_perubahan/$1';
$route['admin/peminjaman/update_status/(:num)'] = 'admin/admin_peminjaman/update_status/$1';

// User Routes
$route['login']                                 = 'Login/index';
$route['login/proses_login']                    = 'Login/proses_login';
$route['login/logout']                          = 'Login/logout';
$route['logout']                                = 'Logout/index';
$route['register']                              = 'Register/index';
$route['register/proses_daftar']                = 'Register/proses_daftar';
$route['user/dashboard']                        = 'user/Dashboard/index';
$route['user/alat']                             = 'user/Alat/index';
$route['user/peminjaman/tambah/(:num)']         = 'user/Peminjaman/tambah/$1';

// User Peminjaman
$route['user/peminjaman/tambah/(:num)'] = 'user/Peminjaman/tambah/$1';
$route['user/peminjaman/simpan']        = 'user/Peminjaman/simpan';
$route['user/peminjaman/riwayat']       = 'user/Peminjaman/riwayat';

// User — konfirmasi perubahan peminjaman
$route['user/peminjaman/konfirmasi/(:num)']     = 'user/Peminjaman/konfirmasi/$1';
$route['user/ganti_password']                   = 'user/Dashboard/ganti_password';
$route['user/proses_ganti_password']            = 'user/Dashboard/proses_ganti_password';
$route['user/ubah_password']                    = 'user/Dashboard/ubah_password';
