<?php

namespace Flexibleit\Support\Models;

use Illuminate\Database\Eloquent\Model;

class SupportNote extends Model
{
    public function saveNote($input)
    {
        $this->note = $input['note'];
        $this->user_id = $input['user_id'];
        $this->ticket_id = $input['ticket_id'];
        if ($this->save()) {
            return $this;
        }
        return false;
    }

    // public function supportTicket()
    // {
    //     return $this->belongsTo('Flexibleit\Support\Models\SupportTicket', 'ticket_id');
    // }
}
