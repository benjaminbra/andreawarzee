<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Redirect extends Controller
{
    /**
     * Redirect to login
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        return redirect('login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function home()
    {
        return redirect('fr');
    }
}
