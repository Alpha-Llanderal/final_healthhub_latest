<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function show()
    {
        // Returns the privacy_policy view
        return view('privacy_policy');
    }
}

