<?php

// Route::get('/support', function(){
//     return view('Flexi\Support::support');
// });
// Route::get('/another-support', function(){
//     echo 'another Support';exit;
// });
// Route::group(['namespace'=>'Flexibleit\Support\Http\Controllers'], function (){
    
// });
$prefix = config('support.support_path_prefix');
Route::group(['namespace'=>'Flexibleit\Support\Http\Controllers','middleware'=>['web', 'auth'], 'prefix'=>$prefix], function () use($prefix) {
    Route::get('/', 'SupportController@index')->name($prefix);
    Route::match(['get', 'post'], '/tickets/add', 'SupportTicketController@add')->name($prefix.'.ticket.add');
    Route::get('/tickets/show/{ticket_id}', 'SupportTicketController@show')->name($prefix.'.ticket.show');
});