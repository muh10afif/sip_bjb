<style type="text/css">
    img{
        cursor: pointer;
    }
</style>

<?php if (!empty($reg_employee)): ?>
    <a href="<?= base_url("monitoring/monitoring_debitur/$jenis/w/debitur/".$reg_employee) ?>">
<?php else: ?>
    <a href="<?= base_url("monitoring/monitoring_debitur/$jenis/w/semua") ?>">
<?php endif ?>
<button class="btn btn-success"><i class="fa fa-chevron-left"></i><?= nbs(3) ?>Kembali</button></a><br><br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
                <i class="fa fa-navicon"></i><?= nbs(3) ?>Foto Monitoring
            </div>
            <div class="panel-body">
            	<dibv class="row">
            		<div class="col-md-2">
            			<label>Deal Reff :</label>
            		</div>
            		<div class="col-md-2" align="left">
            			<?php $a = $foto_deb->row_array(); ?>
            			<?= $a['deal_reff'] ?>
            		</div>
            	</dibv>
            	<div class="row gbr">

		            <?php foreach ($foto_deb->result_array() as $f): ?>
		                <div class="col-md-4">
		                  <div class="thumbnail">
		                    <img class="img-responsive" style="height: 250px; width: 100%;" src="data:image/jpeg;base64, <?php echo base64_encode($f['picture']) ?>" >
		                  </div>
		                </div>      
		            <?php endforeach ?>
		          </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>assets/viewer/css/viewer.css">
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script src="<?= base_url() ?>assets/viewer/js/viewer.js"></script>

<script type="text/javascript">
  $('.gbr').viewer();
</script>