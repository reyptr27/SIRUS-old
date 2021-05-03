<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Login Route
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Auth
Route::group(['middleware' => ['auth']], function () {
    
    //Logout
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    
    //Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/panduanregister', 'DashboardController@downloadpanduanregister')->name('dashboard.downloadpanduanregister');        
    Route::get('/panduanapprove', 'DashboardController@downloadpanduanapprove')->name('dashboard.downloadpanduanapprove');        
    
    //Manual Book
    Route::get('/manualbook/json', 'ManualBook\ManualBookController@json')->name('manualbook.json');
    Route::get('/manualbook', 'ManualBook\ManualBookController@index')->name('manualbook.index');
    Route::get('/manualbook/create', 'ManualBook\ManualBookController@create')->name('manualbook.create');
    Route::post('/manualbook/create', 'ManualBook\ManualBookController@store')->name('manualbook.store');
    Route::get('/manualbook/{id}/update', 'ManualBook\ManualBookController@edit')->name('manualbook.edit');
    Route::patch('/manualbook/{id}/update', 'ManualBook\ManualBookController@update')->name('manualbook.update');
    Route::delete('/manualbook/{id}', 'ManualBook\ManualBookController@destroy')->name('manualbook.destroy');
    Route::get('/manualbook/{id}/download', 'ManualBook\ManualBookController@download')->name('manualbook.download');        
    Route::get('/manualbook/{id}/show', 'ManualBook\ManualBookController@show')->name('manualbook.show');
 
    //Permission master-data
    Route::group(['middleware' => ['permission:master-data']], function(){
        //Role
        Route::resource('/role', 'RoleController')->except([
            'create', 'show', 'edit'
        ]);

        //Permission
        Route::resource('/permission', 'PermissionController')->except([
            'create', 'show', 'edit'
        ]);
        //Permission-Role
        Route::get('/permission/user/{id}', 'PermissionController@permissionUserList')->name('permission.user.list');
        Route::post('/permission/user/{id}', 'PermissionController@permissionUserAdd')->name('permission.user.add');
        Route::delete('/permission/user/{id}', 'PermissionController@permissionUserDelete')->name('permission.user.delete');
        //Permission-Role
        Route::get('/permission/role/{id}', 'PermissionController@permissionRoleList')->name('permission.role.list');
        Route::post('/permission/role/{id}', 'PermissionController@permissionRoleAdd')->name('permission.role.add');
        Route::delete('/permission/role/{id}', 'PermissionController@permissionRoleDelete')->name('permission.role.delete');

        //User
        Route::resource('/users', 'UserController')->except([
            'show'
        ]);
        Route::get('/users/json', 'UserController@json')->name('users.json');

        //User-Role
        Route::get('/users/roles/{id}', 'UserController@userRoleList')->name('users.role.list'); 
        Route::post('/users/roles/{id}', 'UserController@userRoleAdd')->name('users.role.add');
        Route::delete('/users/roles/{id}', 'UserController@userRoleDelete')->name('users.role.delete');
        
        //User-Permission
        Route::get('/users/permission/{id}', 'UserController@userPermissionList')->name('users.permission.list');
        Route::post('/users/permission/{id}', 'UserController@userPermissionAdd')->name('users.permission.add');
        Route::delete('/users/permission/{id}', 'UserController@userPermissionDelete')->name('users.permission.delete');

        //Role-Permission
        Route::get('/role/permission/{id}', 'RoleController@rolePermissionList')->name('role.permission.list');
        Route::post('/role/permission/{id}', 'RoleController@rolePermissionAdd')->name('role.permission.add');
        Route::delete('/role/permission/{id}', 'RoleController@rolePermissionDelete')->name('role.permission.delete');
        //Role-User
        Route::get('/role/user/{id}', 'RoleController@roleUserList')->name('role.user.list');
        Route::post('/role/user/{id}', 'RoleController@roleUserAdd')->name('role.user.add');
        Route::delete('/role/user/{id}', 'RoleController@roleUserDelete')->name('role.user.delete');
        
        //Master Data
        Route::resource('/cabang', 'Master\CabangController', ['except' => ['edit','show','create','destroy']]);
        Route::resource('/departemen', 'Master\DepartemenController', ['except' => ['edit','show','create','destroy']]);
        Route::resource('/divisi', 'Master\DivisiController', ['except' => ['edit','show','create','destroy']]);
    }); 
    // end master-data 
    
    //Profile
    Route::get('/profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/profile/{id}/edit', 'ProfileController@update')->name('profile.update');
    Route::get('/profile/password/{id}', 'ProfileController@editPassword')->name('profile.password');
    Route::patch('/profile/password/{id}', 'ProfileController@updatePassword')->name('profile.password.update');
    Route::post('/profile/image_upload/{id}', 'ProfileController@imageUpload')->name('profile.imageUpload');

    //Approval
    Route::group(['middleware' => ['permission:approval-pic']], function(){
        Route::get('/approvalpic', 'AccountController@approvalpic')->name('approvalpic');    
        Route::patch('/approvalpic/{id}/edit', 'AccountController@updateapprovalpic')->name('approvalpic.update');
        Route::patch('/approvalpic/{id}/approve', 'AccountController@approvepic')->name('approvalpic.approve');
    });
    Route::group(['middleware' => ['permission:approval-controller']], function(){
        Route::get('/approvalcontroller', 'AccountController@approvalcontroller')->name('approvalcontroller');    
        Route::patch('/approvalcontroller/{id}/approve', 'AccountController@approvecontroller')->name('approvalcontroller.approve');
        Route::patch('/approvalcontroller/{id}/reject', 'AccountController@rejectcontroller')->name('approvalcontroller.reject');
    });

    //Nomor Surat
        //Tujuan Eksternal
        Route::get('/nomorsurat/eksternal/tujuan', 'Nomorsurat\SuratEksternalController@indexTujuan')
        ->name('tujuan.eksternal.index');
        Route::post('/nomorsurat/eksternal/tujuan', 'Nomorsurat\SuratEksternalController@storeTujuan')
        ->name('tujuan.eksternal.store');
        Route::patch('/nomorsurat/eksternal/tujuan/{id}', 'Nomorsurat\SuratEksternalController@updateTujuan')
        ->name('tujuan.eksternal.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/eksternal/tujuan/{id}', 'Nomorsurat\SuratEksternalController@destroyTujuan')
        ->name('tujuan.eksternal.destroy')->middleware('permission:nomorsurat-hapus'); //tujuan
        
        //Surat Eksternal
        Route::get('/nomorsurat/eksternal/json', 'Nomorsurat\SuratEksternalController@json')
        ->name('surat.eksternal.json');
        Route::get('/nomorsurat/eksternal', 'Nomorsurat\SuratEksternalController@index')
        ->name('surat.eksternal.index');
        Route::get('/nomorsurat/eksternal/create', 'Nomorsurat\SuratEksternalController@create')
        ->name('surat.eksternal.create');
        Route::post('/nomorsurat/eksternal', 'Nomorsurat\SuratEksternalController@store')
        ->name('surat.eksternal.store');
        Route::get('/nomorsurat/eksternal/{id}', 'Nomorsurat\SuratEksternalController@edit')
        ->name('surat.eksternal.edit');
        Route::patch('/nomorsurat/eksternal/{id}', 'Nomorsurat\SuratEksternalController@update')
        ->name('surat.eksternal.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/eksternal/{id}', 'Nomorsurat\SuratEksternalController@destroy')
        ->name('surat.eksternal.destroy')->middleware('permission:nomorsurat-hapus');

        //Tujuan HD
        Route::get('/nomorsurat/hd/tujuan', 'Nomorsurat\SuratHDController@indexTujuan')
        ->name('tujuan.hd.index');
        Route::post('/nomorsurat/hd/tujuan', 'Nomorsurat\SuratHDController@storeTujuan')
        ->name('tujuan.hd.store');
        Route::patch('/nomorsurat/hd/tujuan/{id}', 'Nomorsurat\SuratHDController@updateTujuan')
        ->name('tujuan.hd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/hd/tujuan/{id}', 'Nomorsurat\SuratHDController@destroyTujuan')
        ->name('tujuan.hd.destroy')->middleware('permission:nomorsurat-hapus'); //tujuan
        
        //Kategori HD
        Route::get('/nomorsurat/hd/kategori', 'Nomorsurat\SuratHDController@indexKategori')
        ->name('kategori.hd.index');
        Route::post('/nomorsurat/hd/kategori', 'Nomorsurat\SuratHDController@storeKategori')
        ->name('kategori.hd.store');
        Route::patch('/nomorsurat/hd/kategori/{id}', 'Nomorsurat\SuratHDController@updateKategori')
        ->name('kategori.hd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/hd/kategori/{id}', 'Nomorsurat\SuratHDController@destroyKategori')
        ->name('kategori.hd.destroy')->middleware('permission:nomorsurat-hapus');
        
        //Surat HD
        Route::get('/nomorsurat/hd/json', 'Nomorsurat\SuratHDController@json')
        ->name('surat.hd.json');
        Route::get('/nomorsurat/hd', 'Nomorsurat\SuratHDController@index')
        ->name('surat.hd.index');
        Route::get('/nomorsurat/hd/create', 'Nomorsurat\SuratHDController@create')
        ->name('surat.hd.create');
        Route::post('/nomorsurat/hd', 'Nomorsurat\SuratHDController@store')
        ->name('surat.hd.store');
        Route::get('/nomorsurat/hd/{id}', 'Nomorsurat\SuratHDController@edit')
        ->name('surat.hd.edit');
        Route::patch('/nomorsurat/hd/{id}', 'Nomorsurat\SuratHDController@update')
        ->name('surat.hd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/hd/{id}', 'Nomorsurat\SuratHDController@destroy')
        ->name('surat.hd.destroy')->middleware('permission:nomorsurat-hapus');
        
        //Tujuan NHD
        Route::get('/nomorsurat/nhd/tujuan', 'Nomorsurat\SuratNHDController@indexTujuan')
        ->name('tujuan.nhd.index');
        Route::post('/nomorsurat/nhd/tujuan', 'Nomorsurat\SuratNHDController@storeTujuan')
        ->name('tujuan.nhd.store');
        Route::patch('/nomorsurat/nhd/tujuan/{id}', 'Nomorsurat\SuratNHDController@updateTujuan')
        ->name('tujuan.nhd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/nhd/tujuan/{id}', 'Nomorsurat\SuratNHDController@destroyTujuan')
        ->name('tujuan.nhd.destroy')->middleware('permission:nomorsurat-hapus'); //tujuan
        
        //Kategori NHD
        Route::get('/nomorsurat/nhd/kategori', 'Nomorsurat\SuratNHDController@indexKategori')
        ->name('kategori.nhd.index');
        Route::post('/nomorsurat/nhd/kategori', 'Nomorsurat\SuratNHDController@storeKategori')
        ->name('kategori.nhd.store');
        Route::patch('/nomorsurat/nhd/kategori/{id}', 'Nomorsurat\SuratNHDController@updateKategori')
        ->name('kategori.nhd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/nhd/kategori/{id}', 'Nomorsurat\SuratNHDController@destroyKategori')
        ->name('kategori.nhd.destroy')->middleware('permission:nomorsurat-hapus');
        
        //Surat NHD
        Route::get('/nomorsurat/nhd/json', 'Nomorsurat\SuratNHDController@json')
        ->name('surat.nhd.json');
        Route::get('/nomorsurat/nhd', 'Nomorsurat\SuratNHDController@index')
        ->name('surat.nhd.index');
        Route::get('/nomorsurat/nhd/create', 'Nomorsurat\SuratNHDController@create')
        ->name('surat.nhd.create');
        Route::post('/nomorsurat/nhd', 'Nomorsurat\SuratNHDController@store')
        ->name('surat.nhd.store');
        Route::get('/nomorsurat/nhd/{id}', 'Nomorsurat\SuratNHDController@edit')
        ->name('surat.nhd.edit');
        Route::patch('/nomorsurat/nhd/{id}', 'Nomorsurat\SuratNHDController@update')
        ->name('surat.nhd.update');
        //delete -> permission:nomorsurat-hapus
        Route::delete('/nomorsurat/nhd/{id}', 'Nomorsurat\SuratNHDController@destroy')
        ->name('surat.nhd.destroy')->middleware('permission:nomorsurat-hapus');
    //END Nomor Surat

    // MAINTENANCE CCTV
    Route::get('/maintenance_cctv', 'Maintenance\MaintenanceCCTVController@index')->name('maintenance_cctv.index');
    Route::post('/maintenance_cctv', 'Maintenance\MaintenanceCCTVController@store')->name('maintenance_cctv.store');
    Route::patch('/maintenance_cctv/{id}', 'Maintenance\MaintenanceCCTVController@update')->name('maintenance_cctv.update');
    Route::delete('/maintenance_cctv/{id}', 'Maintenance\MaintenanceCCTVController@destroy')->name('maintenance_cctv.destroy');
    Route::get('/maintenance_cctv/cetak/{id}','Maintenance\MaintenanceCCTVController@cetakPDF')->name('maintenance_cctv.cetak');
    Route::post('/maintenance_cctv/{id}','Maintenance\MaintenanceCCTVController@autofill')->name('maintenance_cctv.autofill');

    //Permintaan IT
        //jenis permintaan
        Route::get('/jenispermintaan', 'Permintaan\JenisPermintaanController@index')->name('jenispermintaan.index');
        Route::post('/jenispermintaan', 'Permintaan\JenisPermintaanController@store')->name('jenispermintaan.store');
        Route::patch('/jenispermintaan/{id}', 'Permintaan\JenisPermintaanController@update')->name('jenispermintaan.update');
        Route::delete('/jenispermintaan/{id}', 'Permintaan\JenisPermintaanController@destroy')->name('jenispermintaan.destroy');
        
        //perbaikan
        Route::get('/perbaikan/json', 'Permintaan\PerbaikanController@json')->name('perbaikan.json');
        Route::get('/perbaikan', 'Permintaan\PerbaikanController@index')->name('perbaikan.index');
        Route::get('/perbaikan/create', 'Permintaan\PerbaikanController@create')->name('perbaikan.create');
        Route::post('/perbaikan', 'Permintaan\PerbaikanController@store')->name('perbaikan.store');
        Route::get('/perbaikan/{id}', 'Permintaan\PerbaikanController@edit')->name('perbaikan.edit');
        Route::patch('/perbaikan/{id}', 'Permintaan\PerbaikanController@update')->name('perbaikan.update');
        Route::delete('/perbaikan/{id}', 'Permintaan\PerbaikanController@destroy')->name('perbaikan.destroy')->middleware('permission:perbaikan-hapus');
        Route::get('/perbaikan/cetak/{id}','Permintaan\PerbaikanController@cetakPerbaikan')->name('perbaikan.cetak');
        Route::post('/perbaikan/selectjenis','Permintaan\PerbaikanController@selectjenis')->name('perbaikan.selectjenis');
        Route::patch('/perbaikan/updatestatus/{id}','Permintaan\PerbaikanController@updatestatus')->name('perbaikan.updatestatus');
        Route::get('export/perbaikan','Permintaan\ExportController@exportperbaikan')->name('export.perbaikan');

        //pengadaan
        Route::get('/pengadaan/json', 'Permintaan\PengadaanController@json')->name('pengadaan.json');
        Route::get('/pengadaan', 'Permintaan\PengadaanController@index')->name('pengadaan.index');
        Route::get('/pengadaan/create', 'Permintaan\PengadaanController@create')->name('pengadaan.create');
        Route::post('/pengadaan', 'Permintaan\PengadaanController@store')->name('pengadaan.store');
        Route::get('/pengadaan/{id}', 'Permintaan\PengadaanController@edit')->name('pengadaan.edit');
        Route::patch('/pengadaan/{id}', 'Permintaan\PengadaanController@update')->name('pengadaan.update');
        Route::delete('/pengadaan/{id}', 'Permintaan\PengadaanController@destroy')->name('pengadaan.destroy')->middleware('permission:perbaikan-hapus');
        Route::get('/pengadaan/cetak/{id}','Permintaan\PengadaanController@cetakPengadaan')->name('pengadaan.cetak');
        Route::post('/pengadaan/selectjenis','Permintaan\PengadaanController@selectjenis')->name('pengadaan.selectjenis');
        Route::post('/pengadaan/selectpemohon','Permintaan\PengadaanController@selectpemohon')->name('pengadaan.selectpemohon');
        Route::patch('/pengadaan/updatestatus/{id}','Permintaan\PengadaanController@updatestatus')->name('pengadaan.updatestatus');

        //Program
        Route::get('/program/json', 'Permintaan\ProgramController@json')->name('program.json');
        Route::get('/program', 'Permintaan\ProgramController@index')->name('program.index');
        Route::get('/program/create', 'Permintaan\ProgramController@create')->name('program.create');
        Route::post('/program', 'Permintaan\ProgramController@store')->name('program.store');
        Route::get('/program/{id}', 'Permintaan\ProgramController@edit')->name('program.edit');
        Route::patch('/program/{id}', 'Permintaan\ProgramController@update')->name('program.update');
        Route::delete('/program/{id}', 'Permintaan\ProgramController@destroy')->name('program.destroy')->middleware('permission:perbaikan-hapus');
        Route::get('/program/cetak/{id}','Permintaan\ProgramController@cetakProgram')->name('program.cetak');
        // Route::post('/program/selectjenis','Permintaan\ProgramController@selectjenis')->name('program.selectjenis');
        // Route::post('/program/selectpemohon','Permintaan\ProgramController@selectpemohon')->name('program.selectpemohon');
        Route::patch('/program/updatestatus/{id}','Permintaan\ProgramController@updatestatus')->name('program.updatestatus');
    //END Permintaan IT

    //Account Receivable
        //Master Customer
        Route::get('/customer/json', 'Master\CustomerController@json')->name('customer.json');
        Route::get('/customer', 'Master\CustomerController@index')->name('customer.index');
        //END Master Customer
    //END Account Receivable

    //E-Arsip
        //Jenis Arsip
        Route::get('/arsip/jenis', 'Arsip\JenisController@index')->name('jenis.arsip.index');
        Route::post('/arsip/jenis', 'Arsip\JenisController@store')->name('jenis.arsip.store');
        Route::patch('/arsip/jenis/{id}', 'Arsip\JenisController@update')->name('jenis.arsip.update');
        Route::delete('/arsip/jenis/{id}', 'Arsip\JenisController@destroy')->name('jenis.arsip.destroy')->middleware('permission:arsip-jenis-hapus');
        //END Jenis Arsip

        //Arsip
        Route::get('/arsip/json', 'Arsip\ArsipController@json')->name('arsip.json');
        Route::get('/arsip', 'Arsip\ArsipController@index')->name('arsip.index');
        Route::get('/arsip/create', 'Arsip\ArsipController@create')->name('arsip.create');
        Route::post('/arsip', 'Arsip\ArsipController@store')->name('arsip.store');
        Route::get('/arsip/{id}/edit', 'Arsip\ArsipController@edit')->name('arsip.edit');
        Route::patch('/arsip/{id}/edit', 'Arsip\ArsipController@update')->name('arsip.update');
        Route::patch('/arsip/{id}', 'Arsip\ArsipController@delete')->name('arsip.delete');
        Route::get('/arsip/{id}', 'Arsip\ArsipController@download')->name('arsip.download');
        Route::get('/arsip/{id}/show', 'Arsip\ArsipController@show')->name('arsip.show');
            //Trash
            Route::group(['middleware' => ['permission:arsip-trash']], function(){
                Route::get('/trash/json', 'Arsip\ArsipController@jsonTrash')->name('trash.json');
                Route::get('/trash', 'Arsip\ArsipController@indexTrash')->name('trash.index');
                Route::delete('/trash/{id}', 'Arsip\ArsipController@destroy')->name('trash.destroy');
                Route::patch('/trash/{id}', 'Arsip\ArsipController@restore')->name('trash.restore');
            });
            //END Trash
        //END Arsip
    //END E-Arsip

    //Surat Tugas
        Route::group(['middleware' => ['permission:surat-tugas']], function(){
            //Tujuan
            Route::get('/surattugas/tujuan', 'Surattugas\TujuanController@index')->name('surattugas.tujuan');
            Route::post('/surattugas/tujuan', 'Surattugas\TujuanController@store')->name('surattugas.tujuan.store');
            Route::patch('/surattugas/tujuan/{id}', 'Surattugas\TujuanController@update')->name('surattugas.tujuan.update');
            Route::delete('/surattugas/tujuan/{id}', 'Surattugas\TujuanController@destroy')->name('surattugas.tujuan.destroy')->middleware('permission:surat-tugas-tujuan-hapus');
            //Surat Tugas
            Route::get('/surattugas/json', 'Surattugas\SuratTugasController@json')->name('surattugas.json');
            Route::get('/surattugas', 'Surattugas\SuratTugasController@index')->name('surattugas.index');
            Route::get('/surattugas/create', 'Surattugas\SuratTugasController@create')->name('surattugas.create');
            Route::post('/surattugas/create', 'Surattugas\SuratTugasController@store')->name('surattugas.store');
            Route::get('/surattugas/{id}/edit', 'Surattugas\SuratTugasController@edit')->name('surattugas.edit');
            Route::patch('/surattugas/{id}/edit', 'Surattugas\SuratTugasController@update')->name('surattugas.update');
            Route::get('/surattugas/{id}/print', 'Surattugas\SuratTugasController@print')->name('surattugas.print')->middleware('permission:surat-tugas-print');
            Route::delete('/surattugas/{id}', 'Surattugas\SuratTugasController@destroy')->name('surattugas.destroy')->middleware('permission:surat-tugas-hapus');
        
            //Resend Approval
            Route::patch('/surattugas/{id}/resend', 'Surattugas\ApprovalController@resend')->name('surattugas.approval.resend');
        });

        Route::group(['middleware' => ['permission:surat-tugas-approval']], function(){
            //Approval
            Route::get('/surattugas/approval/json', 'Surattugas\ApprovalController@json')->name('surattugas.approval.json');
            Route::get('/surattugas/approval', 'Surattugas\ApprovalController@index')->name('surattugas.approval.index');    
            Route::patch('/surattugas/approval/{id}/approve', 'Surattugas\ApprovalController@approve')->name('surattugas.approval.approve');    
            Route::patch('/surattugas/approval/{id}/reject', 'Surattugas\ApprovalController@reject')->name('surattugas.approval.reject');    
        });
    //END Surat Tugas

    //Formulir HRD
        //Form Izin
            Route::get('/formulir/izin/json', 'FormulirHRD\FormIzinController@json')->name('hrd.izin.json');
            Route::get('/formulir/izin', 'FormulirHRD\FormIzinController@index')->name('hrd.izin.index');
            Route::get('/formulir/izin/create', 'FormulirHRD\FormIzinController@create')->name('hrd.izin.create');
            Route::post('/formulir/izin/getKaryawan','FormulirHRD\FormIzinController@getKaryawan')->name('hrd.izin.getKaryawan');
            Route::post('/formulir/izin/create', 'FormulirHRD\FormIzinController@store')->name('hrd.izin.store');
            Route::get('/formulir/izin/{id}/edit', 'FormulirHRD\FormIzinController@edit')->name('hrd.izin.edit');
            Route::patch('/formulir/izin/{id}/edit', 'FormulirHRD\FormIzinController@update')->name('hrd.izin.update');
            Route::patch('/formulir/izin/{id}/upload', 'FormulirHRD\FormIzinController@upload')->name('hrd.izin.upload');        
            Route::get('/formulir/izin/{id}/download', 'FormulirHRD\FormIzinController@download')->name('hrd.izin.download');        
            Route::get('/formulir/izin/{id}/show', 'FormulirHRD\FormIzinController@show')->name('hrd.izin.show');   
            Route::get('/formulir/izin/{id}/print', 'FormulirHRD\FormIzinController@print')->name('hrd.izin.print');
            Route::delete('/formulir/izin/{id}', 'FormulirHRD\FormIzinController@destroy')->name('hrd.izin.destroy')->middleware('permission:hrd-formulir-hapus');
        //END Form Izin
        //Form Sakit
            Route::get('/formulir/sakit/json', 'FormulirHRD\FormSakitController@json')->name('hrd.sakit.json');
            Route::get('/formulir/sakit', 'FormulirHRD\FormSakitController@index')->name('hrd.sakit.index');
            Route::get('/formulir/sakit/create', 'FormulirHRD\FormSakitController@create')->name('hrd.sakit.create');
            Route::post('/formulir/sakit/create', 'FormulirHRD\FormSakitController@store')->name('hrd.sakit.store');
            Route::get('/formulir/sakit/{id}/edit', 'FormulirHRD\FormSakitController@edit')->name('hrd.sakit.edit');
            Route::patch('/formulir/sakit/{id}/edit', 'FormulirHRD\FormSakitController@update')->name('hrd.sakit.update');
            Route::patch('/formulir/sakit/{id}/upload', 'FormulirHRD\FormSakitController@upload')->name('hrd.sakit.upload');        
            Route::get('/formulir/sakit/{id}/download', 'FormulirHRD\FormSakitController@download')->name('hrd.sakit.download');        
            Route::get('/formulir/sakit/{id}/show', 'FormulirHRD\FormSakitController@show')->name('hrd.sakit.show');   
            Route::get('/formulir/sakit/{id}/print', 'FormulirHRD\FormSakitController@print')->name('hrd.sakit.print');
            Route::delete('/formulir/sakit/{id}', 'FormulirHRD\FormSakitController@destroy')->name('hrd.sakit.destroy')->middleware('permission:hrd-formulir-hapus');
        //END Form Sakit
        //Form Unpaid
            Route::get('/formulir/unpaid/json', 'FormulirHRD\FormUnpaidController@json')->name('hrd.unpaid.json');
            Route::get('/formulir/unpaid', 'FormulirHRD\FormUnpaidController@index')->name('hrd.unpaid.index');
            Route::get('/formulir/unpaid/create', 'FormulirHRD\FormUnpaidController@create')->name('hrd.unpaid.create');
            Route::post('/formulir/unpaid/create', 'FormulirHRD\FormUnpaidController@store')->name('hrd.unpaid.store');
            Route::get('/formulir/unpaid/{id}/edit', 'FormulirHRD\FormUnpaidController@edit')->name('hrd.unpaid.edit');
            Route::patch('/formulir/unpaid/{id}/edit', 'FormulirHRD\FormUnpaidController@update')->name('hrd.unpaid.update');
            Route::patch('/formulir/unpaid/{id}/upload', 'FormulirHRD\FormUnpaidController@upload')->name('hrd.unpaid.upload');        
            Route::get('/formulir/unpaid/{id}/download', 'FormulirHRD\FormUnpaidController@download')->name('hrd.unpaid.download');        
            Route::get('/formulir/unpaid/{id}/show', 'FormulirHRD\FormUnpaidController@show')->name('hrd.unpaid.show');     
            Route::get('/formulir/unpaid/{id}/print', 'FormulirHRD\FormUnpaidController@print')->name('hrd.unpaid.print');
            Route::delete('/formulir/unpaid/{id}', 'FormulirHRD\FormUnpaidController@destroy')->name('hrd.unpaid.destroy')->middleware('permission:hrd-formulir-hapus');
        //END Form Unpaid
        //Form Cuti
            Route::get('/formulir/cuti/json', 'FormulirHRD\FormCutiController@json')->name('hrd.cuti.json');
            Route::get('/formulir/cuti', 'FormulirHRD\FormCutiController@index')->name('hrd.cuti.index');
            Route::get('/formulir/cuti/create', 'FormulirHRD\FormCutiController@create')->name('hrd.cuti.create');
            Route::post('/formulir/cuti/create', 'FormulirHRD\FormCutiController@store')->name('hrd.cuti.store');
            Route::get('/formulir/cuti/{id}/edit', 'FormulirHRD\FormCutiController@edit')->name('hrd.cuti.edit');
            Route::patch('/formulir/cuti/{id}/edit', 'FormulirHRD\FormCutiController@update')->name('hrd.cuti.update');
            Route::get('/formulir/cuti/{id}/print', 'FormulirHRD\FormCutiController@print')->name('hrd.cuti.print');
            Route::delete('/formulir/cuti/{id}', 'FormulirHRD\FormCutiController@destroy')->name('hrd.cuti.destroy')->middleware('permission:hrd-formulir-hapus');
            Route::patch('/formulir/cuti/{id}/upload', 'FormulirHRD\FormCutiController@upload')->name('hrd.cuti.upload');        
            Route::get('/formulir/cuti/{id}/download', 'FormulirHRD\FormCutiController@download')->name('hrd.cuti.download');        
            Route::get('/formulir/cuti/{id}/show', 'FormulirHRD\FormCutiController@show')->name('hrd.cuti.show');        
            Route::get('/formulir/cuti/{id}/serahterima', 'FormulirHRD\FormCutiController@showSerahterima')->name('hrd.cuti.serahterima');
            Route::post('/formulir/cuti/{id}/serahterima', 'FormulirHRD\FormCutiController@storeSerahterima')->name('hrd.cuti.serahterimastore');
            Route::get('/formulir/cuti/{id}/inventaris', 'FormulirHRD\FormCutiController@showInventaris')->name('hrd.cuti.inventaris');
            Route::post('/formulir/cuti/{id}/inventaris', 'FormulirHRD\FormCutiController@storeInventaris')->name('hrd.cuti.inventarisstore');

        //END Form Cuti
    // END Formulir HRD

    //Alamat Gudang
    Route::group(['middleware' => ['permission:scm-ba-alamatgudang']], function(){
        Route::get('/alamatgudang', 'BaGudang\AlamatController@index')->name('alamatgudang.index');
        Route::post('/alamatgudang', 'BaGudang\AlamatController@store')->name('alamatgudang.store');
        Route::patch('/alamatgudang/{id}', 'BaGudang\AlamatController@update')->name('alamatgudang.update');
        Route::delete('/alamatgudang/{id}', 'BaGudang\AlamatController@destroy')->name('alamatgudang.destroy');
    });
    //Berita Acara Gudang
    Route::group(['middleware' => ['permission:scm-ba-serahterimabarang']], function(){
        Route::get('/beritaacara/gudang/json', 'BaGudang\BaGudangController@json')->name('bagudang.json');
        Route::get('/beritaacara/gudang', 'BaGudang\BaGudangController@index')->name('bagudang.index');
        Route::get('/beritaacara/gudang/create', 'BaGudang\BaGudangController@create')->name('bagudang.create');
        Route::post('/beritaacara/gudang/create', 'BaGudang\BaGudangController@store')->name('bagudang.store');
        Route::get('/beritaacara/gudang/{id}/edit', 'BaGudang\BaGudangController@edit')->name('bagudang.edit');
        Route::patch('/beritaacara/gudang/{id}/edit', 'BaGudang\BaGudangController@update')->name('bagudang.update');
        Route::patch('/beritaacara/gudang/{id}/upload', 'BaGudang\BaGudangController@upload')->name('bagudang.upload');        
        Route::get('/beritaacara/gudang/{id}/download', 'BaGudang\BaGudangController@download')->name('bagudang.download');        
        Route::get('/beritaacara/gudang/{id}/show', 'BaGudang\BaGudangController@show')->name('bagudang.show');        
        Route::get('/beritaacara/gudang/{id}/print', 'BaGudang\BaGudangController@print')->name('bagudang.print');
        Route::delete('/beritaacara/gudang/{id}', 'BaGudang\BaGudangController@destroy')->name('bagudang.destroy')->middleware('permission:scm-ba-hapus');
    });
    //Event
        Route::get('/event/json', 'Event\EventController@json')->name('event.json');
        Route::get('/event', 'Event\EventController@index')->name('event.index');
        Route::get('/event/create', 'Event\EventController@create')->name('event.create');
        Route::post('/event/create', 'Event\EventController@store')->name('event.store');
        Route::get('/event/{id}/edit', 'Event\EventController@edit')->name('event.edit');
        Route::patch('/event/{id}/edit', 'Event\EventController@update')->name('event.update');
        Route::delete('/event/{id}', 'Event\EventController@destroy')->name('event.destroy')->middleware('permission:event-hapus');
        Route::get('/event/{id}/print', 'Event\EventController@print')->name('event.print');

        //Absensi
        Route::get('/event/{id}/absensi', 'Event\EventController@viewAbsensi')->name('event.absensi');
        Route::post('/event/{id}/absensi/getKaryawan','Event\EventController@getKaryawan')->name('event.absensi.getKaryawan');
        Route::post('/event/{id}/absensi', 'Event\EventController@storeAbsensi')->name('absensi.store');
        Route::patch('/event/{id}/absensi', 'Event\EventController@updateAbsensi')->name('absensi.update');
        //View Log
        Route::get('/event/{id}/absensi/log/json', 'Event\EventController@jsonLog')->name('event.log.json');
        Route::get('/event/{id}/absensi/log', 'Event\EventController@viewLog')->name('event.log');
        Route::get('/event/{id}/absensi/log/excel', 'Event\EventController@excelLog')->name('event.log.excel');
        Route::get('/event/{id}/absensi/log/pdf', 'Event\EventController@pdfLog')->name('event.log.pdf');
        //Notulen
        Route::get('/event/{id}/notulen', 'Event\NotulenController@form')->name('event.notulen');
        Route::post('/event/{id}/notulen', 'Event\NotulenController@store')->name('event.notulen.store');
        Route::patch('/event/{id}/notulen', 'Event\NotulenController@update')->name('event.notulen.update');
        Route::get('/event/{id}/notulen/print', 'Event\NotulenController@print')->name('event.notulen.print');
    //END Event

    // News
        //Kategori
        Route::get('/news/kategori', 'News\KategoriController@index')->name('news.kategori.index');
        Route::post('/news/kategori', 'News\KategoriController@store')->name('news.kategori.store');
        Route::patch('/news/kategori/{id}', 'News\KategoriController@update')->name('news.kategori.update');
        Route::delete('/news/kategori/{id}', 'News\KategoriController@destroy')->name('news.kategori.destroy');

        //News
        Route::get('/news/json', 'News\NewsController@json')->name('news.json');
        Route::get('/news', 'News\NewsController@index')->name('news.index');
        Route::get('/news/create', 'News\NewsController@create')->name('news.create');
        Route::post('/news/create', 'News\NewsController@store')->name('news.store');
        Route::get('/news/{id}/edit', 'News\NewsController@edit')->name('news.edit');
        Route::patch('/news/{id}/edit', 'News\NewsController@update')->name('news.update');
        Route::delete('/news/{id}', 'News\NewsController@destroy')->name('news.destroy');
    // END News 

        
    //TAM Berita Acara
        //List RS
        Route::get('/tam/ba/data_rs', 'TAM\BA\RSController@index')->name('tam.ba.index');
        Route::post('/tam/ba/data_rs', 'TAM\BA\RSController@store')->name('tam.ba.store');
        Route::patch('/tam/ba/data_rs/{id}', 'TAM\BA\RSController@update')->name('tam.ba.update');
        Route::post('/tam/ba/data_rs/import_excel', 'TAM\BA\RSController@import_excel')->name('tam.rs.import');
        Route::delete('/tam/ba/data_rs/{id}', 'TAM\BA\RSController@destroy')->name('tam.ba.destroy')->middleware('permission:tam-ba-hapus');

        //List TEKNISI
        Route::get('/tam/ba/data_teknisi', 'TAM\BA\TeknisiTAMController@index')->name('tam.teknisi.index');
        Route::post('/tam/ba/data_teknisi/{id}', 'TAM\BA\TeknisiTAMController@store')->name('tam.teknisi.store');
        // Route::patch('/tam/ba/data_teknisi/{id}', 'TAM\BA\TeknisiController@update')->name('tam.teknisi.update');
        Route::delete('/tam/ba/data_teknisi/{id}', 'TAM\BA\TeknisiTAMController@destroy')->name('tam.teknisi.destroy')->middleware('permission:tam-ba-hapus');

        // Berita Acara Chemical RO
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/chemical/json', 'TAM\BA\ChemicalController@json')->name('chemical_ro.json');
            Route::get('/tam/ba/chemical', 'TAM\BA\ChemicalController@index')->name('chemical_ro.index');
            Route::get('/tam/ba/chemical/create', 'TAM\BA\ChemicalController@create')->name('chemical_ro.create');
            Route::post('/tam/ba/chemical/create', 'TAM\BA\ChemicalController@store')->name('chemical_ro.store');
            Route::get('/tam/ba/chemical/{id}/edit', 'TAM\BA\ChemicalController@edit')->name('chemical_ro.edit');
            Route::patch('/tam/ba/chemical/{id}/edit', 'TAM\BA\ChemicalController@update')->name('chemical_ro.update');
            Route::patch('/tam/ba/chemical/{id}/upload', 'TAM\BA\ChemicalController@upload')->name('chemical_ro.upload');        
            Route::get('/tam/ba/chemical/{id}/download', 'TAM\BA\ChemicalController@download')->name('chemical_ro.download');        
            Route::get('tam/ba/chemical/{id}/show', 'TAM\BA\ChemicalController@show')->name('chemical_ro.show');        
            Route::get('/tam/ba/chemical/{id}/print', 'TAM\BA\ChemicalController@print')->name('chemical_ro.print');
            Route::delete('/tam/ba/chemical/{id}', 'TAM\BA\ChemicalController@destroy')->name('chemical_ro.destroy')->middleware('permission:tam-ba-hapus');
        });


        //Berita Acara Flushing Pipa
         Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/flushing/json', 'TAM\BA\FlushingController@json')->name('flushing.json');
            Route::get('/tam/ba/flushing', 'TAM\BA\FlushingController@index')->name('flushing.index');
            Route::get('/tam/ba/flushing/create', 'TAM\BA\FlushingController@create')->name('flushing.create');
            Route::post('/tam/ba/flushing/create', 'TAM\BA\FlushingController@store')->name('flushing.store');
            Route::get('/tam/ba/flushing/{id}/edit', 'TAM\BA\FlushingController@edit')->name('flushing.edit');
            Route::patch('/tam/ba/flushing/{id}/edit', 'TAM\BA\FlushingController@update')->name('flushing.update');
            Route::patch('/tam/ba/flushing/{id}/upload', 'TAM\BA\FlushingController@upload')->name('flushing.upload');        
            Route::get('/tam/ba/flushing/{id}/download', 'TAM\BA\FlushingController@download')->name('flushing.download');        
            Route::get('tam/ba/flushing/{id}/show', 'TAM\BA\FlushingController@show')->name('flushing.show');        
            Route::get('/tam/ba/flushing/{id}/print', 'TAM\BA\FlushingController@print')->name('flushing.print');
            Route::delete('/tam/ba/flushing/{id}', 'TAM\BA\FlushingController@destroy')->name('flushing.destroy')->middleware('permission:tam-ba-hapus');
        });

        // Berita Acara Ganti Membrane
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/ganti_membrane/json', 'TAM\BA\GantimembraneController@json')->name('gantimembrane.json');
            Route::get('/tam/ba/ganti_membrane', 'TAM\BA\GantimembraneController@index')->name('gantimembrane.index');
            Route::get('/tam/ba/ganti_membrane/create', 'TAM\BA\GantimembraneController@create')->name('gantimembrane.create');
            Route::post('/tam/ba/ganti_membrane/create', 'TAM\BA\GantimembraneController@store')->name('gantimembrane.store');
            Route::get('/tam/ba/ganti_membrane/{id}/edit', 'TAM\BA\GantimembraneController@edit')->name('gantimembrane.edit');
            Route::patch('/tam/ba/ganti_membrane/{id}/edit', 'TAM\BA\GantimembraneController@update')->name('gantimembrane.update');
            Route::patch('/tam/ba/ganti_membrane/{id}/upload', 'TAM\BA\GantimembraneController@upload')->name('gantimembrane.upload');        
            Route::get('/tam/ba/ganti_membrane/{id}/download', 'TAM\BA\GantimembraneController@download')->name('gantimembrane.download');        
            Route::get('tam/ba/ganti_membrane/{id}/show', 'TAM\BA\GantimembraneController@show')->name('gantimembrane.show');        
            Route::get('/tam/ba/ganti_membrane/{id}/print', 'TAM\BA\GantimembraneController@print')->name('gantimembrane.print');
            Route::delete('/tam/ba/ganti_membrane/{id}', 'TAM\BA\GantimembraneController@destroy')->name('gantimembrane.destroy')->middleware('permission:tam-ba-hapus');
        });
            // Berita Acara Tambah Membrane
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/tambah_membrane/json', 'TAM\BA\TambahmembraneController@json')->name('tambahmembrane.json');
            Route::get('/tam/ba/tambah_membrane', 'TAM\BA\TambahmembraneController@index')->name('tambahmembrane.index');
            Route::get('/tam/ba/tambah_membrane/create', 'TAM\BA\TambahmembraneController@create')->name('tambahmembrane.create');
            Route::post('/tam/ba/tambah_membrane/create', 'TAM\BA\TambahmembraneController@store')->name('tambahmembrane.store');
            Route::get('/tam/ba/tambah_membrane/{id}/edit', 'TAM\BA\TambahmembraneController@edit')->name('tambahmembrane.edit');
            Route::patch('/tam/ba/tambah_membrane/{id}/edit', 'TAM\BA\TambahmembraneController@update')->name('tambahmembrane.update');
            Route::patch('/tam/ba/tambah_membrane/{id}/upload', 'TAM\BA\TambahmembraneController@upload')->name('tambahmembrane.upload');        
            Route::get('/tam/ba/tambah_membrane/{id}/download', 'TAM\BA\TambahmembraneController@download')->name('tambahmembrane.download');        
            Route::get('tam/ba/tambah_membrane/{id}/show', 'TAM\BA\TambahmembraneController@show')->name('tambahmembrane.show');        
            Route::get('/tam/ba/tambah_membrane/{id}/print', 'TAM\BA\TambahmembraneController@print')->name('tambahmembrane.print');
            Route::delete('/tam/ba/tambah_membrane/{id}', 'TAM\BA\TambahmembraneController@destroy')->name('tambahmembrane.destroy')->middleware('permission:tam-ba-hapus');
        });
            // Berita Acara Ganti Filter Endotoxin
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/ganti_filter/json', 'TAM\BA\GantifilterController@json')->name('gantifilter.json');
            Route::get('/tam/ba/ganti_filter', 'TAM\BA\GantifilterController@index')->name('gantifilter.index');
            Route::get('/tam/ba/ganti_filter/create', 'TAM\BA\GantifilterController@create')->name('gantifilter.create');
            Route::post('/tam/ba/ganti_filter/create', 'TAM\BA\GantifilterController@store')->name('gantifilter.store');
            Route::get('/tam/ba/ganti_filter/{id}/edit', 'TAM\BA\GantifilterController@edit')->name('gantifilter.edit');
            Route::patch('/tam/ba/ganti_filter/{id}/edit', 'TAM\BA\GantifilterController@update')->name('gantifilter.update');
            Route::patch('/tam/ba/ganti_filter/{id}/upload', 'TAM\BA\GantifilterController@upload')->name('gantifilter.upload');        
            Route::get('/tam/ba/ganti_filter/{id}/download', 'TAM\BA\GantifilterController@download')->name('gantifilter.download');        
            Route::get('tam/ba/ganti_filter/{id}/show', 'TAM\BA\GantifilterController@show')->name('gantifilter.show');        
            Route::get('/tam/ba/ganti_filter/{id}/print', 'TAM\BA\GantifilterController@print')->name('gantifilter.print');
            Route::delete('/tam/ba/ganti_filter/{id}', 'TAM\BA\GantifilterController@destroy')->name('gantifilter.destroy')->middleware('permission:tam-ba-hapus');
        });
            // Berita Acara Ganti Media Pre- Treatment
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/ganti_media/json', 'TAM\BA\GantimediaController@json')->name('gantimedia.json');
            Route::get('/tam/ba/ganti_media', 'TAM\BA\GantimediaController@index')->name('gantimedia.index');
            Route::get('/tam/ba/ganti_media/create', 'TAM\BA\GantimediaController@create')->name('gantimedia.create');
            Route::post('/tam/ba/ganti_media/create', 'TAM\BA\GantimediaController@store')->name('gantimedia.store');
            Route::get('/tam/ba/ganti_media/{id}/edit', 'TAM\BA\GantimediaController@edit')->name('gantimedia.edit');
            Route::patch('/tam/ba/ganti_media/{id}/edit', 'TAM\BA\GantimediaController@update')->name('gantimedia.update');
            Route::patch('/tam/ba/ganti_media/{id}/upload', 'TAM\BA\GantimediaController@upload')->name('gantimedia.upload');        
            Route::get('/tam/ba/ganti_media/{id}/download', 'TAM\BA\GantimediaController@download')->name('gantimedia.download');        
            Route::get('tam/ba/ganti_media/{id}/show', 'TAM\BA\GantimediaController@show')->name('gantimedia.show');        
            Route::get('/tam/ba/ganti_media/{id}/print', 'TAM\BA\GantimediaController@print')->name('gantimedia.print');
            Route::delete('/tam/ba/ganti_media/{id}', 'TAM\BA\GantimediaController@destroy')->name('gantimedia.destroy')->middleware('permission:tam-ba-hapus');
        });
            // Berita Acara Kalibrasi Mesin
        Route::group(['middleware' => ['permission:tam-ba']], function(){
            Route::get('/tam/ba/kalibrasi/json', 'TAM\BA\KalibrasiController@json')->name('kalibrasi.json');
            Route::get('/tam/ba/kalibrasi', 'TAM\BA\KalibrasiController@index')->name('kalibrasi.index');
            Route::get('/tam/ba/kalibrasi/create', 'TAM\BA\KalibrasiController@create')->name('kalibrasi.create');
            Route::post('/tam/ba/kalibrasi/create', 'TAM\BA\KalibrasiController@store')->name('kalibrasi.store');
            Route::get('/tam/ba/kalibrasi/{id}/edit', 'TAM\BA\KalibrasiController@edit')->name('kalibrasi.edit');
            Route::patch('/tam/ba/kalibrasi/{id}/edit', 'TAM\BA\KalibrasiController@update')->name('kalibrasi.update');
            Route::patch('/tam/ba/kalibrasi/{id}/upload', 'TAM\BA\KalibrasiController@upload')->name('kalibrasi.upload');        
            Route::get('/tam/ba/kalibrasi/{id}/download', 'TAM\BA\KalibrasiController@download')->name('kalibrasi.download');        
            Route::get('tam/ba/kalibrasi/{id}/show', 'TAM\BA\KalibrasiController@show')->name('kalibrasi.show');        
            Route::get('/tam/ba/kalibrasi/{id}/print', 'TAM\BA\KalibrasiController@print')->name('kalibrasi.print');
            Route::delete('/tam/ba/kalibrasi/{id}', 'TAM\BA\KalibrasiController@destroy')->name('kalibrasi.destroy')->middleware('permission:tam-ba-hapus');
        });
    //END TAM Berita Acara

    // Form Permintaan Pemeriksaan CekLab
    Route::group(['middleware' => ['permission:tam-ba']], function(){
        Route::get('/tam/ceklab/json', 'TAM\CeklabController@json')->name('ceklab.json');
        Route::get('/tam/ceklab', 'TAM\CeklabController@index')->name('ceklab.index');
        Route::get('/tam/ceklab/create', 'TAM\CeklabController@create')->name('ceklab.create');
        Route::post('/tam/ceklab/create', 'TAM\CeklabController@store')->name('ceklab.store');
        Route::get('/tam/ceklab/{id}/edit', 'TAM\CeklabController@edit')->name('ceklab.edit');
        Route::patch('/tam/ceklab/{id}/edit', 'TAM\CeklabController@update')->name('ceklab.update');
        Route::patch('/tam/ceklab/{id}/upload', 'TAM\CeklabController@upload')->name('ceklab.upload');        
        Route::get('/tam/ceklab/{id}/download', 'TAM\CeklabController@download')->name('ceklab.download');        
        Route::get('tam/ceklab/{id}/show', 'TAM\CeklabController@show')->name('ceklab.show');        
        Route::get('/tam/ceklab/{id}/print', 'TAM\CeklabController@print')->name('ceklab.print');
        Route::delete('/tam/ceklab/{id}', 'TAM\CeklabController@destroy')->name('ceklab.destroy')->middleware('permission:tam-ba-hapus');
    });
    //END Form Permintaan Pemeriksaan CekLab
    
    //Telegram Broadcast
    Route::group(['middleware' => ['permission:telegram']], function(){
        Route::get('/telegram', 'Telegram\TelegramBotController@sendMessage')->name('telegram.message');
        Route::post('/telegram/send-message', 'Telegram\TelegramBotController@storeMessage')->name('telegram.message.store');
        Route::get('/telegram/photo', 'Telegram\TelegramBotController@sendPhoto')->name('telegram.photo');
        Route::post('/telegram/send-photo', 'Telegram\TelegramBotController@storePhoto')->name('telegram.photo.store');
        Route::get('/telegram/document', 'Telegram\TelegramBotController@sendDocument')->name('telegram.document');
        Route::post('/telegram/send-document', 'Telegram\TelegramBotController@storeDocument')->name('telegram.document.store');
        Route::get('/telegram/updated-activity', 'Telegram\TelegramBotController@updatedActivity');
    });
    //END Telegram Broadcast

    //Monitoring Mesin
        Route::group(['middleware' => ['permission:monitoring-mesin']], function(){
            //Tipe Mesin
            Route::get('/monitoring_mesin/tipe/json', 'Monitoring_Mesin\TipeMesinController@json')->name('monitoringmesin.tipe.json');
            Route::get('/monitoring_mesin/tipe', 'Monitoring_Mesin\TipeMesinController@index')->name('monitoringmesin.tipe.index');
            Route::get('/monitoring_mesin/tipe/create', 'Monitoring_Mesin\TipeMesinController@create')->name('monitoringmesin.tipe.create');
            Route::post('/monitoring_mesin/tipe/create', 'Monitoring_Mesin\TipeMesinController@store')->name('monitoringmesin.tipe.store');
            Route::get('/monitoring_mesin/tipe/{id}/edit', 'Monitoring_Mesin\TipeMesinController@edit')->name('monitoringmesin.tipe.edit');
            Route::patch('/monitoring_mesin/tipe/{id}/edit', 'Monitoring_Mesin\TipeMesinController@update')->name('monitoringmesin.tipe.update');
            Route::delete('/monitoring_mesin/tipe/{id}', 'Monitoring_Mesin\TipeMesinController@destroy')->name('monitoringmesin.tipe.destroy')->middleware('permission:monitoring-mesin-hapus'); 
            //END Tipe Mesin

            //Stock Mesin
            Route::get('/monitoring_mesin/stock/json', 'Monitoring_Mesin\StockMesinController@json')->name('monitoringmesin.stock.json');
            Route::get('/monitoring_mesin/stock', 'Monitoring_Mesin\StockMesinController@index')->name('monitoringmesin.stock.index');
            Route::get('/monitoring_mesin/stock/{id}/edit', 'Monitoring_Mesin\StockMesinController@edit')->name('monitoringmesin.stock.edit');
            Route::patch('/monitoring_mesin/stock/{id}/edit', 'Monitoring_Mesin\StockMesinController@update')->name('monitoringmesin.stock.update')->middleware('permission:monitoring-mesin-hapus');
            Route::delete('/monitoring_mesin/stock/{id}', 'Monitoring_Mesin\StockMesinController@destroy')->name('monitoringmesin.stock.destroy')->middleware('permission:monitoring-mesin-hapus');
            Route::post('/monitoring_mesin/stock/getTipe', 'Monitoring_Mesin\StockMesinController@getTipe')->name('monitoringmesin.stock.getTipe'); 
            //END Stock Mesin
            
            //Pembatalan Pengiriman Mesin
            Route::get('/monitoring_mesin/batal/json', 'Monitoring_Mesin\BatalKirimController@json')->name('monitoringmesin.batal.json');
            Route::get('/monitoring_mesin/batal', 'Monitoring_Mesin\BatalKirimController@index')->name('monitoringmesin.batal.index');
            //END Pembatalan Pengiriman Mesin
            
            Route::group(['middleware' => ['permission:monitoring-mesin-scm']], function(){
                //Penerimaan Mesin
                Route::get('/monitoring_mesin/penerimaan/json', 'Monitoring_Mesin\PenerimaanMesinController@json')->name('monitoringmesin.penerimaan.json');
                Route::get('/monitoring_mesin/penerimaan', 'Monitoring_Mesin\PenerimaanMesinController@index')->name('monitoringmesin.penerimaan.index');
                Route::get('/monitoring_mesin/penerimaan/create', 'Monitoring_Mesin\PenerimaanMesinController@create')->name('monitoringmesin.penerimaan.create');
                Route::post('/monitoring_mesin/penerimaan/create', 'Monitoring_Mesin\PenerimaanMesinController@store')->name('monitoringmesin.penerimaan.store');
                Route::delete('/monitoring_mesin/penerimaan/{id}', 'Monitoring_Mesin\PenerimaanMesinController@destroy')->name('monitoringmesin.penerimaan.destroy')->middleware('permission:monitoring-mesin-hapus');
                Route::post('/monitoring_mesin/penerimaan/getTipe', 'Monitoring_Mesin\PenerimaanMesinController@getTipe')->name('monitoringmesin.penerimaan.getTipe'); 
                //END Penerimaan Mesin
            }); //END SCM

            Route::group(['middleware' => ['permission:monitoring-mesin-hd']], function(){
                //Rekomendasi Pengiriman Mesin
                Route::get('/monitoring_mesin/rekomendasi/json', 'Monitoring_Mesin\RekomendasiPengirimanController@json')->name('monitoringmesin.rekomendasi.json');
                Route::get('/monitoring_mesin/rekomendasi', 'Monitoring_Mesin\RekomendasiPengirimanController@index')->name('monitoringmesin.rekomendasi.index');
                Route::get('/monitoring_mesin/rekomendasi/create', 'Monitoring_Mesin\RekomendasiPengirimanController@create')->name('monitoringmesin.rekomendasi.create');
                Route::post('/monitoring_mesin/rekomendasi/create', 'Monitoring_Mesin\RekomendasiPengirimanController@store')->name('monitoringmesin.rekomendasi.store');
                Route::patch('/monitoring_mesin/rekomendasi/{id}', 'Monitoring_Mesin\RekomendasiPengirimanController@hapus')->name('monitoringmesin.rekomendasi.hapus');
                Route::post('/monitoring_mesin/rekomendasi/getStock', 'Monitoring_Mesin\RekomendasiPengirimanController@getStock')->name('monitoringmesin.rekomendasi.getStock'); 
                //END Rekomendasi Pengiriman Mesin

                //Approval Penyelesaian
                Route::get('/monitoring_mesin/approvalpenyelesaian/json', 'Monitoring_Mesin\ApprovalPenyelesaianController@json')->name('monitoringmesin.selesai.json');
                Route::get('/monitoring_mesin/approvalpenyelesaian', 'Monitoring_Mesin\ApprovalPenyelesaianController@index')->name('monitoringmesin.selesai.index');
                Route::get('/monitoring_mesin/approvalpenyelesaian/{id}/update', 'Monitoring_Mesin\ApprovalPenyelesaianController@edit')->name('monitoringmesin.selesai.edit');
                Route::patch('/monitoring_mesin/approvalpenyelesaian/{id}/update', 'Monitoring_Mesin\ApprovalPenyelesaianController@update')->name('monitoringmesin.selesai.update');
                Route::patch('/monitoring_mesin/approvalpenyelesaian/{id}/upload', 'Monitoring_Mesin\ApprovalPenyelesaianController@upload')->name('monitoringmesin.selesai.upload');        
                Route::get('/monitoring_mesin/approvalpenyelesaian/{id}/download', 'Monitoring_Mesin\ApprovalPenyelesaianController@download')->name('monitoringmesin.selesai.download');        
                Route::get('/monitoring_mesin/approvalpenyelesaian/{id}/show', 'Monitoring_Mesin\ApprovalPenyelesaianController@show')->name('monitoringmesin.selesai.show');
                //END Approval Penyelesaian
            }); //END HD

            Route::group(['middleware' => ['permission:monitoring-mesin-tam']], function(){
                //Planning Pengiriman
                Route::get('/monitoring_mesin/rencanapengiriman/json', 'Monitoring_Mesin\RencanaPengirimanController@json')->name('monitoringmesin.rencanapengiriman.json');
                Route::get('/monitoring_mesin/rencanapengiriman', 'Monitoring_Mesin\RencanaPengirimanController@index')->name('monitoringmesin.rencanapengiriman.index');
                Route::get('/monitoring_mesin/rencanapengiriman/{id}/update', 'Monitoring_Mesin\RencanaPengirimanController@edit')->name('monitoringmesin.rencanapengiriman.edit');
                Route::patch('/monitoring_mesin/rencanapengiriman/{id}/update', 'Monitoring_Mesin\RencanaPengirimanController@update')->name('monitoringmesin.rencanapengiriman.update');
                Route::patch('/monitoring_mesin/rencanapengiriman/{id}', 'Monitoring_Mesin\RencanaPengirimanController@hapus')->name('monitoringmesin.rencanapengiriman.hapus');
                //END Planning Pengiriman

                //Realisasi Pengiriman
                Route::get('/monitoring_mesin/realisasipengiriman/json', 'Monitoring_Mesin\RealisasiPengirimanController@json')->name('monitoringmesin.realisasipengiriman.json');
                Route::get('/monitoring_mesin/realisasipengiriman', 'Monitoring_Mesin\RealisasiPengirimanController@index')->name('monitoringmesin.realisasipengiriman.index');
                Route::patch('/monitoring_mesin/realisasipengiriman/{id}/updateKirim', 'Monitoring_Mesin\RealisasiPengirimanController@updateKirim')->name('monitoringmesin.realisasipengiriman.updateKirim');
                Route::patch('/monitoring_mesin/realisasipengiriman/{id}/updateInstalasi', 'Monitoring_Mesin\RealisasiPengirimanController@updateInstalasi')->name('monitoringmesin.realisasipengiriman.updateInstalasi');
                Route::patch('/monitoring_mesin/realisasipengiriman/{id}', 'Monitoring_Mesin\RealisasiPengirimanController@hapus')->name('monitoringmesin.realisasipengiriman.hapus');
                //END Realisasi Pengiriman
            }); //END TAM

            Route::group(['middleware' => ['permission:monitoring-mesin-acct']], function(){
                //Akuisisi Mesin
                Route::get('/monitoring_mesin/akuisisi/json', 'Monitoring_Mesin\AkuisisiMesinController@json')->name('monitoringmesin.akuisisi.json');
                Route::get('/monitoring_mesin/akuisisi', 'Monitoring_Mesin\AkuisisiMesinController@index')->name('monitoringmesin.akuisisi.index');
                Route::get('/monitoring_mesin/akuisisi/{id}/update', 'Monitoring_Mesin\AkuisisiMesinController@edit')->name('monitoringmesin.akuisisi.edit');
                Route::patch('/monitoring_mesin/akuisisi/{id}/update', 'Monitoring_Mesin\AkuisisiMesinController@update')->name('monitoringmesin.akuisisi.update');       
                Route::get('/monitoring_mesin/akuisisi/{id}/download', 'Monitoring_Mesin\AkuisisiMesinController@download')->name('monitoringmesin.akuisisi.download');        
                Route::get('/monitoring_mesin/akuisisi/{id}/show', 'Monitoring_Mesin\AkuisisiMesinController@show')->name('monitoringmesin.akuisisi.show');
                //END Akuisisi Mesin
            }); //END ACCT

            Route::get('/monitoring_mesin/report', 'Monitoring_Mesin\ReportController@index')->name('monitoringmesin.report.index');
            Route::get('/monitoring_mesin/report/filter', 'Monitoring_Mesin\ReportController@getData')->name('monitoringmesin.report.filter');
            Route::get('/monitoring_mesin/report/{id}/detail', 'Monitoring_Mesin\ReportController@detail')->name('monitoringmesin.report.detail');
            Route::get('/monitoring_mesin/report/{id}/detail/excel', 'Monitoring_Mesin\ReportController@detailexcel')->name('monitoringmesin.report.detailexcel');
        });
    //END Monitoring Mesin

    //CAPA
        //Lokasi
        Route::group(['middleware' => ['permission:capa-lokasi']], function(){
            Route::get('/capa/lokasi', 'CAPA\LokasiController@index')->name('capa.lokasi.index');
            Route::post('/capa/lokasi', 'CAPA\LokasiController@store')->name('capa.lokasi.store');
            Route::patch('/capa/lokasi/{id}', 'CAPA\LokasiController@update')->name('capa.lokasi.update');
            Route::delete('/capa/lokasi/{id}', 'CAPA\LokasiController@destroy')->name('capa.lokasi.destroy');
        });
        //END Lokasi

        //Capa
            Route::get('/capa/json', 'CAPA\CapaController@json')->name('capa.json');
            Route::get('/capa', 'CAPA\CapaController@index')->name('capa.index');
            Route::get('/capa/create', 'CAPA\CapaController@create')->name('capa.create');
            Route::post('/capa/create', 'CAPA\CapaController@store')->name('capa.store');
            Route::get('/capa/{id}/edit', 'CAPA\CapaController@edit')->name('capa.edit');
            Route::patch('/capa/{id}/update', 'CAPA\CapaController@update')->name('capa.update');
            Route::delete('/capa/{id}', 'CAPA\CapaController@destroy')->name('capa.destroy');
            Route::get('/capa/{id}/print', 'CAPA\CapaController@print')->name('capa.print');
            //Upload
            Route::patch('/capa/{id}/upload', 'CAPA\CapaController@upload')->name('capa.upload');        
            Route::get('/capa/{id}/download', 'CAPA\CapaController@download')->name('capa.download');        
            Route::get('/capa/{id}/show', 'CAPA\CapaController@show')->name('capa.show');
            //Status
            Route::patch('/capa/{id}/resend', 'CAPA\CapaController@resend')->name('capa.resend');
        //END Capa
        
        //Verifikasi
            Route::get('/capa/verifikasi/json', 'CAPA\VerifikasiController@json')->name('capa.verifikasi.json');
            Route::get('/capa/verifikasi', 'CAPA\VerifikasiController@index')->name('capa.verifikasi.index');
            Route::get('/capa/verifikasi/{id}/edit', 'CAPA\VerifikasiController@edit')->name('capa.verifikasi.edit');
            Route::patch('/capa/verifikasi/{id}/update', 'CAPA\VerifikasiController@update')->name('capa.verifikasi.update');
            Route::patch('/capa/verifikasi/{id}/reject', 'CAPA\VerifikasiController@reject')->name('capa.verifikasi.reject');
        //END Verifikasi

        //Report
        Route::group(['middleware' => ['permission:capa-report']], function(){
            Route::get('/capa/report', 'CAPA\ReportController@index')->name('capa.report.index');
            Route::get('/capa/report/filter', 'CAPA\ReportController@getData')->name('capa.report.filter');
            Route::get('/capa/report/{id}/detail', 'CAPA\ReportController@detail')->name('capa.report.detail');
        });
        // END Report 
    //END CAPA
}); 
//END Middleware:Auth
 