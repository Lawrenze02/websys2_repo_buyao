<?php

use Illuminate\Support\Facades\Route;

Route::get('/student/{id}/{name}', function ($id,$name) {
   

    return 'Student ID: '.$id.'<br> Student Name: '.$name;
});

Route::get('/course/{course}/{year?}', function ($course, $year = null) {

   
    return 'Course: '.$course.'<br> Year: '.$year;
});

Route::get('/ojt/{company}/{city}/{allowance?}',function($company,$city,$allowance = 'Yes'){

return 'Company Name: '.$company.'<br> City: '.$city.'<br>Allowance(Yes or No): '.$allowance;

});

Route::get('/event/{Ename}/{Pname}/{year}',function($Ename,$Pname,$year){

return 'Event Name: '.$Ename.'<br>Participant Name: '.$Pname.'<br>Year Level: '.$year;
});
