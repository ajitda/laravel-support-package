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

    public function noteFiles()
    {
        return $this->hasMany('Flexibleit\Support\Models\SupportUpload', 'support_note_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // public function supportTicket()
    // {
    //     return $this->belongsTo('Flexibleit\Support\Models\SupportTicket', 'ticket_id');
    // }
}
