<?php if ($d_print == 'word'): ?>


    <?php

    $name = "Bukti_kunjungan_".$data_deb['deal_reff'].'_'.$jenis;

    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=$name.doc");
    ?>
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
            </style>
        </head>

<?php elseif ($d_print == 'print'): ?>

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

                  @-moz-document url-prefix() {}
                    .col-sm-1,
                    .col-sm-2,
                    .col-sm-3,
                    .col-sm-4,
                    .col-sm-5,
                    .col-sm-6,
                    .col-sm-7,
                    .col-sm-8,
                    .col-sm-9,
                    .col-sm-10,
                    .col-sm-11,
                    .col-sm-12,
                    .col-md-1,
                    .col-md-2,
                    .col-md-3,
                    .col-md-4,
                    .col-md-5,
                    .col-md-6,
                    .col-md-7,
                    .col-md-8,
                    .col-md-9,
                    .col-md-10,
                    .col-md-11,
                    .col-smdm-12 {
                        float: left;
                    }
                    .col-sm-12,
                    .col-md-12 {
                        width: 100%;
                    }
                    .col-sm-11,
                    .col-md-11 {
                        width: 91.66666667%;
                    }
                    .col-sm-10,
                    .col-md-10 {
                        width: 83.33333333%;
                    }
                    .col-sm-9,
                    .col-md-9 {
                        width: 75%;
                    }
                    .col-sm-8,
                    .col-md-8 {
                        width: 66.66666667%;
                    }
                    .col-sm-7,
                    .col-md-7 {
                        width: 58.33333333%;
                    }
                    .col-sm-6,
                    .col-md-6 {
                        width: 50%;
                    }
                    .col-sm-5,
                    .col-md-5 {
                        width: 41.66666667%;
                    }
                    .col-sm-4,
                    .col-md-4 {
                        width: 33.33333333%;
                    }
                    .col-sm-3,
                    .col-md-3 {
                        width: 25%;
                    }
                    .col-sm-2,
                    .col-md-2 {
                        width: 16.66666667%;
                    }
                    .col-sm-1,
                    .col-md-1 {
                        width: 8.33333333%;
                    }
                    .col-sm-pull-12 {
                        right: 100%;
                    }
                    .col-sm-pull-11 {
                        right: 91.66666667%;
                    }
                    .col-sm-pull-10 {
                        right: 83.33333333%;
                    }
                    .col-sm-pull-9 {
                        right: 75%;
                    }
                    .col-sm-pull-8 {
                        right: 66.66666667%;
                    }
                    .col-sm-pull-7 {
                        right: 58.33333333%;
                    }
                    .col-sm-pull-6 {
                        right: 50%;
                    }
                    .col-sm-pull-5 {
                        right: 41.66666667%;
                    }
                    .col-sm-pull-4 {
                        right: 33.33333333%;
                    }
                    .col-sm-pull-3 {
                        right: 25%;
                    }
                    .col-sm-pull-2 {
                        right: 16.66666667%;
                    }
                    .col-sm-pull-1 {
                        right: 8.33333333%;
                    }
                    .col-sm-pull-0 {
                        right: auto;
                    }
                    .col-sm-push-12 {
                        left: 100%;
                    }
                    .col-sm-push-11 {
                        left: 91.66666667%;
                    }
                    .col-sm-push-10 {
                        left: 83.33333333%;
                    }
                    .col-sm-push-9 {
                        left: 75%;
                    }
                    .col-sm-push-8 {
                        left: 66.66666667%;
                    }
                    .col-sm-push-7 {
                        left: 58.33333333%;
                    }
                    .col-sm-push-6 {
                        left: 50%;
                    }
                    .col-sm-push-5 {
                        left: 41.66666667%;
                    }
                    .col-sm-push-4 {
                        left: 33.33333333%;
                    }
                    .col-sm-push-3 {
                        left: 25%;
                    }
                    .col-sm-push-2 {
                        left: 16.66666667%;
                    }
                    .col-sm-push-1 {
                        left: 8.33333333%;
                    }
                    .col-sm-push-0 {
                        left: auto;
                    }
                    .col-sm-offset-12 {
                        margin-left: 100%;
                    }
                    .col-sm-offset-11 {
                        margin-left: 91.66666667%;
                    }
                    .col-sm-offset-10 {
                        margin-left: 83.33333333%;
                    }
                    .col-sm-offset-9 {
                        margin-left: 75%;
                    }
                    .col-sm-offset-8 {
                        margin-left: 66.66666667%;
                    }
                    .col-sm-offset-7 {
                        margin-left: 58.33333333%;
                    }
                    .col-sm-offset-6 {
                        margin-left: 50%;
                    }
                    .col-sm-offset-5 {
                        margin-left: 41.66666667%;
                    }
                    .col-sm-offset-4 {
                        margin-left: 33.33333333%;
                    }
                    .col-sm-offset-3 {
                        margin-left: 25%;
                    }
                    .col-sm-offset-2 {
                        margin-left: 16.66666667%;
                    }
                    .col-sm-offset-1 {
                        margin-left: 8.33333333%;
                    }
                    .col-sm-offset-0 {
                        margin-left: 0%;
                    }
                }

                body {
                    margin: 50px;
                }
            </style>
        </head>

