<style type="text/css">
	table thead tr th {
		text-align: center;
	}
</style>
<div class="row">

    <div class="col-md-3">
        <a href="<?= base_url("monitoring/kelolaan_debitur/npl/") ?>">
        <button class="btn <?= ($aktif == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'npl') ? "<i class='fa fa-circle'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url("monitoring/kelolaan_debitur/wo/") ?>">
        <button class="btn <?= ($aktif == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'wo') ? "<i class='fa fa-circle'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <?php if (!empty($data_deb)): ?>
            <a href="<?= base_url('monitoring/kelolaan_debitur/'.$aktif.'/excel') ?>">
            <button class="btn btn-success pull-right" name="unduh"><i class="fa fa-download"></i><?= nbs(2) ?>Unduh EXCEL</button></a>
        <?php endif ?>
    </div>
    
</div><br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
                <i class="fa fa-navicon"></i><?= nbs(3); echo $judul; ?>
            </div>
            <div class="panel-body">
                <table class="table table-hover tabel-bordered" id="kelolaan">
                    <thead style="background-color: #e3e3fb">
                        <tr>
                            <th>No</th>
                            <th>Deal Reff</th>
                            <th>Nama</th>
                            <th>Kanwil</th>
                            <th>Cabang Induk</th>
                            <th>Kantor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($data_deb as $deb): ?>
                            <tr>
                                <td align="center"><?= $no++ ?></td>
                                <td><?= $deb['deal_reff'] ?></td>
                                <td><?= $deb['nama'] ?></td>
                                <td><?= $deb['kanwil'] ?></td>
                                <td><?= $deb['cabang_induk'] ?></td>
                                <td><?= $deb['kantor'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            	
            </div>
		</div>
	</div>	
</div>

<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>

<script>
     $(function () {
        $('#kelolaan').DataTable();
    });
</script>