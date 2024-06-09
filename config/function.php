<?php
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

function numberValue($value5,$value4,$value3,$value2,$value1){

    if ($value5 >= $value4 && $value5 >= $value3 && $value5 >= $value2 && $value5 >= $value1) {
        return 5;
    } elseif ($value4 >= $value3 && $value4 >= $value2 && $value4 >= $value1) {
        return 4;
    } elseif ($value3 >= $value2 && $value3 >= $value1) {
        return 3;
    } elseif ($value2 >= $value1) {
        return 2;
    } else {
        return 1;
    }
 
}

function AdRating($mean){
    if ($mean >=4.21 && $mean<=5.00) {
        $mean = "Excellent";
        echo $mean;
    } else if ($mean >= 3.41 && $mean <= 4.20) {
        $mean = "Very Good";
        echo $mean;
    } else if ($mean >= 2.61 && $mean <= 3.40) {
        $mean = "Good";
        echo $mean;
    } else if ($mean >= 1.81 && $mean <= 2.60) {
        $mean = "Fair";
        echo $mean;
    } else if ($mean >= 1.00 && $mean <= 1.80) {
        $mean = "Needs Improvement";
        echo $mean;
    }
}

// $currentDate = date('Y-m-d');
// $start = date('Y-m-01', strtotime($currentDate));
// $end = date('Y-m-t', strtotime($currentDate));

$queryone = "SELECT COUNT(*) as ac_cleaned  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=1 AND done=1";
// $ACcleaned = mysqli_fetch_assoc($one);
$one = $connect->prepare($queryone);
$one->bind_param("ss", $from, $to);
$one->execute();
$ONE = $one->get_result();
$ACcleaned = $ONE->fetch_assoc();
$service1 = $ACcleaned['ac_cleaned'];

$querytwo = "SELECT COUNT(*) as ac_repair  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=2 AND done=1";
// $ACrepair = mysqli_fetch_assoc($two);
$two = $connect->prepare($querytwo);
$two->bind_param("ss", $from, $to);
$two->execute();
$TWO = $two->get_result();
$ACrepair = $TWO->fetch_assoc();
$service2 = $ACrepair['ac_repair'];

$querythree = "SELECT COUNT(*) as ac_install  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=3 AND done=1";
// $ACinstall = mysqli_fetch_assoc($three);
$three = $connect->prepare($querythree);
$three->bind_param("ss", $from, $to);
$three->execute();
$THREE = $three->get_result();
$ACinstall = $THREE->fetch_assoc();
$service3 = $ACinstall['ac_install'];

$queryfour = "SELECT COUNT(*) as fan_repair  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=4 AND done=1";
// $EFrepair = mysqli_fetch_assoc($four);
$four = $connect->prepare($queryfour);
$four->bind_param("ss", $from, $to);
$four->execute();
$FOUR = $four->get_result();
$EFrepair = $FOUR->fetch_assoc();
$service4 = $EFrepair['fan_repair'];

$queryfive = "SELECT COUNT(*) as fan_install  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=5 AND done=1";
// $EFinstall = mysqli_fetch_assoc($five);
$five = $connect->prepare($queryfive);
$five->bind_param("ss", $from, $to);
$five->execute();
$FIVE = $five->get_result();
$EFinstall = $FIVE->fetch_assoc();
$service5 = $EFinstall['fan_install'];

$querysix = "SELECT COUNT(*) as equipment  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=6 AND done=1";
// $equipment = mysqli_fetch_assoc($six);
$six = $connect->prepare($querysix);
$six->bind_param("ss", $from, $to);
$six->execute();
$SIX = $six->get_result();
$equipment = $SIX->fetch_assoc();
$service6 = $equipment['equipment'];

$queryseven = "SELECT COUNT(*) as computer  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=7 AND done=1";
// $computer = mysqli_fetch_assoc($seven);
$seven = $connect->prepare($queryseven);
$seven->bind_param("ss", $from, $to);
$seven->execute();
$SEVEN = $seven->get_result();
$computer = $SEVEN->fetch_assoc();
$service7 = $computer['computer']; 

