<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/images/bjb.png">
        <title>SIP BJB | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/swa/sweetalert2.css">    
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" >
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">  
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">       
        <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">   

        <style>
            .field-icon {
                float: right;
                margin-left: -25px;
                margin-right: 10px;
                margin-top: -26px;
                position: relative;
                z-index: 2;
            }
            .swal2-popup {
                font-size: 1.6rem !important;
            }
        </style>
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#" ><img width="200px" src="<?php echo base_url()?>assets/images/bjb.png"></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body" style="box-shadow: 0 0 4px #3f95eb; border-radius: 10px; margin-top: 50px;">
                <p class="login-box-msg"><?= $this->session->flashdata('login'); ?></p>

                <form id="form-login" action="<?= base_url('Auth/proses_login') ?>" method="post" autocomplete="off">
                    <div class="form-group has-feedback">
                        <input type="text" name="userid" class="form-control" id="username" placeholder="User ID" value="<?= $this->session->flashdata('userid'); ?>" required />
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required/>
                        <span toggle="#password" class="glyphicon glyphicon-eye-open field-icon toggle-password"></span>
                    </div>
                    
                    <div class="row text-center">
                        <!-- <div class="col-md-2"></div> -->
                        <div class="col-md-12" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div><!-- /.col -->
                        <!-- <div class="col-md-2"></div> -->
                    </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        
    </body>

    <!-- <form method="post" id="import_form" enctype="multipart/form-data">

        <p><label>Pilih File Excel</label>

        <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>

        <br />

        <input type="submit" id="import" name="import" value="Import" class="btn btn-info" />

    </form> -->

</html>


<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- sweetalert2 -->
<script src="<?= base_url() ?>assets/bower_components/swa/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {

        $('#import_form').on('submit', function(event){

            event.preventDefault();

            $.ajax({

            url:"<?= base_url('Auth/import') ?>",

            method:"POST",

            data:new FormData(this),

            contentType:false,

            cache:false,

            processData:false,

            success:function(data){

                $('#file').val('');

                swal({
                    title               : 'Berhasil',
                    text                : 'Data Berhasil Diupload',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-success",
                    type                : 'success',
                    showConfirmButton   : false,
                    timer               : 1000
                }); 

            }

            })

        });

        // 26-12-2020
        $(".toggle-password").on('click',function() {

            $(this).toggleClass("glyphicon-eye-open glyphicon-eye-close");

            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });

        // 26-12-2020
        $('#form-login2').on('submit', function () {

            var username    = $('#username').val();
            var password    = $('#password').val();

            if ((username == "") && (password == "")) {

                $('#username').focus();

                swal({
                    title               : "Peringatan",
                    text                : 'Semua data harus terisi dahulu!',
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 1000
                }); 

                return false;

            } else if (username == "") {

                $('#username').focus();

                swal({
                    title               : "Peringatan",
                    text                : 'User ID harus terisi dahulu!',
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 700
                }); 

                return false;

            } else if (password == "") {

                $('#password').focus();

                swal({
                    title               : "Peringatan",
                    text                : 'Password harus terisi dahulu!',
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 700
                }); 

                return false;

            } else {

                $.ajax({

                    url         : "<?= base_url() ?>Auth/generate_pass",
                    type        : "POST",
                    data        : {password:password},
                    dataType    : 'JSON',
                    success     : function (data1) {

                        var pass = data1.hasil;

                        // jalankan proses ajax kirim data
                        $.ajax({
                            url         : "http://localhost:58874/api/UserWeb/LoginUser",
                            type        : "POST",
                            //url         : "http://192.168.226.110/sip_bjb/api/User/GetUser",
                            //url         : "http://192.168.201.75/sip_bjb/api/User/GetUser",
                            beforeSend  : function () {
                                swal({
                                    title   : 'Menunggu',
                                    html    : 'Memproses Data',
                                    onOpen  : () => {
                                        swal.showLoading();
                                    }
                                })
                            },
                            data        : {userId:username, password:pass},
                            dataType    : 'JSON',
                            success     : function (data) {

                                var r       = data.rc;
                                var id_log  = data.id_log;

                                console.log(data)

                                $.ajax({
                                    url     : "Auth/buat_log",
                                    type    : "post",
                                    data    : {userId:username, response:r, id_log:id_log},
                                    dataType: "JSON",
                                    success : function (data3) {
                                    
                                        if (data.rc == "00") {

                                            $.ajax({
                                                url     : "Auth/buat_session",
                                                type    : "post",
                                                data    : data,
                                                dataType: "JSON",
                                                success : function (data2) {
                                                
                                                    var url = "<?= base_url('dasbor') ?>";
                                                    window.location.href = url;

                                                }
                                            })

                                        } else if (data.rc == "63") {

                                            $('#password').val('');

                                            swal({
                                                title               : "Peringatan",
                                                text                : "Password Salah!",
                                                type                : 'warning',
                                                showConfirmButton   : false,
                                                timer               : 1000
                                            }); 

                                            $('#password').focus();

                                            return false;

                                        } else if (data.rc == "44") {

                                            $('#username').val('');

                                            swal({
                                                title               : "Peringatan",
                                                text                : "User ID tidak terdaftar!",
                                                type                : 'warning',
                                                showConfirmButton   : false,
                                                timer               : 1000
                                            }); 

                                            $('#username').focus();

                                            return false;
                                        
                                        } else if (data.rc == "Masih ada yang aktif") {

                                            $('#username').val('');
                                            $('#password').val('');

                                            swal({
                                                title               : "Peringatan",
                                                text                : "User ID masih Aktif!",
                                                type                : 'warning',
                                                showConfirmButton   : false,
                                                timer               : 5000
                                            }); 

                                            $('#username').focus();

                                            return false;

                                        } else {

                                            $('#username').val('');
                                            $('#password').val('');

                                            swal({
                                                title               : "Peringatan",
                                                text                : "Gagal Login",
                                                type                : 'warning',
                                                showConfirmButton   : false,
                                                timer               : 5000
                                            }); 

                                            $('#username').focus();

                                            return false;

                                        }

                                    }
                                })

                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                            swal({
                                title               : "Peringatan",
                                text                : "Koneksi Tidak Terhubung",
                                type                : 'warning',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            return false;
                            }							

                            
                        })
                        
                        return false;
                        
                    }
                    
                })

                return false;

            }

            })
        
    })
</script>

</body>
</html>