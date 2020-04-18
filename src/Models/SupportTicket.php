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

    public function getAll()
    {
        return $this->latest()->get();
    }

    public function ticketNotes()
    {
        return $this->hasMany('Flexibleit\Support\Models\SupportNote', 'ticket_id');
    }

    public function getById($id)
    {
        return $this->with('ticketNotes')->where('id', $id)->first();
    }
}
