<!-- MODAL for editing schedule details -->
<div class="modal fade modal-xl" id="editSched<?php echo $row['scheduled_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-dark">
                <h5 class="modal-title" id="">Edit Preventive Maintenance Program Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="../config/edit-sched.php" onsubmit="updaterecord()">
                    <input hidden name="sched-id" id="sched-id" value="<?php echo $row['scheduled_id'] ?>">
                    <div class="row">
                        <div class="col-md mb-2">
                            <label for="sched-location">Offices / Colleges / Dorms:</label>
                            <textarea rows=2 type="text" class="form-control" name="sched-location" id="sched-location" placeholder="" value="<?php echo $row['scheduled_id'] ?>" required><?php echo $row['sched_location'] ?></textarea>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Quarter:</label>
                            <select class="form-control" name="quarter" id="quarter" value="" placeholder="Quarter">
                                <option><?php echo $row['quarter'] ?></option>
                                <option value="1">1st QUARTER</option>
                                <option value="2">2nd QUARTER</option>
                                <option value="3">3rd QUARTER</option>
                                <option value="4">4th QUARTER</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md mb-2">
                            <label for="rac-window">RAC Window Type:</label>
                            <input type="number" class="form-control" name="rac-window" id="rac-window" value="<?php echo $row['rac_window_type'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="rac-split">RAC Split Type:</label>
                            <input type="number" class="form-control" name="rac-split" id="rac-window" value="<?php echo $row['rac_split_type'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="ref-freezer">Ref / Freezer:</label>
                            <input type="number" class="form-control" name="ref-freezer" id="ref-freezer" value="<?php echo $row['ref_freezer'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="car-aircon">Car Aircon:</label>
                            <input type="number" class="form-control" name="car-aircon" id="car-aircon" value="<?php echo $row['car_aircon'] ?>" placeholder="" required>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md mb-2">
                            <label for="electric-fan">Electric Fan:</label>
                            <input type="number" class="form-control" name="electric-fan" id="electric-fan" value="<?php echo $row['electric_fan'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="computer-unit">Computer Unit:</label>
                            <input type="number" class="form-control" name="computer-unit" id="computer-unit" value="<?php echo $row['computer_unit'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="type-writer">Type Writer:</label>
                            <input type="number" class="form-control" name="type-writer" id="type-writer" value="<?php echo $row['type_writer'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="dispenser">Dispenser:</label>
                            <input type="number" class="form-control" name="dispenser" id="dispenser" value="<?php echo $row['dispenser'] ?>" placeholder="" required>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md mb-2">
                            <label for="lab-equipment">Laboratory Equipment:</label>
                            <input type="number" class="form-control" name="lab-equipment" id="lab-equipment" value="<?php echo $row['lab_equipment'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for="others">Other Equipment:</label>
                            <input type="number" class="form-control" name="others" id="others" value="<?php echo $row['others'] ?>" placeholder="" required>
                        </div>
                        <div class="col-md mb-2">
                            <label for=""></label>
                            <input type="" class="form-control" name="" placeholder="" hidden>
                        </div>
                        <div class="col-md mb-2">
                            <label for=""></label>
                            <input type="" class="form-control" name="" placeholder="" hidden>
                        </div>
                    </div>
            </div>
            <br>

            <div class="modal-footer d-flex justify-content-center align-items-center">
                <button type="submit" name="edit" class="btn btn-warning">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>