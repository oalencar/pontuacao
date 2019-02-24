<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('roles', 'RolesController', ['except' => ['create', 'edit']]);

        Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);

        Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']]);

        Route::resource('orderstatuses', 'OrderStatusesController', ['except' => ['create', 'edit']]);

        Route::resource('awards', 'AwardsController', ['except' => ['create', 'edit']]);

        Route::resource('clientes', 'ClientesController', ['except' => ['create', 'edit']]);

        Route::get('clientes/company/{companyId}', 'ClientesController@clientsFromCompany');

        Route::resource('scores', 'ScoresController', ['except' => ['create', 'edit']]);

        Route::resource('partner_types', 'PartnerTypesController', ['except' => ['create', 'edit']]);

        Route::get('partners/company/{id}', 'PartnersController@findByCompany');

});
