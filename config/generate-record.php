<?php

// generate equipment record | user

include 'connect.php';
require_once('../vendor/autoload.php');

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4','orientation' => 'P', 'default_font_size' => 11, 'default_font' => 'Calibri']);

$head = '
    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/downloads/fontawesome-web/css/all.min.css">
        <link rel="stylesheet" href="assets/css/mpdf-bootstrap.css">
    </head>';

$header = '
    <header margin="-20px">
        <table style="width:100%;">
        <tr>
            <td width="33%" style="text-align:right;"><img src="../assets/img/clsu-logo.png" style="margin-left:2rem;" height="100" width="100"></td>
            <td width="33%" align="center"><p class="mb-0 mt-0" margin="0" style="margin:0 !important;">REPUBLIC OF THE PHILIPPINES</p>
                <p class="mb-0 mt-0" margin="0" style="font-weight:bold;">CENTRAL LUZON STATE UNIVERSITY</p>
                <p class="mb-0 mt-0" style="margin:0 !important;">Science City of Muñoz, Nueva Ecija</p>
                <p class=" mb-3 mt-3">OFFICE OF THE UNIVERSITY PRESIDENT</p>    
            <td width="33%" style="text-align: right;"></td>
        </tr>
        </table>
    </header>';

$title = '
    <div class="text-center" style="padding-top:1rem;">
        <p style="text-align:center; margin-top:-2rem; font-size:16px;font-weight:bold;">EQUIPMENT / MACHINE MAINTENANCE RECORD</p>
    </div>';

if (isset($_POST['generate-dox'])) {
    $equipment = $_POST['eq-id'];
    $getEq = $connect->prepare("SELECT * FROM equipments WHERE equipment_id = ?");
    $getEq->bind_param("i", $equipment);
    $getEq->execute();
    $eq = $getEq->get_result();
    $data = $eq->fetch_assoc();

    $table2Content = '';
    $select = "SELECT * FROM maintenance_records WHERE equipment_id=? AND userID = ? AND last_mnt IS NOT NULL ORDER BY mnt_id DESC";
    $mnt = $connect->prepare($select);
    $mnt->bind_param("ii",$equipment, $user,);
    $mnt->execute();
    $row = $mnt->get_result();
    if ($row->num_rows > 0) {
        $table2Content = '
            
             <tr>
                 <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Maintenance Date</td>
                 <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Maintained By</td>
                 <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Description</td>
                 <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Notes/Remarks</td>
             </tr>
           
            ';
        while ($row2 = $row->fetch_assoc()) {
            $table2Content .= '
            <tr>
                <td style="border: 1px solid black; padding:.2rem; text-align:center;">' . date("F j, Y", strtotime($row2['last_mnt'])) . '</td>
                <td style="border: 1px solid black; padding:.2rem; text-align:center;">' . $row2['maintained_by'] . '</td>
                <td style="border: 1px solid black; padding:.2rem; text-align:center;">' . $row2['mnt_description'] . '</td>
                <td style="border: 1px solid black; padding:.2rem; text-align:center;">' . $row2['notes_remarks'] . '</td>
            </tr>
            ';
        }
    } else {
        $table2Content = '
            <tr style="border: 1px solid black; padding:.2rem;text-align:center;">
                <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Maintenance Date</td>
                <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Maintained By</td>
                <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Description</td>
                <td style="border: 1px solid black; text-transform:uppercase; font-size:11px; background:#D4F6CC; padding:.3rem; font-weight:bold;text-align:center;">Notes/Remarks</td>
            </tr>
            <tr><td colspan="4" style="text-align:center;border:1px solid;padding:2rem;">no records</td></tr>';
    }

$html = '
    <!DOCTYPE html>
    <html>
    <body>

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
    <br>
    ' . $title . '

    <div class="container" style="display:flex;justify-content:center;align-items:center;">
    <table style="border: 1px solid black; display:flex;justify-content:center;align-items:center; width:100%;border-collapse:collapse;">
        <tr>
            <td style="background:#D4F6CC; padding:.5rem; text-align:center; font-weight:bold; text-transform:uppercase;font-size:11px;" colspan="2">Equipment Information</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Name of equipment / device:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['equip_name'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Category:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['category'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Equipment Model:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['equip_model'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Brand / Label:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['brand_label'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Serial Number:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['property_number'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Location:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['equip_location'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Status:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['equip_status'] . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Date put into Service:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . date("F j, Y",strtotime($data['date_service'])) . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Person Responsible for the Equipment:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . $data['assigned_person'] . '</td>
        </tr>
        <tr>
            <td style="background:#D4F6CC; padding:.5rem; text-align:center; font-weight:bold; text-transform:uppercase;font-size:11px;" colspan="2">Purchase Details</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Date of Purchase:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . date("F j, Y", strtotime($data['date_purchased'])) . '</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td scope="col" class="col-3 border" style="border:1px solid; padding:.2rem; font-size:15px;">Price:</td>
            <td style="border: 1px solid black;  padding:.2rem .2rem .2rem 1rem; font-size:15px;">' . number_format($data['price'], 2, '.', ',') . '</td>
        </tr>
        <tr>
            <td style="background:#D4F6CC; padding:.5rem; text-align:center; font-weight:bold; text-transform:uppercase;font-size:11px;" colspan="2">Remarks</td>
        </tr>
        <tr class="border" style="border: 1px solid black;">
            <td style="border: 1px solid black;  padding:1rem; font-size:15px;" colspan="2">' . (empty($data['notes_remarks']) ? '<br>' : $data['notes_remarks']) . '</td> 
        </tr>
    </table>

    </div>
    <div style="padding-top:1rem;">
    <table style="width:100%;border-collapse:collapse;">
    '.$table2Content.'
    </table>
    </div>
    </body>
    </html>';

    $mpdf->SetMargins(0,0,10,0);
    $mpdf->writeHTML($html);
    // ob_end_clean();
    $mpdf->Output('equipment-record.pdf', 'D');

}
