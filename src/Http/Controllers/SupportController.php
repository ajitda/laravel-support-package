<?php

namespace Flexibleit\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Flexibleit\Support\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function index()
    {
        $data['sp_tickets'] = (new SupportTicket())->getAll();
        return view('support::support', $data);
    }
}
