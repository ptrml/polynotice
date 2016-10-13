<?php

Route::get('/polynotice/cfg', 'CfgController@index')->name('polynotice.cfg');
Route::get('/polynotice/unseen', 'PolynoticeController@getUnseenNotices')->name('polynotice.unseen');
Route::post('/polynotice/see', 'PolynoticeController@seeNotice')->name('polynotice.see');

