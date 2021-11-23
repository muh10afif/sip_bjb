<?php
// $serverName = "DESKTOP-I10QEH4\SQLEXPRESS"; //serverName\instanceName
$serverName = "10.6.231.154"; //serverName\instanceName

// 	'hostname' => '10.6.231.154',
// 	'username' => 'bjbsa',
// 	'password' => 'P@ssw0rd@SQL',
// 	'database' => 'sip_bjb',

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"bjb160421");

// $connectionInfo = array("UID"           =>"sa",
//                         "PWD"           =>"digital",
//                         "Database"      =>"bjb160421",
//                         "CharacterSet"  =>"UTF-8");

$connectionInfo = array("UID"           =>"bjbsa",
                        "PWD"           =>"P@ssw0rd@SQL",
                        "Database"      =>"sip_bjb",
                        "CharacterSet"  =>"UTF-8");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

    $sql0 = "SELECT DISTINCT kanwil FROM m_debitur ORDER BY kanwil ASC";

    $hasil0 = sqlsrv_query( $conn, $sql0);

while( $row = sqlsrv_fetch_array( $hasil0, SQLSRV_FETCH_ASSOC) ) {
        $kanwil = $row['kanwil'];

        $sql10 = "SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$kanwil' ORDER BY cabang_induk ASC";

        $hasil10 = sqlsrv_query( $conn, $sql10);

        while( $row = sqlsrv_fetch_array( $hasil10, SQLSRV_FETCH_ASSOC) ) {
                $cabang_induk = $row['cabang_induk'];

            // count npl
            $sql1 = "SELECT COUNT(b.deal_reff) as count_npl FROM tr_kelolaan a INNER JOIN m_debitur b ON ( a.deal_reff = b.deal_reff ) WHERE a.stat = 1 AND b.jenis_debitur= 'npl' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk'";

            $hasil1 = sqlsrv_query( $conn, $sql1);

            while( $row = sqlsrv_fetch_array( $hasil1, SQLSRV_FETCH_ASSOC) ) {
                $count_npl = (int) $row['count_npl'];
            }

            // sum npl
                $sql2 = "SELECT SUM(b.outstanding) as sum_npl FROM tr_kelolaan a INNER JOIN m_debitur b ON ( a.deal_reff = b.deal_reff ) WHERE a.stat = 1 AND b.jenis_debitur= 'npl' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk'";

                $hasil2 = sqlsrv_query( $conn, $sql2);

                while( $row = sqlsrv_fetch_array( $hasil2, SQLSRV_FETCH_ASSOC) ) {
                        $sum_npl = (float) $row['sum_npl'];
                }
            // monitoring_npl
                $sql3 = "SELECT COUNT ( t.id ) AS monitoring_npl FROM tr_monitoring as t INNER JOIN m_debitur as d ON d.deal_reff = t.deal_reff WHERE t.status = 1 AND t.hasil_komitmen = 'Not Yet Due / Missed' AND d.jenis_debitur= 'npl' AND d.kanwil = '$kanwil' AND d.cabang_induk = '$cabang_induk' AND t.tgl_komitmen BETWEEN CONVERT ( DATE, GETDATE()) AND DATEADD(DAY,3,CONVERT (DATE,GETDATE()) )";

                $hasil3 = sqlsrv_query( $conn, $sql3);

                while( $row = sqlsrv_fetch_array( $hasil3, SQLSRV_FETCH_ASSOC) ) {
                    $monitoring_npl = (int) $row['monitoring_npl'];
                }

            // potensi_npl
                $sql4 = "SELECT SUM ( a.nominal ) AS potensi_npl FROM tr_monitoring a JOIN m_debitur b ON ( a.deal_reff = b.deal_reff )
                JOIN tr_kelolaan c ON ( b.deal_reff = c.deal_reff ) WHERE a.hasil_komitmen <> 'Failed' AND b.jenis_debitur = 'npl' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk' AND c.stat = 1  AND MONTH ( a.tgl_komitmen ) = MONTH (CONVERT (DATE,GETDATE()))";

                $hasil4 = sqlsrv_query( $conn, $sql4);

                while( $row = sqlsrv_fetch_array( $hasil4, SQLSRV_FETCH_ASSOC) ) {
                    $potensi_npl = (float) $row['potensi_npl'];
                }

            // count wo
                $sql11 = "SELECT COUNT(b.deal_reff) as count_wo FROM tr_kelolaan a INNER JOIN m_debitur b ON ( a.deal_reff = b.deal_reff ) WHERE a.stat = 1 AND b.jenis_debitur= 'wo' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk' ";

                $hasil11 = sqlsrv_query( $conn, $sql11);

                while( $row = sqlsrv_fetch_array( $hasil11, SQLSRV_FETCH_ASSOC) ) {
                    $count_wo = (int) $row['count_wo'];
                }

            // sum wo
                $sql22 = "SELECT SUM(b.tunggakan_pokok) as sum_wo FROM tr_kelolaan a INNER JOIN m_debitur b ON ( a.deal_reff = b.deal_reff ) WHERE a.stat = 1 AND b.jenis_debitur= 'wo' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk' ";

                $hasil22 = sqlsrv_query( $conn, $sql22);

                while( $row = sqlsrv_fetch_array( $hasil22, SQLSRV_FETCH_ASSOC) ) {
                    $sum_wo = (float) $row['sum_wo'];
                }

            // monitoring_wo
                $sql33 = "SELECT COUNT ( t.id ) AS monitoring_wo FROM tr_monitoring as t INNER JOIN m_debitur as d ON d.deal_reff = t.deal_reff WHERE t.status = 1 AND t.hasil_komitmen = 'Not Yet Due / Missed' AND d.jenis_debitur= 'wo' AND d.kanwil = '$kanwil' AND d.cabang_induk = '$cabang_induk'  AND t.tgl_komitmen BETWEEN CONVERT ( DATE, GETDATE()) AND DATEADD(DAY,3,CONVERT (DATE,GETDATE()) )";

                $hasil33 = sqlsrv_query( $conn, $sql33);

                while( $row = sqlsrv_fetch_array( $hasil33, SQLSRV_FETCH_ASSOC) ) {
                    $monitoring_wo = (int) $row['monitoring_wo'];
                }

            // monitoring_wo
                $sql44 = "SELECT SUM ( a.nominal ) AS potensi_wo FROM tr_monitoring a JOIN m_debitur b ON ( a.deal_reff = b.deal_reff )
                JOIN tr_kelolaan c ON ( b.deal_reff = c.deal_reff ) WHERE a.hasil_komitmen <> 'Failed' AND b.jenis_debitur = 'wo' AND b.kanwil = '$kanwil' AND b.cabang_induk = '$cabang_induk'  AND c.stat = 1  AND MONTH ( a.tgl_komitmen ) = MONTH (CONVERT (DATE,GETDATE()))";

                $hasil44 = sqlsrv_query( $conn, $sql44);

                while( $row = sqlsrv_fetch_array( $hasil44, SQLSRV_FETCH_ASSOC) ) {
                    $potensi_wo = (float) $row['potensi_wo'];
                }

                $sql00 = "SELECT * FROM rekap_kanwil_cabang WHERE kanwil = '$kanwil' AND cabang_induk = '$cabang_induk'";

                $hasil00 = sqlsrv_query( $conn, $sql00);

                if (sqlsrv_has_rows( $hasil00 ) === true) {
                    $sql111 = "UPDATE rekap_kanwil_cabang SET kanwil = '$kanwil', cabang_induk = '$cabang_induk', count_npl = $count_npl , sum_npl = $sum_npl, monitoring_npl = $monitoring_npl, potensi_npl = $potensi_npl, count_wo = $count_wo, sum_wo = $sum_wo , monitoring_wo = $monitoring_wo , potensi_wo = $potensi_wo WHERE kanwil = '$kanwil' AND cabang_induk = '$cabang_induk'";
                } else {
                    $sql111 = "INSERT INTO rekap_kanwil_cabang (kanwil, cabang_induk, count_npl , sum_npl, monitoring_npl, potensi_npl, count_wo, sum_wo , monitoring_wo , potensi_wo) values('$kanwil', '$cabang_induk', $count_npl , $sum_npl, $monitoring_npl, $potensi_npl, $count_wo, $sum_wo , $monitoring_wo , $potensi_wo)";
                }


                $stmt = sqlsrv_query( $conn, $sql111);

                if( $stmt === false ) {


                    echo "Error in executing query.</br>";


                    die( print_r( sqlsrv_errors(), true));


                }
        }
     
    }


// $sql1 = "SELECT DISTINCT kanwil FROM m_debitur";

// $stmt = sqlsrv_query( $conn, $sql1);

// while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//     echo $row['kanwil']."<br />";
// }


sqlsrv_close( $conn);

?>