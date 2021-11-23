<?php 

    // persiapkan curl
    $ch = curl_init(); 

    // set url 
    //curl_setopt($ch, CURLOPT_URL, "http://localhost:58874/api/rekap/GetRekap");
    
    curl_setopt($ch, CURLOPT_URL, "http://192.168.201.75/sip_bjb/api/rekapKanwil/GetRekap");

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
            "Authorization: bearer 7SO4hyCKtlFeKhmE7s8ZeeKxkLnXTc8LydEWhI5USmR6FgFoiv2c0D7bxzkN2IUbLSqdYezWoX_lX2YiIrvEHFBghPSOrcuJlSHI13QfLAPSbtFFa8IdiuX33OqCMZMiLbpKgQWT-WelLyJTfqwrszlAY27bpl7_n3F9TziEU4JdBAR7_OBjK8oxVA2hfYbBBGehHHh0PWzt3QVOODGc0yz6aqz4g4eM-6VbWxP3fVZQVPhDOkD7pvfl3eYp_xTn1JMIAofnpmhaMijqgxFHw_7JTov2zkGjy3oACVg-M7D25g_oVE8xOn0XVKSjYX8Q"
    )); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    echo $output;

?>