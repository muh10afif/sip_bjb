<?php
ini_set('max_execution_time', 0); 

$serverName = "DESKTOP-I10QEH4\SQLEXPRESS"; //serverName\instanceName
// $serverName = "10.6.231.154"; //serverName\instanceName

// 	'hostname' => '10.6.231.154',
// 	'username' => 'bjbsa',
// 	'password' => 'P@ssw0rd@SQL',
// 	'database' => 'sip_bjb',

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"bjb160421");

$connectionInfo = array("UID"           =>"sa",
                        "PWD"           =>"digital",
                        "Database"      =>"bjb160421",
                        "CharacterSet"  =>"UTF-8");

// $connectionInfo = array("UID"           =>"sa",
//                         "PWD"           =>"P@ssw0rd@SQL",
//                         "Database"      =>"sip_bjb",
//                         "CharacterSet"  =>"UTF-8");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

    $sql_del = "DROP TABLE report_npl_kanwil1";

    sqlsrv_query( $conn, $sql_del);

    $sql_seg = "SELECT DISTINCT segmen FROM m_debitur ORDER BY segmen ASC";

    $hasil_seg = sqlsrv_query( $conn, $sql_seg);

    $i=1;
    while( $row = sqlsrv_fetch_array( $hasil_seg, SQLSRV_FETCH_ASSOC) ) {

        $segmen1 = $row['segmen'];

        $segmen2    = str_replace(' ', '_', $segmen1);
        $segmen     = str_replace('&', 'dan', $segmen2);

        if ($i == 1) {

            $sql_c = "CREATE TABLE report_npl_kanwil1 (id INT IDENTITY PRIMARY KEY, nama VARCHAR(255) , cabang_induk VARCHAR(200), reg_employee VARCHAR(100) , urutan INT , $segmen INT,  add_time datetime DEFAULT GETDATE() )";

            $hasil_c = sqlsrv_query( $conn, $sql_c);
            
        } else {

            $sql_c = "ALTER TABLE report_npl_kanwil1 ADD $segmen INT";

            $hasil_c = sqlsrv_query( $conn, $sql_c);
            
        }

        $i++;
    }

    $sql0 = "SELECT DISTINCT kanwil FROM m_debitur WHERE kanwil = 'Kanwil 1' ORDER BY kanwil ASC";

    $hasil0 = sqlsrv_query( $conn, $sql0);

    while( $row = sqlsrv_fetch_array( $hasil0, SQLSRV_FETCH_ASSOC) ) {
        $kanwil = $row['kanwil'];

        // $sql10 = "SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$kanwil' ORDER BY cabang_induk ASC";

        // $hasil10 = sqlsrv_query( $conn, $sql10);

        $sql_seg = "SELECT DISTINCT segmen FROM m_debitur ORDER BY segmen ASC";

        $hasil_seg = sqlsrv_query( $conn, $sql_seg);

        while( $row_seg = sqlsrv_fetch_array( $hasil_seg, SQLSRV_FETCH_ASSOC) ) {

                $segmen = $row_seg['segmen'];

                // $segmen2    = str_replace(' ', '_', $segmen1);
                // $segmen     = str_replace('&', 'dan', $segmen2);

            // count npl
            $sql1 = "SELECT total_kelolaan FROM report_kanwil WHERE kanwil = '$kanwil' AND segmen = '$segmen' ";

            $hasil1 = sqlsrv_query( $conn, $sql1);

            $s = 1;
            while( $row_k = sqlsrv_fetch_array( $hasil1, SQLSRV_FETCH_ASSOC) ) {
                $total_kelolaan_kanwil = (int) $row_k['total_kelolaan'];

                $segmen2    = str_replace(' ', '_', $segmen);
                $segmen3     = str_replace('&', 'dan', $segmen2);

                $sql13 = "SELECT * FROM report_npl_kanwil1 WHERE nama = '$kanwil'";

                $hasil13 = sqlsrv_query( $conn, $sql13);

                if (sqlsrv_has_rows( $hasil13 ) === true) {

                    $sql_input = "UPDATE report_npl_kanwil1 SET nama = '$kanwil', urutan = 1, $segmen3 = $total_kelolaan_kanwil WHERE nama = '$kanwil'";
                
                    $hasil_in = sqlsrv_query( $conn, $sql_input);
                    
                } else {

                    $sql_input = "INSERT INTO report_npl_kanwil1 (nama, urutan, $segmen3) values('$kanwil', 1, $total_kelolaan_kanwil)";
                
                    $hasil_in = sqlsrv_query( $conn, $sql_input);
                    
                }

                //cabang induk

                $sql0c = "SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$kanwil'";

                $hasil0c = sqlsrv_query( $conn, $sql0c);

                while( $rowc = sqlsrv_fetch_array( $hasil0c, SQLSRV_FETCH_ASSOC) ) {
                    $cabang_induk = $rowc['cabang_induk'];

                    $sql_segc = "SELECT DISTINCT segmen FROM m_debitur ORDER BY segmen ASC";

                    $hasil_segc = sqlsrv_query( $conn, $sql_segc);

                    while( $row_segc = sqlsrv_fetch_array( $hasil_segc, SQLSRV_FETCH_ASSOC) ) {

                            $segmenc = $row_segc['segmen'];

                            // $segmen2    = str_replace(' ', '_', $segmen1);
                            // $segmen     = str_replace('&', 'dan', $segmen2);

                        // count npl
                        $sql1c = "SELECT total_kelolaan FROM report_cabang WHERE kanwil = '$kanwil' AND cabang_induk = '$cabang_induk' AND segmen = '$segmenc' ";

                        $hasil1c = sqlsrv_query( $conn, $sql1c);

                        $t = 1;
                        while( $row_kc = sqlsrv_fetch_array( $hasil1c, SQLSRV_FETCH_ASSOC) ) {
                            $total_kelolaan_cabang = (int) $row_kc['total_kelolaan'];

                            $segmen2c    = str_replace(' ', '_', $segmenc);
                            $segmen3c     = str_replace('&', 'dan', $segmen2c);

                            $sql13c = "SELECT * FROM report_npl_kanwil1 WHERE nama = '$cabang_induk'";

                            $hasil13c = sqlsrv_query( $conn, $sql13c);

                            if (sqlsrv_has_rows( $hasil13c ) === true) {

                                $sql_inputc = "UPDATE report_npl_kanwil1 SET nama = '$cabang_induk', cabang_induk='$cabang_induk', urutan = 2, $segmen3c = $total_kelolaan_cabang WHERE nama = '$cabang_induk'";
                            
                                $hasil_inc = sqlsrv_query( $conn, $sql_inputc);
                                
                            } else {

                                $sql_inputc = "INSERT INTO report_npl_kanwil1 (nama, cabang_induk, urutan, $segmen3c) values('$cabang_induk', '$cabang_induk', 2, $total_kelolaan_cabang)";
                            
                                $hasil_inc = sqlsrv_query( $conn, $sql_inputc);
                                
                            }

                            // ao
                            $sql0ca = "SELECT DISTINCT c.reg_employee, c.name FROM tr_kelolaan a INNER JOIN m_debitur b ON (a.deal_reff = b.deal_reff) INNER JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.cabang_induk = '$cabang_induk' AND b.kanwil = '$kanwil'";

                            $hasil0ca = sqlsrv_query( $conn, $sql0ca);

                            while( $rowca = sqlsrv_fetch_array( $hasil0ca, SQLSRV_FETCH_ASSOC) ) {
                                $reg_employee   = $rowca['reg_employee'];
                                $ao             = $rowca['name'];

                                $sql_segca = "SELECT DISTINCT segmen FROM m_debitur ORDER BY segmen ASC";

                                $hasil_segca = sqlsrv_query( $conn, $sql_segca);

                                while( $row_segca = sqlsrv_fetch_array( $hasil_segca, SQLSRV_FETCH_ASSOC) ) {

                                        $segmenca = $row_segca['segmen'];

                                        // $segmen2    = str_replace(' ', '_', $segmen1);
                                        // $segmen     = str_replace('&', 'dan', $segmen2);

                                    // count npl
                                    $sql1ca = "SELECT total_kelolaan FROM report_ao WHERE kanwil = '$kanwil' AND cabang_induk = '$cabang_induk' AND segmen = '$segmenca' AND reg_employee = '$reg_employee' ";

                                    $hasil1ca = sqlsrv_query( $conn, $sql1ca);

                                    $a = 1;
                                    while( $row_kca = sqlsrv_fetch_array( $hasil1ca, SQLSRV_FETCH_ASSOC) ) {
                                        $total_kelolaan_ao = (int) $row_kca['total_kelolaan'];

                                        $segmen2ca    = str_replace(' ', '_', $segmenca);
                                        $segmen3ca     = str_replace('&', 'dan', $segmen2ca);

                                        $sql13ca = "SELECT * FROM report_npl_kanwil1 WHERE nama = '$ao'";

                                        $hasil13ca = sqlsrv_query( $conn, $sql13ca);

                                        if (sqlsrv_has_rows( $hasil13ca ) === true) {

                                            $sql_inputca = "UPDATE report_npl_kanwil1 SET nama = '$ao',  cabang_induk='$cabang_induk', reg_employee = '$reg_employee', urutan = 3, $segmen3ca = $total_kelolaan_ao WHERE nama = '$ao'";
                                        
                                            $hasil_inca = sqlsrv_query( $conn, $sql_inputca);

                                            if( $hasil_inca === false ) {


                                                echo "Error in executing query.</br>";


                                                die( print_r( sqlsrv_errors(), true));


                                            }
                                            
                                        } else {

                                            $sql_inputca = "INSERT INTO report_npl_kanwil1 (nama, cabang_induk, reg_employee, urutan, $segmen3ca) values('$ao', '$cabang_induk',  '$reg_employee', 3, $total_kelolaan_ao)";
                                        
                                            $hasil_inca = sqlsrv_query( $conn, $sql_inputca);

                                            if( $hasil_inca === false ) {


                                                echo "Error in executing query.</br>";


                                                die( print_r( sqlsrv_errors(), true));


                                            }
                                            
                                        }

                                        // kolektibilitas
                                        $sql0cak = "SELECT * FROM m_kolektibilitas WHERE id BETWEEN 3 AND 5";

                                        $hasil0cak = sqlsrv_query( $conn, $sql0cak);

                                        while( $rowcak = sqlsrv_fetch_array( $hasil0cak, SQLSRV_FETCH_ASSOC) ) {
                                            $kolektibilitas   = $rowcak['kolektibilitas'];
                                            $id_kol           = $rowcak['id'];

                                            $sql_segcak = "SELECT DISTINCT segmen FROM m_debitur ORDER BY segmen ASC";

                                            $hasil_segcak = sqlsrv_query( $conn, $sql_segcak);

                                            while( $row_segcak = sqlsrv_fetch_array( $hasil_segcak, SQLSRV_FETCH_ASSOC) ) {

                                                    $segmencak = $row_segcak['segmen'];

                                                    // $segmen2    = str_replace(' ', '_', $segmen1);
                                                    // $segmen     = str_replace('&', 'dan', $segmen2);

                                                // count npl
                                                $sql1cak = "SELECT total_kelolaan FROM report_kolek WHERE kanwil = '$kanwil' AND cabang_induk = '$cabang_induk' AND segmen = '$segmencak' AND reg_employee = '$reg_employee' AND kolektibilitas = '$kolektibilitas'";

                                                $hasil1cak = sqlsrv_query( $conn, $sql1cak);

                                                $k = 1;
                                                while( $row_kcak = sqlsrv_fetch_array( $hasil1cak, SQLSRV_FETCH_ASSOC) ) {
                                                    $total_kelolaan_kolek = (int) $row_kcak['total_kelolaan'];

                                                    $segmen2cak    = str_replace(' ', '_', $segmencak);
                                                    $segmen3cak     = str_replace('&', 'dan', $segmen2cak);

                                                    $sql13cak = "SELECT * FROM report_npl_kanwil1 WHERE nama = '$kolektibilitas' AND cabang_induk = '$cabang_induk' AND reg_employee = '$reg_employee'";

                                                    $hasil13cak = sqlsrv_query( $conn, $sql13cak);

                                                    if (sqlsrv_has_rows( $hasil13cak ) === true) {

                                                        $sql_inputcak = "UPDATE report_npl_kanwil1 SET nama = '$kolektibilitas', urutan = 4, $segmen3cak = $total_kelolaan_kolek, cabang_induk = '$cabang_induk', reg_employee = '$reg_employee' WHERE nama = '$kolektibilitas' AND cabang_induk = '$cabang_induk' AND reg_employee = '$reg_employee'";
                                                    
                                                        $hasil_incak = sqlsrv_query( $conn, $sql_inputcak);

                                                        if( $hasil_incak === false ) {


                                                            echo "Error in executing query.</br>";


                                                            die( print_r( sqlsrv_errors(), true));


                                                        }
                                                        
                                                    } else {

                                                        $sql_inputcak = "INSERT INTO report_npl_kanwil1 (nama, urutan,$segmen3cak, cabang_induk, reg_employee) values('$kolektibilitas', 4, $total_kelolaan_kolek, '$cabang_induk', '$reg_employee')";
                                                    
                                                        $hasil_incak = sqlsrv_query( $conn, $sql_inputcak);

                                                        if( $hasil_incak === false ) {


                                                            echo "Error in executing query.</br>";


                                                            die( print_r( sqlsrv_errors(), true));


                                                        }
                                                        
                                                    }
                                                        
                                                    $k++;
                                                }
                                                    
                                            }
                                        
                                        }
                                        
                                            
                                        $a++;
                                    }
                                        
                                }
                            
                            }
                            
                                
                            $t++;
                        }
                            
                    }
                
                }
                
                    
                $s++;
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