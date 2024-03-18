<?php

use Illuminate\Support\Facades\Route;

Route::get('/apidocs', function () {
    return view('apidocs');
});
