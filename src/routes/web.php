<?php

// Route::get('/support', function(){
//     return view('Flexi\Support::support');
// });
// Route::get('/another-support', function(){
//     echo 'another Support';exit;
// });
Route::group(['namespace'=>'Flexibleit\Support\Http\Controllers'], function (){
    Route::get('/support', 'SupportController@index');
    Route::match(['get', 'post'], '/tickets/add', 'SupportTicketController@add')->name('ticket.add');
});