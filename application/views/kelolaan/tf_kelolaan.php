<style type="text/css">
    #tf_kelolaan thead tr th {
        vertical-align: middle;
        text-align: center;
      }
</style>
<div class="row">

    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/tf_kelolaan/npl') ?>"><button class="btn <?= ($aktif == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'npl') ? "<i class='fa fa-circle'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/tf_kelolaan/wo') ?>"><button class="btn <?= ($aktif == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'wo') ? "<i class='fa fa-circle'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>

</div><br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <i class="fa fa-navicon "></i><?= nbs(3) ?>Data Karyawan <?= $jenis ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" data-scroll-x="true" id="tf_kelolaan">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Cif</th>
                                <th>Alamat</th>
                                <th>Kanwil</th>
                                <th>Cabang Induk</th>
                                <th>Kantor</th>
                                <th>Deal Reff</th>
                                <th>Plafond</th>
                                <th>Status Kelolaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($record->result() as $r) { ?>
                            <tr class="gradeU">
                                <td><?php echo $no ?></td>
                                <td><?php echo $r->nama ?></td>
                                <td><?php echo $r->cif ?></td>
                                <td><?php echo $r->alamat; echo $r->idl;?></td>
                                <td><?php echo $r->kanwil ?></td>
                                <td><?php echo $r->cabang_induk ?></td>
                                <td><?php echo $r->kantor ?></td>
                                <td><?php echo $r->deal ?></td>
                                <td><?php echo $r->plafond ?></td>
                                <td><?php if($r->stat != 0){
                                        echo '<span class="label label-success">'."Sudah Masuk Kelolaan"; }
                                        else{
                                        echo '<span class="label label-danger">'."Belum masuk kelolaan";
                                        }?></td>
                                <td> <?php
                                        if($r->stat != 0){
                                            echo " ";
                                        }
                                        else{
                                        echo anchor("kelolaan/tf_kelolaan_update/$r->idl/$aktif",'Tambahkan',array('class'=>'label label-warning'));}?></td>
                            </tr>
                        <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- /. PANEL  -->
    </div>
</div>
<!-- /. ROW  -->



<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script>
     $(function () {
        $('#tf_kelolaan').DataTable({
            order: [[ 0, "asc" ]],
            pageLength: 25,
            scrollY:"500px",
            scrollCollapse: true
        })
    });
</script>
