<?php
function repairType($job)
{
    if ($job == 1) {
        $job = "Aircon Cleaning";
        echo $job;
    } else if ($job == 2) {
        $job = "Aircon Repair";
        echo $job;
    } else if ($job == 3) {
        $job = "Aircon Installation";
        echo $job;
    } else if ($job == 4) {
        $job = "Electric Fan Cleaning / Repair";
        echo $job;
    } else if ($job == 5) {
        $job = "Electric Fan installation";
        echo $job;
    } else if ($job == 6) {
        $job = "Other Equipment Repair";
        echo $job;
    } else if ($job == 7) {
        $job = "Computer Repair & Troubleshoot";
        echo $job;
    } else if ($job == 8) {
        $job = "Hauling Services";
        echo $job;
    }
}

?>