<?php
namespace Flexibleit\Support\Http\Controllers\Traits;

use Flexibleit\Support\Mail\SupportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
trait CommonTrait
{
    public function processNotification($notify) {
        $response = [];
        if(!empty($notify)) {
            if(is_array($notify)) {
                foreach($notify as $key=>$value) {
                    $response['notify'] = [$key=>$value];
                }
            } else {
                $response['notify'] = ['success'=>$notify];
            }
        }
        return $response;
    }

    public function uploadFile($image_tmp, $path)
    {
        $extension = $image_tmp->getClientOriginalExtension();
        $filename = rand(1111, 9999999).".".$extension;
        $large_image_path = $path.'/'.$filename;
        // $large_image = Image::make($image_tmp);
        Storage::put($large_image_path, $image_tmp);
        return $filename;
    }

    public function uploadMultipleFiles($files, $path)
    {
        $files_array = [];
        foreach($files as $file) {
            $filename = $this->uploadFile($file, $path);
            $files_array[] = $filename;
        }
        return $files_array;
    }

    public function sendEmail($to_email, $message, $button=[])
    {
        $mailObj = new SupportMail($message, $button);
        Mail::to($to_email)->send($mailObj);
    }
}