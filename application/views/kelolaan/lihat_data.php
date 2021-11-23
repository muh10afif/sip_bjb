<style type="text/css">

    #tabel_kelolaan tr th {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="row">

    <div class="col-md-6">
        <span style="font-size: 25px; font-weight: bold;"><?= $title ?></span>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/data/npl') ?>"><button style="box-shadow: 1px 1px 1px 1px rgb(71, 142, 255);" class="btn <?= ($aktif == 'npl') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'npl') ? "<i class='fa fa-check'></i>".nbs(2)  : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur NPL</button></a>
    </div>
    <div class="col-md-3">
        <a href="<?= base_url('kelolaan/data/wo') ?>"><button style="box-shadow: 1px 1px 1px 1px rgb(71, 142, 255);" class="btn <?= ($aktif == 'wo') ? 'btn-primary' : 'btn-default' ?> btn-block"><?= ($aktif == 'wo') ? "<i class='fa fa-check'></i>".nbs(2) : "<i class='fa fa-circle-o'></i>".nbs(2) ?>Status Debitur WO</button></a>
    </div>

</div><br>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary">
            <div class="panel-heading">
                Filter Data
            </div>
            <div class="panel-body" style="padding: 10px; margin: 20px; margin-bottom: 5px;">
                <input type="hidden" id="jenis" value="<?= $aktif ?>">
                <div class="col-md-12" hidden>
                    <form method="post" id="import_form" enctype="multipart/form-data">

                        <p><label>Pilih File Excel</label>

                        <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>

                        <br />

                        <input type="submit" id="import" name="import" value="Import" class="btn btn-info" />

                    </form>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Kanwil</label>
                        <?php if ($sess_level == 3): ?>
                            <div class="col-md-9" style="margin-bottom: 10px">
                                : <span style="font-size: 15px; font-weight: bold;"><?= $sess_kanwil ?></span>
                            </div>
                        <?php else: ?>
                            <div class="col-md-9">
                                <select class="form-control select2 kanwil2" id="kanwil2" name="kanwil2" style="width: 100%;">
                                    <option value="">Pilih Kanwil</option>
                                    <?php foreach ($kanwil as $k): ?>
                                        <option value="<?= $k['kanwil'] ?>"><?= $k['kanwil'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">AO</label>
                        <div class="col-md-9">
                            <select class="form-control select2 ao2" id="ao2" name="ao2" style="width: 100%;">
                                    <option value="">Pilih AO</option>
                                    <?php foreach ($ao as $o): ?>
                                        <option value="<?= $o['name'] ?>"><?= $o['name'] ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-3">Cabang Induk</label>
                        <div class="col-md-9">
                            <select class="form-control select2 cabang" id="cabang" name="cabang" style="width: 100%;">
                                <option value="">Pilih Cabang Induk</option>
                                <?php foreach ($cabang as $c): ?>
                                    <option value="<?= $c['cabang_induk'] ?>"><?= $c['cabang_induk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Status Kelolaan</label>
                        <div class="col-md-9">
                            <select class="form-control select2 status_kelolaan" id="status_kelolaan" name="status_kelolaan" style="width: 100%;">
                                <option value="">Pilih Status</option>
                                <option value="1">Sudah Ada</option>
                                <option value="0">Belum Ada</option>
                            </select>
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
            <div class="panel-heading">
            List Debitur <?= strtoupper($aktif) ?> <?= nbs(5) ?>
            <a href="<?php echo base_url("kelolaan/atur_otomatis/$aktif")?>"><button class="btn bg-maroon">ATUR OTOMATIS</button></a>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm" id="tabel_kelolaan" width="100%">
                        <thead style="background-color: #e3e3fb;">
                            <tr>
                                <th>No</th>
                                <th width="15%">Nama</th>
                                <th width="25%">Alamat</th>
                                <th>Kanwil</th>
                                <th>Cabang Induk</th>
                                <th>Deal Reff</th>
                                <th>AO</th>
                                <th width="10%">Aksi</th>
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
<!-- /. ROW  -->

<div id="modal_tambah" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="" id="my-modal-title" style="font-weight: bold;">Tambah Kelolaan</h4>
                    </div>
                    <div class="col-md-6">
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                
            </div>
            <form action="" autocomplete="off" id="form-tambah">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <input type="hidden" id="deal_reff" name="deal_reff">
                <input type="hidden" id="jenis_debitur" name="jenis_debitur" value="<?= $aktif ?>">
                <div class="modal-body" style="margin: 10px;">
                    
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-3 col-form-label">Nama Debitur</label>
                        <div class="col-sm-9">
                            <span id="nama" class="col-form-label"></span>
                        </div>
                    </div>
                    
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-3 col-form-label">Kanwil</label>
                        <div class="col-sm-9">
                            <span id="kanwil" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-3 col-form-label">Cabang Induk</label>
                        <div class="col-sm-9">
                            <span id="cabang_induk" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-3 col-form-label">Deal Reff</label>
                        <div class="col-sm-9">
                            <span id="Tdeal_reff" class="col-form-label"></span>
                        </div>
                    </div>

                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-3 col-form-label">AO</label>
                        <div class="col-sm-9">
                            <select class="form-control select2 ao" name="ao" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="simpan" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_detail" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="" id="my-modal-title" style="font-weight: bold;">Detail Debitur</h4>
                    </div>
                    <div class="col-md-6">
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                
            </div>
            <form action="" autocomplete="off" id="form-detail">
                <div class="modal-body" style="margin: 20px;">
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Nama Debitur</label>
                        <div class="col-sm-8">
                            <span id="nama_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <span id="alamat_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Telepon</label>
                        <div class="col-sm-8">
                            <span id="telepon_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Handphone</label>
                        <div class="col-sm-8">
                            <span id="handphone_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Kanwil</label>
                        <div class="col-sm-8">
                            <span id="kanwil_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Cabang Induk</label>
                        <div class="col-sm-8">
                            <span id="cabang_induk_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Kantor</label>
                        <div class="col-sm-8">
                            <span id="kantor_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Deal Reff</label>
                        <div class="col-sm-8">
                            <span id="deal_reff_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">AO</label>
                        <div class="col-sm-8">
                        <span id="ao_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Segmen</label>
                        <div class="col-sm-8">
                        <span id="segmen_det" class="col-form-label"></span>
                        </div>
                    </div>

                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">CIF</label>
                        <div class="col-sm-8">
                            <span id="cif_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Loan Type</label>
                        <div class="col-sm-8">
                            <span id="loan_type_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="kategori" class="col-sm-4 col-form-label">Plafond</label>
                        <div class="col-sm-8">
                            <span id="plafond_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1 p_outstanding" hidden>
                        <label for="kategori" class="col-sm-4 col-form-label">Outstanding</label>
                        <div class="col-sm-8">
                            <span id="outstanding_det" class="col-form-label"></span>
                        </div>
                    </div>
                    <div class="form-group row p-1 p_pelaporan" hidden>
                        <label for="kategori" class="col-sm-4 col-form-label">Pokok Pelaporan</label>
                        <div class="col-sm-8">
                            <span id="tunggakan_pokok_det" class="col-form-label"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/js/plugins/jQuery/jQuery-2.1.3.min.js'); ?>"></script>
<script>
     /*$(function () {
        $('#kelolaan').DataTable({
            order: [[ 0, "asc" ]],
            pageLength: 25,
            scrollY:"800px",
            scrollCollapse: false
        })
    });*/

    // untuk javascript datatables
$(document).ready(function() {

    $('#import_form').on('submit', function(event){

        event.preventDefault();

        $.ajax({

            url         :"<?= base_url('Auth/import') ?>",
            method      :"POST",
            data        :new FormData(this),
            contentType :false,
            cache       :false,
            processData :false,
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

    // 26-01-21
    var tabel_kelolaan  = $('#tabel_kelolaan').DataTable({
        "processing"    : true,
        "serverSide"    : true,
        "ajax"          : {
            "url"   : "<?= base_url() ?>Kelolaan/tampil_kelolaan",
            "type"  : "POST",
            "data"  : function (data) {
                data.jenis      = $('#jenis').val();
                data.status     = $('#status_kelolaan').val();
                data.kanwil     = $('#kanwil2').val();
                data.cabang     = $('#cabang').val();
                data.ao         = $('#ao2').val();
            }
        },
        "order"         : [[ 0, 'asc']],
        "columnDefs"     : [{
            "targets"       : [0,6,7],
            "orderable"     : false
        }, {
            "targets"       : [0,7],
            "className"     : "text-center"
        }]
    });

    // 26-01-21
    $('#tampilkan').on('click', function () {

        tabel_kelolaan.ajax.reload(null, false);
        
    })

    // 26-01-21
    $('#reset').on('click', function () {

        $('#kanwil2').val('').trigger('change');
        $('#ao2').val('').trigger('change');
        $('#cabang').val('').trigger('change');
        $('#status_kelolaan').val('').trigger('change');
        tabel_kelolaan.ajax.reload(null, false);
        
    })

    // 26-01-21
    $('.select2').select2()

    // 26-01-21
    $('#tabel_kelolaan').on('click', '.detail', function () {

        var nama            = $(this).attr('nama');
        var alamat          = $(this).attr('alamat');
        var telepon         = $(this).attr('telepon');
        var handphone       = $(this).attr('handphone');
        var kanwil          = $(this).attr('kanwil');
        var cabang_induk    = $(this).attr('cabang_induk');
        var kantor          = $(this).attr('kantor');
        var deal_reff       = $(this).attr('deal_reff');
        var ao              = $(this).attr('ao');
        var cif             = $(this).attr('cif');
        var segmen          = $(this).attr('segmen');
        var loan_type       = $(this).attr('loan_type');
        var plafond         = $(this).attr('plafond');
        var outstanding     = $(this).attr('outstanding');
        var tunggakan_pokok = $(this).attr('tunggakan_pokok');

        var jenis           = $('#jenis').val();

        if (jenis == 'wo') {
            $('.p_outstanding').attr('hidden', true);
            $('.p_pelaporan').attr('hidden', false);
        } else {
            $('.p_outstanding').attr('hidden', false);
            $('.p_pelaporan').attr('hidden', true);
        }

        $('#nama_det').text(": "+nama);
        $('#alamat_det').text(": "+alamat);
        $('#telepon_det').text(": "+telepon);
        $('#handphone_det').text(": "+handphone);
        $('#kanwil_det').text(": "+kanwil);
        $('#cabang_induk_det').text(": "+cabang_induk);
        $('#kantor_det').text(": "+kantor);
        $('#deal_reff_det').text(": "+deal_reff);
        $('#ao_det').text((ao == '') ? ': Belum Masuk Kelolaan' : ': '+ao);
        $('#cif_det').text(": "+cif);
        $('#segmen_det').text(": "+segmen);
        $('#loan_type_det').text(": "+loan_type);
        $('#plafond_det').text(": "+plafond);
        $('#outstanding_det').text(": "+outstanding);
        $('#tunggakan_pokok_det').text(": "+tunggakan_pokok);
        $('#modal_detail').modal('show');
        
    })

    // 06-01-2021
    $('#tabel_kelolaan').on('click', '.tambah_kelolaan', function () {

        $('#simpan').attr('disabled', true);

        var cabang_induk    = $(this).attr('cabang_induk');
        var deal_reff       = $(this).attr('deal_reff');
        var nama            = $(this).attr('nama');
        var kanwil          = $(this).attr('kanwil');
        
        $.ajax({
            url         : "<?= base_url() ?>Kelolaan/ambil_ao",
            method      : "POST",
            // beforeSend  : function () {
            //     swal({
            //         title   : 'Menunggu',
            //         html    : 'Memproses Data',
            //         onOpen  : () => {
            //             swal.showLoading();
            //         }
            //     })
            // },
            data        : {cabang_induk:cabang_induk},
            dataType    : "JSON",
            success     : function (data) {
                
                swal.close();
                $('.ao').html(data.option);
                $('#nama').text(": "+nama);
                $('#kanwil').text(": "+kanwil);
                $('#cabang_induk').text(": "+cabang_induk);
                $('#Tdeal_reff').text(": "+deal_reff);
                $('#deal_reff').val(deal_reff);
                $('#modal_tambah').modal('show');
                
            },
            error       : function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }

        })

        return false;
        
    })

    // 06-01-2021
    $('.ao').on('change', function () {

        var isi = $(this).val();

        if (isi == '') {
            $('#simpan').attr('disabled', true);
        } else {
            $('#simpan').attr('disabled', false);
        }
        
    })

    // 06-01-2021
    $('#simpan').on('click', function () {

        var jenis_debitur   = $('#jenis_debitur').val();
        var deal_reff       = $('#deal_reff').val();
        var reg_employee    = $('.ao').val();

        swal({
            title       : 'Peringatan',
            html        : 'Apakah yakin akan simpan data?',
            type        : 'warning',

            buttonsStyling      : true,
            confirmButtonClass  : "btn btn-success btn-sm",
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
                    url         : "<?= base_url() ?>Kelolaan/simpan_kelolaan",
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
                    data        : {jenis_debitur:jenis_debitur, deal_reff:deal_reff, reg_employee:reg_employee},
                    dataType    : "JSON",
                    success     : function (data) {
                        
                            $('#modal_tambah').modal('hide');

                            if (data.status == 'sukses') {
                                swal({
                                    title               : 'Berhasil',
                                    text                : 'Data Berhasil Disimpan',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-success",
                                    type                : 'success',
                                    showConfirmButton   : false,
                                    timer               : 1000
                                });  
                            } else {
                                swal({
                                    title               : 'Gagal',
                                    text                : 'Data Telah Punya Kelolaan',
                                    buttonsStyling      : true,
                                    type                : 'error',
                                    showConfirmButton   : true
                                });  
                            }

                            $('#ao2').html(data.option);

                            tabel_kelolaan.ajax.reload(null, false);
                        
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
                        text                : 'Anda membatalkan simpan data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })
        
    })

   $('#kelolaan').DataTable({ 
 
      "processing"      : true, 
      "serverSide"      : true, 
      "scrollCollapse"  : false,

      "order": [], 
             
      "ajax": {
          "url": "<?php echo site_url("kelolaan/json/$aktif")?>",
          "type": "POST"
      },
  
      "columnDefs": [
          { 
              "targets": [ -1 ], 
              "orderable": false, 
          },
      ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {    
        var index = iDisplayIndex +1;
        $('td:eq(0)',nRow).html(index);
        return nRow;
        }
 
   });
});

</script>