<?php else: ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <style>
            body {
                color: black;
                font-family: calibri;
                margin: 0;
            }

            body {
                margin: 30px 300px 30px 300px;
            }
        </style>
    </head>
<?php endif ?>


    <body>

        <?php if ($d_print == null): ?>
            <a href="<?= base_url('monitoring/bukti_kunjungan/'.$data_deb['id_tr_m'].'/'.$jenis.'/word') ?>">
            <button class="btn btn-info"><i class="fa fa-download"></i><?= nbs(5) ?>Download Word</button></a> <?= nbs(5) ?> 
            <a target="_blank" href="<?= base_url('monitoring/bukti_kunjungan/'.$data_deb['id_tr_m'].'/'.$jenis.'/print') ?>">
            <button class="btn btn-success"><i class="fa fa-print"></i><?= nbs(5) ?>Print</button></a>
            <?= br(2) ?>
        <?php endif ?>

        

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
                    <td><?= tgl_indo(date('Y-m-d' ,strtotime($data_deb['start_date']))) ?> sd. <?= tgl_indo(date('Y-m-d' ,strtotime($data_deb['mat_date']))) ?></td>
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
                    <td><?= tgl_indo(date('Y-m-d' ,strtotime($data_deb['start_date']))) ?> sd. <?= tgl_indo(date('Y-m-d' ,strtotime($data_deb['mat_date']))) ?></td>
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
                <td align="center">( <?= $data_deb['nama_debitur'] ?> )<br> <?= $data_deb['keterangan'] ?></td>
                <td></td>
                <td align="center">( <?= $data_deb['name'] ?> )</td>
            </tr>
        </table>

        <?php if ($d_print == 'word'): ?>

            <?php 
            
                $ad = ceil(count($foto_deb->result_array()) / 2);

                $fr = $foto_deb->result_array();

                $ct = count($foto_deb->result_array());
            
            ?>

            <?php if ($ct > 1) : ?>

            <?php for ($i=0; $i < $ad; $i++) : ?>

                <?php 
                    if ($i == 0) {

                        $m  = $i;
                        $as = $fr[$i]; 
                        $i  = $i; 

                    } else {

                        $m  = $m + 2;
                        $as = $fr[$m];
                        
                    }

                    $ag = $fr[$m + 1];

                ?>

                <table width="100%" style="margin-top: 10px;">
                    <tr>
                        <td width="150" align="center">
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($as['picture']) ?>"></td>
                        <td width="150" align="center">
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($ag['picture']) ?>"></td>
                    </tr>
                </table>
                
            <?php endfor ?>

            <?php else : ?>

                <?php for ($i=0; $i < 1; $i++) : ?>

                    <?php 
                        if ($i == 0) {

                            $m  = $i;
                            $as = $fr[$i]; 
                            $i  = $i; 

                        } else {

                            $m  = $m + 2;
                            $as = $fr[$m];
                            
                        }

                        if ($ct > 1) {
                            $ag = $fr[$m + 1];
                            $bb = $as['picture'];
                            $bg = '<img src="data:image/jpeg;base64, "'.base64_encode($bb).'">';
                        } else {
                            $bg = '';
                        }
                        
                    ?>

                    <table width="100%" style="margin-top: 10px;">
                        <tr>
                            <td width="150" align="center">
                                <img src="data:image/jpeg;base64, <?php echo base64_encode($as['picture']) ?>"></td>
                            <td width="150" align="center"><?= $bg ?></td>
                        </tr>
                    </table>

                    <?php endfor ?>

            <?php endif ?>

        <?php else : ?>

            <div class="row"> 
                <?php foreach ($foto_deb->result_array() as $s=>$f): ?>
                    <div class="col-sm-6 text-center" style="margin-top: 10px;">
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($f['picture']) ?>" style="">
                    </div>
                <?php endforeach ?>
            </div>
            
        <?php endif ?>
           
                
        <!-- <table width="100%" style="margin-top: 10px;">
            <tr>
                <td align="center"><img src="data:image/jpeg;base64, <?php echo base64_encode($f['picture']) ?>" style="height: 400px;"></td>
            </tr>
        </table> -->

        <?php if ($d_print == 'print'): ?>
            <script type="text/javascript">
                window.print();
            </script>
        <?php endif ?>

    </body>
</html>