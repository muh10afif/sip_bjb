  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style type="text/css">
  tr th {
    text-align: center;
  }
  #monitoring thead tr th {
    vertical-align: middle;
  }
  .kol .select2 {
    margin-top: 10px;
  }
  .ao .select2 {
    margin-top: 10px;
  }
  .ao .date {
    margin-top: 10px;
  }
</style>
<div class="row">

    <div class="col-md-3">
        <a href="<?= base_url('report/monitoring/npl') ?>"><button class="btn <?= ($jenis == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($jenis == 'npl') ? "<i class='fa fa-circle'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('report/monitoring/wo') ?>"><button class="btn <?= ($jenis == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($jenis == 'wo') ? "<i class='fa fa-circle'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>

</div><br>
<div class="row">
        <div class="col-md-12">

        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                  <h1 class="box-title"><i class="fa fa-filter"></i><?= nbs(3) ?>Filter Data</h1>
             </div>

        <form method="POST" target="_self" id="tab" action="<?= base_url('report/monitoring') ?>">
            <input type="hidden" name="jenis_deb" value="<?= $jenis ?>">
            <div class="box-body text-center" style="background-color: white;">
            
            <div class="col-md-12">
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
                    <select class="form-control select2 ao" name="ao" id="ao1" style="width: 100%;">
                      <option value="">-- Pilih AO --</option>
                      <?php foreach ($d_ao->result_array() as $o): ?>
                        <option value="<?= $o['reg_employee'] ?>" <?= ($p_ao == $o['reg_employee']) ? 'selected' : '' ?>><?= $o['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4 ao">
                  <select class="form-control select2 ao" name="monitoring" id="ao1" style="width: 100%;">
                    <option value="">-- Pilih Jenis Monitoring --</option>
                    <?php foreach ($d_monitoring->result_array() as $o): ?>
                      <option value="<?= $o['monitoring'] ?>" <?= ($p_monitoring == $o['monitoring']) ? 'selected' : '' ?>><?= $o['monitoring'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-md-4 ao">
                   <select class="form-control select2" name="segmen" style="width: 100%;">
                      <option value="">-- Pilih Segmen --</option>
                      <?php foreach ($header->result_array() as $h): ?>
                        <option value="<?= $h['segmen'] ?>" <?= ($p_segmen == $h['segmen']) ? 'selected' : '' ?>><?= $h['segmen'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-4 ao">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="bulan" class="form-control pull-right" value="<?= ($p_bulan != null) ? $p_bulan : '' ?>" id="datepicker3" placeholder="-- Pilih Bulan dan Tahun --">
                  </div>
                </div>
            </div>
            <div class="col-md-12">
               
                <div class="col-md-4 ao">
                   <select class="form-control select2" name="komitmen" style="width: 100%;">
                      <option value="">-- Pilih Komitmen --</option>
                      <?php foreach ($d_komitmen->result_array() as $h): ?>
                        <option value="<?= $h['komitmen'] ?>" <?= ($p_komitmen == $h['komitmen']) ? 'selected' : '' ?>><?= $h['komitmen'] ?></option>
                      <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-4 ao">
                  <select class="form-control select2 kol" name="jns" style="width: 100%;">
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
                    <a href="<?= base_url("report/monitoring/$jenis") ?>"><button class="btn btn-success" type="button" style="margin-top: 5px"><i class="fa fa-bars"></i><?= nbs(2) ?>Tampilkan Semua</button></a><?= nbs(3) ?>
                    <button class="btn btn-warning" onclick="a()" name="unduh" style="margin-top: 5px"><i class="fa fa-download"></i><?= nbs(2) ?>Unduh Report</button>
                </div>
            </div>
            </form>
        </div>
     </div>
    </div>
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h1 class="box-title">Report Monitoring Komitmen Debitur - Jenis Debitur <?= strtoupper($jenis) ?></h1>
      </div>
      <div class="box-body">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h1 class="box-title">Report Monitoring Komitmen Debitur - Jenis Debitur <?= strtoupper($jenis) ?></h1>
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
        <h1 class="box-title">Report Monitoring Komitmen Debitur - Jenis Debitur <?= strtoupper($jenis) ?></h1>
      </div>
      <div class="box-body table-responsive">
        
        <!-- Membuat variabel kosong untuk menampung array -->
        <?php $segmen = array(); ?>

        <table class="table table-hover table-striped table-bordered" id="monitoring">
          <thead style="background-color: #e3e3fb">
            <tr>

              <?php if (empty($p_segmen)): ?>
                <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>
              <?php else: ?>
                <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur WHERE segmen = '$p_segmen'")->result_array(); ?>
              <?php endif ?>
              
              <th style="display: none;"></th>
              <th width="200px"></th>
                <?php foreach($result_segmen as $item):
                    array_push($segmen, $item['segmen']); ?>
                    <th> <?= $item['segmen'] ?> </th>
                <?php endforeach ?>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            
            <?php if (empty($p_monitoring)): ?>
                <?php $result_monitoring = $this->db->query("SELECT DISTINCT monitoring FROM tr_monitoring WHERE monitoring != '' ORDER BY monitoring ASC")->result_array(); ?>
            <?php else: ?>
                <?php $result_monitoring = $this->db->query("SELECT DISTINCT monitoring FROM tr_monitoring WHERE monitoring = '$p_monitoring'")->result_array(); ?>
            <?php endif ?>
            

            <?php foreach($result_monitoring as $monitoring): ?>
            <tr>
              <?php $total = 0 ?>
              <td style="display: none;"> <?= $a = strtoupper($monitoring['monitoring']) ?> </td>
              <td style="text-align: left; font-weight: bold;"><?= $a = strtoupper($monitoring['monitoring']) ?></td>
              <?php for($i=0; $i < count($segmen); $i++): ?>
                <?php 

                  $this->db->select('count(a.deal_reff) as total_kelolaan');
                  $this->db->from('tr_kelolaan as a');
                  $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
                  $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
                  $this->db->join('m_employee as e', 'e.reg_employee = c.reg_employee', 'inner');
                  $this->db->where('b.segmen', $segmen[$i]);
                  $this->db->where('c.monitoring', $a);
                  $this->db->where('b.jenis_debitur', $jenis);
                  $this->db->where('a.stat', 1);

                  $kwl = $this->session->userdata('kanwil'); 
                  $lvl = $this->session->userdata('level');

                  if ((!empty($kwl)) && ($lvl == 3)) {
                      $this->db->where('b.kanwil', $kwl);
                  } else {
                      if (!empty($p_kanwil)) {
                          $this->db->where('b.kanwil', $p_kanwil);
                      } 
                  }

            if (!empty($p_bulan) || !empty($p_monitoring) || !empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_debitur) || !empty($p_komitmen) ) {
                    
                      if (!empty($p_bulan)) {
                          $this->db->where("c.tgl_komitmen LIKE '%$p_bulan%' ");
                      }
                      if (!empty($p_segmen)) {
                          $this->db->where('b.segmen', $p_segmen);
                      }
                      if (!empty($p_monitoring)) {
                          $this->db->where('c.monitoring', $p_monitoring);
                      }
                      if (!empty($p_cabang)) {
                          $this->db->where('b.cabang_induk', $p_cabang);
                      }
                      if (!empty($p_ao)) {
                          $this->db->where('e.reg_employee', $p_ao);
                      }
                      if (!empty($p_debitur)) {
                          $this->db->where('b.nama', $p_debitur);
                      }
                      if (!empty($p_komitmen)) {
                          $this->db->where('c.komitmen', $p_komitmen);
                      }
                      
                  }

                  $result = $this->db->get()->row();

                ?>

                <td align="right"> <?= ($result->total_kelolaan == null) ? 0 : $result->total_kelolaan; ?> </td>
                <?php $total += $result->total_kelolaan; ?>
              <?php endfor ?>
              <td align="right"><?= $total ?> </td>
            </tr>
              <?php if (empty($p_komitmen)): ?>
                  <?php $result_komitmen = $this->db->query("SELECT DISTINCT komitmen FROM tr_monitoring WHERE monitoring = '$a'")->result_array(); ?>
              <?php else: ?>
                  <?php $result_komitmen = $this->db->query("SELECT DISTINCT komitmen FROM tr_monitoring WHERE monitoring = '$a' AND komitmen = '$p_komitmen'")->result_array(); ?>
              <?php endif ?>
              
              <?php foreach($result_komitmen as $komitmen): ?>
              <tr>
                <?php $total = 0 ?>
                <td style="display: none;"><?= $a ?></td>
                <td> <?= nbs(3); ?> <?= $b = $komitmen['komitmen'] ?> </td>
                <?php for($j=0; $j < count($segmen); $j++): ?>
                  <?php 

                    $this->db->select('count(a.deal_reff) as total_kelolaan');
                    $this->db->from('tr_kelolaan as a');
                    $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
                    $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
                    $this->db->join('m_employee as e', 'e.reg_employee = c.reg_employee', 'inner');
                    $this->db->where('b.segmen', $segmen[$j]);
                    $this->db->where('c.monitoring', $a);
                    $this->db->where('c.komitmen', $b);
                    $this->db->where('b.jenis_debitur', $jenis);
                    $this->db->where('a.stat', 1);

                    $kwl = $this->session->userdata('kanwil'); 
                    $lvl = $this->session->userdata('level');

                    if ((!empty($kwl)) && ($lvl == 3)) {
                        $this->db->where('b.kanwil', $kwl);
                    } else {
                        if (!empty($p_kanwil)) {
                            $this->db->where('b.kanwil', $p_kanwil);
                        } 
                    }

                if (!empty($p_bulan) || !empty($p_monitoring) || !empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_debitur) || !empty($p_komitmen) ) {
                    
                        if (!empty($p_bulan)) {
                            $this->db->where("c.tgl_komitmen LIKE '%$p_bulan%' ");
                        }
                        if (!empty($p_segmen)) {
                            $this->db->where('b.segmen', $p_segmen);
                        }
                        if (!empty($p_monitoring)) {
                            $this->db->where('c.monitoring', $p_monitoring);
                        }
                        if (!empty($p_cabang)) {
                            $this->db->where('b.cabang_induk', $p_cabang);
                        }
                        if (!empty($p_ao)) {
                            $this->db->where('e.reg_employee', $p_ao);
                        }
                        if (!empty($p_debitur)) {
                            $this->db->where('b.nama', $p_debitur);
                        }
                        if (!empty($p_komitmen)) {
                            $this->db->where('c.komitmen', $p_komitmen);
                        }
                        
                    }

                    $result = $this->db->get()->row();

                  ?>
                  
                  <td align="right"> <?= ($result->total_kelolaan == null) ? 0 : $result->total_kelolaan; ?> </td>
                  <?php $total += $result->total_kelolaan; ?>
                <?php endfor ?>
                <td align="right"><?= $total ?> </td>
              </tr>
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
<!-- bootstrap datepicker -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('assets/js/Chart.js'); ?>"></script>

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
        $('#monitoring').DataTable({
          //order: [[ 0, "asc" ]],
          pageLength      : 25,
          ordering 		    : false
        })
        $('.select2').select2()
        $('#datepicker3').datepicker({
          format: 'yyyy-mm',
          autoclose: true,
          viewMode: "months", 
          minViewMode: "months"
        })
    });
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

