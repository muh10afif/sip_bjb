<style type="text/css">

    #tabel_log_req tr th {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="row">

    <div class="col-md-6">
        <span style="font-size: 25px; font-weight: bold;"><?= $title ?></span>
    </div>

</div><br>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary">
            <div class="panel-heading">
                Filter Data
            </div>
            <div class="panel-body" style="padding: 10px; margin: 20px; margin-bottom: 5px;">

                <div class="d-flex justify-content-center">
                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-3">
                            <label class="col-md-3 text-right">User Id</label>
                            <div class="col-md-9">
                                <select class="form-control select2 user_id" id="user_id" name="user_id" style="width: 100%;">
                                        <option value="">User Id</option>
                                        <?php foreach ($user_id as $o): ?>
                                            <option value="<?= $o['user_id'] ?>"><?= $o['user_id'] ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>
                
            </div>
            <div class="panel-footer text-right">
            <button type="button" id="tampilkan" name="tampilkan" class="btn btn-success">Tampilkan</button><?= nbs(3) ?>
            <button type="button" id="reset" class="btn btn-warning">Reset</button>
            </div>
        </div>

        <div class="panel panel-primary">

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm" id="tabel_log_req" width="100%">
                        <thead style="background-color: #e3e3fb;">
                            <tr>
                                <th>No</th>
                                <th>UserId</th>
                                <th>Response</th>
                                <th>Aksi</th>
                                <th>Created At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- /. PANEL  -->
    </div>
</div>

<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script>
    $(document).ready(function () {

        $('.select2').select2();

        var tabel_log_req  = $('#tabel_log_req').DataTable({
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                "url"   : "<?= base_url() ?>Log_req/tampil_log_req",
                "type"  : "POST",
                "data"  : function (data) {
                    data.user_id      = $('#user_id').val();
                }
            },
            "columnDefs"     : [{
                "targets"       : [0],
                "orderable"     : false
            }, {
                "targets"       : [0],
                "className"     : "text-center"
            }]
        });

        // 26-01-21
        $('#tampilkan').on('click', function () {

            tabel_log_req.ajax.reload(null, false);
            
        })

        // 26-01-21
        $('#reset').on('click', function () {

            $('#user_id').val('').trigger('change');
            tabel_log_req.ajax.reload(null, false);
            
        })

        // 22-03-2021
        $('#tabel_log_req').on('click', '.ubah_status', function () {

            var id = $(this).data('id');

            swal({
                title       : 'Peringatan',
                html        : 'Apakah yakin akan menonaktifkan?',
                type        : 'warning',

                buttonsStyling      : true,
                confirmButtonClass  : "btn btn-danger btn-sm",
                cancelButtonClass   : "btn btn-light mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Ya, simpan',
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url() ?>Log_req/ubah_status",
                        method      : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses Data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data        : {id:id},
                        dataType    : "JSON",
                        success     : function (data) {

                            swal({
                                title               : 'Berhasil',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            tabel_log_req.ajax.reload(null, false);
                            
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {

                    swal({
                            title               : 'Batal',
                            text                : 'Anda membatalkan ubah status',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-primary",
                            type                : 'error',
                            showConfirmButton   : false,
                            timer               : 1000
                        }); 
                }
            })

        })
        
    })
</script>