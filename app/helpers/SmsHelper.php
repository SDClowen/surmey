<?php
class SmsHelper
{
    public static function send(array $messages)
    {
        $config = (object)require_once APP_DIR.'/config/sms.php';

        foreach($messages as $message) {
            $message["no"] = str_replace(["(", ")", " "], "", $message["no"]);
            #$message["no"] = preg_replace("/[^0-9]/", "", $message["no"]);
        }

        $data = [
            "msgheader" => $config->header,
            "messages" => $messages,
            "encoding" => "TR",
            "iysfilter" => "",
            "partnercode" => ""
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.netgsm.com.tr/sms/rest/v2/send');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($config->username . ':' . $config->password)
        ]);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = json_decode(curl_exec($ch));
        
        if ($response->code != 0) {
            $response->status = @lang("netgsm_code_$response->code") ?? $response->description;
        } else {
            $response->status = "SUCCESS";
        }

        return $response;
    }
}