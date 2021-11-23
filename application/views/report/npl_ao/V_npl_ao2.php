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
				
				<!-- Membuat variabel kosong untuk menampung array -->
				<?php $segmen = array(); ?>

				<table class="table table-hover table-striped table-bordered " data-scroll-x="true" id="npl_ao" width="100%">
					<thead style="background-color: #e3e3fb">
						<tr>
							<?php if (empty($p_segmen)): ?>
								<?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>
							<?php else: ?>
								<?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur WHERE segmen = '$p_segmen'")->result_array(); ?>
							<?php endif ?>
							
							<th style="display: none;"></th>
							<th width="350px"></th>
								<?php foreach($result_segmen as $item):
										array_push($segmen, $item['segmen']); ?>
										<th> <?= $item['segmen'] ?> </th>
								<?php endforeach ?>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

						<?php $kwl = $this->session->userdata('kanwil'); 
						      $lvl = $this->session->userdata('level'); ?>

						<?php if ((!empty($kwl)) && ($lvl == 3)): ?>
						  <?php $result_kanwil = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur WHERE kanwil = '$kwl'")->result_array();?>
						<?php else: ?>

						  <?php if (empty($p_kanwil)): ?>
						    <?php $result_kanwil = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur ORDER BY kanwil ASC")->result_array();?>
						  <?php else: ?>
						    <?php $result_kanwil = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur WHERE kanwil = '$p_kanwil'")->result_array();?>
						  <?php endif ?>

						<?php endif ?>
						
						<?php foreach($result_kanwil as $kanwil): ?>
						<tr>
							<?php $total = 0 ?>
							<td style="display: none;"> <?= $a = strtoupper($kanwil['kanwil']) ?> </td>
							<td style="text-align: left; font-weight: bold;"><?= $a = strtoupper($kanwil['kanwil']) ?></td>
							<?php for($i=0; $i < count($segmen); $i++): ?>

								<?php 

									// $this->db->where('segmen', $segmen[$i]);
									// $this->db->where('kanwil', $a);
									
									// $result = $this->db->get('report_kanwil')->row_array();

				                //   $this->db->select('count(a.deal_reff) as total_kelolaan');
				                //   $this->db->from('tr_kelolaan as a');
				                //   $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
				                // //   $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
				                //   $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
				                //   $this->db->where('b.segmen', $segmen[$i]);
				                //   $this->db->where('b.kanwil', $a);
				                //   $this->db->where('b.jenis_debitur', 'npl');
								//   $this->db->where('a.stat', 1);

				            	// if (!empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_kol) ) {
				                    
				                //       if (!empty($p_kol)) {
				                //           $this->db->where('b.kolektibilitas', $p_kol);
				                //       }
				                //       if (!empty($p_segmen)) {
				                //           $this->db->where('b.segmen', $p_segmen);
				                //       }
								// 		if (!empty($p_kanwil)) {
								// 			$this->db->where('b.kanwil', $p_kanwil);
								// 		}
				                //       if (!empty($p_cabang)) {
				                //           $this->db->where('b.cabang_induk', $p_cabang);
				                //       }
				                //       if (!empty($p_ao)) {
				                //           $this->db->where('e.reg_employee', $p_ao);
				                //       }
				                      
				                //   }

				                //   $result = $this->db->get()->row();

				                ?>

								<td align="right"> 
									<!-- <?= ($result['total_kelolaan'] == null) ? 0 : $result['total_kelolaan']; ?> -->
								</td>
								<!-- <?php $total += $result['total_kelolaan']; ?> -->
							<?php endfor ?>
							<td align="right">
							<!-- <?= $total ?> -->
							</td>
						</tr>
							<?php if (empty($p_cabang)): ?>
								<?php $result_cabang = $this->db->query("SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$a'")->result_array(); ?>
							<?php else: ?>
								<?php $result_cabang = $this->db->query("SELECT DISTINCT cabang_induk FROM m_debitur WHERE kanwil = '$a' AND cabang_induk = '$p_cabang'")->result_array(); ?>
							<?php endif ?>

							
							<?php foreach($result_cabang as $cabang): ?>
							<tr>
								<?php $total = 0 ?>
								<td style="display: none;"><?= $a ?></td>
								<td style="padding-left: 30px"><?= $b = $cabang['cabang_induk'] ?> </td>
								<?php for($j=0; $j < count($segmen); $j++): ?>

									<?php 

					                //   $this->db->select('count(a.deal_reff) as total_kelolaan');
					                //   $this->db->from('tr_kelolaan as a');
					                //   $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
					                // //   $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
					                //   $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
					                //   $this->db->where('b.segmen', $segmen[$j]);
					                //   $this->db->where('b.kanwil', $a);
					                //   $this->db->where('b.cabang_induk', $b);
					                //   $this->db->where('b.jenis_debitur', 'npl');
									//   $this->db->where('a.stat', 1);

					            	// if (!empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_kol) ) {
					                    
					                //       if (!empty($p_kol)) {
					                //           $this->db->where('b.kolektibilitas', $p_kol);
					                //       }
					                //       if (!empty($p_segmen)) {
					                //           $this->db->where('b.segmen', $p_segmen);
					                //       }
					                //       if (!empty($p_cabang)) {
					                //           $this->db->where('b.cabang_induk', $p_cabang);
					                //       }
					                //       if (!empty($p_ao)) {
					                //           $this->db->where('e.reg_employee', $p_ao);
					                //       }
					                      
					                //   }

					                //   $result = $this->db->get()->row();

									// $this->db->where('segmen', $segmen[$j]);
									// $this->db->where('kanwil', $a);
									// $this->db->where('cabang_induk', $b);
									
									// $result = $this->db->get('report_cabang')->row_array();

					                ?>

									<td align="right"> 
									<!-- <?= ($result['total_kelolaan'] == null) ? 0 : $result['total_kelolaan']; ?> -->
								</td>
								<!-- <?php $total += $result['total_kelolaan']; ?> -->
							<?php endfor ?>
							<td align="right">
							<!-- <?= $total ?> -->
							</td>
							</tr>
								<?php if (empty($p_ao)): ?>
									<?php $result_ao = $this->db->query("SELECT DISTINCT c.reg_employee, c.name FROM tr_kelolaan a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.cabang_induk = '$b'")->result_array(); ?>
								<?php else: ?>
									<?php $result_ao = $this->db->query("SELECT DISTINCT c.reg_employee, c.name FROM tr_kelolaan a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.cabang_induk = '$b' AND c.reg_employee = '$p_ao'")->result_array(); ?>
								<?php endif ?>
								

									<?php foreach($result_ao as $ao): ?>
									<tr>
										<?php $total = 0; $reg = $ao['reg_employee']?>
										<td style="display: none;"><?= $a ?></td>
										<td style="padding-left: 60px"> <?= $c = $ao['name'] ?> </td>
										<?php for($k=0; $k < count($segmen); $k++): ?>

											<?php 

							                //   $this->db->select('count(a.deal_reff) as total_kelolaan');
							                //   $this->db->from('tr_kelolaan as a');
							                //   $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
							                // //   $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
							                //   $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
							                //   $this->db->where('b.segmen', $segmen[$k]);
							                //   $this->db->where('b.kanwil', $a);
							                //   $this->db->where('b.cabang_induk', $b);
							                //   $this->db->where('e.reg_employee', $reg);
							                //   $this->db->where('b.jenis_debitur', 'npl');
											//   $this->db->where('a.stat', 1);


							            	// if (!empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_kol) ) {
							                    
							                //       if (!empty($p_kol)) {
							                //           $this->db->where('b.kolektibilitas', $p_kol);
							                //       }
							                //       if (!empty($p_segmen)) {
							                //           $this->db->where('b.segmen', $p_segmen);
							                //       }
							                //       if (!empty($p_cabang)) {
							                //           $this->db->where('b.cabang_induk', $p_cabang);
							                //       }
							                //       if (!empty($p_ao)) {
							                //           $this->db->where('e.reg_employee', $p_ao);
							                //       }
							                      
							                //   }

							                //   $result = $this->db->get()->row();

											// $result = $this->model_report->count_report($segmen[$k], $a, $b, $reg)->row_array();

							                // $this->db->where('segmen', $segmen[$k]);
											// $this->db->where('kanwil', $a);
											// $this->db->where('cabang_induk', $b);
											// $this->db->where('reg_employee', $reg);
											
											// $result = $this->db->get('report_ao')->row_array();

											?>

											<td align="right"> 
											<!-- <?= ($result['total_kelolaan'] == null) ? 0 : $result['total_kelolaan']; ?> -->
										</td>
										<!-- <?php $total += $result['total_kelolaan']; ?> -->
										<?php endfor ?>
										<td align="right">
										<!-- <?= $total ?> -->
										</td>
									</tr>
										<?php if (empty($p_kol)): ?>
											<?php $result_kol = $this->db->query("SELECT * FROM m_kolektibilitas WHERE id BETWEEN 3 AND 5")->result_array(); ?>
										<?php else: ?>
											<?php $result_kol = $this->db->query("SELECT * FROM m_kolektibilitas WHERE id = $p_kol ")->result_array(); ?>
										<?php endif ?>
										
										<?php foreach($result_kol as $kol): ?>
										<tr>
											<?php $total = 0; $id_kol = $kol['id']; ?>
											<td style="display: none;"><?= $a ?></td>
											<td style="padding-left: 90px"><?= $c = $kol['kolektibilitas'] ?> </td>
											<?php for($l=0; $l < count($segmen); $l++): ?>

												<?php 

								                //   $this->db->select('count(a.deal_reff) as total_kelolaan');
								                //   $this->db->from('tr_kelolaan as a');
								                //   $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
								                // //   $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
								                //   $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
								                //   $this->db->where('b.segmen', $segmen[$l]);
								                //   $this->db->where('b.kanwil', $a);
								                //   $this->db->where('b.cabang_induk', $b);
								                //   $this->db->where('e.reg_employee', $reg);
								                //   $this->db->where('b.kolektibilitas', $id_kol);
								                //   $this->db->where('b.jenis_debitur', 'npl');
												//   $this->db->where('a.stat', 1);

								            	// if (!empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_kol) ) {
								                    
								                //       if (!empty($p_kol)) {
								                //           $this->db->where('b.kolektibilitas', $p_kol);
								                //       }
								                //       if (!empty($p_segmen)) {
								                //           $this->db->where('b.segmen', $p_segmen);
								                //       }
								                //       if (!empty($p_cabang)) {
								                //           $this->db->where('b.cabang_induk', $p_cabang);
								                //       }
								                //       if (!empty($p_ao)) {
								                //           $this->db->where('e.reg_employee', $p_ao);
								                //       }
								                      
								                //   }

								                //   $result = $this->db->get()->row();

												// $result = $this->model_report->count_report($segmen[$l], $a, $b, $reg, $id_kol)->row_array();

								                // $this->db->where('segmen', $segmen[$l]);
												// $this->db->where('kanwil', $a);
												// $this->db->where('cabang_induk', $b);
												// $this->db->where('reg_employee', $reg);
												// $this->db->where('kolektibilitas', $id_kol);
												
												// $result = $this->db->get('report_kolek')->row_array();

												?>

												<td align="right"> 
												<!-- <?= ($result['total_kelolaan'] == null) ? 0 : $result['total_kelolaan']; ?> -->
											</td>
											<!-- <?php $total += $result['total_kelolaan']; ?> -->
											<?php endfor ?>
											<td align="right">
											<!-- <?= $total ?> -->
											</td>
										</tr>
									<?php endforeach ?>
								<?php endforeach ?>
							<?php endforeach ?>
						<?php endforeach ?>
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/utils.js'); ?>"></script>

<script>
     $(function () {
        $('#npl_ao2').DataTable({
        	// order: [[ 0, "asc" ]],
        	pageLength			: 25,
        	scrollY				:"500px",
        	scrollCollapse		: false,
			ordering 			: false
        })
        $('.select2').select2()
    });
</script>