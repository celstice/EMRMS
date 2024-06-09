<!-- MODAL for confirming request -->
<div id="confirm-request<?php echo $row['job_id'] ?>" aria-hidden="true" class="modal">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0 text-center d-flex justify-content-center align-items-center tea-green-bg">
                <h6 class="text-uppercase fw-bold">Confirm Job Request</h6>
            </div>
            <form id="confirmForm" action="" method="post" onsubmit="loading()">
                <input id="job-id" name="job-id" hidden value="<?php echo $row['job_id']; ?>">
                <input id="uid" name="uid" hidden value="<?php echo $row['userID']; ?>">
                <div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
                    <?php
                    $jid = $row['job_id'];
                    $query = mysqli_query($connect, "SELECT * FROM job_request WHERE job_id = '$jid'");
                    while ($rows = mysqli_fetch_assoc($query)) { ?>

                        <div class="borders">
                            <div class="">
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Request for Job Services to be Rendered:</span>
                                    <input class="form-control" id="job-service" required name="job-service" value="<?php echo $row['job_service']; ?>">
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Requesting Official:</span>
                                    <input class="form-control" id="requesting-official" required name="requesting-official" value="<?php echo $row['requesting_official']; ?>">
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Location:</span>
                                    <input class="form-control" id="location" required name="job-location" value="<?php echo $row['job_location']; ?>">
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Date Requested:</span>
                                    <input class="form-control" type="date" id="date-requested" required name="date-requested" value="<?php echo $row['date_requested']; ?>">
                                </div>
                                <hr>
                                <div class="border-bottom p-2 d-flex flex-column justify-content-center tea-green-bgx">
                                    <span class="tg-text text-uppercase fw-bold text-center">Job Control Number:&nbsp;<span class="text-danger">*</span></span>
                                    <input class="form-control" id="job-number" name="job-number" placeholder="ERMS-0000" required>
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Supplies / Materials Needed:</span>
                                    <textarea rows="2" class="form-control" id="supplies-materials" name="supplies-materials" required></textarea>
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Causes & Remedies:</span>
                                    <textarea rows="2" class="form-control" id="causes" name="causes" required></textarea>
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Assigned Personnel:</span>
                                    <textarea rows="2" class="form-control" id="assigned-personnel" name="assigned-personnel" required>ERMS Personnel</textarea>
                                </div>
                                <div class="borderx p-2 d-flex flex-column text-center">
                                    <span class="fst-italic fw-bold tg-text">Feedback Number:<span class="text-danger">*</span></span>
                                    <input class="form-control" id="feedback-number" placeholder="00000" name="feedback-number" required>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <div class="m-1">
                            <button type="button" class="btn btn-danger close " data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                        <div class="m-1">
                            <button value="" type="submit" name="confirm" id="confirm" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>