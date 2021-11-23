<div class="box-body table-responsive">
    <h4>Report Nominatif Monitoring  Komitmen Debitur <?= strtoupper($jenis) ?></h4>
  
    <table class="a">
      <?php if (!empty($p_segmen)): ?>
        <tr>
          <td width="150px">Segmen</td>
          <td>:</td>
          <td><?= $p_segmen ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_cabang)): ?>
        <tr>
          <td width="150px">Cabang</td>
          <td>:</td>
          <td><?= $p_cabang ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_kanwil)): ?>
        <tr>
          <td width="150px">Kanwil</td>
          <td>:</td>
          <td><?= $p_kanwil ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($nama_ao)): ?>
        <tr>
          <td width="150px">AO</td>
          <td>:</td>
          <td><?= $nama_ao ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($nama_kol)): ?>
        <tr>
          <td width="150px">Kolektibilitas</td>
          <td>:</td>
          <td><?= $nama_kol ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_debitur)): ?>
        <tr>
          <td width="150px">Debitur</td>
          <td>:</td>
          <td><?= $p_debitur ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_bulan)): ?>
        <tr>
          <td width="150px">Bulan</td>
          <td>:</td>
          <td><?= bln_indo($p_bulan) ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_komitmen)): ?>
        <tr>
          <td width="150px">Komitmen</td>
          <td>:</td>
          <td><?= $p_komitmen ?></td>
        </tr>
      <?php endif ?>
      <?php if (!empty($p_monitoring)): ?>
        <tr>
          <td width="150px">Jenis Monitoring</td>
          <td>:</td>
          <td><?= $p_monitoring ?></td>
        </tr>
      <?php endif ?>
        
    </table>

  <table border="1" id="potensi" width="100%">
    <thead style="background-color: #e3e3fb">
    	<tr>
    		<th>No</th>
    		<th>Kanwil</th>
    		<th>Cabang</th>
    		<th>Kantor</th>
    		<?php if ($jenis == 'wo'): ?>
    			<th>Status</th>
    		<?php endif ?>
    		<?php if ($jenis == 'npl'): ?>
    			<th>Kolektibilitas</th>
    		<?php endif ?>
    		<th>Segmen</th>
    		<th>Deal Type</th>
    		<th>Deal Refference</th>
    		<th>Nama Debitur</th>
        <th>Jenis Monitoring</th>
        <th>Komitmen</th>
    		<th>Tanggal Komitmen / Janji Bayar</th>
    		<th>Nominal</th>
    		<th>Nama AO PPK</th>
    	</tr>
    </thead>
    <tbody>
      <?php if (!empty($report_detail->result_array()) ): ?>

        <?php $no=1; foreach ($report_detail->result_array() as $r): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['kanwil'] ?></td>
            <td><?= $r['cabang_induk'] ?></td>
            <td><?= $r['kantor'] ?></td>
            <?php if ($jenis == 'wo'): ?>
              <td><?= strtoupper($r['jenis_debitur']) ?></td>
            <?php endif ?>
            <?php if ($jenis == 'npl'): ?>
              <td><?= $r['kolektibilitas'] ?></td>
            <?php endif ?>
            <td><?= $r['segmen'] ?></td>
            <td><?= $r['loan_type'] ?></td>
            <td><?= $r['deal_reff'] ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['monitoring'] ?></td>
            <td><?= $r['komitmen'] ?></td>
            <td><?= tgl_indo(date('Y-m-d', strtotime($r['tgl_komitmen']))) ?></td>
            <td align="right"><?= number_format($r['nominal'],'0','.','.') ?></td>
            <td><?= $r['name'] ?></td>
          </tr>
        <?php endforeach ?>

      <?php else: ?>
          <tr>
            <td colspan="14" align="center">Data Tidak Ada</td>
          </tr>
      <?php endif ?>
    	
    </tbody>
  </table>
</div>
