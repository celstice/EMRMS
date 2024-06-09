<?php

// generate user feedback results | admin

include 'connect.php';
require_once ('../vendor/autoload.php');

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['feedback-pdf'])) {
    
    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
    $feedback = $_POST['fid'];
    $getFeedback = $connect->prepare("SELECT * FROM feedbacks WHERE feedback_id = ?");
    $getFeedback->bind_param("i", $feedback);
    $getFeedback->execute();
    $fb = $getFeedback->get_result();
    $data = $fb->fetch_assoc();

    $user_id = $data['job_id'];
    // $getUser = mysqli_query($connect, "SELECT * FROM users WHERE userID = '$user_id'");
    // $employee = mysqli_fetch_assoc($getUser);
    $getUser = $connect->prepare("SELECT * FROM job_request WHERE job_id = ?");
    $getUser->bind_param("i", $user_id);
    $getUser->execute();
    $u = $getUser->get_result();
    $employee = $u->fetch_assoc();
 
    $head = '
    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/downloads/fontawesome-web/css/all.min.css">
    </head>';
    $header = '
    <div class="" style="display:grid; gap:50px 50px;">
    <div class="text-center m-0" style="font-size:15px;grid-column-start: 1;grid-column-end: 3;">
        <p class="mb-0 mt-0" margin="0" style="margin:0 !important;">REPUBLIC OF THE PHILIPPINES</p>
        <p class="mb-0 mt-0" margin="0" style="font-weight:bold;">CENTRAL LUZON STATE UNIVERSITY</p>
        <p class="mb-0 mt-0" style="margin:0 !important;">Science City of Muñoz, Nueva Ecija</p>
        <p class=" mb-3 mt-3">OFFICE OF THE UNIVERSITY PRESIDENT</p>  
    </div>
    <div class="text-end m-0" style="grid-column-start:4;">
        <h6 class="fw-bolder">Feedback No.&nbsp;'.$data['feedback_number'].'</h6>
    </div>
    </div>
    <div class="text-center">
        <p style="font-weight:bold;">FEEDBACK FORM</p>
        <p class="mt-3 mb-3">Office Rated:&nbsp;'.$data['office'].' </p>
    </div>
    
    ';
    $row = '
    <table class="table border-0" style="font-size:14px">
    <tr class="border-0 d-flex justify-content-start">
        <td class="m-1 h6 border-0">Type of Transaction / Service:&nbsp;<br>'.$data['job_service'].'</td>
        <td class="m-1 h6 border-0" style="padding-right:1rem;">Name of Employee:&nbsp;<br>'.$employee['requesting_official'].'</td>
        <td class="m-1 h6 border-0">Date:&nbsp;<br>'.date("F j, Y",strtotime($data['feedback_date'])).'</td>
    </tr>
    </table>
    ';

    $html = '
<!DOCTYPE html>
<html>
'.$head.$header.$row.'
<table style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;" colspan="3">Service Quality</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;">Needs Improvement (1)</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;">Fair (2)</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;">Good (3)</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;">Very Good (4)</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center; font-size:14px;">Excellent (5)</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8">RESPONSIVENESS</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">1. The service is provided promptly / timely.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive1'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive1'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive1'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive1'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive1'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">2. The personnel show willingness to help the client.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive2'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive2'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive2'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive2'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['responsive2'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">RELIABILITY</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">1. The service exhibits quality and high standard.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability1'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability1'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability1'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability1'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability1'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">2. The personnel show willingness to help the client.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability2'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability2'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability2'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability2'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['reliability2'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">ACCESS AND FACILITIES</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">1. The facilities are clean, organized and accessible.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['facility'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['facility'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['facility'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['facility'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['facility'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">2. Online Services are made available.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['access'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['access'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['access'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['access'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['access'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">COMMUNICATION</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">1. The instructions and information are clear.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication1'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication1'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication1'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication1'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication1'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">2. The personnel explains te service effectively.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication2'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication2'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication2'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication2'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['communication2'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">COST</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">1. The billing process, method and payment are timely and appropriate.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost1'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost1'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost1'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost1'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost1'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">2. The cost of service is fair and reasonable.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost2'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost2'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost2'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost2'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['cost2'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">INTEGRITY</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">The employees demonstrate honesty, justice, fairness and trustworthiness.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['integrity'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['integrity'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['integrity'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['integrity'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['integrity'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">ASSURANCE</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">The frontline staff are knowledgeable, helpful, courteous and understand clientneeds.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['assurance'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['assurance'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['assurance'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['assurance'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['assurance'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="8" class="title">OUTCOME</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">The desired service is achieved.</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['outcome'] == "1" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['outcome'] == "2" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['outcome'] == "3" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['outcome'] == "4" ? '/' : '') . '</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;">' . ($data['outcome'] == "5" ? '/' : '') . '</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; padding:.3rem;" colspan="3">Comment / Suggestion for Improvement:</td>
        <td style="border: 1px solid black; padding:.3rem; text-align:center;" colspan="5">'.$data['comments'].'</td>
    </tr>
                            
</table>
    
</body>
</html>';

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetMargins(0,0,10,0);

    $pdf->SetHTMLHeader('<header><img src="../assets/img/clsu-logo.png" style="margin-left:2rem;" height="100" width="100"></header>');
    $pdf->SetHTMLFooter('<p class="text-center mb-3">THANK YOU.</p><p style="font-size:10px;">OUP.XXX.YYY.P.003 (Revision No. 3, October 18, 2021)</p>');
    $pdf->writeHTML($html);
    // ob_end_clean();
    $pdf->Output('feedback.pdf', 'D');
}
?>