$queryeight = "SELECT COUNT(*) as hauling  FROM repair_records WHERE date_finish BETWEEN ? AND ? AND repair_type=8 AND done=1";
// $hauling = mysqli_fetch_assoc($eight);
$eight = $connect->prepare($queryeight);
$eight->bind_param("ss", $from, $to);
$eight->execute();
$EIGHT = $eight->get_result();
$hauling = $EIGHT->fetch_assoc();
$service8 = $hauling['hauling'];

$total_job = $service1+$service2+$service3+$service4+$service5+$service6+$service7+$service8;
// echo "TOTAL JOB: ".$total_job;
if ($total_job!=0){
$percent1 = number_format(round((($service1 / $total_job) * 100), 2), 2);
$percent2 = number_format(round((($service2 / $total_job) * 100), 2), 2);
$percent3 = number_format(round((($service3 / $total_job) * 100), 2), 2);
$percent4 = number_format(round((($service4 / $total_job) * 100), 2), 2);
$percent5 = number_format(round((($service5 / $total_job) * 100), 2), 2);
$percent6 = number_format(round((($service6 / $total_job) * 100), 2), 2);
$percent7 = number_format(round((($service7 / $total_job) * 100), 2), 2);
$percent8 = number_format(round((($service8 / $total_job) * 100), 2), 2);
} else {
    // echo "no data";
    $percent1 = "0";
    $percent2 = "0";
    $percent3 = "0";
    $percent4 = "0";
    $percent5 = "0";
    $percent6 = "0";
    $percent7 = "0";
    $percent8 = "0";
}

