<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function generalTerm()
    {
        return view('legal.general-terms');
    }

    public function privacy()
    {
        return view('legal.privacy-policy');
    }

    public function cookies()
    {
        return view('legal.cookies-policy');
    }
}
