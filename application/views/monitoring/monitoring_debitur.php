<style type="text/css">
	table thead tr th {
		text-align: center;
	}
</style>
<div class="row">

    <div class="col-md-3">
        <?php if ($list == 'debitur'): ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/npl/n/$list/".$this->session->userdata('reg_employee')) ?>">
        <?php elseif ($list == 'semua'): ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/npl/n/$list/") ?>">
        <?php else: ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/npl") ?>">
        <?php endif ?>

        <button class="btn <?= ($aktif == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'npl') ? "<i class='fa fa-circle'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <?php if ($list == 'debitur'): ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/wo/w/$list/".$this->session->userdata('reg_employee')) ?>">
        <?php elseif ($list == 'semua'): ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/wo/w/$list/") ?>">
        <?php else: ?>
            <a href="<?= base_url("monitoring/monitoring_debitur/wo") ?>">
        <?php endif ?>
        
        <button class="btn <?= ($aktif == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'wo') ? "<i class='fa fa-circle'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>
    <div class="col-md-3"></div>
        <div class="col-md-3">
        <?php if (!empty($data_deb)): ?>
            <?php if ($list == 'semua'): ?>
                <a href="<?= base_url('monitoring/monitoring_debitur/'.$aktif.'/excel/semua') ?>">
            <?php elseif ($list == 'debitur'): ?>
                <a href="<?= base_url('monitoring/monitoring_debitur/'.$aktif.'/excel/debitur/'.$reg_employee) ?>">  
            <?php else: ?>
                <a href="<?= base_url('monitoring/monitoring_debitur/'.$aktif.'/excel/') ?>">          
            <?php endif ?>
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
                <?php if ($list == 'semua') : ?>
                    <table class="table table-hover tabel-bordered" id="monitoring">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No</th>
                                <th>Deal Reff</th>
                                <th>Nama</th>
                                <th>Komitmen</th>
                                <th>Tanggal Komitmen</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($data_deb as $d): ?>
                                <tr>
                                    <td align="center"><?= $no++ ?></td>
                                    <td><?= $d['deal_reff'] ?></td>
                                    <td><?= $d['nama'] ?></td>
                                    <td><?= $d['komitmen'] ?></td>
                                    <td align="center"><?= date("d F Y", strtotime($d['tgl_komitmen'])) ?></td>
                                    <td>Rp. <?= number_format($d['nominal'],'0','.','.') ?></td>
                                    <?php 

                                        $cr = $this->M_monitoring->cari_data('picture_monitoring', ['id_monitoring' => $d['id_tr_m']])->num_rows();

                                        if ($cr == 0) {
                                            $dis = 'disabled';
                                        } else {
                                            $dis = '';
                                        }
                                    
                                    ?>
                                    <td width="10%">
                                        <a target="_blank" href="<?= base_url('monitoring/bukti_kunjungan/'.$d['id_tr_m'].'/'.$aktif) ?>"><button class="btn btn-success btn-xs"><i class="fa fa-download"></i><?= nbs(3) ?>Bukti Kunjungan</button></a><?= nbs(3) ?>

                                        <?php if (!empty($reg_employee)): ?>
                                            <a href="<?= base_url('monitoring/foto_monitoring/'.$d['id_tr_m'].'/'.$aktif.'/'.$reg_employee) ?>">
                                        <?php else: ?>
                                            <a href="<?= base_url('monitoring/foto_monitoring/'.$d['id_tr_m'].'/'.$aktif) ?>" >
                                        <?php endif ?>

                                        <button class="btn btn-primary btn-xs" <?= $dis ?>><i class="fa fa-file-image-o"></i><?= nbs(3) ?>Foto Monitoring</button></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php elseif ($list == 'debitur') : ?>

                    <table class="table table-hover tabel-bordered" id="monitoring">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No</th>
                                <th>Deal Reff</th>
                                <th>Nama</th>
                                <th>Komitmen</th>
                                <th>Tanggal Komitmen</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $no1=1; foreach ($reg as $r): ?>

                            <?php
                            
                            $data_d = $this->M_monitoring->get_data_list_monitoring_2($aktif, $r['deal_reff'])->result_array();

                             foreach ($data_d as $d): ?>
                                <tr>
                                    <td align="center"><?= $no1++ ?></td>
                                    <td><?= $d['deal_reff'] ?></td>
                                    <td><?= $d['nama'] ?></td>
                                    <td><?= $d['komitmen'] ?></td>
                                    <td align="center"><?= tgl_indo(date("Y-m-d", strtotime($d['tgl_komitmen']))) ?></td>
                                    <td>Rp. <?= number_format($d['nominal'],'0','.','.') ?></td>
                                    <?php 

                                        $cr = $this->M_monitoring->cari_data('picture_monitoring', ['id_monitoring' => $d['id_tr_m']])->num_rows();

                                        if ($cr == 0) {
                                            $dis = 'disabled';
                                        } else {
                                            $dis = '';
                                        }
                                    
                                    ?>
                                    <td width="10%">
                                        <a target="_blank" href="<?= base_url('monitoring/bukti_kunjungan/'.$d['id_tr_m'].'/'.$aktif) ?>"><button class="btn btn-success btn-xs"><i class="fa fa-download"></i><?= nbs(3) ?>Bukti Kunjungan</button></a><?= nbs(3) ?>

                                        <?php if (!empty($reg_employee)): ?>
                                            <a href="<?= base_url('monitoring/foto_monitoring/'.$d['id_tr_m'].'/'.$aktif.'/'.$d['reg']) ?>">
                                        <?php else: ?>
                                            <a href="<?= base_url('monitoring/foto_monitoring/'.$d['id_tr_m'].'/'.$aktif) ?>" >
                                        <?php endif ?>

                                        <button class="btn btn-primary btn-xs" <?= $dis ?>><i class="fa fa-file-image-o"></i><?= nbs(3) ?>Foto Monitoring</button></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                <?php else: ?>
                    <table class="table table-hover tabel-bordered" id="monitoring">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No</th>
                                <th>Deal Reff</th>
                                <th>Komitmen</th>
                                <th>Tanggal Komitmen</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no2=1; foreach ($data_deb as $d): ?>
                                <tr>
                                    <td><?= $no2++ ?></td>
                                    <td><?= $d['deal_reff'] ?></td>
                                    <td><?= $d['komitmen'] ?></td>
                                    <td align="center"><?= tgl_indo(date("Y-m-d", strtotime($d['tgl_komitmen']))) ?></td>
                                    <td>Rp. <?= number_format($d['nominal'],'0','.','.') ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif ?>
            	
            </div>
		</div>
	</div>	
</div>

<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>

<script>
     $(function () {
        $('#monitoring').DataTable();
    });
</script>