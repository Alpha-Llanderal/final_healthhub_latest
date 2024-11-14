<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function showLanding()
    {
        return view('privacy_policy.landing'); // Ensure this view exists
    }
}
