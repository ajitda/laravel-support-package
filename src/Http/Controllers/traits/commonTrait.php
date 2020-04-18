<?php
namespace Flexibleit\Support\Http\Controllers\Traits;

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
}