// -------------------------------------------------------------------------------------
// RESPONSIVENESS #1
// count how many raters answered (5,4,3,2,1) in responsive1 column
$responsive1 = $connect->prepare("SELECT
    SUM(CASE WHEN responsive1 = 5 THEN 1 ELSE 0 END) as responsive1_5,
    SUM(CASE WHEN responsive1 = 4 THEN 1 ELSE 0 END) as responsive1_4,
    SUM(CASE WHEN responsive1 = 3 THEN 1 ELSE 0 END) as responsive1_3,
    SUM(CASE WHEN responsive1 = 2 THEN 1 ELSE 0 END) as responsive1_2,
    SUM(CASE WHEN responsive1 = 1 THEN 1 ELSE 0 END) as responsive1_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Responsive1 = mysqli_query($connect,$responsive1);
// $rs1= mysqli_fetch_assoc($Responsive1);
$responsive1->bind_param("ss", $from, $to);
$responsive1->execute();
$RS1 = $responsive1->get_result();
$rs1 = $RS1->fetch_assoc();
$responsive1_5 = $rs1['responsive1_5'];
$responsive1_4 = $rs1['responsive1_4'];
$responsive1_3 = $rs1['responsive1_3'];
$responsive1_2 = $rs1['responsive1_2'];
$responsive1_1 = $rs1['responsive1_1'];

# pick which rate number (5,4,3,2,1) has the highest count in responsive1
$rs1Max = max($responsive1_5, $responsive1_4, $responsive1_3, $responsive1_2, $responsive1_1);
// echo "RS1MAX:".$rs1Max;
if ($rs1Max!=0){
    # pick which rate number (5,4,3,2,1) has the highest count in responsive1_x and assign the value 5 if responsive1_5 has the highest count etc 
    $rs1number = numberValue($responsive1_5, $responsive1_4, $responsive1_3, $responsive1_2, $responsive1_1);
    $rs1Mean = number_format(round((($rs1Max / $raters) * $rs1number), 2), 2);
} else {
    $rs1number = "0";
    $rs1Mean = "0.00";
}

// -------------------------------------------------------------------------------------
// RESPONSIVENESS #2
# count how many raters answered (5,4,3,2,1) in responsive1 column
$responsive2 = $connect->prepare("SELECT
    SUM(CASE WHEN responsive2 = 5 THEN 1 ELSE 0 END) as responsive2_5,
    SUM(CASE WHEN responsive2 = 4 THEN 1 ELSE 0 END) as responsive2_4,
    SUM(CASE WHEN responsive2 = 3 THEN 1 ELSE 0 END) as responsive2_3,
    SUM(CASE WHEN responsive2 = 2 THEN 1 ELSE 0 END) as responsive2_2,
    SUM(CASE WHEN responsive2 = 1 THEN 1 ELSE 0 END) as responsive2_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Responsive2 = mysqli_query($connect, $responsive2);
// $rs2 = mysqli_fetch_assoc($Responsive2);
$responsive2->bind_param("ss", $from, $to);
$responsive2->execute();
$RS2 = $responsive2->get_result();
$rs2 = $RS2->fetch_assoc();
$responsive2_5 = $rs2['responsive2_5'];
$responsive2_4 = $rs2['responsive2_4'];
$responsive2_3 = $rs2['responsive2_3'];
$responsive2_2 = $rs2['responsive2_2'];
$responsive2_1 = $rs2['responsive2_1'];

# pick which rate number (5,4,3,2,1) has the highest count in responsive1
$rs2Max = max($responsive2_5, $responsive2_4, $responsive2_3, $responsive2_2, $responsive2_1);

if ($rs2Max!=0){
    # pick which rate number (5,4,3,2,1) has the highest count in responsive1_x and assign the value 5 if responsive1_5 has the highest count etc 
    $rs2number = numberValue($responsive2_5, $responsive2_4, $responsive2_3, $responsive2_2, $responsive2_1);
    $rs2Mean = number_format(round((($rs2Max / $raters) * $rs2number), 2), 2);
} else {
    $rs2number = "0";
    $rs2Mean = "0.00";
}

$rsMean=number_format(round((($rs1Mean+$rs2Mean) /2 ), 2), 2);

// -------------------------------------------------------------------------------------
// RELIABILITY #1
$reliability1 = $connect->prepare("SELECT
    SUM(CASE WHEN reliability1 = 5 THEN 1 ELSE 0 END) as reliability1_5,
    SUM(CASE WHEN reliability1 = 4 THEN 1 ELSE 0 END) as reliability1_4,
    SUM(CASE WHEN reliability1 = 3 THEN 1 ELSE 0 END) as reliability1_3,
    SUM(CASE WHEN reliability1 = 2 THEN 1 ELSE 0 END) as reliability1_2,
    SUM(CASE WHEN reliability1 = 1 THEN 1 ELSE 0 END) as reliability1_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Reliability1 = mysqli_query($connect, $reliability1);
// $rl1 = mysqli_fetch_assoc($Reliability1);
$reliability1->bind_param("ss", $from, $to);
$reliability1->execute();
$RL1 = $reliability1->get_result();
$rl1 = $RL1->fetch_assoc();
$reliability1_5 = $rl1['reliability1_5'];
$reliability1_4 = $rl1['reliability1_4'];
$reliability1_3 = $rl1['reliability1_3'];
$reliability1_2 = $rl1['reliability1_2'];
$reliability1_1 = $rl1['reliability1_1'];

$rl1Max = max($reliability1_5, $reliability1_4, $reliability1_3, $reliability1_2, $reliability1_1);

if ($rl1Max!=0){
    $rl1number = numberValue($reliability1_5, $reliability1_4, $reliability1_3, $reliability1_2, $reliability1_1);   
    $rl1Mean = number_format(round((($rl1Max / $raters) * $rl1number), 2), 2);
} else {
    $rl1number = "0";
    $rl1Mean ="0.00";
}

// -------------------------------------------------------------------------------------
// RELIABILITY #2
$reliability2 = $connect->prepare("SELECT
    SUM(CASE WHEN reliability2 = 5 THEN 1 ELSE 0 END) as reliability2_5,
    SUM(CASE WHEN reliability2 = 4 THEN 1 ELSE 0 END) as reliability2_4,
    SUM(CASE WHEN reliability2 = 3 THEN 1 ELSE 0 END) as reliability2_3,
    SUM(CASE WHEN reliability2 = 2 THEN 1 ELSE 0 END) as reliability2_2,
    SUM(CASE WHEN reliability2 = 1 THEN 1 ELSE 0 END) as reliability2_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Reliability2 = mysqli_query($connect, $reliability2);
// $rl2 = mysqli_fetch_assoc($Reliability2);
$reliability2->bind_param("ss", $from, $to);
$reliability2->execute();
$RL2 = $reliability2->get_result();
$rl2 = $RL2->fetch_assoc();
$reliability2_5 = $rl2['reliability2_5'];
$reliability2_4 = $rl2['reliability2_4'];
$reliability2_3 = $rl2['reliability2_3'];
$reliability2_2 = $rl2['reliability2_2'];
$reliability2_1 = $rl2['reliability2_1'];

$rl2Max = max($reliability2_5, $reliability2_4, $reliability2_3, $reliability2_2, $reliability2_1);

if ($rl2Max!=0){
    $rl2number = numberValue($reliability2_5, $reliability2_4, $reliability2_3, $reliability2_2, $reliability2_1);   
    $rl2Mean = number_format(round((($rl2Max / $raters) * $rl2number), 2), 2);
} else {
    $rl2number = "0";
    $rl2Mean = "0.00";
}

$rlMean = number_format(round((($rl1Mean + $rl2Mean) / 2), 2), 2);

// -------------------------------------------------------------------------------------
// FACILITIES
$facility = $connect->prepare("SELECT
    SUM(CASE WHEN facility = 5 THEN 1 ELSE 0 END) as facility_5,
    SUM(CASE WHEN facility = 4 THEN 1 ELSE 0 END) as facility_4,
    SUM(CASE WHEN facility = 3 THEN 1 ELSE 0 END) as facility_3,
    SUM(CASE WHEN facility = 2 THEN 1 ELSE 0 END) as facility_2,
    SUM(CASE WHEN facility = 1 THEN 1 ELSE 0 END) as facility_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Facility= mysqli_query($connect, $facility);
// $fac = mysqli_fetch_assoc($Facility);
$facility->bind_param("ss", $from, $to);
$facility->execute();
$FAC = $facility->get_result();
$fac = $FAC->fetch_assoc();
$facility_5 = $fac['facility_5'];
$facility_4 = $fac['facility_4'];
$facility_3 = $fac['facility_3'];
$facility_2 = $fac['facility_2'];
$facility_1 = $fac['facility_1'];

$facilityMax = max($facility_5, $facility_4, $facility_3, $facility_2, $facility_1);

if ($facilityMax!=0){
    $fnumber = numberValue($facility_5, $facility_4, $facility_3, $facility_2, $facility_1);   
    $facilityMean = number_format(round((($facilityMax / $raters) * $fnumber), 2), 2);
} else {
    $fnumber = "0";
    $facilityMean = "0.00";
}

// -------------------------------------------------------------------------------------
// ACCESS
$access = $connect->prepare("SELECT
    SUM(CASE WHEN access = 5 THEN 1 ELSE 0 END) as access_5,
    SUM(CASE WHEN access = 4 THEN 1 ELSE 0 END) as access_4,
    SUM(CASE WHEN access = 3 THEN 1 ELSE 0 END) as access_3,
    SUM(CASE WHEN access = 2 THEN 1 ELSE 0 END) as access_2,
    SUM(CASE WHEN access = 1 THEN 1 ELSE 0 END) as access_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Access = mysqli_query($connect, $access);
// $acc = mysqli_fetch_assoc($Access);
$access->bind_param("ss", $from, $to);
$access->execute();
$ACC = $access->get_result();
$acc = $ACC->fetch_assoc();
$access_5 = $acc['access_5'];
$access_4 = $acc['access_4'];
$access_3 = $acc['access_3'];
$access_2 = $acc['access_2'];
$access_1 = $acc['access_1'];

$accessMax = max($access_5, $access_4, $access_3, $access_2, $access_1);

if ($accessMax!=0){
    $acnumber = numberValue($access_5, $access_4, $access_3, $access_2, $access_1);   
    $accessMean = number_format(round((($accessMax / $raters) * $acnumber), 2), 2);
} else {
    $acnumber = "0";
    $accessMean = "0.00";
}

$AFMean = number_format(round((($facilityMean + $accessMean) / 2), 2), 2);

// -------------------------------------------------------------------------------------
// COMMUNICATION #1
$communication1 = $connect->prepare("SELECT
    SUM(CASE WHEN communication1 = 5 THEN 1 ELSE 0 END) as communication1_5,
    SUM(CASE WHEN communication1 = 4 THEN 1 ELSE 0 END) as communication1_4,
    SUM(CASE WHEN communication1 = 3 THEN 1 ELSE 0 END) as communication1_3,
    SUM(CASE WHEN communication1 = 2 THEN 1 ELSE 0 END) as communication1_2,
    SUM(CASE WHEN communication1 = 1 THEN 1 ELSE 0 END) as communication1_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Communication1 = mysqli_query($connect, $communication1);
// $comm1 = mysqli_fetch_assoc($Communication1);
$communication1->bind_param("ss", $from, $to);
$communication1->execute();
$COMM1 = $communication1->get_result();
$comm1 = $COMM1->fetch_assoc();
$communication1_5 = $comm1['communication1_5'];
$communication1_4 = $comm1['communication1_4'];
$communication1_3 = $comm1['communication1_3'];
$communication1_2 = $comm1['communication1_2'];
$communication1_1 = $comm1['communication1_1'];

$comm1Max = max($communication1_5, $communication1_4, $communication1_3, $communication1_2, $communication1_1);

if ($comm1Max!=0){
    $comm1number = numberValue($communication1_5, $communication1_4, $communication1_3, $communication1_2, $communication1_1);   
    $comm1Mean = number_format(round((($comm1Max / $raters) * $comm1number), 2), 2);
} else {
    $comm1number = "0";
    $comm1Mean = "0.00";
}

// -------------------------------------------------------------------------------------
// COMMUNICATION #2
$communication2 = $connect->prepare("SELECT
    SUM(CASE WHEN communication2 = 5 THEN 1 ELSE 0 END) as communication2_5,
    SUM(CASE WHEN communication2 = 4 THEN 1 ELSE 0 END) as communication2_4,
    SUM(CASE WHEN communication2 = 3 THEN 1 ELSE 0 END) as communication2_3,
    SUM(CASE WHEN communication2 = 2 THEN 1 ELSE 0 END) as communication2_2,
    SUM(CASE WHEN communication2 = 1 THEN 1 ELSE 0 END) as communication2_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Communication2 = mysqli_query($connect, $communication2);
// $comm2 = mysqli_fetch_assoc($Communication2);
$communication2->bind_param("ss", $from, $to);
$communication2->execute();
$COMM2 = $communication2->get_result();
$comm2 = $COMM2->fetch_assoc();
$communication2_5 = $comm2['communication2_5'];
$communication2_4 = $comm2['communication2_4'];
$communication2_3 = $comm2['communication2_3'];
$communication2_2 = $comm2['communication2_2'];
$communication2_1 = $comm2['communication2_1'];

$comm2Max = max($communication2_5, $communication2_4, $communication2_3, $communication2_2, $communication2_1);

if ($comm2Max!=0){
    $comm2number = numberValue($communication2_5, $communication2_4, $communication2_3, $communication2_2, $communication2_1);   
    $comm2Mean = number_format(round((($comm2Max / $raters) * $comm2number), 2), 2);
} else {
    $comm2number = "0";
    $comm2Mean = "0.00";
}

$commMean = number_format(round((($comm1Mean + $comm2Mean) / 2), 2), 2);

// -------------------------------------------------------------------------------------
// COSTS #1
$cost1 = $connect->prepare("SELECT
    SUM(CASE WHEN cost1 = 5 THEN 1 ELSE 0 END) as cost1_5,
    SUM(CASE WHEN cost1 = 4 THEN 1 ELSE 0 END) as cost1_4,
    SUM(CASE WHEN cost1 = 3 THEN 1 ELSE 0 END) as cost1_3,
    SUM(CASE WHEN cost1 = 2 THEN 1 ELSE 0 END) as cost1_2,
    SUM(CASE WHEN cost1 = 1 THEN 1 ELSE 0 END) as cost1_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Cost1 = mysqli_query($connect, $cost1);
// $cs1 = mysqli_fetch_assoc($Cost1);
$cost1->bind_param("ss", $from, $to);
$cost1->execute();
$CS1 = $cost1->get_result();
$cs1 = $CS1->fetch_assoc();
$cost1_5 = $cs1['cost1_5'];
$cost1_4 = $cs1['cost1_4'];
$cost1_3 = $cs1['cost1_3'];
$cost1_2 = $cs1['cost1_2'];
$cost1_1 = $cs1['cost1_1'];

$cs1Max = max($cost1_5, $cost1_4, $cost1_3, $cost1_2, $cost1_1);
if ($cs1Max!=0){
    $cs1number = numberValue($cost1_5, $cost1_4, $cost1_3, $cost1_2, $cost1_1);
    $cs1Mean = number_format(round((($cs1Max / $raters) * $cs1number), 2), 2);
} else {
    $cs1number = "0";
    $cs1Mean = "0.00";
}


// -------------------------------------------------------------------------------------
// COSTS #2
$cost2 = $connect->prepare("SELECT
    SUM(CASE WHEN cost2 = 5 THEN 1 ELSE 0 END) as cost2_5,
    SUM(CASE WHEN cost2 = 4 THEN 1 ELSE 0 END) as cost2_4,
    SUM(CASE WHEN cost2 = 3 THEN 1 ELSE 0 END) as cost2_3,
    SUM(CASE WHEN cost2 = 2 THEN 1 ELSE 0 END) as cost2_2,
    SUM(CASE WHEN cost2 = 1 THEN 1 ELSE 0 END) as cost2_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Cost2 = mysqli_query($connect, $cost2);
// $cs2 = mysqli_fetch_assoc($Cost2);
$cost2->bind_param("ss", $from, $to);
$cost2->execute();
$CS2 = $cost2->get_result();
$cs2 = $CS2->fetch_assoc();
$cost2_5 = $cs2['cost2_5'];
$cost2_4 = $cs2['cost2_4'];
$cost2_3 = $cs2['cost2_3'];
$cost2_2 = $cs2['cost2_2'];
$cost2_1 = $cs2['cost2_1'];

$cs2Max = max($cost2_5, $cost2_4, $cost2_3, $cost2_2, $cost2_1);

if ($cs2Max!=0){
    $cs2number = numberValue($cost2_5, $cost2_4, $cost2_3, $cost2_2, $cost2_1);
    $cs2Mean = number_format(round((($cs2Max / $raters) * $cs2number), 2), 2);
} else {
    $cs2number = "0";
    $cs2Mean = "0.00";
}

$costMean = number_format(round((($cs1Mean + $cs2Mean) / 2), 2), 2);

// -------------------------------------------------------------------------------------
// INTEGRITY
$integrity = $connect->prepare("SELECT
    SUM(CASE WHEN integrity = 5 THEN 1 ELSE 0 END) as integrity_5,
    SUM(CASE WHEN integrity = 4 THEN 1 ELSE 0 END) as integrity_4,
    SUM(CASE WHEN integrity = 3 THEN 1 ELSE 0 END) as integrity_3,
    SUM(CASE WHEN integrity = 2 THEN 1 ELSE 0 END) as integrity_2,
    SUM(CASE WHEN integrity = 1 THEN 1 ELSE 0 END) as integrity_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Integrity = mysqli_query($connect, $integrity);
// $intg = mysqli_fetch_assoc($Integrity);
$integrity->bind_param("ss", $from, $to);
$integrity->execute();
$INTG = $integrity->get_result();
$intg = $INTG->fetch_assoc();
$integrity_5 = $intg['integrity_5'];
$integrity_4 = $intg['integrity_4'];
$integrity_3 = $intg['integrity_3'];
$integrity_2 = $intg['integrity_2'];
$integrity_1 = $intg['integrity_1'];

$intgMax = max($integrity_5, $integrity_4, $integrity_3, $integrity_2, $integrity_1);

if ($intgMax!=0){
    $intgnumber = numberValue($integrity_5, $integrity_4, $integrity_3, $integrity_2, $integrity_1);
    $intgMean = number_format(round((($intgMax / $raters) * $intgnumber), 2), 2);
} else {
    $intgnumber = "0";
    $intgMean = "0.00";
}


// -------------------------------------------------------------------------------------
// ASSURANCE
$assurance = $connect->prepare("SELECT
    SUM(CASE WHEN integrity = 5 THEN 1 ELSE 0 END) as integrity_5,
    SUM(CASE WHEN integrity = 4 THEN 1 ELSE 0 END) as integrity_4,
    SUM(CASE WHEN integrity = 3 THEN 1 ELSE 0 END) as integrity_3,
    SUM(CASE WHEN integrity = 2 THEN 1 ELSE 0 END) as integrity_2,
    SUM(CASE WHEN integrity = 1 THEN 1 ELSE 0 END) as integrity_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Assurance = mysqli_query($connect, $assurance);
// $asr = mysqli_fetch_assoc($Assurance);
$assurance->bind_param("ss", $from, $to);
$assurance->execute();
$ASR = $assurance->get_result();
$asr = $ASR->fetch_assoc();
$assurance_5 = $asr['integrity_5'];
$assurance_4 = $asr['integrity_4'];
$assurance_3 = $asr['integrity_3'];
$assurance_2 = $asr['integrity_2'];
$assurance_1 = $asr['integrity_1'];

$asrMax = max($assurance_5, $assurance_4, $assurance_3, $assurance_2, $assurance_1);

if ($asrMax!=0){
    $asrnumber = numberValue($assurance_5, $assurance_4, $assurance_3, $assurance_2, $assurance_1);   
    $asrMean = number_format(round((($asrMax / $raters) * $asrnumber), 2), 2);
} else {
    $asrnumber = "0";
    $asrMean = "0.00";
}

// -------------------------------------------------------------------------------------
// OUTCOME
$outcome = $connect->prepare("SELECT
    SUM(CASE WHEN outcome = 5 THEN 1 ELSE 0 END) as outcome_5,
    SUM(CASE WHEN outcome = 4 THEN 1 ELSE 0 END) as outcome_4,
    SUM(CASE WHEN outcome = 3 THEN 1 ELSE 0 END) as outcome_3,
    SUM(CASE WHEN outcome = 2 THEN 1 ELSE 0 END) as outcome_2,
    SUM(CASE WHEN outcome = 1 THEN 1 ELSE 0 END) as outcome_1
    FROM feedbacks
    WHERE feedback_date BETWEEN ? AND ?");
// $Outcome = mysqli_query($connect, $outcome);
// $oc = mysqli_fetch_assoc($Outcome);
$outcome->bind_param("ss", $from, $to);
$outcome->execute();
$OC = $outcome->get_result();
$oc = $OC->fetch_assoc();
$outcome_5 = $oc['outcome_5'];
$outcome_4 = $oc['outcome_4'];
$outcome_3 = $oc['outcome_3'];
$outcome_2 = $oc['outcome_2'];
$outcome_1 = $oc['outcome_1'];

$ocMax = max($outcome_5, $outcome_4, $outcome_3, $outcome_2, $outcome_1);

if ($ocMax!=0){
    $ocnumber = numberValue($outcome_5, $outcome_4, $outcome_3, $outcome_2, $outcome_1);
    $ocMean = number_format(round((($ocMax / $raters) * $ocnumber), 2), 2);
} else {
    $ocnumber = "0";
    $ocMean = "0.00";
}


// -------------------------------------------------------------------------------------
// COMMENTS
$comment = $connect->prepare("SELECT GROUP_CONCAT(comments SEPARATOR ', ') as all_comments FROM feedbacks WHERE comments !=' ';");
// $Comments = mysqli_query($connect,$comment);
// $comments = mysqli_fetch_assoc($Comments);
$comment->execute();
$COMMENT = $comment->get_result();
$comments = $COMMENT->fetch_assoc();
$all_Comments = $comments['all_comments'];

// -------------------------------------------------------------------------------------
// CATEGORY MEAN
$totalMean = number_format(round((($rsMean+$rlMean+$AFMean+$commMean+$intgMean+$asrMean+$ocMean) / 7), 2), 2);

?>