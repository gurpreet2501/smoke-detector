<?php

namespace App\Http\Controllers;

use App\User;
use App\Models;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show()
    {
        return view('password.reset');
    }

    public function send_reset_email()
    {
        $record = Models\Users::where('email', $_POST['email'])->first();
        
        if(!$record)
            return;
        return view('password.reset');
    }
}