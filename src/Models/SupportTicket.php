<?php

namespace Flexibleit\Support\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{

    public function saveTicket($input)
    {
        $this->user_id = $input['user_id'];
        $this->title = $input['title'];
        $this->closed = 0;
        if ($this->save()) {
            return $this;
        }
        return false;
    }

    public function updateTicket($input, $id)
    {
        $ticket = $this->findOrFail($id);
        $ticket->closed = $input['closed'];
        if ($ticket->save()) {
            return $ticket;
        }
        return false;
    }

    public function getAll($paginate = null, $option = null)
    {
        $support_admin_col = config('support.support_admin');
        $user = auth()->user();
        $result = $this->latest();
        if ($user->$support_admin_col != 1) {
            $result = $result->where('user_id', $user->id);
        }
        if (!empty($option)) {
            $result = $result->where($option);
        }
        if (!empty($paginate['paginate'])) {
            return $result->paginate($paginate['paginate']);
        } else if (!empty($paginate['get'])) {
            return $result->get();
        } else {
            return $result;
        }
    }

    public function ticketNotes()
    {
        return $this->hasMany('Flexibleit\Support\Models\SupportNote', 'ticket_id');
    }

    public function getById($id)
    {
        return $this->with('ticketNotes', 'ticketNotes.noteFiles', 'ticketNotes.user')->where('id', $id)->first();
    }
}
