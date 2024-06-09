<?php

//  generate job order form with values

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
        <img src="../assets/img/clsu-logo.png" style="margin-left:4rem;margin-top:-1rem;height:auto;width:6rem;float:left;">
        <div style="margin-left:-10rem; align-content:center;">
            <div style="margin:0 auto;text-align:center; width:700px;">
            <span>Republic of the Philippines</span><br>
            <span style="font-weight:bold;font-size:15px;">CENTRAL LUZON STATE UNIVERSITY</span><br>
            <span>Science City of Muñoz, Nueva Ecija</span>
            </div>
        </div> 
        <div style="text-align:center; margin-top:-.5rem;">
        <span style="text-align:center;align-content:center;margin:0 auto;">PHYSICAL PLANT AND SITE DEVELOPMENT SERVICES</span>
        </div>   
    </div>
';

if (isset($_POST['jobrequest'])) {
    $jobID= $_POST['job-id'];
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4','orientation'=>'P', 'default_font_size' => 11, 'default_font' => 'Calibri']);
   
    $dateNow = date("Y-m-d");
    $title1 = '
        <div style="text-align:center;">
            <p style="font-weight:bold;font-size:18px;">JOB ORDER</p>
        </div>
    ';

    $table1 = '';

    $select = $connect->prepare("SELECT * FROM job_request WHERE job_id=?");
    $select->bind_param("i",$jobID);
    $select->execute();
    $job=$select->get_result();
    // $row1 = $job->fetch_assoc();

    $filename = '';
    if ($job->num_rows > 0) {
        while ($row1 = $job->fetch_assoc()) {
            $job_control = $row1['job_control_number'];
            $job_service = $row1['job_service'];
            $supplies = $row1['supplies_materials'];
            $causes = $row1['causes'];
            $official = $row1['requesting_official'];
            $personnel = $row1['assigned_personnel'];
            $location = $row1['job_location'];
            $feedback = $row1['feedback_number'];
            $date = date("F j, Y", strtotime($row1['date_requested']));
            $filename = $job_control;
        }
    } else {
        $table1 = '<tr class="text-center"><td colspan="5">no records</td></tr>';
    }

    $html1 = '
        <!DOCTYPE html>
        <html>
        <body>
        ' . $head . $header . $title1 . '
       
            <table style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:50%; padding: 1rem; vertical-align: top;">
            <table style="width:100%; margin-right:.5rem;">
                <tr>
                    <td style="padding: .1rem; font-size:14px;white-space: nowrap;">REQUEST FOR JOB/SERVICES TO BE RENDERED:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td style="padding: .2rem; width: 90%;">&nbsp;&nbsp;&nbsp;'.$job_service. '&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding: .1rem; ">SUPPLIES/MATERIALS NEEDED:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td style="padding: .1rem; width: 90%;">&nbsp;&nbsp;&nbsp;'.$supplies. '&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding: .1rem; ">CAUSES AND REMEDIES:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td style="padding: .1rem; width: 90%;">&nbsp;&nbsp;&nbsp;'.$causes. '&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>

        <td style="width:50%; padding: 1rem; vertical-align: top;">
            <table style="width:100%;">
                <tr>
                    <td>REQUESTING OFFICIAL:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td style="padding: .1rem;">&nbsp;&nbsp;&nbsp;'.$official. '&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>LOCATION:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td style="padding: .1rem;">&nbsp;&nbsp;&nbsp;'.$location. '&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>ASSIGNED PERSONNEL:</td>
                </tr>
                <tr style="border-bottom: 1px solid;">
                    <td>&nbsp;&nbsp;&nbsp;'.$personnel.'&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>DATE REQUESTED:&nbsp;<span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;'.$date.'&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
                <tr>
                    <td>FEEDBACK NUMBER:&nbsp;<span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;'.$feedback.'&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
                <tr>
                    <td>JOB ORDER CONTROL NO:&nbsp;<span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;'.$job_control.'&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

          
            <p style="margin:0rem 0rem 0rem 12rem !important;">NOTED:</p>
            <div style="text-align:center;margin:0 !important;padding:0;">
                <p style="margin-top:-1rem !important;padding:0;">
                <span style="text-decoration:underline;">&nbsp;CARLO RAUL C. DIVINA&nbsp;</span><br>
                <span>Director, PPSDS</span>
                </p>
            </div>
            <table>
                <tr style="">
                    <td style="width:50% !important;margin:0;padding:0;">
                        <p style="margin:0;padding:0;">Date & Time Started:_________________________</p>
                        <p style="margin:0;padding:0;">Date & Time Finished:________________________</p>
                    </td>
                   
                    <td style="margin:0 !important;padding:0;width:50%;">
                    <span style="font-size:10px;margin:1rem !important;text-align:center;">This is to certify that the requested job / services has been completed.</span><br>
                    <span>CONFORME:</span><br>_________________________________________________<br>
                    <span style="color:#ffffff !important;text-align:center;">---------------------------</span>END-USER
                    </td>
                </tr>
            </table>
        <div>
            <span style="font-size:10px;">ADM.PSD.YYY.F.005 (Revision No. 3; August 29, 2023)</span> 
        </div>
        </body>
        </html>';

    $pdf->SetMargins(10, 10, 10, 10);
    $pdf->writeHTML($html1);
    // ob_end_clean();
    $pdf->Output('job-order_'.$filename.'.pdf', 'D');
}
?>