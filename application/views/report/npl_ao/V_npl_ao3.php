<style type="text/css">
	tr th {
		text-align: center;
	}
	#npl_ao thead tr th {
		vertical-align: middle;
	}
	.kol .select2 {
		margin-top: 10px;
	}
	.ao .select2 {
		margin-top: 10px;
	}
</style>
<div class="row">
      	<div class="col-md-12">

		<div class="box box-primary box-solid">
			<div class="box-header with-border">
                  <h1 class="box-title">Filter Data</h1>
             </div>

		<form method="POST" target="_self" id="tab" action="<?= base_url('report/kelelolaan_npl_ao') ?>">
      		<div class="box-body text-center" style="background-color: white;">
      		<div class="col-md-12">
      			<div class="col-md-4">
	                <select class="form-control select2" name="segmen" style="width: 100%;">
	                	<option value="">-- Pilih Segmen --</option>
	                	<?php foreach ($header->result_array() as $h): ?>
	                		<option value="<?= $h['segmen'] ?>" <?= ($p_segmen == $h['segmen']) ? 'selected' : '' ?>><?= $h['segmen'] ?></option>
	                	<?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-4">
                    
                    <select class="form-control select2 cabang1" name="cabang" id="cabang1" style="width: 100%;">
	                	<option value="">-- Pilih Cabang --</option>

	                	<?php $kwl = $this->session->userdata('kanwil'); 
                              $lvl = $this->session->userdata('level'); ?>

                        <?php if ((!empty($kwl)) && ($lvl == 3)): ?>
                          <?php $res = $this->db->query("SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$kwl'")->result_array();?>
                          <?php foreach ($res as $r): ?>
                            
                            <option value="<?= $r['cabang_induk'] ?>" <?= ($p_cabang == $r['cabang_induk']) ? 'selected' : '' ?>><?= $r['cabang_induk'] ?></option>

                          <?php endforeach ?>
                        <?php else: ?>

                        <?php foreach ($d_cabang->result_array() as $h): ?>
                          <option value="<?= $h['cabang_induk'] ?>" <?= ($p_cabang == $h['cabang_induk']) ? 'selected' : '' ?>><?= $h['cabang_induk'] ?></option>
                        <?php endforeach ?>

                        <?php endif ?>

                    </select>
	            </div>
	             <div class="col-md-4">
                    <select class="form-control select2" name="kanwil" id="kanwil1" style="width: 100%;">
	                	<option value="">-- Pilih Kanwil --</option>

						<?php $kwl = $this->session->userdata('kanwil'); 
                              $lvl = $this->session->userdata('level'); ?>

                        <?php if ((!empty($kwl)) && ($lvl == 3)): ?>
                          <?php $res = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur WHERE kanwil = '$kwl'")->row_array();?>
                          <option value="<?= $res['kanwil'] ?>" <?= ($p_kanwil == $res['kanwil']) ? 'selected' : '' ?>><?= $res['kanwil'] ?></option>
                        <?php else: ?>

                          <?php foreach ($kanwil->result_array() as $h): ?>
                            <option value="<?= $h['kanwil'] ?>" <?= ($p_kanwil == $h['kanwil']) ? 'selected' : '' ?>><?= $h['kanwil'] ?></option>
                          <?php endforeach ?>

                        <?php endif ?>

                    </select>
	            </div>
      		</div>
      		<div class="col-md-12">
      			<div class="col-md-4 kol">
	            	<select class="form-control select2" name="kol" style="width: 100%;">
	                	<option value="">-- Pilih Kolektibilitas --</option>
	                	<?php foreach ($kol->result_array() as $h): ?>
	                		<option value="<?= $h['id'] ?>" <?= ($p_kol == $h['id']) ? 'selected' : '' ?>><?= $h['kolektibilitas'] ?></option>
	                	<?php endforeach ?>
                    </select>
	            </div>
	            <div class="col-md-4 ao">
	            	<select class="form-control select2" name="ao" id="ao1" style="width: 100%;">
	            		<option value="">-- Pilih AO --</option>
	            		<?php foreach ($d_ao->result_array() as $o): ?>
	            			<option value="<?= $o['reg_employee'] ?>" <?= ($p_ao == $o['reg_employee']) ? 'selected' : '' ?>><?= $o['name'] ?></option>
	            		<?php endforeach ?>
	            	</select>
	            </div> 
	            <div class="col-md-4 ao">
	            	<select class="form-control select2" name="jns" style="width: 100%;">
	            		<option value="">-- Pilih Jenis Report --</option>
	            		<option value="data">Laporan</option>
	            		<option value="detail">Nominatif</option>
	            	</select>
	            </div>
      		</div>
	            
	            
	      	</div>
	      	<div class="box-footer">
	      		<div class="col-md-12" align="center">

		      		<button class="btn btn-primary" onclick="b()" name="cari" style="margin-top: 5px"><i class="fa fa-search"></i><?= nbs(2) ?>Tampilkan</button><?= nbs(3) ?>
                    <button class="btn btn-success" onclick="b()" name="all" style="margin-top: 5px"><i class="fa fa-bars"></i><?= nbs(2) ?>Tampilkan Semua</button><?= nbs(3) ?>
	            	<button class="btn btn-warning" onclick="a()" name="unduh" style="margin-top: 5px"><i class="fa fa-download"></i><?= nbs(2) ?>Unduh Report</button>

	            </div>
	      	</div>
      	</div>
     </div>
 	</form>
    </div>
    <div class="row">
	<div class="col-md-6">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h1 class="box-title">Report Monitoring Kelolaan NPL AO PPK</h1>
			</div>
			<div class="box-body">
				<canvas id="myChart"></canvas>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h1 class="box-title">Report Monitoring Kelolaan NPL AO PPK</h1>
			</div>
			<div class="box-body">
				<canvas id="myChart2"></canvas>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h1 class="box-title">Report Monitoring Kelolaan NPL AO PPK</h1>
			</div>
			<div class="box-body table-responsive">

            <div>
            <?php $segmen = array(); ?>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php $kwl = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur ORDER BY kanwil ASC")->result_array();
                        $i = 0;
                        foreach ($kwl as $k):
                        
                        $kanwil = str_replace(' ','_', strtolower($k['kanwil']));
                     ?>
                        <li role="presentation" class=""><a href="#<?= $kanwil ?>" aria-controls="<?= $kanwil ?>" role="tab" data-toggle="tab"><?= str_replace('_',' ', strtoupper($kanwil)) ?></a></li>
                    
                        
                    <?php $i++; endforeach; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <?php $kwl = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur ORDER BY kanwil ASC")->result_array();
                        foreach ($kwl as $k):
                        
                        $kanwil = str_replace(' ','_', strtolower($k['kanwil']));
                     ?>
                        
                        <div role="tabpanel" class="tab-pane" id="<?= $kanwil ?>">

                            <table class="table table-light table-bordered table-hover table-striped " style="width: 100%">
                                <thead style="background-color: #e3e3fb">
                                    <tr>
                                        <?php if (empty($p_segmen)): ?>
                                            <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>
                                        <?php else: ?>
                                            <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur WHERE segmen = '$p_segmen'")->result_array(); ?>
                                        <?php endif ?>
                                        
                                        <!-- <th style="display: none;"></th> -->
                                        <th width="350px"></th>
                                            <?php foreach($result_segmen as $item):?>
                                                    <th> <?= $item['segmen'] ?> </th>
                                            <?php endforeach ?>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $kwl_1 = $this->db->get('report_npl_'.$kanwil)->result_array();
                                    
                                        foreach ($kwl_1 as $ka): 
                                        
                                        if ($ka['urutan'] == 2) {
                                            $stl = "style='padding-left: 30px'";
                                        } elseif ($ka['urutan'] == 3) {
                                            $stl = "style='padding-left: 60px'";
                                        } elseif ($ka['urutan'] == 4) {
                                            $stl = "style='padding-left: 90px'";
                                        } else {
                                            $stl = "style=''";
                                        }
                                        ?>

                                    <tr>
                                        <td <?= $stl ?>><?= $ka['nama'] ?></td>
                                        <?php foreach($result_segmen as $item):
                                            
                                            $segmen1    = str_replace(' ', '_', $item['segmen']);
                                            $segmen     = str_replace('&', 'dan', $segmen1);
                                        ?>

                                                <th align='right'> <?= $ka[$segmen] ?> </th>
                                        <?php endforeach ?>
                                        <th align='right'><?= $ka['total'] ?></th>
                                    </tr>
                                    
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                        </div>
                    
                    <?php endforeach; ?>

                </div>

            </div>
				
			</div>
		</div>
	</div>
