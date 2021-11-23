<!DOCTYPE html>
<html>
<head>
	<title>Preview Report <?= ($jns_report == 'detail') ? 'Nominatif' : '' ?> <?= strtoupper($jenis) ?></title>

	<!-- Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap-4/css/bootstrap.min.css">

	<style type="text/css">
		tr th {
		text-align: center;
		}
		#potensi thead tr th {
			vertical-align: middle;
		}

		th, td {
	      padding: 5px;
	      font-size: 11px;
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
      table.table-bordered{
        border:1px solid black;
        margin-top:20px;
      }
      table.table-bordered > thead > tr > th{
          border:1px solid black;
      }
      table.table-bordered > tbody > tr > td{
          border:1px solid black;
      }
	</style>
</head>
<body>

<?php if ((!isset($_POST['pdf'])) || (!isset($_POST['excel']))): ?>
	<form method="POST" target="_self" id="tab" action="<?= base_url('report/kelelolaan_wo_ao') ?>">
		<input type="hidden" name="jns" value="<?= $jns_report ?>">
		<input type="hidden" name="jenis_deb" value="<?= $jenis ?>">
	    <input type="hidden" name="segmen" value="<?= $p_segmen ?>">
	    <input type="hidden" name="kol" value="<?= $p_kol ?>">
	    <input type="hidden" name="kanwil" value="<?= $p_kanwil ?>">
	    <input type="hidden" name="cabang" value="<?= $p_cabang ?>">
	    <input type="hidden" name="ao" value="<?= $p_ao ?>">

		<button name="pdf" onclick="b()" class="btn btn-primary">UNDUH - PDF</button><?= nbs(5) ?>
		<button name="excel" onclick="b()" class="btn btn-warning">UNDUH - EXCEL</button>
	</form><br>
<?php endif ?>
	
	<?= $konten ?>

</body>
</html>