<div class="box-body table-responsive">
    <h4>Report Monitoring Kelolaan NPL AO PPK</h4>
  
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
        
    </table>
    <!-- Membuat variabel kosong untuk menampung array -->
    <?php $segmen = array(); ?>

    <table border="1" id="npl_ao" width="100%" align="center">
        <thead style="background-color: #e3e3fb">
          <tr>
            <?php if (empty($p_segmen)): ?>
              <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur")->result_array(); ?>
            <?php else: ?>
              <?php $result_segmen = $this->db->query("SELECT DISTINCT segmen FROM m_debitur WHERE segmen = '$p_segmen'")->result_array(); ?>
            <?php endif ?>
            
            <!-- <th style="display: none;"></th> -->
            <th width="350px"></th>
              <?php foreach($result_segmen as $item):
                  array_push($segmen, $item['segmen']); ?>
                  <th> <?= $item['segmen'] ?> </th>
              <?php endforeach ?>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $l): ?>
          <tr>
            <td><?= nbs($l['urutan']) ?><?= $l['nama'] ?></td>
            <?php foreach($result_segmen as $item): $a1 = str_replace(" ", "_", $item['segmen']); ?>
                <td align="right"> <?php $a2 = str_replace("&", "dan", $a1); ?> <?= number_format($l[$a2],0,'.','.') ?> </td>
            <?php endforeach ?>
            <td align="right"><?= number_format($l['total'],0,'.','.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
</div>