</div>
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/utils.js'); ?>"></script>


<script type="text/javascript">
  function a() {
    var x = document.getElementById('tab');

    if (x.hasAttribute("target")) {
      x.setAttribute("target", "_blank");
    }
  }

  function b() {
    var x = document.getElementById('tab');

    if (x.hasAttribute("target")) {
      x.setAttribute("target", "_self");
    }
  }
</script>

<script>
  $(function () {
    $.ajaxSetup({
      type: "POST",
      url: "<?= base_url('report/ambil_data') ?>",
      cache: false,
    });

    $("#kanwil1").change(function(){

      var value   = $(this).val();
      var cabang  = $('#cabang1').val();

      if (value != null) {
        $.ajax({
          data:{modul:'cabang', id:value, cabang:cabang},
          success: function(respond){
            $("#cabang1").html(respond);

            if (cabang != '') {
              $("#cabang1").val(cabang).trigger('change');
            }
          }
        })
      }
    })
  })
</script>

<script>
  $(function () {
    $.ajaxSetup({
      type: "POST",
      url: "<?= base_url('report/ambil_data') ?>",
      cache: false,
    });

    $("#cabang1").change(function(){

      var value     = $(this).val();
      var id_kanwil = $("#kanwil1").val();

      if (value != null) {
        $.ajax({
          data:{modul:'kanwil', id:value, id_kanwil:id_kanwil},
          success: function(respond){
            $("#kanwil1").html(respond);
          }
        })
      }
    })
  })
</script>

<script>
  $(function () {
    $.ajaxSetup({
      type: "POST",
      url: "<?= base_url('report/ambil_data') ?>",
      cache: false,
    });

    $(".cabang1").change(function(){

      var cab   = $(this).val();
      var kan   = document.getElementById("kanwil1").value;  
      var id_ao = $('#ao1').val();

      if (cab != null && kan != null) {
        $.ajax({
          data:{modul:'ao', id:cab, kanwil:kan, id_ao:id_ao},
          success: function(respond){
            $("#ao1").html(respond);
          }
        })
      }
    })
  })
</script>

<script>
     $(function () {
        // $('.table').DataTable();
        $('.table2').DataTable({
        	// order: [[ 0, "asc" ]],
        	pageLength			: 25,
        	scrollY				:"500px",
        	scrollCollapse		: false,
			ordering 			: false
        })
        $('.select2').select2()
    });
</script>

<script type="text/javascript">
	function b() {
		var x = document.getElementById('tab');

		if (x.hasAttribute("target")) {
			x.setAttribute("target", "_self");
		}
	}
</script>

<?php $a=array(); foreach ($result_segmen as $h) : ?>
		<?php array_push($a, $h['segmen'])  ?>
<?php endforeach ?>
