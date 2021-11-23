                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <?php echo form_open("kelolaan/post/$jenis"); ?>
                                <div class="form-group">
                                    <label>AO</label>
                                    <select class="form-control" name="reg_employee">
                                        <?php if (!empty($record)): ?>
                                            <?php foreach ($record as $r) {?>
                                            <option value="<?php echo $r->reg_employee; ?>">
                                            <?php echo $r->name;?>
                                            </option>
                                            <?php } ?>
                                        <?php else: ?>
                                            <option value="">-- AO TIDAK ADA --</option>
                                        <?php endif ?>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Deal Reff</label>
                                    <input class="form-control" name="deal_reff" value="<?php echo $rcd;?>">
                                </div>
                                <a href="<?= base_url("kelolaan/data/$jenis") ?>"><button type="button" class="btn btn-default btn-sm">Kembali</button></a> <?= nbs(5) ?>
                                <button type="submit" name="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </div>
                        </div>
                        <!-- /. PANEL  -->
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <!-- /. ROW  -->