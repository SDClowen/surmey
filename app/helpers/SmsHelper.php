<?php
class SmsHelper
{
    public static function send($phone, $message)
    {
        $config = (object)require_once APP_DIR.'/config/sms.php';
     
        $phone = str_replace(["(", ")", " "], "", $phone);


        $xmlData = '<?xml version="1.0"?>
        <mainbody>
           <header>
               <usercode>' . $config->username . '</usercode>
               <password>' . $config->password . '</password>
               <msgheader>' . $config->header . '</msgheader>
           </header>
           <body>
               <msg>
                   <![CDATA[' . $message . ']]>
               </msg>
               <no>' . $phone . '</no>
           </body>
        </mainbody>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.netgsm.com.tr/sms/send/otp');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        $result = curl_exec($ch);

        $xml = new SimpleXMLElement($result);

        $response = new stdClass;
        $response->code = strval($xml->main->code);
        $jobid = 0;

        #if($response->code <= 100 && $response->code % 10 == 0)
        if ($response->code == 20 || $response->code == 30 || $response->code == 40 ||
            $response->code == 41 ||  $response->code == 51 || $response->code == 60 ||
            $response->code == 70 || $response->code == 80 || $response->code == 100) {
            $response->status = lang("netgsm_code_$response->code");
        } else {
            $response->status = "SUCCESS";

            $jobid = strval(($xml->main->jobID[0]));
            $response->jobid = $jobid;
        }

        return $response;
    }
}