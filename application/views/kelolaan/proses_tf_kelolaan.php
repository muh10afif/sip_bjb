<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-body">
                <?php echo form_open("kelolaan/proses_kelola/$jenis"); ?>
                <div class="form-group">
                    <label>AO</label>

                    <input class="form-control" type="text" value="<?php echo $rcd['name'];?>" readonly>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $rcd['ida']; ?>">
                    <label>Deal Reff</label>
                        <input class="form-control" type="text" name="deal" value="<?php echo $rcd['deal_reff'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Proses</label>
                    <select class="form-control" name="stat">
                        <option value="1">Setujui
                        </option>
                        <option value="2">Tolak
                        </option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-sm">Simpan</button>
            <?= form_close(); ?>
            </div>
        </div>
        <!-- /. PANEL  -->
    </div>
</div>
<!-- /. ROW  -->