<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/images/bjb.png">
        <title>SIP BJB | BACKEND</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/select2/dist/css/select2.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">  
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url('assets/js/plugins/morris/morris.css'); ?>" rel="stylesheet">
        <!-- jvectormap -->
        <link href="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- Theme style -->
          <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
          <!-- AdminLTE Skins. Choose a skin from the css/skins
               folder instead of downloading all of them to reduce the load. -->
          <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">

           <!-- Theme style -->
        <!-- <link href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <!-- <link href="<?php echo base_url('assets/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .aktif {
                /*background-color: #418afa;*/
                background: linear-gradient(to right, #3366ff 0%, #99ccff 100%);
                color: white;
                box-shadow: 2px 0.5px rgb(71, 142, 255);
                border-radius: 7px;
                margin-left: 0px;
                margin-top: 5px;
                width: 97%;
            }
            .aktifmenu {
                background: linear-gradient(to left, #ccccff 0%, #ffffcc 100%);
                color: black;
                box-shadow: 2px 0.5px rgb(233, 236, 242);
                border-radius: 7px;
                margin-left: 0px;
                margin-top: 5px;
                width: 97%;
            }
            .sh:hover{
              background: #fff;
              color: #26425E;
              box-shadow: 2px 1px 2px 1px rgb(71, 142, 255);
              border-radius: 10px;
              margin-left: 10px;
            }
        </style>
    </head>
    <body class="skin-default">
        <div class="wrapper">
        <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url('dasbor')?>" class="logo"><img height="40px" src=<?php echo base_url()?>assets/images/bjb.png></a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <!-- notifikasi -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-bell-o"></i>
                                  <span class="label label-warning"><?= $this->session->userdata('hitung_deb') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                  <li class="header"><?= $this->session->userdata('hitung_deb') ?> Debitur Follow UP </li>
                                  <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                    <?php $data = $this->session->userdata('data_debb'); ?>

                                    <?php $no=1; foreach ($data as $d): ?>
                                        <li><!-- start message -->
                                            <a href="<?= base_url('monitoring/monitoring_debitur/'.strtolower($d['jenis_debitur'])) ?>">
                                              <h5><span class="label label-success"><?= $no++ ?></span>
                                                <?= $d['nama'] ?>
                                                <small class="pull-right"><i class="fa fa-user"></i><?= nbs(2) ?><?= strtoupper($d['jenis_debitur']) ?></small>
                                              </h5>
                                              <p><?= $d['komitmen'] ?></p>
                                            </a>
                                          </li>
                                          <!-- end message -->
                                    <?php endforeach ?>

                                      
                                      
                                    </ul>
                                  </li>
                                  <li class="footer"><a href="<?= base_url('monitoring/monitoring_debitur') ?>">Tampilkan Selengkapnya</a></li>
                                </ul>
                              </li>

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url('assets/images/person.png'); ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?= $this->session->userdata('name'); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url('assets/images/person.png'); ?>" class="img-circle" alt="User Image" />
                                        <p style="color: black">
                                            <?= $this->session->userdata('name'); ?>
                                            <small><?= $this->session->userdata('auto'); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="text-center">
                                            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-primary btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url('assets/images/person.png'); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p style="color: black">
                                <?= $this->session->userdata('name'); ?>
                            </p>
                                <small><i class="fa fa-circle text-success"></i><?= nbs(4) ?><?= $this->session->userdata('auto'); ?></small>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" >
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?> <?= ($menu == 'karyawan' || $menu == 'pengguna') ? 'active menu-open' : '' ?>">
                            <a href="#" class="sh <?= ($menu == 'karyawan' || $menu == 'pengguna') ? 'aktifmenu' : '' ?>">
                                <i class="fa fa-dashboard"></i> <span>Master</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class="sh <?= ($menu == 'karyawan') ? 'aktif' : '' ?>" href="<?php echo base_url()?>karyawan/data"><i class="fa fa-circle-o"></i> Karyawan</a></li>
                                <li><a class="sh <?= ($menu == 'pengguna') ? 'aktif' : '' ?>" href="<?php echo base_url()?>pengguna/data"><i class="fa fa-circle-o"></i> Pengguna</a></li>
                            </ul>
                        </li>
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?> <?= ($menu == 'kelolaan' || $menu == 'tf_kelolaan' || $menu == 'pengajuan_kelolaan') ? 'active menu-open' : '' ?>">
                            <a href="#" class="sh <?= ($menu == 'kelolaan'  || $menu == 'tf_kelolaan' || $menu == 'pengajuan_kelolaan') ? 'aktifmenu' : '' ?>">
                                <i class="fa fa-files-o"></i>
                                <span>Transaksi</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class="sh <?= ($menu == 'kelolaan') ? 'aktif' : '' ?>" href="<?php echo base_url()?>kelolaan/data"><i class="fa fa-circle-o"></i> Atur Kelolaan</a></li>
                                <li><a class="sh <?= ($menu == 'tf_kelolaan') ? 'aktif' : '' ?>" href="<?php echo base_url()?>kelolaan/tf_kelolaan"><i class="fa fa-circle-o"></i> Transfer Kelolaan</a></li>
                                <li><a class="sh <?= ($menu == 'pengajuan_kelolaan') ? 'aktif' : '' ?>" href="<?php echo base_url()?>kelolaan/pengajuan_kelolaan"><i class="fa fa-circle-o"></i> Pengajuan Kelolaan</a></li>
                            </ul>
                        </li>
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?><?= ($menu == 'export_npl' || $menu == 'export_wo') ? 'active menu-open' : '' ?>">
                            <a href="#" class="sh <?= ($menu == 'export_npl' || $menu == 'export_wo') ? 'aktifmenu' : '' ?>">
                                <i class="fa fa-pie-chart"></i>
                                <span>Export</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class="sh <?= ($menu == 'export_npl') ? 'aktif' : '' ?>" href="<?php echo base_url('export/form')?>"><i class="fa fa-circle-o"></i> Upload Debitur NPL</a></li>
                                <li><a class="sh <?= ($menu == 'export_wo') ? 'aktif' : '' ?>" href="<?php echo base_url('export/formWO')?>"><i class="fa fa-circle-o"></i> Upload Debitur WO</a></li>
                            </ul>
                        </li>
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?>">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Monitoring</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url('monitoring')?>"><i class="fa fa-circle-o"></i> Monitoring Progress</a></li>
                                <li><a href="<?php echo base_url('monitoring/monitoring_debitur/npl/a/semua')?>"><i class="fa fa-circle-o"></i> Monitoring Debitur</a></li>
                            </ul>
                        </li>
                            <!-- <li class="treeview <?= ($aktif == 'report') ? 'active' : '' ?>"> -->
                                <li class="treeview">
                                <a href='#'>
                                    <i class='fa fa-edit'></i><span>Report</span>
                                    <i class='fa fa-angle-left pull-right'></i>
                                </a>
                            <ul class='treeview-menu'>
                                <li><a href="<?php echo base_url('report/potensi')?>"><i class='fa fa-circle-o'></i>Potensi Recovery</a></li>
                                <li><a href="<?php echo base_url('report/monitoring') ?>"><i class='fa fa-circle-o'></i>Monitoring Komitmen<br>Debitur</a></li>
                                <li><a href="<?php echo base_url('report/kelelolaan_npl_ao') ?>"><i class='fa fa-circle-o'></i><span>Monitoring Kelolaan NPL<br>AO PPK</span></a></li>
                                <li><a href="<?php echo base_url('report/kelelolaan_wo_ao') ?>"><i class='fa fa-circle-o'></i>Monitoring Kelolaan WO<br>AO PPK</a></li>
                                <li><a href="<?php echo base_url('report/potensi_restruk') ?>"><i class='fa fa-circle-o'></i>Monitoring Potensi<br>Restrukturisasi</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 align="left">
                        Import data excel
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
        <div class="wrapper">                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                               <form method="post" action="<?php echo base_url("export/form"); ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Masukan Excel</label>
                                    <input type="file" class="form-control" name="file" >
                                </div>
                                <button type="submit" name="preview" class="btn btn-primary btn-sm">Export</button>
                                </form>
                            </div>
                        </div>
                        <!-- /. PANEL  -->
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                   <?php
                    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
                        if(isset($upload_error)){ // Jika proses upload gagal
                            echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
                            die; // stop skrip
                        }
                        
                        // Buat sebuah tag form untuk proses import data ke database
                        echo "<form method='post' action='".base_url("export/simpan")."'>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-striped table-bordered table-hover'>
                        <thead>
                        <tr style='font-size:12px'>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Kanwil</th>
                            <th>Nama Cabang Induk</th>
                            <th>Nama Kantor</th>
                            <th>Segmen</th>
                            <th>Loan Type</th>
                            <th>Deal Reff</th>
                            <th>Start Date</th>
                            <th>Mat Date</th>
                            <th>Plafond</th>
                            <th>Outstanding</th>
                            <th>Kolektabilitas</th>
                            <th>DPD</th>
                            <th>Tunggakan Pokok</th>
                            <th>Tunggakan Bunga</th>
                        </tr>
                        </thead>";
                        
                        $numrow = 1;
                        $kosong = 0;
                        
                        // Lakukan perulangan dari data yang ada di excel
                        // $sheet adalah variabel yang dikirim dari controller
                            $no=1; foreach($sheet as $row){ 
                            ?>

                            <?php

                                // Ambil data pada excel sesuai Kolom
                                $nama = $row['A']; // Ambil data nama
                                $cif = $row['B']; // Ambil data jenis kelamin
                                $alamat = $row['C'];
                                $telpon = $row['D'];
                                $kanwil = $row['E'];
                                $cabang = $row['F']; // Ambil data alamat
                                $kantor = $row['G'];
                                $segmen = $row['H'];
                                $loan = $row['I'];
                                $deal = $row['J'];
                                $start = $row['K'];
                                $mat = $row['L'];
                                $plafond = $row['M'];
                                $outstanding = $row['N'];
                                $kolektabilitas = $row['O'];
                                $dpd = $row['P'];
                                $pokok = $row['Q'];
                                $bunga = $row['R'];
                                // Cek jika semua data tidak diisi
                                if(empty($nama) && empty($cif) && empty($alamat) && empty($telpom) && empty($kanwil) && empty($cabang) &&empty($kantor)&& empty($segmen) &&empty($loan)&& empty($deal) &&empty($start)&& empty($mat) &&empty($plafond)&& empty($outstanding) &&empty($kolektabilitas)&& empty($dpd) &&empty($pokok)&& empty($bunga))
                                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                                
                                // Cek $numrow apakah lebih dari 1
                                // Artinya karena baris pertama adalah nama-nama kolom
                                // Jadi dilewat saja, tidak usah diimport
                                if($numrow > 0){
                                    // Validasi apakah semua data telah diisi
                                   
                                    // Jika salah satu data ada yang kosong
                                    if(empty($nama) && empty($cif) && empty($alamat) && empty($telpom) && empty($kanwil) && empty($cabang) &&empty($kantor)&& empty($segmen) &&empty($loan)&& empty($deal) &&empty($start)&& empty($mat) &&empty($plafond)&& empty($outstanding) &&empty($kolektabilitas)&& empty($dpd) &&empty($pokok)&& empty($bunga)){
                                        $kosong++; // Tambah 1 variabel $kosong
                                    }
                                    
                                        echo "<tbody>";
                                        echo "<tr style='font-size:12px'>";
                                        echo "<td>".$no."</td>";
                                        echo "<td>".$nama."</td>";
                                        echo "<td>".$cif."</td>";
                                        echo "<td>".$alamat."</td>";
                                        echo "<td>".$telpon."</td>";
                                        echo "<td>".$kanwil."</td>";
                                        echo "<td>".$cabang."</td>";
                                        echo "<td>".$kantor."</td>";
                                        echo "<td>".$segmen."</td>";
                                        echo "<td>".$loan."</td>";
                                        echo "<td>".$deal."</td>";
                                        echo "<td>".$start."</td>";
                                        echo "<td>".$mat."</td>";
                                        echo "<td>".number_format($plafond,2)."</td>";
                                        echo "<td>".number_format($outstanding,2)."</td>";
                                        echo "<td>".$kolektabilitas."</td>";
                                        echo "<td>".$dpd."</td>";
                                        echo "<td>".$pokok."</td>";
                                        echo "<td>".$bunga."</td>";
                                        echo "</tr>";
                                        echo "</tbody>";
                                    }
                                    $no++;
                                    $numrow++; // Tambah 1 setiap kali looping
                                }
                                
                                echo "</table>";
                                
                                 // Jika semua data sudah diisi
                                    echo "<hr>";
                                    
                                    // Buat sebuah tombol untuk mengimport data ke database
                                    echo "<button class='btn btn-info' type='submit' name='import'>Import</button> ";
                                    echo "<a href='".base_url("index.php/DT_klaim")."'><button class='btn btn-success'>Cancel</button></a>";
                                
                                echo "</form>";
                                echo "</div>";
                            }
                        ?>
        </div>
    </div>
    </section><!-- /.content -->
            </div><!-- /.content-wrapper -->    
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.1
                </div>
                <strong>Copyright &copy; <?= date("Y", now('Asia/Jakarta')) ?> Solusi Karya Digital.</strong> All rights reserved.
            </footer>

        </div><!-- ./wrapper -->
        <!-- jQuery 2.1.3 -->
        <script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <!-- FastClick -->
        <script src="<?php echo base_url('assets/js/plugins/fastclick/fastclick.min.js'); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets/js/AdminLTE/app.min.js'); ?>" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo base_url('assets/js/plugins/sparkline/jquery.sparkline.min.js'); ?>" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="<?php echo base_url('assets/js/plugins/slimScroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/Chart.js'); ?>"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo base_url('assets/js/AdminLTE/dashboard2.js'); ?>" type="text/javascript"></script>
       
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url() ?>/assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/dataTables/dataTables.bootstrap.js"></script>
        <!-- Select2 -->
        <script src="<?= base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        
    </body>
</html>  