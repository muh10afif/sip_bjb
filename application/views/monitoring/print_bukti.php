<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <style>
            body {
                color: black;
                font-family: calibri;
                margin: 0;
            }

            @media print {
              @page { margin: 0; size: A4; }
              body { margin: 0.7cm; }
            }

            body {
                margin: 50px;
            }
        </style>
    </head>
    <body>
        <center><img width="120" height="70" src="<?php echo base_url()?>assets/images/bjb.png"></center>
        <center><span style="font-weight: bold; text-decoration: underline;">BUKTI KUNJUNGAN</span></center>
        <?= br(2) ?>
        <p style="text-align: justify;"><?= nbs(5) ?>Pada hari ini, <?= tgl_ind($data_deb['waktu_kunjungan']) ?> telah dilakukan kunjungan petugas bank bjb <?php $a = strtolower($data_deb['cabang_ao']); echo  ucwords($a) ?>.</p>
        <ul type="disc">
            <table>
            <tr>
                <td><li>Nama <?= nbs(5) ?>:<?= nbs(5); echo $data_deb['name'] ?></li></td>
            </tr>
            </table>
        </ul>
        <p>Data identitas Debitur yang dikunjungi :</p>

        <?php if ($jenis == 'npl'): ?>

            <ul type="disc">
                <table>
                <tr>
                    <td width="150"><li>Nama</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['nama'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Alamat</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['alamat'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Cabang Induk</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['cabang_induk'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Kantor</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['kantor'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Segmen</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['segmen'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Loan Type</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['loan_type'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Deal Refference</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['deal_reff'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Jangka Waktu</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= date('d F Y' ,strtotime($data_deb['start_date'])) ?> sd. <?= date('d F Y' ,strtotime($data_deb['mat_date'])) ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Plafond</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($data_deb['plafond'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Outstanding</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($data_deb['outstanding'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Kolektibilitas</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['kolektibilitas'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>DPD</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['dpd'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Tunggakan Pokok</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($a = $data_deb['tunggakan_pokok'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Tunggakan Bunga</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($b = $data_deb['tunggakan_bunga'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Denda</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($c = $data_deb['denda'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Total Tunggakan</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?php $tt = $a+$b+$c; echo number_format($tt,'0','.','.') ?></td>
                </tr>
                </table>
            </ul>

        <?php else: ?>

            <ul type="disc">
                <table>
                <tr>
                    <td width="150"><li>Nama</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['nama'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Alamat</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['alamat'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Cabang Induk</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['cabang_induk'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Kantor</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['kantor'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Segmen</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['segmen'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Loan Type</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['loan_type'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Deal Refference</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= $data_deb['deal_reff'] ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Jangka Waktu</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td><?= tgl_indo($data_deb['start_date']) ?> sd. <?= tgl_indo($data_deb['mat_date']) ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Plafond</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($data_deb['plafond'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Outstanding</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($data_deb['outstanding'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Bunga</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?php 
                    $bg = ($data_deb['bunga_lapor'] + $data_deb['bunga_ekstra']);
                    echo $j = number_format($bg,'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Denda</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?= number_format($e = $data_deb['denda'],'0','.','.') ?></td>
                </tr>
                <tr>
                    <td width="150"><li>Total Kewajiban</li></td>
                    <td>:<?= nbs(5) ?></td>
                    <td>Rp. <?php $tw = $bg+$e; echo number_format($tw,'0','.','.') ?></td>
                </tr>
                </table>
            </ul>
            
        <?php endif ?>
        <?= br() ?>
        <p>Hasil Kunjungan :</p>
        <ul type="disc">
            <table>
            <tr>
                <td><li>Kondisi Usaha Saat Ini <br> <?= nbs(4) ?><?= $data_deb['kondisi_usaha'] ?>.</li></td>
            </tr><br>
            <tr>
                <td><li>Komitmen <br><?= nbs(4) ?> <?= $data_deb['auto_text'] ?>. <br> <?= $data_deb['free_text'] ?></li></td>
            </tr>
        </table>
            
        </ul><?= br(2) ?>

        <?php $tgl = substr($data_deb['waktu_kunjungan'], 0, 10) ?>

        <table width="100%">
            <tr>
                <td></td>
                <td></td>
                <td align="center" style="margin: 5px;">Bandung, <?= tgl_indo($tgl) ?></td>
            </tr>
            <tr>
                <td align="center">Yang Menerima Kunjungan</td>
                <td width="150"></td>
                <td align="center">Yang Melaksanakan Kunjungan</td>
            </tr>
            <tr>
                <td height="100" align="center">
                    <img width="120" height="70" src="<?= base_url('assets/images/ttd_deb.png') ?>"></td>
                <td></td>
                <td align="center">
                    <img width="120" height="70" src="<?= base_url('assets/images/ttd_ao.png') ?>"></td>
                </td>
            </tr>
            <tr>
                <td align="center">( <?= $data_deb['nama'] ?> )</td>
                <td></td>
                <td align="center">( <?= $data_deb['name'] ?> )</td>
            </tr>
        </table>

        <script type="text/javascript">
            window.print();
        </script>

    </body>
</html>