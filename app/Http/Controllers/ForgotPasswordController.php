<?php

namespace App\Http\Controllers;

use App\User;
use App\Models;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show()
    {
        return view('password.forgot');
    }

    public function send_reset_email()
    {
        $record = Models\Users::where('email',$_POST['email'])->first();
        echo "<pre>";
        print_r($record);
        exit;

        if(!$record)
            return 
        return view('password.forgot');
    }
}