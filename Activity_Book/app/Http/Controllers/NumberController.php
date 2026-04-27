<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //

        return view('form1');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $number = $request->num;
        if ($number % 2 == 0) {
            echo 'The number is even';
        } else {
            echo 'The number is odd.';
        }
    }

    public function createMulti()
    {
        return view('multi');
    }

    public function storeMulti(Request $request)
    {
        $row = $request->row;
        $col = $request->column;


        echo '<table border="1"; cellpadding="5"';
        for ($i = 1; $i <= $row; $i++) {
            echo '<tr>';
            for ($j = 1; $j <= $col; $j++) {
                $res = $i * $j;
                echo '<td>' . $res . '</td>';
            }

            echo '</tr>';
        }
        echo '</table>';
    }

    public function createLogin()
    {
        return view('login');
    }

    public function storeLogin(Request $request)
    {
        $user = $request->user;
        $pass = $request->pass;

        if ($user == 'juan' && $pass == 'petra') {
            echo '
            <center>Logged in Successfully.</center>
            ';
        } else {
            echo 'Login Failed.';
            redirect('login');
        }
    }

    public function storeRegister(Request $request)
    {
        $fname = $request->fname;
        $mname = $request->mname;
        $lname = $request->lname;
        $bdate = $request->bdate;
        $addrs = $request->addrs;

        echo 'Your name is' . $fname . ' ' .  $mname . ' ' . $lname . ' from ' .  $addrs . ' birthday on ' . $bdate;
    }

    public function createRegister()
    {
        return view('registration');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
