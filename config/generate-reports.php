<?php

// generate reports (user&admin reports)

include 'connect.php';
require_once('../vendor/autoload.php');

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
$dateNow = date("Y-m-d");

$head = '
    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/downloads/fontawesome-web/css/all.min.css">
    </head>';
$header = '
    <div style="background:greehn; float:left;">
        <img src="../assets/img/clsu-logo.png" style="margin-left:3rem;margin-top:-1rem;height:auto;width:7rem;float:left;">
        <div style="margin-left:-10rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
        </div>    
    </div>
';

// generate admin inv records
if (isset($_POST['download'])) {
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal', 'orientation' => 'L', 'default_font_size' => 11, 'default_font' => 'Calibri']);

    $dateNow = date("Y-m-d");
    $title3 = '
        <div class="text-center mt-3">
            <p style="font-weight:bold;">INVENTORY RECORDS</p>
            <h4 class="text-uppercase fw-bold">' . date("F Y") . '</h4>
        </div>
    ';

    $table3 = '';

    $query3 = "SELECT * FROM admin_inventory WHERE archive=0";
    $stmt3 = $connect->prepare($query3);
    $stmt3->execute();
    $q3 = $stmt3->get_result();

    if ($q3->num_rows > 0) {
        while ($row3 = $q3->fetch_assoc()) {
            $year = $row3['year_purchase'];
            $date = date("F Y", strtotime($year));
            $table3 .= '
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding:.3rem;">' . $row3['area'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['ac_floor_area'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . ($row3['type_st'] == "Split Type" ? 'x' : '') . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . ($row3['type_wt'] == "Window Type" ? 'x' : '') . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['status'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['qty_st'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['qty_wt'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['category_st'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['category_wt'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['cooling_capacity'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['capacity_rating'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['energy_st'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['energy_wt'] . '</td>
					<td colspan="2" style="border: 1px solid black; padding:.3rem;">' . $date . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['operation_hours'] . '</td>
					<td style="border: 1px solid black; padding:.3rem;">' . $row3['operation_days'] . '</td>
					
                </tr>
            ';
        }
    } else {
        $table3 = '<tr class="text-center"><td colspan="15">no records</td></tr>';
    }

    $html3 = '
        <!DOCTYPE html>
        <html>
        <body>
        ' . $head . $header . $title3 . '
        <div style="display:flex !important; justify-content:center !important; align-items :center;width:100% !important; margin: 0 auto !important;">
            <table style="border: 1px solid black; text-align:center; margin: 0 auto;border-collapse:collapse;">
                <tr style="border: 1px solid black;">
					<td rowspan="4" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Area</td>
					<td rowspan="4" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Floor Area</td>
					<td colspan="2" rowspan="3" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Type</td>
					<td rowspan="4" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Status</td>
					<td colspan="2" rowspan="3" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Quantity</td>
					<td colspan="2" rowspan="3" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Category</td>
					<td colspan="4" rowspan="" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Nameplate Rating</td>
					<td rowspan="4" colspan="2" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Year of Purchase</td>
					<td colspan="2" rowspan="2" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Operation</td>
				</tr>
				<tr style="border: 1px solid black;">
					<td rowspan="3" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Cooling Capacity</td>
					<td rowspan="3" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Capacity Rating</td>
					<td colspan="2" rowspan="2" style="border: 1px solid black; border-bottom:1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Energy Efficiency Ratio</td>
				</tr>
				<tr>
					<td rowspan="2" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Hours per Day</td>
					<td rowspan="2" style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">Days per Week</td>
				</tr>
				<tr>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">ST</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">WT</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">ST</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">WT</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">ST</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">WT</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">ST</td>
					<td style="border: 1px solid black; padding:.3rem; background:#D4F6CC; text-transform:uppercase;">WT</td>
				</tr>
				
                ' . $table3 . '
            </table>
        </div>
        </body>
        </html>';

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetMargins(10, 10, 10, 10);
    $pdf->writeHTML($html3);
    // ob_end_clean();
    $pdf->Output('inventory.pdf', 'D');

// generate equipment reports
} else if (isset($_POST['equipments'])) {
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'L', 'default_font_size' => 11, 'default_font' => 'Calibri']);

    $dateNow = date("Y-m-d");
    $title4 = '
            <p style="text-align:center; margin-top:-2rem; font-size:16px;font-weight:bold;">EQUIPMENT RECORDS</p>
            <h4 style="text-transform:uppercase;text-align:center;margin:1rem;">' . date("F Y") . '</h4>
    ';

    $table4 = ''; 

    $query4 = "SELECT * FROM equipments WHERE userID=? AND archive=0 ORDER BY equipment_id AND category DESC";
    $stmt4 = $connect->prepare($query4);
    $stmt4->bind_param("i", $user);
    $stmt4->execute();
    $q4 = $stmt4->get_result();

    if ($q4->num_rows > 0) {
        while ($row4 = $q4->fetch_assoc()) {
            $table4 .= '
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['equip_name'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['category'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['equip_model'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['brand_label'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['property_number'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['equip_location'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['equip_status'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . date("F j, Y", strtotime($row4['date_service'])) . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row4['assigned_person'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . date("F j, Y", strtotime($row4['date_purchased'])) . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . number_format($row4['price'],2,'.',',') . '</td>
                </tr>
            ';
        }
    } else {
        $table4 = '<tr><td style="padding:1rem !important;" colspan="11">No records</td></tr>';
    }

    $html4 = '
        <!DOCTYPE html>
        <html>
        '. $head. '
        <body>
        <div style="background:greehn; float:left;">
            <img src="../assets/img/clsu-logo.png" style="margin-left:10rem;margin-top:-1rem;height:auto;width:7rem;float:left;">
            <div style="margin-left:-17rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
            </div>    
        </div>
        <br>
    ' . $title4 . '
        <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
            <table style="border: 1px solid; text-align:center; margin: 0 auto; border-collapse:collapse;">
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Equipment</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Category</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Equipment Model</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Brand / Label</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Property Number</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Location</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Status</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Date Put into Service</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Person Responsible</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Date Purchased</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Price</td>
                </tr>
                ' . $table4 . '
            </table>
        </div>
        </body>
        </html>';

    $pdf->SetMargins(10, 0, 10, 0);
    $pdf->writeHTML($html4);
    // ob_end_clean();
    $pdf->Output('equipments.pdf', 'D');

    // generate user inventory reports
} else if (isset($_POST['user-inv'])) {
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'orientation' =>'L', 'default_font_size' => 11, 'default_font' => 'Calibri']);

    $dateNow = date("Y-m-d");

    $title5 = '
        <p style="text-align:center; margin-top:-2rem; font-size:16px;font-weight:bold;">INVENTORY RECORDS</p>
        <h4 style="text-transform:uppercase;text-align:center;margin:1rem;">' . date("F Y") . '</h4>
    ';
    
    $table5 = '';

    $query5 = "SELECT * FROM user_inventory WHERE archive=0 AND userID= ?";
    $stmt5 = $connect->prepare($query5);
    $stmt5->bind_param("i", $user);
    $stmt5->execute();
    $q5 = $stmt5->get_result();

    if ($q5->num_rows > 0) {
        while ($row5 = $q5->fetch_assoc()) {
            $date_acquired=date("F j, Y", strtotime($row5['date_acquired']));
            $table5 .= '
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['inv_item'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['property_number'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['quantity'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . number_format($row5['price'],2,'.',',') . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . number_format($row5['total'],2,'.',',') . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['unit'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['area_location'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . (!empty($row5['date_acquired']) && $row5['date_acquired'] != "0000-00-00" ? $date_acquired : '') . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['description'] . '</td>
                    <td style="border: 1px solid black; padding:.3rem;">' . $row5['remarks'] . '</td>
                </tr>
            ';
        }
    } else {
        $table5 = '<tr><td style="padding:1rem !important;" colspan="10">no records</td></tr>';
    }

    $html5 = '
        <!DOCTYPE html>
        <html>
        ' . $head . '
        <body>
        <div style="background:greehn; float:left;">
            <img src="../assets/img/clsu-logo.png" style="margin-left:10rem;margin-top:-1rem;height:auto;width:7rem;float:left;">
            <div style="margin-left:-17rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
            </div>    
        </div>
  
        <br>
    '.$title5 . '
        <div style="display:flex !important; justify-content:center !important; align-items :center; width:100vh !important; margin: 0 auto !important;">
            <table style="border: 1px solid; text-align:center; margin: 0 auto; border-collapse:collapse;">
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Equipment</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Property Number</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Quantity</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Price</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Total</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Unit</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Location</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Date Acquired</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Description</td>
                    <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;">Remarks</td>
                </tr>
                ' . $table5 . '
            </table>
        </div>
        </body>
        </html>';

    $pdf->SetMargins(10, 0, 10, 0);
    $pdf->WriteHTML($html5);
    $pdf->Output('inventory.pdf', 'D');

// MONTH REPORT
} else if (isset($_POST['get-month-report'])){
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4','default_font_size' => 11,'default_font' => 'Calibri']);
    
    $evaluation = mysqli_real_escape_string($connect,$_POST['evaluation']);
    $raters = mysqli_real_escape_string($connect,$_POST['raters']);
    $service1 = mysqli_real_escape_string($connect,$_POST['service1']);
    $service2 = mysqli_real_escape_string($connect,$_POST['service2']);
    $service3 = mysqli_real_escape_string($connect,$_POST['service3']);
    $service4 = mysqli_real_escape_string($connect,$_POST['service4']);
    $service5 = mysqli_real_escape_string($connect,$_POST['service5']);
    $service6 = mysqli_real_escape_string($connect,$_POST['service6']);
    $service7 = mysqli_real_escape_string($connect,$_POST['service7']);
    $service8 = mysqli_real_escape_string($connect,$_POST['service8']);
    $percent1 = mysqli_real_escape_string($connect,$_POST['percent1']);
    $percent2 = mysqli_real_escape_string($connect,$_POST['percent2']);
    $percent3 = mysqli_real_escape_string($connect,$_POST['percent3']);
    $percent4 = mysqli_real_escape_string($connect,$_POST['percent4']);
    $percent5 = mysqli_real_escape_string($connect,$_POST['percent5']);
    $percent6 = mysqli_real_escape_string($connect,$_POST['percent6']);
    $percent7 = mysqli_real_escape_string($connect,$_POST['percent7']);
    $percent8 = mysqli_real_escape_string($connect,$_POST['percent8']);
    $total_job = mysqli_real_escape_string($connect,$_POST['total-job']);

    // RESPOSIVENESS
    $responsive1_1 = mysqli_real_escape_string($connect,$_POST['responsive1-1']);
    $responsive1_2 = mysqli_real_escape_string($connect,$_POST['responsive1-2']);
    $responsive1_3 = mysqli_real_escape_string($connect,$_POST['responsive1-3']);
    $responsive1_4 = mysqli_real_escape_string($connect,$_POST['responsive1-4']);
    $responsive1_5 = mysqli_real_escape_string($connect,$_POST['responsive1-5']);
    $rs1Mean = mysqli_real_escape_string($connect,$_POST['rs1-mean']);
    $rs1Rate = mysqli_real_escape_string($connect,$_POST['rs1-rate']);

    $responsive2_1 = mysqli_real_escape_string($connect,$_POST['responsive2-1']);
    $responsive2_2 = mysqli_real_escape_string($connect,$_POST['responsive2-2']);
    $responsive2_3 = mysqli_real_escape_string($connect,$_POST['responsive2-3']);
    $responsive2_4 = mysqli_real_escape_string($connect,$_POST['responsive2-4']);
    $responsive2_5 = mysqli_real_escape_string($connect,$_POST['responsive2-5']);
    $rs2Mean = mysqli_real_escape_string($connect,$_POST['rs2-mean']);
    $rs2Rate = mysqli_real_escape_string($connect,$_POST['rs2-rate']);

    $rsMean = mysqli_real_escape_string($connect,$_POST['rs-mean']);

    // RELIABILITY
    $reliability1_1 = mysqli_real_escape_string($connect,$_POST['reliability1-1']);
    $reliability1_2 = mysqli_real_escape_string($connect,$_POST['reliability1-2']);
    $reliability1_3 = mysqli_real_escape_string($connect,$_POST['reliability1-3']);
    $reliability1_4 = mysqli_real_escape_string($connect,$_POST['reliability1-4']);
    $reliability1_5 = mysqli_real_escape_string($connect,$_POST['reliability1-5']);
    $rl1Mean = mysqli_real_escape_string($connect,$_POST['rl1-mean']);
    $rl1Rate = mysqli_real_escape_string($connect,$_POST['rl1-rate']);

    $reliability2_1 = mysqli_real_escape_string($connect,$_POST['reliability2-1']);
    $reliability2_2 = mysqli_real_escape_string($connect,$_POST['reliability2-2']);
    $reliability2_3 = mysqli_real_escape_string($connect,$_POST['reliability2-3']);
    $reliability2_4 = mysqli_real_escape_string($connect,$_POST['reliability2-4']);
    $reliability2_5 = mysqli_real_escape_string($connect,$_POST['reliability2-5']);
    $rl2Mean = mysqli_real_escape_string($connect,$_POST['rl2-mean']);
    $rl2Rate = mysqli_real_escape_string($connect,$_POST['rl2-rate']);

    $rlMean = mysqli_real_escape_string($connect,$_POST['rl-mean']);

    // ACCESS AND FACILITY
    $facility_1 = mysqli_real_escape_string($connect,$_POST['facility-1']);
    $facility_2 = mysqli_real_escape_string($connect,$_POST['facility-2']);
    $facility_3 = mysqli_real_escape_string($connect,$_POST['facility-3']);
    $facility_4 = mysqli_real_escape_string($connect,$_POST['facility-4']);
    $facility_5 = mysqli_real_escape_string($connect,$_POST['facility-5']);
    $facMean = mysqli_real_escape_string($connect,$_POST['fac-mean']);
    $facRate = mysqli_real_escape_string($connect,$_POST['fac-rate']);

    $access_1 = mysqli_real_escape_string($connect,$_POST['access-1']);
    $access_2 = mysqli_real_escape_string($connect,$_POST['access-2']);
    $access_3 = mysqli_real_escape_string($connect,$_POST['access-3']);
    $access_4 = mysqli_real_escape_string($connect,$_POST['access-4']);
    $access_5 = mysqli_real_escape_string($connect,$_POST['access-5']);
    $accMean = mysqli_real_escape_string($connect,$_POST['acc-mean']);
    $accRate = mysqli_real_escape_string($connect,$_POST['acc-rate']);

    $afMean = mysqli_real_escape_string($connect,$_POST['af-mean']);

    // COMMUNICATION
    $comm1_1 = mysqli_real_escape_string($connect,$_POST['comm1-1']);
    $comm1_2 = mysqli_real_escape_string($connect,$_POST['comm1-2']);
    $comm1_3 = mysqli_real_escape_string($connect,$_POST['comm1-3']);
    $comm1_4 = mysqli_real_escape_string($connect,$_POST['comm1-4']);
    $comm1_5 = mysqli_real_escape_string($connect,$_POST['comm1-5']);
    $comm1Mean = mysqli_real_escape_string($connect,$_POST['comm1-mean']);
    $comm1Rate = mysqli_real_escape_string($connect,$_POST['comm1-rate']);

    $comm2_1 = mysqli_real_escape_string($connect,$_POST['comm2-1']);
    $comm2_2 = mysqli_real_escape_string($connect,$_POST['comm2-2']);
    $comm2_3 = mysqli_real_escape_string($connect,$_POST['comm2-3']);
    $comm2_4 = mysqli_real_escape_string($connect,$_POST['comm2-4']);
    $comm2_5 = mysqli_real_escape_string($connect,$_POST['comm2-5']);
    $comm2Mean = mysqli_real_escape_string($connect,$_POST['comm2-mean']);
    $comm2Rate = mysqli_real_escape_string($connect,$_POST['comm2-rate']);

    $commMean = mysqli_real_escape_string($connect,$_POST['comm-mean']);

    // COSTS
    $cost1_1 = isset($_POST['cost1-1']) ? mysqli_real_escape_string($connect,$_POST['cost1-1']) : null;
    $cost1_2 = isset($_POST['cost1-2']) ? mysqli_real_escape_string($connect,$_POST['cost1-2']) : null;
    $cost1_3 = isset($_POST['cost1-3']) ? mysqli_real_escape_string($connect,$_POST['cost1-3']) : null;
    $cost1_4 = isset($_POST['cost1-4']) ? mysqli_real_escape_string($connect,$_POST['cost1-4']) : null;
    $cost1_5 = isset($_POST['cost1-5']) ? mysqli_real_escape_string($connect,$_POST['cost1-5']) : null;
    $cs1Mean = isset($_POST['cs1-mean']) ? mysqli_real_escape_string($connect,$_POST['cs1-mean']) : null;
    $cs1Rate = isset($_POST['cs1-rate']) ? mysqli_real_escape_string($connect,$_POST['cs1-rate']) : null;

    $cost2_1 = isset($_POST['cost2-1']) ? mysqli_real_escape_string($connect,$_POST['cost2-1']) : null;
    $cost2_2 = isset($_POST['cost2-2']) ? mysqli_real_escape_string($connect,$_POST['cost2-2']) : null;
    $cost2_3 = isset($_POST['cost2-3']) ? mysqli_real_escape_string($connect,$_POST['cost2-3']) : null;
    $cost2_4 = isset($_POST['cost2-4']) ? mysqli_real_escape_string($connect,$_POST['cost2-4']) : null;
    $cost2_5 = isset($_POST['cost2-5']) ? mysqli_real_escape_string($connect,$_POST['cost2-5']) : null;
    $cs2Mean = isset($_POST['cs2-mean']) ? mysqli_real_escape_string($connect,$_POST['cs2-mean']) : null;
    $cs2Rate = isset($_POST['cs2-rate']) ? mysqli_real_escape_string($connect,$_POST['cs2-rate']) : null;

    $costMean = isset($_POST['cost-mean']) ? mysqli_real_escape_string($connect,$_POST['cost-mean']) : null;
    // INTEGRITY
    $intg_1 = mysqli_real_escape_string($connect,$_POST['intg-1']);
    $intg_2 = mysqli_real_escape_string($connect,$_POST['intg-2']);
    $intg_3 = mysqli_real_escape_string($connect,$_POST['intg-3']);
    $intg_4 = mysqli_real_escape_string($connect,$_POST['intg-4']);
    $intg_5 = mysqli_real_escape_string($connect,$_POST['intg-5']);
    $intgMean = mysqli_real_escape_string($connect,$_POST['intg-mean']);
    $intgRate = mysqli_real_escape_string($connect,$_POST['intg-rate']);

    $integMean = mysqli_real_escape_string($connect,$_POST['integ-mean']);

    // ASSURANCE
    $asrc_1 = mysqli_real_escape_string($connect,$_POST['asrc-1']);
    $asrc_2 = mysqli_real_escape_string($connect,$_POST['asrc-2']);
    $asrc_3 = mysqli_real_escape_string($connect,$_POST['asrc-3']);
    $asrc_4 = mysqli_real_escape_string($connect,$_POST['asrc-4']);
    $asrc_5 = mysqli_real_escape_string($connect,$_POST['asrc-5']);
    $asrcMean = mysqli_real_escape_string($connect,$_POST['asrc-mean']);
    $asrcRate = mysqli_real_escape_string($connect,$_POST['asrc-rate']);

    $asrMean = mysqli_real_escape_string($connect,$_POST['asr-mean']);

    // OUTCOME
    $out_1 = mysqli_real_escape_string($connect,$_POST['out-1']);
    $out_2 = mysqli_real_escape_string($connect,$_POST['out-2']);
    $out_3 = mysqli_real_escape_string($connect,$_POST['out-3']);
    $out_4 = mysqli_real_escape_string($connect,$_POST['out-4']);
    $out_5 = mysqli_real_escape_string($connect,$_POST['out-5']);
    $outMean = mysqli_real_escape_string($connect,$_POST['out-mean']);
    $outRate = mysqli_real_escape_string($connect,$_POST['out-rate']);

    $ocMean = mysqli_real_escape_string($connect,$_POST['oc-mean']);

    $comments = mysqli_real_escape_string($connect,$_POST['comments']);
    
    // mean
    $RSMean = mysqli_real_escape_string($connect,$_POST['responsive-mean']);
    $RLMean = mysqli_real_escape_string($connect,$_POST['reliable-mean']);
    $AFMean = mysqli_real_escape_string($connect,$_POST['AcFc-mean']);
    $CMMean = mysqli_real_escape_string($connect,$_POST['communicate-mean']);
    $CSMean = isset($_POST['costs-mean']) ? mysqli_real_escape_string($connect,$_POST['costs-mean']) : null;
    $INMean = mysqli_real_escape_string($connect,$_POST['integrity-mean']);
    $ASMean = mysqli_real_escape_string($connect,$_POST['assurance-mean']);
    $OCMean = mysqli_real_escape_string($connect,$_POST['outcome-mean']);

    // mean rate
    $RSRate = mysqli_real_escape_string($connect,$_POST['responsive-rate']);
    $RLRate = mysqli_real_escape_string($connect,$_POST['reliable-rate']);
    $AFRate = mysqli_real_escape_string($connect,$_POST['AcFc-rate']);
    $CMRate = mysqli_real_escape_string($connect,$_POST['communicate-rate']);
    $CSRate = isset($_POST['costs-rate']) ? mysqli_real_escape_string($connect,$_POST['costs-mean']) : null;
    $INRate = mysqli_real_escape_string($connect,$_POST['integrity-rate']);
    $ASRate = mysqli_real_escape_string($connect,$_POST['assurance-rate']);
    $OCRate = mysqli_real_escape_string($connect,$_POST['outcome-rate']);

    $totalMean = mysqli_real_escape_string($connect,$_POST['total-mean']);
    $totalRate = mysqli_real_escape_string($connect,$_POST['total-rate']);

    // paragraphs
    $discussion = mysqli_real_escape_string($connect,$_POST['discussion']);
    $conclusion = mysqli_real_escape_string($connect,$_POST['conclusion']);
    $action = mysqli_real_escape_string($connect,$_POST['action']);

    // name and designation
    $name1 = mysqli_real_escape_string($connect,$_POST['name1']);
    $name2 = mysqli_real_escape_string($connect,$_POST['name2']);
    $name3 = mysqli_real_escape_string($connect,$_POST['name3']);
    $name4 = mysqli_real_escape_string($connect,$_POST['name4']);
    $position1 = mysqli_real_escape_string($connect,$_POST['position1']);
    $position2 = mysqli_real_escape_string($connect,$_POST['position2']);
    $position3 = mysqli_real_escape_string($connect,$_POST['position3']);
    $position4 = mysqli_real_escape_string($connect,$_POST['position4']);


    // -------------------------------------------
    $html7 = '
    <!DOCTYPE html>
        <html>
        ' . $head .
    '
        <body>
        <div style=" float:left;">
            <img src="../assets/img/clsu-logo.png" style="margin-left:5rem;margin-top:-1.5rem;height:auto;width:7rem;float:left;">
            <div style="margin-left:-12rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
            </div>    
        </div>
  
        <div class="container ps-5 pe-5 mb-3">
            <div class="text-center">
                <p style="">OFFICE OF THE UNIVERSITY PRESIDENT</p>
                <p style="margin:0;font-weight:bold;">OFFICE FEEDBACK REPORT</p><br>
                <p style="font-weight:bold;margin:0;">Office Rated: ERMS - PPSDS</p>
                <p style="font-weight:bold;">Evaluation Period:&nbsp;'.$evaluation.'</p>
                <h6>This is the summary report on the feedback given by <span class="fw-bold"><u>&nbsp;'. $raters. '&nbsp;</u></span> raters / evaluators.</h6>
            </div>
        </div>
        
        <div style="display:flex; justify-content:center; ">
            <div style="margin:0 5rem 0;">
                <h6>Type of Services rendered within the evaluation period:</h6>
            </div>
            <div style="margin:0 auto;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Type</td>
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Frequency</td>
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Percent</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Air-con Cleaned</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service1.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent1.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ">Air-con Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service2.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent2.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ">Air-con Installed</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service3.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent3.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Electric Fan Cleaned / Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service4.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent4.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Electric Fan Installed</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service5.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent5.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Other Equipment Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service6.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent6.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Computer Repair & Troubleshoot</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service7.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent7.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Hauling Services</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$service8.'</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">'.$percent8. '</td>
                    </tr>
                    <tr style="border: 1px solid;">
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">Total</td>
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">'.$total_job. '</td>
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">100%</td>
                    </tr>
                </table>            
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">I. RESPONSIVENESS <span style="font-style:italic;">(PAGTUGON)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>RESPONSIVENESS (PAGTUGON)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The service is provided promptly / timely. <br><span class="fst-italic">Mabilis ang serbisyo at nasa tamang oras.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive1_1.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive1_2.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive1_3.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive1_4.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive1_5.'</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">'.$rs1Mean.'</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">'.$rs1Rate.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The personnel show willingness to help the client. <br><span class="fst-italic">Nagpapakita ng kagustuhang maglingkod ang mga kawani.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive2_1.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive2_2.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive2_3.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive2_4.'</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">'.$responsive2_5.'</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">'.$rs2Mean.'</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">'.$rs2Rate.'</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Responsiveness (Pagtugon)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">'.$rsMean. '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">II. RELIABILITY <span style="font-style:italic;">(PAGIGING MAAASAHAN)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>RELIABILITY (PAGIGING MAAASAHAN)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The service exhibits quality and high standard. <br><span class="fst-italic">Nagpapamalas ng kalidad at mataas na pamnatayan ang serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The service meets the expectations of the client. <br><span class="fst-italic">Nakapaglilingkod nang ayon sa inaasahan ng kliyente.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Reliability (Pagiging Maaasahan)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $rlMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center;width:100%;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">III. ACCESS AND FACILITIES <span style="font-style:italic;">(PASILIDAD)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;width:100%;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>ACCESS AND FACILITIES (PASILIDAD)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The facilities are clean, organized and accessible. <br><span class="fst-italic">Malinis, maayos at madaling marating ang pasilidad.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $facMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $facRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. Online services are made available. <br><span class="fst-italic">Mayroong serbisyong online.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $accMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $accRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Access and Facilities (Pasilidad)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $afMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">IV. COMMUNICATION <span style="font-style:italic;">(KOMUNIKASYON)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>COMMUNICATION (KOMUNIKASYON)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The instructions and information are clear. <br><span class="fst-italic">Malinaw ang mga tagubilin at impormasyon.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The personnel explains the service effectively. <br><span class="fst-italic">Naipaliliwanag nang mabisa ng mga kawani ang kanilang serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Communication (Komunikasyon)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $commMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">V. COSTS <span style="font-style:italic;">(HALAGA)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>COSTS (HALAGA)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The billing process, method and payment procedure are timely and appropriate. <br><span class="fst-italic">Nasa oras at angkop ang proseso ng paniningil at metodo ng pagbabayad.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The cost of service is fair and reasonable. <br><span class="fst-italic">Angkop at makatwiran ang halaga ng serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Costs (Halaga)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $costMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VI. INTEGRITY  <span style="font-style:italic;">(INTEGRIDAD)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>INTEGRITY (INTEGRIDAD)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The employees demonstrate honesty, justice, fairness and trustworthiness. <br><span class="fst-italic">Matapat, makatarungan, mapagkakatiwalaan at tapat ang mga kawani.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $intgMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $intgRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Integrity (Integridad)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $integMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="height:5rem;"></div>
        <div style="display:flex; justify-content:center;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VII. ASSURANCE <span style="font-style:italic;">(KASIGURUHAN)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>ASSURANCE (KASIGURUHAN)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The frontline staff are knowledegable, helpful, courteous and understand client needs. <br><span class="fst-italic">Maalam, matulungin, magalang at maunawain sa mga pangangailangan ng kliyente ang mga pangunang empleyado.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $asrcMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $asrcRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Assurance (Kasiguruhan)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $asrMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem; width:100%;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VIII. OUTCOME <span style="font-style:italic;">(RESULTA)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto; width:100%;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>OUTCOME (RESULTA)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The desired service is achieved. <br><span class="fst-italic">Naabot ang ninanais na serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $outMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $outRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Outcome (Resulta)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $ocMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top:2rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Rater&#39;s Comments / Suggestions</h6>
            <div style="margin: 1rem 2rem;">
                <span>'.$comments. '</span>
            </div>
        </div>

        <div style="display:flex; justify-content:center;">
            <div style="display:flex; margin:0;padding:0;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">OFFICE FEEDBACK RATING</h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="margin:0 !important;">
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Category</td>
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Category Mean</td>
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Adjectival Rating</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">I. RESPONSIVENESS <span style="font-style:italic;">(PAGTUGON)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$RSMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$RSRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">II. RELIABILITY <span style="font-style:italic;">(PAGIGING MAAASAHAN)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$RLMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$RLRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">III. ACCESS & FACILITIES <span style="font-style:italic;">(PASILIDAD)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$AFMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$AFRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">IV. COMMUNICATION <span style="font-style:italic;">(KOMUNIKASYON)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$CMMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$CMRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">V. COSTS <span style="font-style:italic;">(HALAGA)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$CSMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$CSRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VI. INTEGRITY <span style="font-style:italic;">(INTEGRIDAD)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$INMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$INRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VII. ASSURANCE <span style="font-style:italic;">(KASIGURUHAN)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$ASMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$ASRate. '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VIII. OUTCOME <span style="font-style:italic;">(RESULTA)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$OCMean.'</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">'.$OCRate.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; text-align:right; font-weight:bold; padding:.3rem;">TOTAL CATEGORY MEAN</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;" colspan="2">'.$totalMean.'</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; text-align:right; font-weight:bold; padding:.3rem;">ADJECTIVAL RATING</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;" colspan="2">'.$totalRate. '</td>
                    </tr>
                </table>
            </div>

            <div style="background:reds;padding-top:.5rem;">
                <table style="width:18rem; border:1px solid;">
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;"><p>Rating Scale:</p></td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">4.21 - 5.00 - Excellent</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">3.41 - 4.20 - Very Good</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">2.61 - 3.40 - Good</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">1.81 - 2.60 - Fair</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">1.00 - 1.80 - Needs Improvement</td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Discussion Results</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $discussion . '</span>
            </div>
        </div>
        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Conclusion</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $conclusion . '</span>
            </div>
        </div>
        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Action taken on comments / suggestions (where applicable)</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $action . '</span>
            </div>
        </div>

        <div style="margin-top:5rem;">
            <div style="padding:3rem;">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:left;padding-top:5rem;"><div><span style="background:yellowx;font-weight:bold;">Prepared By:&nbsp;' . $name1 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="padding-top:5rem;text-align:right;"><div><span style="background:greenx;font-weight:bold;">Attested:&nbsp;' . $name2 . '</span></div></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;"><div><span style="background:redx;font-weight:bold;">' . $position1 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-right:1rem;"><div><span style="background:redx;font-weight:bold;">' . $position2 . '</span></div></td>
                    </tr>
                            
                    <tr>
                        <td style="text-align:left;padding-top:5rem;"><div><span style="background:bluex;font-weight:bold;">Reviewed By:&nbsp;' . $name3 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-top:5rem;"><div style=""><span style="background:grayx;font-weight:bold;">' . $name4 . '</span></div></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;padding-right:3.7rem;"><div style=""><span style="background:bluex;font-weight:bold;">' . $position3 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-right:.4rem;"><div style=""><span style="background:grayx;font-weight:bold;">' . $position4 . '</span></div></td>
                    </tr>
                </table>
            </div>
        </div>

        </body>
        </html>
    ';

    $pdf->SetMargins(10, 10, 12, 10);
    $pdf->SetHTMLFooter('<p style="font-size:10px;">OUP.XXX.YYY.F.017 (Revision No. 1; November 8, 2021)</p>');
    $pdf->WriteHTML($html7);
    // ob_end_clean();

    $pdf->Output('month-report.pdf', 'D');
        
// SELECT REPORT
} else if (isset($_POST['get-select-report'])){
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font_size' => 11, 'default_font' => 'Calibri']);

    $evaluation = mysqli_real_escape_string($connect,$_POST['evaluation']);
    $raters = mysqli_real_escape_string($connect,$_POST['raters']);
    $service1 = mysqli_real_escape_string($connect,$_POST['service1']);
    $service2 = mysqli_real_escape_string($connect,$_POST['service2']);
    $service3 = mysqli_real_escape_string($connect,$_POST['service3']);
    $service4 = mysqli_real_escape_string($connect,$_POST['service4']);
    $service5 = mysqli_real_escape_string($connect,$_POST['service5']);
    $service6 = mysqli_real_escape_string($connect,$_POST['service6']);
    $service7 = mysqli_real_escape_string($connect,$_POST['service7']);
    $service8 = mysqli_real_escape_string($connect,$_POST['service8']);
    $percent1 = mysqli_real_escape_string($connect,$_POST['percent1']);
    $percent2 = mysqli_real_escape_string($connect,$_POST['percent2']);
    $percent3 = mysqli_real_escape_string($connect,$_POST['percent3']);
    $percent4 = mysqli_real_escape_string($connect,$_POST['percent4']);
    $percent5 = mysqli_real_escape_string($connect,$_POST['percent5']);
    $percent6 = mysqli_real_escape_string($connect,$_POST['percent6']);
    $percent7 = mysqli_real_escape_string($connect,$_POST['percent7']);
    $percent8 = mysqli_real_escape_string($connect,$_POST['percent8']);
    $total_job = mysqli_real_escape_string($connect,$_POST['total-job']);

    // RESPOSIVENESS
    $responsive1_1 = mysqli_real_escape_string($connect,$_POST['responsive1-1']);
    $responsive1_2 = mysqli_real_escape_string($connect,$_POST['responsive1-2']);
    $responsive1_3 = mysqli_real_escape_string($connect,$_POST['responsive1-3']);
    $responsive1_4 = mysqli_real_escape_string($connect,$_POST['responsive1-4']);
    $responsive1_5 = mysqli_real_escape_string($connect,$_POST['responsive1-5']);
    $rs1Mean = mysqli_real_escape_string($connect,$_POST['rs1-mean']);
    $rs1Rate = mysqli_real_escape_string($connect,$_POST['rs1-rate']);

    $responsive2_1 = mysqli_real_escape_string($connect,$_POST['responsive2-1']);
    $responsive2_2 = mysqli_real_escape_string($connect,$_POST['responsive2-2']);
    $responsive2_3 = mysqli_real_escape_string($connect,$_POST['responsive2-3']);
    $responsive2_4 = mysqli_real_escape_string($connect,$_POST['responsive2-4']);
    $responsive2_5 = mysqli_real_escape_string($connect,$_POST['responsive2-5']);
    $rs2Mean = mysqli_real_escape_string($connect,$_POST['rs2-mean']);
    $rs2Rate = mysqli_real_escape_string($connect,$_POST['rs2-rate']);

    $rsMean = mysqli_real_escape_string($connect,$_POST['rs-mean']);

    // RELIABILITY
    $reliability1_1 = mysqli_real_escape_string($connect,$_POST['reliability1-1']);
    $reliability1_2 = mysqli_real_escape_string($connect,$_POST['reliability1-2']);
    $reliability1_3 = mysqli_real_escape_string($connect,$_POST['reliability1-3']);
    $reliability1_4 = mysqli_real_escape_string($connect,$_POST['reliability1-4']);
    $reliability1_5 = mysqli_real_escape_string($connect,$_POST['reliability1-5']);
    $rl1Mean = mysqli_real_escape_string($connect,$_POST['rl1-mean']);
    $rl1Rate = mysqli_real_escape_string($connect,$_POST['rl1-rate']);

    $reliability2_1 = mysqli_real_escape_string($connect,$_POST['reliability2-1']);
    $reliability2_2 = mysqli_real_escape_string($connect,$_POST['reliability2-2']);
    $reliability2_3 = mysqli_real_escape_string($connect,$_POST['reliability2-3']);
    $reliability2_4 = mysqli_real_escape_string($connect,$_POST['reliability2-4']);
    $reliability2_5 = mysqli_real_escape_string($connect,$_POST['reliability2-5']);
    $rl2Mean = mysqli_real_escape_string($connect,$_POST['rl2-mean']);
    $rl2Rate = mysqli_real_escape_string($connect,$_POST['rl2-rate']);

    $rlMean = mysqli_real_escape_string($connect,$_POST['rl-mean']);

    // ACCESS AND FACILITY
    $facility_1 = mysqli_real_escape_string($connect,$_POST['facility-1']);
    $facility_2 = mysqli_real_escape_string($connect,$_POST['facility-2']);
    $facility_3 = mysqli_real_escape_string($connect,$_POST['facility-3']);
    $facility_4 = mysqli_real_escape_string($connect,$_POST['facility-4']);
    $facility_5 = mysqli_real_escape_string($connect,$_POST['facility-5']);
    $facMean = mysqli_real_escape_string($connect,$_POST['fac-mean']);
    $facRate = mysqli_real_escape_string($connect,$_POST['fac-rate']);

    $access_1 = mysqli_real_escape_string($connect,$_POST['access-1']);
    $access_2 = mysqli_real_escape_string($connect,$_POST['access-2']);
    $access_3 = mysqli_real_escape_string($connect,$_POST['access-3']);
    $access_4 = mysqli_real_escape_string($connect,$_POST['access-4']);
    $access_5 = mysqli_real_escape_string($connect,$_POST['access-5']);
    $accMean = mysqli_real_escape_string($connect,$_POST['acc-mean']);
    $accRate = mysqli_real_escape_string($connect,$_POST['acc-rate']);

    $afMean = mysqli_real_escape_string($connect,$_POST['af-mean']);

    // COMMUNICATION
    $comm1_1 = mysqli_real_escape_string($connect,$_POST['comm1-1']);
    $comm1_2 = mysqli_real_escape_string($connect,$_POST['comm1-2']);
    $comm1_3 = mysqli_real_escape_string($connect,$_POST['comm1-3']);
    $comm1_4 = mysqli_real_escape_string($connect,$_POST['comm1-4']);
    $comm1_5 = mysqli_real_escape_string($connect,$_POST['comm1-5']);
    $comm1Mean = mysqli_real_escape_string($connect,$_POST['comm1-mean']);
    $comm1Rate = mysqli_real_escape_string($connect,$_POST['comm1-rate']);

    $comm2_1 = mysqli_real_escape_string($connect,$_POST['comm2-1']);
    $comm2_2 = mysqli_real_escape_string($connect,$_POST['comm2-2']);
    $comm2_3 = mysqli_real_escape_string($connect,$_POST['comm2-3']);
    $comm2_4 = mysqli_real_escape_string($connect,$_POST['comm2-4']);
    $comm2_5 = mysqli_real_escape_string($connect,$_POST['comm2-5']);
    $comm2Mean = mysqli_real_escape_string($connect,$_POST['comm2-mean']);
    $comm2Rate = mysqli_real_escape_string($connect,$_POST['comm2-rate']);

    $commMean = mysqli_real_escape_string($connect,$_POST['comm-mean']);

    // COSTS
    $cost1_1 = isset($_POST['cost1-1']) ? mysqli_real_escape_string($connect,$_POST['cost1-1']) : null;
    $cost1_2 = isset($_POST['cost1-2']) ? mysqli_real_escape_string($connect,$_POST['cost1-2']) : null;
    $cost1_3 = isset($_POST['cost1-3']) ? mysqli_real_escape_string($connect,$_POST['cost1-3']) : null;
    $cost1_4 = isset($_POST['cost1-4']) ? mysqli_real_escape_string($connect,$_POST['cost1-4']) : null;
    $cost1_5 = isset($_POST['cost1-5']) ? mysqli_real_escape_string($connect,$_POST['cost1-5']) : null;
    $cs1Mean = isset($_POST['cs1-mean']) ? mysqli_real_escape_string($connect,$_POST['cs1-mean']) : null;
    $cs1Rate = isset($_POST['cs1-rate']) ? mysqli_real_escape_string($connect,$_POST['cs1-rate']) : null;

    $cost2_1 = isset($_POST['cost2-1']) ? mysqli_real_escape_string($connect,$_POST['cost2-1']) : null;
    $cost2_2 = isset($_POST['cost2-2']) ? mysqli_real_escape_string($connect,$_POST['cost2-2']) : null;
    $cost2_3 = isset($_POST['cost2-3']) ? mysqli_real_escape_string($connect,$_POST['cost2-3']) : null;
    $cost2_4 = isset($_POST['cost2-4']) ? mysqli_real_escape_string($connect,$_POST['cost2-4']) : null;
    $cost2_5 = isset($_POST['cost2-5']) ? mysqli_real_escape_string($connect,$_POST['cost2-5']) : null;
    $cs2Mean = isset($_POST['cs2-mean']) ? mysqli_real_escape_string($connect,$_POST['cs2-mean']) : null;
    $cs2Rate = isset($_POST['cs2-rate']) ? mysqli_real_escape_string($connect,$_POST['cs2-rate']) : null;

    $costMean = isset($_POST['cost-mean']) ? mysqli_real_escape_string($connect,$_POST['cost-mean']) : null;
    // INTEGRITY
    $intg_1 = mysqli_real_escape_string($connect,$_POST['intg-1']);
    $intg_2 = mysqli_real_escape_string($connect,$_POST['intg-2']);
    $intg_3 = mysqli_real_escape_string($connect,$_POST['intg-3']);
    $intg_4 = mysqli_real_escape_string($connect,$_POST['intg-4']);
    $intg_5 = mysqli_real_escape_string($connect,$_POST['intg-5']);
    $intgMean = mysqli_real_escape_string($connect,$_POST['intg-mean']);
    $intgRate = mysqli_real_escape_string($connect,$_POST['intg-rate']);

    $integMean = mysqli_real_escape_string($connect,$_POST['integ-mean']);

    // ASSURANCE
    $asrc_1 = mysqli_real_escape_string($connect,$_POST['asrc-1']);
    $asrc_2 = mysqli_real_escape_string($connect,$_POST['asrc-2']);
    $asrc_3 = mysqli_real_escape_string($connect,$_POST['asrc-3']);
    $asrc_4 = mysqli_real_escape_string($connect,$_POST['asrc-4']);
    $asrc_5 = mysqli_real_escape_string($connect,$_POST['asrc-5']);
    $asrcMean = mysqli_real_escape_string($connect,$_POST['asrc-mean']);
    $asrcRate = mysqli_real_escape_string($connect,$_POST['asrc-rate']);

    $asrMean = mysqli_real_escape_string($connect,$_POST['asr-mean']);

    // OUTCOME
    $out_1 = mysqli_real_escape_string($connect,$_POST['out-1']);
    $out_2 = mysqli_real_escape_string($connect,$_POST['out-2']);
    $out_3 = mysqli_real_escape_string($connect,$_POST['out-3']);
    $out_4 = mysqli_real_escape_string($connect,$_POST['out-4']);
    $out_5 = mysqli_real_escape_string($connect,$_POST['out-5']);
    $outMean = mysqli_real_escape_string($connect,$_POST['out-mean']);
    $outRate = mysqli_real_escape_string($connect,$_POST['out-rate']);

    $ocMean = mysqli_real_escape_string($connect,$_POST['oc-mean']);

    $comments = mysqli_real_escape_string($connect,$_POST['comments']);

    // mean
    $RSMean = mysqli_real_escape_string($connect,$_POST['responsive-mean']);
    $RLMean = mysqli_real_escape_string($connect,$_POST['reliable-mean']);
    $AFMean = mysqli_real_escape_string($connect,$_POST['AcFc-mean']);
    $CMMean = mysqli_real_escape_string($connect,$_POST['communicate-mean']);
    $CSMean = isset($_POST['costs-mean']) ? mysqli_real_escape_string($connect,$_POST['costs-mean']) : null;
    $INMean = mysqli_real_escape_string($connect,$_POST['integrity-mean']);
    $ASMean = mysqli_real_escape_string($connect,$_POST['assurance-mean']);
    $OCMean = mysqli_real_escape_string($connect,$_POST['outcome-mean']);

    // mean rate
    $RSRate = mysqli_real_escape_string($connect,$_POST['responsive-rate']);
    $RLRate = mysqli_real_escape_string($connect,$_POST['reliable-rate']);
    $AFRate = mysqli_real_escape_string($connect,$_POST['AcFc-rate']);
    $CMRate = mysqli_real_escape_string($connect,$_POST['communicate-rate']);
    $CSRate = isset($_POST['costs-rate']) ? mysqli_real_escape_string($connect,$_POST['costs-mean']) : null;
    $INRate = mysqli_real_escape_string($connect,$_POST['integrity-rate']);
    $ASRate = mysqli_real_escape_string($connect,$_POST['assurance-rate']);
    $OCRate = mysqli_real_escape_string($connect,$_POST['outcome-rate']);

    $totalMean = mysqli_real_escape_string($connect,$_POST['total-mean']);
    $totalRate = mysqli_real_escape_string($connect,$_POST['total-rate']);

    // paragraphs
    $discussion = mysqli_real_escape_string($connect,$_POST['discussion']);
    $conclusion = mysqli_real_escape_string($connect,$_POST['conclusion']);
    $action = mysqli_real_escape_string($connect,$_POST['action']);

    // name and designation
    $name1 = mysqli_real_escape_string($connect,$_POST['name1']);
    $name2 = mysqli_real_escape_string($connect,$_POST['name2']);
    $name3 = mysqli_real_escape_string($connect,$_POST['name3']);
    $name4 = mysqli_real_escape_string($connect,$_POST['name4']);
    $position1 = mysqli_real_escape_string($connect,$_POST['position1']);
    $position2 = mysqli_real_escape_string($connect,$_POST['position2']);
    $position3 = mysqli_real_escape_string($connect,$_POST['position3']);
    $position4 = mysqli_real_escape_string($connect,$_POST['position4']);


    // -------------------------------------------
    $html8 = '
    <!DOCTYPE html>
        <html>
        ' . $head .
        '
        <body>
        <div style=" float:left;">
            <img src="../assets/img/clsu-logo.png" style="margin-left:5rem;margin-top:-1.5rem;height:auto;width:7rem;float:left;">
            <div style="margin-left:-12rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
            </div>    
        </div>

        <div class="container ps-5 pe-5 mb-3">
            <div class="text-center">
                <p style="">OFFICE OF THE UNIVERSITY PRESIDENT</p>
                <p style="margin:0;font-weight:bold;">OFFICE FEEDBACK REPORT</p><br>
                <p style="font-weight:bold;margin:0;">Office Rated: ERMS - PPSDS</p>
                <p style="font-weight:bold;">Evaluation Period:&nbsp;' . $evaluation . '</p>
                <h6>This is the summary report on the feedback given by <span class="fw-bold"><u>&nbsp;' . $raters . '&nbsp;</u></span> raters / evaluators.</h6>
            </div>
        </div>
        
        <div style="display:flex; justify-content:center; ">
            <div style="margin:0 5rem 0;">
                <h6>Type of Services rendered within the evaluation period:</h6>
            </div>
            <div style="margin:0 auto;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Type</td>
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Frequency</td>
                        <td style="border:1px solid;font-weight:bold; text-align:center;padding:.2rem">Percent</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Air-con Cleaned</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service1 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent1 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ">Air-con Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service2 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent2 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ">Air-con Installed</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service3 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent3 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Electric Fan Cleaned / Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service4 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent4 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Electric Fan Installed</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service5 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent5 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Other Equipment Repair</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service6 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent6 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Computer Repair & Troubleshoot</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service7 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent7 . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:0 .5rem ;">Hauling Services</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $service8 . '</td>
                        <td style="border:1px solid; text-align:center; padding:.2rem 3rem;">' . $percent8 . '</td>
                    </tr>
                    <tr style="border: 1px solid;">
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">Total</td>
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">' . $total_job . '</td>
                        <td style="border:1px solid; text-align:center;font-weight:bold;padding:.2rem">100%</td>
                    </tr>
                </table>            
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">I. RESPONSIVENESS <span style="font-style:italic;">(PAGTUGON)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>RESPONSIVENESS (PAGTUGON)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The service is provided promptly / timely. <br><span class="fst-italic">Mabilis ang serbisyo at nasa tamang oras.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rs1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rs1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The personnel show willingness to help the client. <br><span class="fst-italic">Nagpapakita ng kagustuhang maglingkod ang mga kawani.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $responsive2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rs2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rs2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Responsiveness (Pagtugon)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $rsMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">II. RELIABILITY <span style="font-style:italic;">(PAGIGING MAAASAHAN)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>RELIABILITY (PAGIGING MAAASAHAN)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The service exhibits quality and high standard. <br><span class="fst-italic">Nagpapamalas ng kalidad at mataas na pamnatayan ang serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The service meets the expectations of the client. <br><span class="fst-italic">Nakapaglilingkod nang ayon sa inaasahan ng kliyente.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $reliability2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $rl2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Reliability (Pagiging Maaasahan)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $rlMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center;width:100%;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">III. ACCESS AND FACILITIES <span style="font-style:italic;">(PASILIDAD)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;width:100%;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>ACCESS AND FACILITIES (PASILIDAD)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The facilities are clean, organized and accessible. <br><span class="fst-italic">Malinis, maayos at madaling marating ang pasilidad.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $facility_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $facMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $facRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. Online services are made available. <br><span class="fst-italic">Mayroong serbisyong online.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $access_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $accMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $accRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Access and Facilities (Pasilidad)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $afMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">IV. COMMUNICATION <span style="font-style:italic;">(KOMUNIKASYON)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>COMMUNICATION (KOMUNIKASYON)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The instructions and information are clear. <br><span class="fst-italic">Malinaw ang mga tagubilin at impormasyon.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The personnel explains the service effectively. <br><span class="fst-italic">Naipaliliwanag nang mabisa ng mga kawani ang kanilang serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $comm2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $comm2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Communication (Komunikasyon)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $commMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">V. COSTS <span style="font-style:italic;">(HALAGA)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>COSTS (HALAGA)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">1. The billing process, method and payment procedure are timely and appropriate. <br><span class="fst-italic">Nasa oras at angkop ang proseso ng paniningil at metodo ng pagbabayad.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost1_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs1Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs1Rate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">2. The cost of service is fair and reasonable. <br><span class="fst-italic">Angkop at mkatwiran ang halaga ng serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $cost2_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs2Mean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $cs2Rate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Costs (Halaga)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $costMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VI. INTEGRITY  <span style="font-style:italic;">(INTEGRIDAD)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>INTEGRITY (INTEGRIDAD)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The employees demonstrate honesty, justice, fairness and trustworthiness. <br><span class="fst-italic">Matapat, makatarungan, mapagkakatiwalaan at tapat ang mga kawani.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $intg_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $intgMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $intgRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Integrity (Integridad)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $integMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="height:5rem;"></div>
        <div style="display:flex; justify-content:center;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VII. ASSURANCE <span style="font-style:italic;">(KASIGURUHAN)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>ASSURANCE (KASIGURUHAN)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The frontline staff are knowledegable, helpful, courteous and understand client needs. <br><span class="fst-italic">Maalam, matukunngin, magalang at maunawain sa mga pangangailangan ng kliyente ang mga pangunang empleyado.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $asrc_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $asrcMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $asrcRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Assurance (Kasiguruhan)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $asrMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="display:flex; justify-content:center; margin-top:1rem; width:100%;">
            <div style="display:flex;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">VIII. OUTCOME <span style="font-style:italic;">(RESULTA)</span></h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="border: 1px solid black;margin:0 auto; width:100%;">
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan=3>OUTCOME (RESULTA)</td>
                        <td style="border:1px solid;padding:.2rem .5rem; text-align:center;" colspan="5">Frequency Ratings</td>
                        <td style="border:1px solid;padding:.1rem 1rem; text-align:center;" rowspan="3">MEAN</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;" rowspan="3">ADJECTIVAL<br>RATING</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">NI</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">F</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">G</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">VG</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">E</td>
                    </tr>
                    <tr style="border:1px solid;text-align:center;">
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">1</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">2</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">3</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">4</td>
                        <td style="border:1px solid;text-align:center; padding:.2rem .5rem;">5</td>
                    </tr>

                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:.2rem .5rem;">The desired service is achieved. <br><span class="fst-italic">Naabot ang ninanais na serbisyo.</span></td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_1 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_2 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_3 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_4 . '</td>
                        <td style="border:1px solid; text-align:center;padding:.5rem;">' . $out_5 . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $outMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center;">' . $outRate . '</td>
                    </tr>
                    <tr style="border:1px solid; text-align:center;">
                        <td style="border:1px solid;padding:.1rem .3rem; text-align:center; font-weight:bold;" colspan="6">Mean Rating for Outcome (Resulta)</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;">' . $ocMean . '</td>
                        <td style="border:1px solid;padding:.1rem .3rem; font-weight:bold;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top:2rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Rater&#39;s Comments / Suggestions</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $comments . '</span>
            </div>
        </div>

        <div style="display:flex; justify-content:center;">
            <div style="display:flex; margin:0;padding:0;">
                <h6 style="font-weight:bold;margin:.5rem 1rem;">OFFICE FEEDBACK RATING</h6>
            </div>
            <div style="display:flex !important; justify-content:center !important; align-items :center; width:100% !important; margin: 0 auto !important;">
                <table style="margin:0 !important;">
                    <tr style="border:1px solid;">
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Category</td>
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Category Mean</td>
                        <td style="border:1px solid;padding:1rem;font-weight:bold; text-align:center;">Adjectival Rating</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">I. RESPONSIVENESS <span style="font-style:italic;">(PAGTUGON)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $RSMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $RSRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">II. RELIABILITY <span style="font-style:italic;">(PAGIGING MAAASAHAN)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $RLMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $RLRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">III. ACCESS & FACILITIES <span style="font-style:italic;">(PASILIDAD)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $AFMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $AFRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">IV. COMMUNICATION <span style="font-style:italic;">(KOMUNIKASYON)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $CMMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $CMRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">V. COSTS <span style="font-style:italic;">(HALAGA)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $CSMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $CSRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VI. INTEGRITY <span style="font-style:italic;">(INTEGRIDAD)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $INMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $INRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VII. ASSURANCE <span style="font-style:italic;">(KASIGURUHAN)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $ASMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $ASRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; padding:.3rem; font-weight:bold;">VIII. OUTCOME <span style="font-style:italic;">(RESULTA)</span></td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $OCMean . '</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;">' . $OCRate . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; text-align:right; font-weight:bold; padding:.3rem;">TOTAL CATEGORY MEAN</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;" colspan="2">' . $totalMean . '</td>
                    </tr>
                    <tr style="border:1px solid;">
                        <td style="border:1px solid; text-align:right; font-weight:bold; padding:.3rem;">ADJECTIVAL RATING</td>
                        <td style="border:1px solid; text-align:center; padding:.3rem;" colspan="2">' . $totalRate . '</td>
                    </tr>
                </table>
            </div>

            <div style="background:reds;padding-top:.5rem;">
                <table style="width:18rem; border:1px solid;">
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;"><p>Rating Scale:</p></td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">4.21 - 5.00 - Excellent</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">3.41 - 4.20 - Very Good</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">2.61 - 3.40 - Good</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">1.81 - 2.60 - Fair</td>
                    </tr>
                    <tr style="margin:0; padding:0;">
                        <td style="margin:0; padding-left:.3rem;">1.00 - 1.80 - Needs Improvement</td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Discussion Results</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $discussion . '</span>
            </div>
        </div>
        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Conclusion</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $conclusion . '</span>
            </div>
        </div>
        <div style="margin-top:5rem;">
            <h6 style="font-weight:bold;margin:.5rem 1rem;">Action taken on comments / suggestions (where applicable)</h6>
            <div style="margin: 1rem 2rem;">
                <span>' . $action . '</span>
            </div>
        </div>

        <div style="margin-top:5rem;">
            <div style="padding:3rem;">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:left;padding-top:5rem;"><div><span style="background:yellowx;font-weight:bold;">Prepared By:&nbsp;' . $name1 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="padding-top:5rem;text-align:right;"><div><span style="background:greenx;font-weight:bold;">Attested:&nbsp;' . $name2 . '</span></div></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;"><div><span style="background:redx;font-weight:bold;">' . $position1 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-right:1rem;"><div><span style="background:redx;font-weight:bold;">' . $position2 . '</span></div></td>
                    </tr>
                            
                    <tr>
                        <td style="text-align:left;padding-top:5rem;"><div><span style="background:bluex;font-weight:bold;">Reviewed By:&nbsp;' . $name3 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-top:5rem;"><div style=""><span style="background:grayx;font-weight:bold;">' . $name4 . '</span></div></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;padding-right:3.7rem;"><div style=""><span style="background:bluex;font-weight:bold;">' . $position3 . '</span></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;padding-right:.4rem;"><div style=""><span style="background:grayx;font-weight:bold;">' . $position4 . '</span></div></td>
                    </tr>
                </table>
            </div>
        </div>

        </body>
        </html>
    ';

    $pdf->SetMargins(10, 10, 12, 10);
    $pdf->SetHTMLFooter('<p style="font-size:10px;">OUP.XXX.YYY.F.017 (Revision No. 1; November 8, 2021)</p>');
    $pdf->WriteHTML($html8);
    // ob_end_clean();

    $pdf->Output('report.pdf', 'D');
        
    
}
