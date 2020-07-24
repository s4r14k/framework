<?php

namespace framework\gestion;

class Connect {

    static function get_organizations() {

        $ch = curl_init("https://backend-dev.everready.ai/m2m/v1/organizations");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-api-key: c38d1542-a8bc-4d14-a7d1-fd5b824be8b1',
            'Content-Type: application/json',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'
        ));

		$responses = curl_exec($ch);

        curl_close($ch);
        
        return $responses;
    }
}