<?php

$serverName = "10.6.231.154";

$connectionInfo = array("UID"           =>"bjbsa",
                        "PWD"           =>"P@ssw0rd@SQL",
                        "Database"      =>"sip_bjb",
                        "CharacterSet"  =>"UTF-8");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

if ($conn) {
    echo 'Koneksi Berhasil !';
} else {
    echo 'Koneksi gagal !';
    die(print_r(sqlsrv_errors(),true));
}

?>