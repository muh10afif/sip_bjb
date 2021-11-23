<style type="text/css">
    #pengajuan thead tr th {
        vertical-align: middle;
        text-align: center;
      }
</style>

<div class="row">

    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/pengajuan_kelolaan/npl') ?>"><button class="btn <?= ($aktif == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'npl') ? "<i class='fa fa-circle'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/pengajuan_kelolaan/wo') ?>"><button class="btn <?= ($aktif == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'wo') ? "<i class='fa fa-circle'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>

</div><br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
            Data Karyawan <?= $jenis ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="pengajuan">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Kanwil</th>
                                <th>Cabang Induk</th>
                                <th>Kantor</th>
                                <th>Deal Reff</th>
                                <th>AO</th>
                                <th>Alasan Pengajuan</th>
                                <th>Alasan Ditolak</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($record->result() as $r) { ?>
                            <tr class="gradeU">
                                <td><?php echo $no ?></td>
                                <td><?php echo $r->nama ?></td>
                                <td><?php echo $r->kanwil ?></td>
                                <td><?php echo $r->cabang_induk ?></td>
                                <td><?php echo $r->kantor ?></td>
                                <td><?php echo $r->deal_reff ?></td>
                                <td><?php echo $r->name ?></td>
                                <td><?php echo $r->alasan_pengajuan ?></td>
                                <td><?php echo $r->alasan_ditolak ?></td>
                                <td><?php if ($r->sts == 0){
                                        echo "<span class='label label-warning'>Belum Ditindak Lanjuti</span>";
                                }elseif($r->sts == 1){
                                    echo "<span class='label label-success'>Disetujui</span>";
                                }elseif($r->sts == 2){
                                    echo "<span class='label label-danger'>Ditolak</span>";
                                } ?></td>
                                <td> 
                                    <?php
                                        if($r->sts==0){
                                            echo anchor("kelolaan/proses/$r->ida/$aktif",'Proses',array('class'=>'btn btn-primary'));
                                        }
                                        elseif($r->sts==1){
                                            echo " ";
                                        }elseif($r->sts==2){
                                            echo " ";
                                        }
                                    ?>
                                </td>
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


<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script>
    $(function () {
        $('#pengajuan').DataTable({
        order: [[ 0, "asc" ]],
        pageLength: 25
        })
    });
</script>