<?php $a=array(); foreach ($result_segmen as $h) : ?>
    <?php array_push($a, $h['segmen'])  ?>
<?php endforeach ?>

<script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($a) ?>,
                datasets: [

                <?php foreach ($result_monitoring as $m) : ?>
              
                {
                    label: "<?= $b = $m['monitoring'] ?>",
                    data: [ 

                    <?php for($i=0; $i < count($a); $i++): ?>
                      
                    <?php 
                        $this->db->select('count(a.deal_reff) as total_kelolaan');
                        $this->db->from('tr_kelolaan as a');
                        $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
                        $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
                        $this->db->join('m_employee as e', 'e.reg_employee = c.reg_employee', 'inner');
                        $this->db->where('b.segmen', $a[$i]);
                        $this->db->where('c.monitoring', $b);
                        $this->db->where('b.jenis_debitur', $jenis);
                        $this->db->where('a.stat', 1);

                        if (!empty($p_bulan) || !empty($p_monitoring || !empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_debitur) || !empty($p_komitmen))) {
                        
                            if (!empty($p_bulan)) {
                                $this->db->where("c.tgl_komitmen LIKE '%$p_bulan%' ");
                            }
                            if (!empty($p_segmen)) {
                                $this->db->where('b.segmen', $p_segmen);
                            }
                            if (!empty($p_monitoring)) {
                                $this->db->where('c.monitoring', $p_monitoring);
                            }
                            if (!empty($p_kanwil)) {
                                $this->db->where('b.kanwil', $p_kanwil);
                            }
                            if (!empty($p_cabang)) {
                                $this->db->where('b.cabang_induk', $p_cabang);
                            }
                            if (!empty($p_ao)) {
                                $this->db->where('e.reg_employee', $p_ao);
                            }
                            if (!empty($p_debitur)) {
                                $this->db->where('b.nama', $p_debitur);
                            }
                            if (!empty($p_komitmen)) {
                                $this->db->where('c.komitmen', $p_komitmen);
                            }
                            
                        }

                        $result = $this->db->get()->row();

                      ?>

                      <?= ($result->total_kelolaan == null) ? 0 : $result->total_kelolaan; ?>,

                      
                    <?php endfor ?>

                          ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                },

              <?php endforeach ?>
                ],
                
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 8
                        }
                    }]
                }
            }
        });
    </script>

