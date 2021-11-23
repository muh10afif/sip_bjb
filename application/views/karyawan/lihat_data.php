<style type="text/css">
    #karyawan thead tr th {
        vertical-align: middle;
        text-align: center;
    }
</style>
<?= $this->session->flashdata('pesan'); ?>
<div class="row" hidden>
    <div class="col-md-12">
        <?php if ($aksi == 'ubah'): ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                <i class="fa fa-edit"></i><?= nbs(3); echo $judul; ?>
                </div>
                <div class="panel-body">
                    <?php echo form_open('karyawan/post_ubah/ubah', 'autocomplete="off"'); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Reg Employee</label>
                            <input class="form-control" name="reg_employee" placeholder="Masukkan Reg Employee" value="<?= $ubah_data['reg_employee'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control" name="name" placeholder="Masukkan Nama" value="<?= $ubah_data['name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                             <input type="text" class="form-control" name="birth_date" id="datepicker1" value="<?= $ubah_data['birth_date'] ?>" placeholder="Masukkan Tanggal Lahir">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" value="<?= $ubah_data['email'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" class="form-control" name="phone" placeholder="Masukkan Nomer Telepon" value="<?= $ubah_data['phone'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="address" placeholder="Masukkan Alamat"><?= $ubah_data['address'] ?></textarea>
                        </div>
                       
                    </div>
                    
                </div>
                <div class="panel-footer text-center">
                <button type="submit" name="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i><?= nbs(3) ?>U P D A T E</button><?= nbs(5) ?>
                <a href="<?= base_url('karyawan/data') ?>"><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i><?= nbs(3) ?>C A N C E L</button></a>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /. PANEL  -->

        <?php else: ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                <i class="fa fa-plus"></i><?= nbs(3) ?>Tambah Karyawan
                </div>
                <div class="panel-body">
                    <?php echo form_open('karyawan/post_ubah/post', 'autocomplete="off"'); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Reg Employee</label>
                            <input class="form-control" name="reg_employee" placeholder="Masukkan Reg Employee" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control" name="name" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                             <input type="text" class="form-control" name="birth_date" id="datepicker1" placeholder="Masukkan Tanggal Lahir">
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="number" class="form-control" name="phone" placeholder="Masukkan Nomer Telepon" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="address" placeholder="Masukkan Alamat"></textarea>
                        </div>
                       
                    </div>
                    
                </div>
                <div class="panel-footer text-center">
                <button type="submit" name="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i><?= nbs(3) ?>S I M P A N</button><?= nbs(5) ?>
                <a href="<?= base_url('karyawan/data') ?>"><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i><?= nbs(3) ?>C A N C E L</button></a>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /. PANEL  -->
        <?php endif ?>
        
    </div>
</div>
<!-- /. ROW  -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <i class="fa fa-navicon "></i><?= nbs(3) ?>Data Karyawan
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="karyawan">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No</th>
                                <th>Reg Employee</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($record->result() as $r) { ?>
                            <tr class="gradeU">
                                <td><?php echo $no ?></td>
                                <td><?php echo $r->reg_employee ?></td>
                                <td><?php echo $r->name ?></td>
                                <td><?php echo $r->birth_date ?></td>
                                <td><?php echo $r->address ?></td>
                                <td><?php echo $r->phone ?></td>
                                <td><?php echo $r->email ?></td>
                                <!-- <td><a class="btn btn-xs btn-block btn-warning" href="<?=site_url("karyawan/data/ubah/$r->reg_employee")?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a class="btn btn-xs btn-block btn-danger" href="<?=site_url("karyawan/hapus/$r->reg_employee/$r->name")?>" onclick="return confirm('Anda yakin menghapus data <?= $r->name ?> ?')"><span class="glyphicon glyphicon-trash"></span></a> -->
                            </tr>
                        <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- /. PANEL  -->
    </div>
</div>
<!-- /. ROW  -->

<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>

<script>
     $(function () {
        $('#karyawan').DataTable({
            order: [[ 0, "asc" ]],
            pageLength: 10
        })
        $('#datepicker1').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        })
        // $("#datepicker1").datepicker("setDate", new Date());
    });
</script>