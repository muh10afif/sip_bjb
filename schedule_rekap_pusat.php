<?php 

    // persiapkan curl
    $ch = curl_init(); 

    // set url 
    //curl_setopt($ch, CURLOPT_URL, "http://localhost:58874/api/rekap/GetRekap");
    
    curl_setopt($ch, CURLOPT_URL, "http://192.168.201.75/sip_bjb/api/rekap/GetRekap");

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
            "Authorization: bearer LQ0rEdQqF5-6nKWMeckZHiFCka494kG0Dy-EqlamNW371XoCcG5YDCv0YepdzRd9QitmOPwsyLPRxvpN3TWyir_i4JVPnkWeBmIaMj2b2hcvSa51uoYrrA95uIi75pdfBJj-dFyx0iOUwxgjGN6dlJig55kyiKBXMGpLAErl0ySQvScXgbmDTtRpoRV8P1S2HjYdqfb8bJ4x5vQdxXu2mguYUJmaRmU5VGdb865MbeWgRQJGZpNJbHmUJnd6Z6Iro59mcE1imCn1s8d9kmktS8feD4Rrfe2ClCoSzLbmXCBX50WXHxLzfoL1Iet36wvV"
    )); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    echo $output;

?>