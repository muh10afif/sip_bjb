            <div class="row">
                <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <?php echo form_open("kelolaan/update/$jenis"); ?>
                                <div class="form-group">
                                    <label>AO</label>
                                    <select class="form-control" name="reg_employee">
                                        <?php foreach ($record as $r) {?>
                                        <option value="<?php echo $r->reg_employee; ?>">
                                        <?php echo $r->name;?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="deal_reff" value="<?php echo $rcd; ?>">
                                    <label>Deal Reff</label>
                                        <input class="form-control" id="disabledInput" type="text" value="<?php echo $rcd;?>" disabled>
                                </div>
                                <a href="<?= base_url("kelolaan/tf_kelolaan/$jenis") ?>"><button type="button" class="btn btn-default btn-sm">Kembali</button></a> <?= nbs(5) ?>
                                <button type="submit" name="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </div>
                        </div>
                        <!-- /. PANEL  -->
                    </div>
                <div class="col-md-3"></div>
            </div>
                <!-- /. ROW  -->