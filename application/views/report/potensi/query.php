 <div class="col-md-3">
    <select class="form-control select2" name="debitur" style="width: 100%;">
      <option value="">-- Pilih Debitur --</option>
      <?php foreach ($debitur->result_array() as $d): ?>
          <option value="<?= $d['nama'] ?>" <?= ($p_debitur == $d['nama']) ? 'selected' : '' ?>><?= $d['nama'] ?></option>
      <?php endforeach ?>
    </select>
</div>




<table class="table table-hover table-striped table-bordered " data-scroll-x="true" id="potensi" width="100%">
  <thead style="background-color: #e3e3fb">
    <tr>
      <?php if (empty($p_segmen)): ?>
        <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>
      <?php else: ?>
        <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur WHERE segmen = '$p_segmen'")->result_array(); ?>
      <?php endif ?>
      
      <th style="display: none;"></th>
      <th width="250px"></th>
        <?php foreach($result_segmen as $item):
            array_push($segmen, $item['segmen']); ?>
            <th> <?= $item['segmen'] ?> </th>
        <?php endforeach ?>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($p_kanwil)): ?>
      <?php $result_kanwil = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur ORDER BY kanwil ASC")->result_array();?>
    <?php else: ?>
      <?php $result_kanwil = $this->db->query("SELECT DISTINCT kanwil FROM m_debitur WHERE kanwil = '$p_kanwil'")->result_array();?>
    <?php endif ?>
    
    <?php foreach($result_kanwil as $kanwil): ?>
    <tr>
      <?php $total = 0 ?>
      <td style="display: none;"> <?= $a = strtoupper($kanwil['kanwil']) ?> </td>
      <td style="text-align: left; font-weight: bold;"><?= $a = strtoupper($kanwil['kanwil']) ?></td>
      <?php for($i=0; $i < count($segmen); $i++): ?>
      
      <!-- filter bulan -->
      <?php if (!empty($p_bulan)): ?>

      <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$a' AND b.jenis_debitur = '$jenis' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

      <!-- filter segmen -->
      <?php elseif (!empty($p_segmen)): ?>

      <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$a' AND b.jenis_debitur = '$jenis'")->row(); ?>

      <!-- filter AO -->
      <?php elseif (!empty($p_ao)): ?>
              
        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$a' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' ")->row(); ?>
      
      <!-- filter kanwil dan cabang -->
      <?php elseif (!empty($p_kanwil) && !empty($p_cabang)): ?>

        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' ")->row(); ?>
      
      <!-- filter kanwil - cabang - AO -->
      <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao)): ?>

        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' ")->row(); ?>

      <!-- filter kanwil - cabang - AO - Bulan -->
      <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan)): ?>

        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' AND a.tgl_komitmen LIKE '%$p_bulan%' ")->row(); ?>

      <!-- filter kanwil - cabang - AO - Bulan - Segmen -->
      <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan) && !empty($p_segmen)): ?>

        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' AND a.tgl_komitmen LIKE '%$p_bulan%' ")->row(); ?>
      
      <!-- filter KOSONG -->
      <?php else: ?>

        <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$i]' AND b.kanwil = '$a' AND b.jenis_debitur = '$jenis'")->row(); ?>

      <?php endif ?>
        

        <td align="right">Rp. <?= ($result->total_kelolaan == null) ? 0 : number_format($result->total_kelolaan,'0','.','.'); ?> </td>
        <?php $total += $result->total_kelolaan; ?>
      <?php endfor ?>
      <td align="right">Rp. <?= number_format($total,'0','.','.') ?> </td>
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

          <!-- filter bulan -->
          <?php if (!empty($p_bulan)): ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$a' AND b.cabang_induk = '$b' AND b.jenis_debitur = '$jenis' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

          <!-- filter segmen -->
          <?php elseif (!empty($p_segmen)): ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$a' AND b.cabang_induk = '$b' AND b.jenis_debitur = '$jenis'")->row(); ?>

          <!-- filter AO -->
          <?php elseif (!empty($p_ao)): ?>
              
              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$a' AND b.cabang_induk = '$b' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' ")->row(); ?>

          <!-- filter kannwil dan cabang -->
          <?php elseif (!empty($p_kanwil) && !empty($p_cabang)): ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' ")->row(); ?>

          <!-- flter kanwil - cabang - AO -->
          <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao)): ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' ")->row(); ?>

          <!-- flter kanwil - cabang - AO - Bulan -->
          <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan)): ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

          <!-- flter kanwil - cabang - AO - Bulan - Segmen -->
          <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan) && !empty($p_segmen)): ?>

              -- <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$p_kanwil' AND b.cabang_induk = '$p_cabang' AND b.jenis_debitur = '$jenis' AND c.reg_employee = '$p_ao' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

          <!-- filter KOSONG -->
          <?php else: ?>

              <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE b.segmen = '$segmen[$j]' AND b.kanwil = '$a' AND b.cabang_induk = '$b' AND b.jenis_debitur = '$jenis'")->row(); ?>

          <?php endif ?>
          
          <td align="right">Rp. <?= ($result->total_kelolaan == null) ? 0 : number_format($result->total_kelolaan,'0','.','.'); ?> </td>
          <?php $total += $result->total_kelolaan; ?>
        <?php endfor ?>
        <td align="right">Rp. <?= number_format($total,'0','.','.') ?> </td>
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

              <!-- filter bulan -->
              <?php if (!empty($p_bulan)): ?>

                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$a'  AND b.cabang_induk = '$b' AND c.reg_employee = '$reg' AND b.jenis_debitur = '$jenis' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

              <!-- filter segmen -->
              <?php elseif (!empty($p_segmen)): ?>

                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$a'  AND b.cabang_induk = '$b' AND c.reg_employee = '$reg' AND b.jenis_debitur = '$jenis'")->row(); ?>

              <!-- filter AO -->
              <?php elseif (!empty($p_ao)): ?>
                  
                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$a'  AND b.cabang_induk = '$b' AND c.reg_employee = '$p_ao' AND b.jenis_debitur = '$jenis'")->row(); ?>

              <!-- filter kanwil dan cabang -->
              <?php elseif (!empty($p_kanwil) && !empty($p_cabang)): ?>
                  
                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$p_kanwil'  AND b.cabang_induk = '$p_cabang' AND c.reg_employee = '$reg' AND b.jenis_debitur = '$jenis'")->row(); ?>

              <!-- filter kanwil - cabang - AO-->
              <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao)): ?>
                  
                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$p_kanwil'  AND b.cabang_induk = '$p_cabang' AND c.reg_employee = '$p_ao' AND b.jenis_debitur = '$jenis'")->row(); ?>

              <!-- filter kanwil - cabang - AO - Bulan -->
              <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan)): ?>
                  
                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$p_kanwil'  AND b.cabang_induk = '$p_cabang' AND c.reg_employee = '$p_ao' AND b.jenis_debitur = '$jenis' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>

              <!-- filter kanwil - cabang - AO - Bulan - Segmen -->
              <?php elseif (!empty($p_kanwil) && !empty($p_cabang) && !empty($p_ao) && !empty($p_bulan) && !empty($p_segmen)): ?>
                  
                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$p_segmen' AND b.kanwil = '$p_kanwil'  AND b.cabang_induk = '$p_cabang' AND c.reg_employee = '$p_ao' AND b.jenis_debitur = '$jenis' AND a.tgl_komitmen LIKE '%$p_bulan%'")->row(); ?>
                  
              <!-- filter KOSONG -->
              <?php else: ?>

                  <?php $result = $this->db->query("SELECT SUM(a.nominal) AS total_kelolaan FROM tr_monitoring a JOIN m_debitur b ON (a.deal_reff = b.deal_reff) JOIN m_employee c ON (a.reg_employee = c.reg_employee) WHERE b.segmen = '$segmen[$k]' AND b.kanwil = '$a'  AND b.cabang_induk = '$b' AND c.reg_employee = '$reg' AND b.jenis_debitur = '$jenis'")->row(); ?>

              <?php endif ?>
              
              <td align="right">Rp. <?= ($result->total_kelolaan == null) ? 0 : number_format($result->total_kelolaan,'0','.','.'); ?> </td>
              <?php $total += $result->total_kelolaan; ?>
            <?php endfor ?>
            <td align="right">Rp. <?= number_format($total,'0','.','.') ?> </td>
          </tr>
            
        <?php endforeach ?>
      <?php endforeach ?>
    <?php endforeach ?>
  
  </tbody>
</table>