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
                    <div class="navbar-custom-menu" >
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->

                            <?php 
                                if ($this->session->userdata('level') != 4) {
                                    if ($this->session->userdata('level') == 0) {
                                        $hd = 'hidden';
                                    } else {
                                        $hd = '';
                                    }
                                } else {
                                    $hd = 'hidden';
                                } 
                            ?>
                            
                            <!-- notifikasi -->
                            <li class="dropdown notifications-menu <?= $hd ?>" style="margin: 5px;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-bell-o fa-2x"></i>
                                  <span class="label label-warning" style="font-size: 12px;"><?= $this->session->userdata('hitung_deb') ?></span>
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
                            <li class="dropdown user user-menu" style="padding: 10px;">
                            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-primary">Keluar</a>
                            </li>

                            <!-- <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url('assets/images/person.png'); ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?= $this->session->userdata('name'); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?php echo base_url('assets/images/person.png'); ?>" class="img-circle" alt="User Image" />
                                        <p style="color: black">
                                            <small><?= $this->session->userdata('nama_lvl'); ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="text-center">
                                            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-primary btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel" style="height: 120px;">
                        <div class="pull-left image">
                            <img src="<?php echo base_url('assets/images/person.png'); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info" >
                            <p style="color: black">
                                <?= wordwrap($this->session->userdata('name'), 15, "<br>"); ?>
                            </p>
                            <small>
                            <?= wordwrap(ucwords(strtolower($this->session->userdata('cabang'))), 30, "<br>"); ?><br>
                            <?= wordwrap(ucwords(strtolower($this->session->userdata('kanwil'))), 30, "<br>"); ?></small><br><br>
                            <small><i class="fa fa-circle text-success"></i><?= nbs() ?><?= $this->session->userdata('nama_lvl'); ?></small>
                        </div>
                        
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?> <?= ($menu == 'karyawan' || $menu == 'pengguna') ? 'active menu-open' : '' ?>">
                            <a href="#" class="sh <?= ($menu == 'karyawan' || $menu == 'pengguna') ? 'aktifmenu' : '' ?>">
                                <i class="fa fa-dashboard"></i> <span>Master</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class="sh <?= ($menu == 'karyawan') ? 'aktif' : '' ?>" href="<?php echo base_url()?>karyawan/data"><i class="fa fa-circle-o"></i> Karyawan</a></li>
                                <li><a class="sh <?= ($menu == 'pengguna') ? 'aktif' : '' ?>" href="<?php echo base_url()?>pengguna/data"><i class="fa fa-circle-o"></i> Pengguna</a></li>
                            </ul>
                        </li>
                        <!-- <li>
                          <a class="sh <?= ($menu == 'list_blokir') ? 'aktif' : '' ?>"  href="<?= base_url('master/list_blokir/') ?>">
                            <i class="fa fa-server"></i> <span>List Blokir</span>
                          </a>
                        </li> -->
                        <?php $lvl = $this->session->userdata('level') ?>

                        <?php if ($lvl == 1 || $lvl == 2 || $lvl == 3 || $lvl == 0): ?>

                            <li>
                                <a class="sh <?= ($menu == 'log') ? 'aktif' : '' ?>" href="<?= base_url("log_req") ?>" >
                                    <i class="fa fa-history"></i> <span>Log Request</span>
                                </a>
                            </li>

                        <?php endif ?>

                        <?php if ($lvl == 0): ?>

                            <li>
                                <a class="sh <?= ($menu == 'log_uim') ? 'aktif' : '' ?>" href="<?= base_url("log_req/uim") ?>" >
                                    <i class="fa fa-history"></i> <span>Log Response UIM</span>
                                </a>
                            </li>
                            <li>
                                <a class="sh <?= ($menu == 'log_error') ? 'aktif' : '' ?>" href="<?= base_url("log_req/error") ?>" >
                                    <i class="fa fa-history"></i> <span>Log Error Login</span>
                                </a>
                            </li>

                        <?php endif ?>

                        <li class="treeview <?=($this->session->userdata('level')=='1' || $this->session->userdata('level')=='2' || $this->session->userdata('level')=='3') ? '' : 'hidden'?> <?= ($menu == 'kelolaan' || $menu == 'tf_kelolaan' || $menu == 'pengajuan_kelolaan') ? 'active menu-open' : '' ?>">
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
                        <li class="treeview <?=($this->session->userdata('level')=='1') ? '' : 'hidden'?><?= ($menu == 'monitoring_prog' || $menu == 'monitoring') ? 'active menu-open' : '' ?>">
                            <a href="#" class="sh <?= ($menu == 'monitoring_prog' || $menu == 'monitoring') ? 'aktifmenu' : '' ?>">
                                <i class="fa fa-laptop"></i>
                                <span>Monitoring</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class="sh <?= ($menu == 'monitoring_prog') ? 'aktif' : '' ?>" href="<?php echo base_url('monitoring')?>"><i class="fa fa-circle-o"></i> Monitoring Progress</a></li>
                                <li><a class="sh <?= ($menu == 'monitoring') ? 'aktif' : '' ?>" href="<?php echo base_url('monitoring/monitoring_debitur/npl/a/semua')?>"><i class="fa fa-circle-o"></i> Monitoring Debitur</a></li>
                            </ul>
                        </li>

                        <?php if ($lvl == 4): ?>

                        <li>
                          <a class="sh <?= ($menu == 'monitoring_deb') ? 'aktif' : '' ?>" href="<?= base_url("monitoring/monitoring_debitur/npl/a/debitur/".$this->session->userdata('reg_employee')) ?>">
                            <i class="fa fa-desktop"></i> <span>Monitoring</span>
                          </a>
                        </li>
                        <li>
                          <a class="sh <?= ($menu == 'kelolaan') ? 'aktif' : '' ?>"  href="<?= base_url('monitoring/kelolaan_debitur/npl/') ?>">
                            <i class="fa fa-server"></i> <span>Kelolaan</span>
                          </a>
                        </li>

                        <?php endif ?>

                        <li class="treeview <?= ($lvl == 4 || $lvl == 0) ? 'hidden' : '' ?> <?= ($menu == 'potensi' || $menu == 'r_monitoring'|| $menu == 'r_kelolaan_npl'|| $menu == 'r_kelolaan_wo' || $menu == 'restruk') ? 'active menu-open' : '' ?>">
                            <a href='#' class="sh <?= ($menu == 'potensi' || $menu == 'r_monitoring'|| $menu == 'r_kelolaan_npl'|| $menu == 'r_kelolaan_wo' || $menu == 'restruk') ? 'aktifmenu' : '' ?>">
                                <i class='fa fa-edit'></i><span>Report</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a class="sh <?= ($menu == 'potensi') ? 'aktif' : '' ?>" href="<?php echo base_url('report/potensi')?>"><i class='fa fa-circle-o'></i>Potensi Recovery</a></li>
                                <li><a class="sh <?= ($menu == 'r_monitoring') ? 'aktif' : '' ?>" href="<?php echo base_url('report/monitoring') ?>"><i class='fa fa-circle-o'></i>Monitoring Komitmen<br>Debitur</a></li>
                                <li><a class="sh <?= ($menu == 'r_kelolaan_npl') ? 'aktif' : '' ?>" href="<?php echo base_url('report/kelelolaan_npl_ao') ?>"><i class='fa fa-circle-o'></i><span>Monitoring Kelolaan NPL<br>AO PPK</span></a></li>
                                <li><a class="sh <?= ($menu == 'r_kelolaan_wo') ? 'aktif' : '' ?>" href="<?php echo base_url('report/kelelolaan_wo_ao') ?>"><i class='fa fa-circle-o'></i>Monitoring Kelolaan WO<br>AO PPK</a></li>
                                <li><a class="sh <?= ($menu == 'restruk') ? 'aktif' : '' ?>" href="<?php echo base_url('report/potensi_restruk') ?>"><i class='fa fa-circle-o'></i>Monitoring Potensi<br>Restrukturisasi</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <div class="content-wrapper">
                
                <!-- Content Header (Page header) -->
                <!-- <section class="content-header">
                    <h1 align="left">
                       <?= $title ?>
                    </h1>
                </section> -->

                <!-- Main content -->
                <section class="content">