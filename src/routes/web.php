<?php

Route::group(['middleware' => 'web','namespace'=>'Rdmarwein\Formbuilder\Http\Controllers'], function()
{
    Route::get('formgen/{id}/{cid?}','FormBuilderController@index')->name('formIndex');
    Route::get('formgen/create/{id}','FormBuilderController@create')->name('formCreate');
    Route::post('formgen/{id}','FormBuilderController@store');
    Route::get('formgen/edit/{id}/{cid}','FormBuilderController@edit')->name('formEdit');
    Route::put('formgen/{id}/{cid}','FormBuilderController@update')->name('formUpdate');
    Route::delete('formgen/{id}/{cid}','FormBuilderController@destroy')->name('formDelete');

    Route::get('formgen/{id}/index/{cid}','FormBuilderController@indexDetail');
});

