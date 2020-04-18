<?php

namespace Flexibleit\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CommonTrait;
use Flexibleit\Support\Models\SupportNote;
use Flexibleit\Support\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    use CommonTrait;

    public function add(Request $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $ticketObj = new SupportTicket();
        $ticket = $ticketObj->saveTicket($input);
        $input['ticket_id'] = $ticket->id;
        $spNoteObj = new SupportNote();
        $spNoteObj->saveNote($input);

        if ($request->ajax()) {
            $notify = __('Support ticket added successfully!');
            $data['sp_tickets'] = $ticketObj->getAll();
            return $this->commonResponse($data, $notify, 'add');
        }
        return redirect(route('support'));
    }

    public function show($id) {
        // dd($id);
        $supportTicket = (new SupportTicket())->getById($id);
        $data['support_ticket'] = $supportTicket;
        return $this->commonResponse($data, null, 'show');
    }

    public function commonResponse($data=null, $notify=null, $option=null)
    {
        $response = $this->processNotification($notify);
        $response['replaceWith']['#supportTicketList'] = view('support::all_tickets', $data)->render();
        return $this->sendResponse($response);
    }
}