<script>
  var ctx = document.getElementById("myChart2").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'polarArea',
      data: {
          labels: <?= json_encode($a) ?>,
          datasets: [

          <?php foreach ($result_monitoring as $m) : ?>
        
          {
              label: "<?= $b = $m['monitoring'] ?>",
              data: [ 

              <?php for($i=0; $i < count($a); $i++): ?>
                <?php 
                    $this->db->select('count(a.deal_reff) as total_kelolaan');
                    $this->db->from('tr_kelolaan as a');
                    $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
                    $this->db->join('tr_monitoring as c', 'c.deal_reff = b.deal_reff', 'inner');
                    $this->db->join('m_employee as e', 'e.reg_employee = c.reg_employee', 'inner');
                    $this->db->where('b.segmen', $a[$i]);
                    $this->db->where('c.monitoring', $b);
                    $this->db->where('b.jenis_debitur', $jenis);
                    $this->db->where('a.stat', 1);

                    if (!empty($p_bulan) || !empty($p_monitoring || !empty($p_segmen) || !empty($p_kanwil) || !empty($p_cabang) || !empty($p_ao) || !empty($p_debitur) || !empty($p_komitmen))) {
                    
                        if (!empty($p_bulan)) {
                            $this->db->where("c.tgl_komitmen LIKE '%$p_bulan%' ");
                        }
                        if (!empty($p_segmen)) {
                            $this->db->where('b.segmen', $p_segmen);
                        }
                        if (!empty($p_monitoring)) {
                            $this->db->where('c.monitoring', $p_monitoring);
                        }
                        if (!empty($p_kanwil)) {
                            $this->db->where('b.kanwil', $p_kanwil);
                        }
                        if (!empty($p_cabang)) {
                            $this->db->where('b.cabang_induk', $p_cabang);
                        }
                        if (!empty($p_ao)) {
                            $this->db->where('e.reg_employee', $p_ao);
                        }
                        if (!empty($p_debitur)) {
                            $this->db->where('b.nama', $p_debitur);
                        }
                        if (!empty($p_komitmen)) {
                            $this->db->where('c.komitmen', $p_komitmen);
                        }
                        
                    }

                    $result = $this->db->get()->row();

                  ?>
                

                <?= ($result->total_kelolaan == null) ? 0 : $result->total_kelolaan; ?>,
              <?php endfor ?>

                    ],
              backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              ],
              borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              ],
              borderWidth: 1
          },

        <?php endforeach ?>
          ],
          
      },
      options: {
          scales: {
              
          }
      }
  });
</script>


    