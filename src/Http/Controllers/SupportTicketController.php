<?php

namespace Flexibleit\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Flexibleit\Support\Http\Controllers\Traits\CommonTrait;
use Flexibleit\Support\Models\SupportNote;
use Flexibleit\Support\Models\SupportTicket;
use Flexibleit\Support\Models\SupportUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    use CommonTrait;

    public function add(Request $request) 
    {
        $input = $request->all();
        $this->validator($input)->validate();
        $input['user_id'] = Auth::user()->id;
        $ticketObj = new SupportTicket();
        $ticket = $ticketObj->saveTicket($input);
        $input['ticket_id'] = $ticket->id;
        $file_urls = [];
        if($request->hasFile('upload_file')) {
            $file_urls = $this->uploadMultipleFiles($request->upload_file, 'public/supports');
        }
        $this->processNote($input, $file_urls);
        // Send all support emails
        $this->processSupportEmail($ticket, 'new-ticket');
        if ($request->ajax()) {
            $notify = __('Support ticket added successfully!');
            $data['sp_tickets'] = $ticketObj->getAll();
            return $this->commonResponse($data, $notify, 'add');
        }
        return redirect(sproute(config('support.support_path_prefix')));
    }

    public function processNote($input, $file_urls)
    {
        $spNoteObj = new SupportNote();
        $sp_note = $spNoteObj->saveNote($input);
        $input['support_note_id'] = $sp_note->id;
        if (!empty($file_urls)) {
            foreach ( $file_urls as $url) {
                $input['url'] = $url;
                $uploadObj = new SupportUpload();
                $uploadObj->saveUpload($input);
            }
        }
        return $sp_note;
    }

    public function show(Request $request, $id)
    {
        $data['sp_ticket'] = (new SupportTicket())->getById($id);
        $user = auth()->user();
        if ($data['sp_ticket']->user_id == $user->id || $user->admin == 1) {
            if ($request->ajax()) {
                return $this->commonResponse($data, null, 'show');
            }
            return view('support::notes.ticket_note', $data);
        } else {
            if ($request->ajax()) {
                $notify = ['warning'=>"You don't have accesss to this ticket"];
                return $this->commonResponse($data=[], $notify);
            }
            return redirect(sproute('support.support_path_prefix'));
        }
       
    }

    public function addNote(Request $request, $ticket_id)
    {
        $input = $request->all();
        if($request->action == 'close_ticket') {
            $input['closed'] = ($input['status'] == 0) ? 1 : 0;
            $data['sp_ticket'] = (new SupportTicket())->updateTicket($input, $ticket_id);
        } else {
            $this->validator($input)->validate();
            $input['user_id'] = Auth::user()->id;
            $input['ticket_id'] = $ticket_id;
            $file_urls = [];
            if($request->hasFile('upload_file')) {
                $file_urls = $this->uploadMultipleFiles($request->upload_file, 'public/supports');
            }
           $this->processNote($input, $file_urls);
            $data['sp_ticket'] = (new SupportTicket())->getById($ticket_id);
            $this->processSupportEmail($data['sp_ticket'], 'add-note');
        }
        if ($request->ajax()) {
            return $this->commonResponse($data, null, 'show');
        }
        return view('support::ticket_details', $data);
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

    public function processSupportEmail($ticket, $option)
    {
        $user = auth()->user();
        $support_admin_col = config('support.support_admin');
        if ($option == 'add-note') {
            $reply_user = ($user->$support_admin_col == 1) ? 'Support' : $user->name;
            $message =   $reply_user." replied to ticket : <b>".$ticket->title."</b>.<br /><br />";
            if (!empty($ticket->ticketNotes)){
                foreach ($ticket->ticketNotes as $note) {
                    $note_user = ($note->user->$support_admin_col == 1) ? 'Support' : $note->user->name;
                    $message .= "<b>".$note_user.":</b><br/>";
                    $message .= $note->note."<br/><br/>";
                }
            }
            $message .= "Please click the below button to view the ticket";
        } else {
            $message = "A ticket created with title : <b>".$ticket->title."</b>.<br /> Please click the below button to view the ticket ";
        }
        $button = ['text'=>'View Ticket', 'url' => sproute('ticket.show', $ticket->id)];
        if ($user->$support_admin_col == 1 && $option == 'add-note') {
            $this->sendEmail($user->email, $message, $button);
        } else {
            foreach (config('support.support_admin_email') as $email) {
                $this->sendEmail($email, $message, $button);
            }
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'note' => ['required', 'string'],
            'description' => ['mimes:jpeg,bmp,png,gif', 'max:10000'],
        ]);
    }
}
