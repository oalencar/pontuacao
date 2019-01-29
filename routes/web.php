<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::resource('orders', 'Admin\OrdersController');
    Route::get('orders/sendEmail/orderRegister/{order_id}', ['uses' => 'Admin\OrdersController@sendEmailOrderRegister', 'as' => 'orders.sendEmail.orderRegister']);
    Route::post('orders_mass_destroy', ['uses' => 'Admin\OrdersController@massDestroy', 'as' => 'orders.mass_destroy']);
    Route::post('orders_restore/{id}', ['uses' => 'Admin\OrdersController@restore', 'as' => 'orders.restore']);
    Route::delete('orders_perma_del/{id}', ['uses' => 'Admin\OrdersController@perma_del', 'as' => 'orders.perma_del']);
    Route::resource('order_statuses', 'Admin\OrderStatusesController');
    Route::post('order_statuses_mass_destroy', ['uses' => 'Admin\OrderStatusesController@massDestroy', 'as' => 'order_statuses.mass_destroy']);
    Route::post('order_statuses_restore/{id}', ['uses' => 'Admin\OrderStatusesController@restore', 'as' => 'order_statuses.restore']);
    Route::delete('order_statuses_perma_del/{id}', ['uses' => 'Admin\OrderStatusesController@perma_del', 'as' => 'order_statuses.perma_del']);

    Route::resource('companies', 'Admin\CompaniesController');
    Route::post('companies_mass_destroy', ['uses' => 'Admin\CompaniesController@massDestroy', 'as' => 'companies.mass_destroy']);
    Route::post('companies_restore/{id}', ['uses' => 'Admin\CompaniesController@restore', 'as' => 'companies.restore']);
    Route::delete('companies_perma_del/{id}', ['uses' => 'Admin\CompaniesController@perma_del', 'as' => 'companies.perma_del']);

    Route::resource('partners', 'Admin\PartnersController');
    Route::post('partners_mass_destroy', ['uses' => 'Admin\PartnersController@massDestroy', 'as' => 'partners.mass_destroy']);
    Route::post('partners_restore/{id}', ['uses' => 'Admin\PartnersController@restore', 'as' => 'partners.restore']);
    Route::delete('partners_perma_del/{id}', ['uses' => 'Admin\PartnersController@perma_del', 'as' => 'partners.perma_del']);

    Route::resource('awards', 'Admin\AwardsController');
    Route::post('awards_mass_destroy', ['uses' => 'Admin\AwardsController@massDestroy', 'as' => 'awards.mass_destroy']);
    Route::post('awards_restore/{id}', ['uses' => 'Admin\AwardsController@restore', 'as' => 'awards.restore']);
    Route::delete('awards_perma_del/{id}', ['uses' => 'Admin\AwardsController@perma_del', 'as' => 'awards.perma_del']);

    Route::resource('clientes', 'Admin\ClientesController');
    Route::post('clientes_mass_destroy', ['uses' => 'Admin\ClientesController@massDestroy', 'as' => 'clientes.mass_destroy']);
    Route::post('clientes_restore/{id}', ['uses' => 'Admin\ClientesController@restore', 'as' => 'clientes.restore']);
    Route::delete('clientes_perma_del/{id}', ['uses' => 'Admin\ClientesController@perma_del', 'as' => 'clientes.perma_del']);

    Route::get('scores/report', ['uses' => 'Admin\ScoresController@report', 'as' => 'scores.report']);
    Route::post('scores/report', ['uses' => 'Admin\ScoresController@reportByCompanyName', 'as' => 'scores.reportByCompanyName']);
    Route::get('scores/report/detail/{id}/company/{company_id}', ['uses' => 'Admin\ScoresController@reportDetail', 'as' => 'scores.report_detail']);
    Route::get('scores/report/detail/partner/{id}/', ['uses' => 'Admin\ScoresController@reportPartnerDetail', 'as' => 'scores.report_partner_detail']);
    Route::resource('scores', 'Admin\ScoresController');
    Route::post('scores_mass_destroy', ['uses' => 'Admin\ScoresController@massDestroy', 'as' => 'scores.mass_destroy']);
    Route::post('scores_restore/{id}', ['uses' => 'Admin\ScoresController@restore', 'as' => 'scores.restore']);
    Route::delete('scores_perma_del/{id}', ['uses' => 'Admin\ScoresController@perma_del', 'as' => 'scores.perma_del']);


    Route::resource('partner_types', 'Admin\PartnerTypesController');
    Route::post('partner_types_mass_destroy', ['uses' => 'Admin\PartnerTypesController@massDestroy', 'as' => 'partner_types.mass_destroy']);
    Route::post('partner_types_restore/{id}', ['uses' => 'Admin\PartnerTypesController@restore', 'as' => 'partner_types.restore']);
    Route::delete('partner_types_perma_del/{id}', ['uses' => 'Admin\PartnerTypesController@perma_del', 'as' => 'partner_types.perma_del']);




});
