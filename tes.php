<?php 

$host="localhost";
$user="root";
$password="";
// $db="bjb_080121";

// $connectionInfo = array( "UID"=>'sa',                            
//                          "PWD"=>'digital',                            
//                          "Database"=>$db); 

// $kon = sqlsrv_connect($host,$connectionInfo);

// $sql="insert into tr_kelolaan (deal_reff,reg_employee,stat) values
// 		('III7889000','sdsd.ddd.00',1)";

// //Mengeksekusi/menjalankan query diatas	
// sqlsrv_query($kon,$sql);

$db="bjb_080121";

// $connectionInfo = array( "UID"=>'sa',                            
//                         "PWD"=>'digital',                            
//                         "Database"=>$db); 

// $kon = sqlsrv_connect('localhost',$connectionInfo);

// $sql="SELECT a.*, b.kolektibilitas, b.outstanding FROM tr_kelolaan a INNER JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE a.stat = '1' AND b.jenis_debitur='npl'";

// //Mengeksekusi/menjalankan query diatas	
// $a = sqlsrv_query($kon,$sql);


// $b = sqlsrv_fetch_array( $a, SQLSRV_FETCH_ASSOC);

// while( $row = $b ) {
//     echo $row['deal_reff'].", ".$row['id']."<br />";
// }

// sqlsrv_free_stmt( $a);

    // persiapkan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, "http://localhost:58874/api/rekap/GetRekap");

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    echo $output;

    // $profile = json_decode($output, TRUE);

    // echo "<pre>";
    // print_r($profile);
    // echo "</pre>";

?>