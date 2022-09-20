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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['form'] = 'Frontend';
$route['form/save'] = 'Frontend/save';

$route['anggota/(:any)'] = 'Anggota/status/$1';
$route['anggota/register/detail/(:any)'] = 'Anggota/detail/$1';
$route['anggota/aktif/detail/(:any)'] = 'Anggota/detail/$1';
$route['anggota/aktif/edit/(:any)'] = 'Anggota/edit/$1';
$route['anggota/aktif/update'] = 'Anggota/update';
$route['anggota/aktif/create'] = 'Anggota/create_aktif';
$route['anggota/aktif/store'] = 'Anggota/store';
$route['anggota/aktif/hapus/(:any)'] = 'Anggota/delete/$1';
$route['anggota/delete/all'] = 'Anggota/itemdelete/';

$route['anggota/tidakaktif/detail/(:any)'] = 'Anggota/detail/$1';
$route['anggota/kta/detail/(:any)'] = 'Anggota/detail/$1';
$route['anggota/kta/upload/(:any)'] = 'Anggota/uploadkta/$1';

$route['anggota/export/(:any)'] = 'Anggota/export/$1';

$route['anggota/send/email'] = 'Anggota/coba_email';


$route['laporan/calonanggota'] = 'Laporan/calonanggota/';
$route['laporan/anggota/(:any)'] = 'Laporan/anggota/$1';


$route['cekanggota'] = 'Cek';
$route['CekAnggota/show/(:any)'] = 'Cek/show/$1';


$route['user'] = 'User';
$route['user/add'] = 'User/tambah';
$route['user/edit/(:any)'] = 'User/update/$1';

$route['jabatan'] = 'Jabatan';
$route['jabatan/add'] = 'Jabatan/tambah';
$route['jabatan/edit/(:any)'] = 'Jabatan/update/$1';

$route['pengurus'] = 'Pengurus';
$route['pengurus/add'] = 'Pengurus/tambah';
$route['pengurus/edit/(:any)'] = 'Pengurus/update/$1';

$route['pengaturan'] = 'Setting';
$route['backupdatabase'] = 'Setting/backup';
$route['hakakses'] = 'Setting/akses';
$route['hakakses/(:any)'] = 'Setting/view/$1';
$route['password'] = 'Setting/password';
$route['userlog'] = 'Setting/log/$1';
$route['userlog/aktifitas'] = 'Setting/aktivitas/$1';

$route['slider'] = 'Slide';
$route['Slide/create']['get'] = 'Slide/create';
$route['Slide/store']['post'] = 'Slide/store';
$route['Slide/edit/(:any)']['get'] = 'Slide/edit/$1';
$route['Slide/update']['post'] = 'Slide/update';
$route['Slide/show/(:any)']['get'] = 'Slide/show/$1';
$route['Slide/data'] = 'Slide/data';
