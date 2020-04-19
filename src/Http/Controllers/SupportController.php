<?php

namespace Flexibleit\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CommonTrait;
use Flexibleit\Support\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $data['sp_tickets'] = (new SupportTicket())->getAll(['paginate'=>10], ['closed'=>0]);
        $data['sp_closed_tickets'] = (new SupportTicket())->getAll(['paginate'=>10], ['closed'=>1]);
        if ($request->ajax()) {
            return $this->commonResponse($data);
        }
        return view('support::support', $data);
    }

    public function commonResponse($data=null, $notify=null, $option=null)
    {
        $response = $this->processNotification($notify);
        if ($option == 'show') {
            $response['replaceWith']['#supportTicketList'] = view('support::ticket_details', $data)->render();
        } else {
            $response['replaceWith']['#supportTicketList'] = view('support::all_tickets', $data)->render();
        }
        return $this->sendResponse($response);
    }
}
