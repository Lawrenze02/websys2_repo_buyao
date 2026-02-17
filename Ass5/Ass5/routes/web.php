<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {



    return view('evaluation', [
        'name' => $_GET['name'],
        'prelim' => $_GET['prelim'],
         'midterm' => $_GET['midterm'],
           'final' => $_GET['final'],
    
    ]);
});
