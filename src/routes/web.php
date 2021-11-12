<?php

Route::group(['middleware' => 'web','namespace'=>'Rdmarwein\Formbuilder\Http\Controllers'], function()
{
    Route::get('formbuilder/{id}','FormBuilderController@index')->name('formIndex');
    Route::get('formbuilder/create/{id}','FormBuilderController@create')->name('formCreate');
    Route::post('formbuilder/{id}','FormBuilderController@store');
    Route::get('formbuilder/edit/{id}/{cid}','FormBuilderController@edit')->name('formEdit');
    Route::put('formbuilder/{id}/{cid}','FormBuilderController@update');
});

