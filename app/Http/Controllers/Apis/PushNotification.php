<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotification extends Controller
{
    // set variables
    public $server_key  = "AAAAnGe67QM:APA91bHV8_TfTtiaY0c2bzPpLFFCY1CGtEuFw_KQ5d-kcYic2nxE6eWJry1-zWjZLqynIxqsX-2pkSiUtirQaSM8MlX_E9m67jaEd9wWLy8JpcaPgckEs_0fyL7fBFi4V5YEjqdDfXvH"; // firebase server token id
    
    function send($device_token , $data) {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
        'to' => $device_token,
        'notification' => $data
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' . $this->server_key,
                'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
    
}
