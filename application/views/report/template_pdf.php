<?php
  
$nama_dokumen=date('dmY')."-report";
//require(APPPATH.'third_party/fpdf.php'); // file fpdf.php harus diincludekan
// require(APPPATH.'third_party/mpdf/mpdf.php');
base_url('vendor/autoload.php');

// $mpdf=new mPDF('utf-8', 'A4-L', 5, 'arial','10','10','10','9','9','9','L'); // Membuat file mpdf baru
$mpdf=new \Mpdf\Mpdf([
  'mode' => 'utf-8',
  'format' => [190, 236],
  'orientation' => 'L'
]);

/*$mpdf = new mPDF('',    // mode - default ''
 '',    // format - A4, for example, default ''
 0,     // font size - default 0
 '',    // default font family
 15,    // margin_left
 15,    // margin right
 16,     // margin top
 16,    // margin bottom
 9,     // margin header
 9,     // margin footer
 'L');  // L - landscape, P - portrait*/
 
//Memulai proses untuk menyimpan variabel php dan html
ob_start();
 
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<style type="text/css">
	tr th {
		text-align: center;
	}
	#npl_ao thead tr th {
		vertical-align: middle;
	}

	th, td {
      padding: 5px;
      font-size: 10px;
    }

    th {
      text-align: center;
    }
    thead tr th {
      background-color: #eee;
    }
    .a tr td {
      font-weight: bold;
    }
    body {
      margin: 20px 20px 20px 20px;
      color: black;
    }
       
</style>
<body>

<?php echo $konten; ?>

</body>
</html>


<?php
//penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
 
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>
