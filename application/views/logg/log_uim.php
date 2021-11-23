<style type="text/css">

    #tabel_log_uim tr th {
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

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm" id="tabel_log_uim" width="100%">
                        <thead style="background-color: #e3e3fb;">
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>RC</th>
                                <th>Response</th>
                                <th>Message</th>
                                <th>Created At</th>
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

        var tabel_log_uim  = $('#tabel_log_uim').DataTable({
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                "url"   : "<?= base_url() ?>Log_req/tampil_log_uim",
                "type"  : "POST"
            },
            "columnDefs"     : [{
                "targets"       : [0],
                "orderable"     : false
            }, {
                "targets"       : [0],
                "className"     : "text-center"
            }]
        });
        
    })
</script>