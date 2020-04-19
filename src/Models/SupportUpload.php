<?php

namespace Flexibleit\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SupportUpload extends Model
{
    public function saveUpload($input)
    {
        $this->support_note_id = $input['support_note_id'];
        $this->url = $input['url'];
        if ($this->save()) {
            return $this;
        }
        return false;
    }

    public function getLink()
    {
        $str_url = Storage::url("public/supports/".$this->url);
        $str = '<a target="_blank" href="'.asset($str_url).'">'.$this->url.'</a>';
        return $str;
    }
}
