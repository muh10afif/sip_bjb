<div class="row">
    <div class="col-md-6">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h1 class="box-title">Bar chart</h1>
            </div>
            <div class="box-body">
                <canvas id="myChart11"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h1 class="box-title">Pie Chart</h1>
            </div>
            <div class="box-body">
                <canvas id="myChart12"></canvas>
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
        $('#wo_ao').DataTable({
            order: [[ 0, "asc" ]],
            pageLength: 25,
            scrollY:"500px",
            scrollCollapse: false
        })
        $('.select2').select2()
    });
</script>

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

<?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>

<?php $a=array(); foreach ($result_segmen as $h) : ?>
        <?php array_push($a, $h['segmen'])  ?>
<?php endforeach ?>

<script>
  var ctx = document.getElementById("myChart11").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: <?= json_encode($a) ?>,
          datasets: [
          <?php $result_monitoring = $this->db->query("SELECT DISTINCT monitoring FROM tr_monitoring WHERE monitoring != '' ORDER BY monitoring ASC")->result_array(); ?>

          <?php foreach ($result_monitoring as $m) : ?>
        
          {
              label: "<?= $b = $m['monitoring'] ?>",
              data: [ 

              <?php for($i=0; $i < count($a); $i++): ?>
                  <?php $result = $this->db->query("SELECT COUNT(a.deal_reff) AS total_kelolaan FROM tr_kelolaan a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN tr_monitoring c ON (c.deal_reff = b.deal_reff) WHERE b.segmen = '$a[$i]' AND c.monitoring = '$b' AND b.jenis_debitur = 'npl'")->row(); ?>
                

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
                      userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                             if (Math.floor(label) === label) {
                                 return label;
                             }

                         }, 
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
  var ctx = document.getElementById("myChart12").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'polarArea',
      data: {
          labels: <?= json_encode($a) ?>,
          datasets: [
          <?php $result_monitoring = $this->db->query("SELECT DISTINCT monitoring FROM tr_monitoring WHERE monitoring != '' ORDER BY monitoring ASC")->result_array(); ?>

          <?php foreach ($result_monitoring as $m) : ?>
        
          {
              label: "<?= $b = $m['monitoring'] ?>",
              data: [ 

              <?php for($i=0; $i < count($a); $i++): ?>
                  <?php $result = $this->db->query("SELECT COUNT(a.deal_reff) AS total_kelolaan FROM tr_kelolaan a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN tr_monitoring c ON (c.deal_reff = b.deal_reff) WHERE b.segmen = '$a[$i]' AND c.monitoring = '$b' AND b.jenis_debitur = 'npl'")->row(); ?>
                

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