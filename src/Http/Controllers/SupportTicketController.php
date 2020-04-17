<?php

namespace App\Http\Controllers;

use Flexibleit\Support\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function add(Request $request) {
        $input = $request->all();
        $ticket = new SupportTicket();
        if ($ticket->saveTicket($input)) {
            return true;
        }
        return false;
    }
}
