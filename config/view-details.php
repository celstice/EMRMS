<!-- MODAL for viewing request details -->
<div id="view-details<?php echo $row['job_id'] ?>" aria-hidden="true" class="modal">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0 text-center d-flex justify-content-center align-items-center">
                <h6 class="text-uppercase fw-bold">Job Request Details</h6>
            </div>
            <div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
                <?php
                    $jid = $row['job_id'];
                    $query = mysqli_query($connect, "SELECT * FROM job_request WHERE userID = '$user' and job_id = '$jid'");
                    while ($rows = mysqli_fetch_assoc($query)) {
                ?>
                <div class="border">
                    <div class="">
                        <div class="border-bottom p-2 d-flex justify-content-center tea-green-bg">
                            <span class="tg-text text-uppercase fw-bold text-center">Job Control Number:&nbsp;</span>
                            <span class="fw-bold text-center"><?php echo $rows['job_control_number']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Request for Job Services to be Rendered:</span>
                            <span class=""><?php echo $rows['job_service']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Requesting Official:</span>
                            <span class=""><?php echo $rows['requesting_official']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Location:</span>
                            <span class=""><?php echo $rows['job_location']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Date Requested:</span>
                            <span class=""><?php echo date("F j, Y", strtotime($rows['date_requested'])); ?></span>
                        </div>
                        <!-- <hr> -->
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Supplies / Materials Needed:</span>
                            <span class=""><?php echo $rows['supplies_materials']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Causes & Remedies:</span>
                            <span class=""><?php echo $rows['causes']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Assigned Personnel:</span>
                            <span class=""><?php echo $rows['assigned_personnel']; ?></span>
                        </div>
                        <div class="borderx p-2 d-flex flex-column text-center">
                            <span class="fst-italic fw-bold tg-text">Feedback Number:</span>
                            <span class=""><?php echo $rows['feedback_number']; ?></span>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button class="tg-text text-upppercase btn btn-secondary bg-opacity-50 text-light fw-bold rounded-0">CLOSE</button>
            </div>
        </div>
    </div>
</div>
