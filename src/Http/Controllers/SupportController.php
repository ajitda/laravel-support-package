<?php

namespace Flexibleit\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support::support');
    }
}
