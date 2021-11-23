<style type="text/css">
    #pengguna thead tr th {
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
                    <?php 
                          $p_level        = $r_user['level'];
                          $p_kanwil       = $r_user['kanwil'];
                          $p_cabang       = $r_user['cabang_induk']; 

                     ?>

                    <?php echo form_open("pengguna/post_ubah/ubah/$p_level/$p_kanwil/$p_cabang", 'autocomplete="off"'); ?>
                  
                        <div class="col-md-3">
                        <input type="hidden" name="id" value="<?= $r_user['id'] ?>">
                        <div class="form-group">
                            <label>Pilih Karyawan</label>
                            <select class="form-control select2" name="reg_employee" style="width: 100%" required>
                                <option value="">--- Pilih Karyawan ---</option>
                                <option value="<?= $r_user['reg_employee'] ?>" selected><?= $r_user['name'] ?></option>
                                <?php $u = $r_user['reg_employee'] ?>
                                <?php foreach ($rcd->result() as $r) {?>
                                <option value="<?php echo $e = $r->reg_employee;?>" <?= ($u == $e) ? 'selected' : '' ?>>
                                    <?php echo $r->name;?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan Username" value="<?= $r_user['email'] ?>" required>
                        </div>
                        
                    </div>
                        <div class="col-md-3">

                        <div class="form-group">
                            <label>Aktif</label>
                            <select class="form-control" name="active" required>
                                <option value="">--- Pilih Aktifasi ---</option>
                                <?php $a = $r_user['active'] ?>
                                <option value="1" <?= ($a == 1) ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= ($a == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        
                         <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" name="level" required>
                                <option value="">
                                    --- Pilih Level ---
                                </option>
                                <?php $p = $r_user['level'] ?>
                                <?php foreach ($level->result_array() as $v): ?>
                                    <option value="<?= $i = $v['id'] ?>" <?= ($p == $i) ? 'selected' : '' ?>><?= $v['auth'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>

                        <div class="col-md-3">

                        <div class="form-group">
                            <label>Kanwil</label>
                            <select class="form-control select2" name="kanwil" id="kanwil" style="width: 100%;">
                                <option value="">
                                    --- Pilih Kanwil ---
                                </option>
                                <?php $k = $r_user['kanwil'] ?>
                                <?php foreach ($ambil_kanwil->result_array() as $r) {?>
                                <option value="<?php echo $ka = $r['kanwil'];?>" <?= ($k == $ka) ? 'selected' : '' ?>>
                                    <?php echo $r['kanwil']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cabang</label>
                            <select class="form-control select2" name="cabang_induk" id="cabang" style="width: 100%;">
                                <option value="">
                                    --- Pilih Cabang ---
                                </option>
                                <?php $c = $r_user['cabang_induk'] ?>
                                <?php foreach ($ambil_cabang->result_array() as $r) {?>
                                <option value="<?php echo $ca = $r['cabang'];?>" <?= ($c == $ca) ? 'selected' : '' ?>>
                                    <?php echo $r['cabang']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>                 
                    <div class="col-md-3">
                        
                            <div class="form-group">
                                <label>Password</label>
                                <input type="hidden" name="p_sha" value="<?= $r_user['sha'] ?>">
                                <input type="password" class="form-control" name="sha" placeholder="Masukkan Password">
                                <span style="color: red">Jika ingin ganti password, silahkan isi. Jika tidak, kosongkan!</span>
                            </div>
                       
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <button type="submit" name="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i><?= nbs(3) ?>U P D A T E</button><?= nbs(5) ?>
                    <a href="<?= base_url('pengguna/data') ?>"><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i><?= nbs(3) ?>C A N C E L</button></a>
                </div>
                <?= form_close(); ?>
                <!-- /. PANEL  -->
            </div>
        <?php else: ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-plus"></i><?= nbs(3) ?>Tambah Pengguna
                </div>
                <div class="panel-body">
                            
                    <?php echo form_open('pengguna/post_ubah/post', 'autocomplete="off"'); ?>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label>Pilih Karyawan</label>
                            <select class="form-control select2" name="reg_employee" style="width: 100%" required>
                                <option value="">--- Pilih Karyawan ---</option>
                                <?php foreach ($rcd->result() as $r) {?>
                                <option value="<?php echo $r->reg_employee;?>">
                                    <?php echo $r->name;?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
                        </div>  
                        
                    </div>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="sha" placeholder="Masukkan Password">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" name="level" required>
                                <option value="">
                                    --- Pilih Level ---
                                </option>
                                <?php foreach ($level->result_array() as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['auth'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label>Kanwil</label>
                            <select class="form-control select2" name="kanwil" id="kanwil" style="width: 100%;">
                                <option value="">
                                    --- Pilih Kanwil ---
                                </option>
                                <?php foreach ($ambil_kanwil->result_array() as $r) {?>
                                <option value="<?php echo $r['kanwil'];?>">
                                    <?php echo $r['kanwil']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cabang</label>
                            <select class="form-control select2" name="cabang_induk" id="cabang" style="width: 100%;">
                                <option value="">
                                    --- Pilih Cabang ---
                                </option>
                                <?php foreach ($ambil_cabang->result_array() as $r) {?>
                                <option value="<?php echo $r['cabang'];?>">
                                    <?php echo $r['cabang']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-md-3">

                         <div class="form-group">
                            <label>Aktif</label>
                            <select class="form-control" name="active" required>
                                <option>--- Pilih Aktifasi ---</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="panel-footer text-center">
                    <button type="submit" name="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i><?= nbs(3) ?>S I M P A N</button><?= nbs(5) ?>
                    <a href="<?= base_url('pengguna/data') ?>"><button type="button" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i><?= nbs(3) ?>C A N C E L</button></a>
                </div>
                <?= form_close(); ?>
                <!-- /. PANEL  -->
            </div>
        <?php endif ?> 
    </div>
</div>
<!-- /. ROW  -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-navicon "></i><?= nbs(3) ?>Data Pengguna
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="pengguna">
                        <thead style="background-color: #e3e3fb">
                            <tr>
                                <th>No</th>
                                <th>Employee</th>
                                <th>Username</th>
                                <th>Kanwil</th>
                                <th>Cabang</th>
                                <th>Level</th>
                                <th>Aktif</th>
                                <!-- <th width="40px">Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($record->result() as $r) { ?>
                            <tr class="gradeU">
                                <td align="center"><?php echo $no ?></td>
                                <td><?php echo $r->name ?></td>
                                <td><?php echo $r->email_user ?></td>
                                <td><?php echo $r->kanwil ?></td>
                                <td><?php echo $r->cabang_induk ?></td>
                                <td><?php echo $r->auth ?></td>
                                <td><?php 
                                    if($r->active==1){
                                    echo "Aktif";
                                    }elseif($r->active==0){
                                        echo "Tidak Aktif";
                                    }?></td>
                                <!-- <td><a class="btn btn-xs btn-block btn-warning" href="<?=site_url("pengguna/data/ubah/$r->id")?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a class="btn btn-xs btn-block btn-danger" href="<?=site_url("pengguna/hapus/$r->id/$r->reg_employee")?>" onclick="return confirm('Anda yakin menghapus data <?= $r->name ?> ?')"><span class="glyphicon glyphicon-trash"></span></a> -->
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
        $('#pengguna').DataTable({
            order: [[ 0, "asc" ]],
            pageLength: 10
        })
        $('.select2').select2()
    });
</script>
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
        $('.select2').select2()
    });
</script>

<script>
    $(function () {
        $.ajaxSetup({
            type: "POST",
            url: "<?= base_url('karyawan/ambil_data') ?>",
            cache: false,
        });

        $("#kanwil").change(function(){

            var value = $(this).val();
            if (value != null) {
                $.ajax({
                    data:{modul:'cabang', kanwil:value},
                    success: function(respond){
                        $("#cabang").html(respond);
                    }
                })
            }
        })
    })
</script>
