<?php
include 'config/connect.php';
$id = $_GET['id'];
$sql = mysqli_query($connect, "SELECT * FROM equipments WHERE equipment_id = '$id'");
$data = mysqli_fetch_array($sql);
?>

<!DOCTYPE HTML>

<html>

<head>
    <title>QR CODE RESULT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/downloads/fontawesome-web/css/all.min.css">
</head>

<body class="is-preloadd">
    <!-- Main -->
    <div id="MAINDIV">

        <a href="scanQR.php" id="back" class="fst-italic ms-3 me-3 mt-3 text-decoration-none text-dark">
            <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to index page</span>
        </a>

        <div class="container-fluid overflow-auto pb-5">
            <?php if ($data) { ?>
                <!-- TITLE -->
                <div id="eq-title" class="d-flex justify-content-center m-3 mid-green-bg p-2 text-light">
                    <h1 class="fw-bold text-light"><?php echo $data['equip_name']; ?></h1>
                </div>
                
                <!-- EQUIPMENT INFO -->
                <div class="container-fluid mb-5">
                    <div class="pb-2 text-start">
                        <span class=" text-uppercase fw-bold h6">Equipment Information</span>
                    </div>
                    <table class=" mb-5 border">
                        <tr class="border">
                            <td scope="col" class="col-5 border">Name of equipment / device:</td>
                            <td><?php echo $data['equip_name']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Category:</td>
                            <td><?php echo $data['category']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Equipment Model:</td>
                            <td><?php echo $data['equip_model']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Brand / Label:</td>
                            <td><?php echo $data['brand_label']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Property Number:</td>
                            <td><?php echo $data['property_number']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Location:</td>
                            <td><?php echo $data['equip_location']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Status:</td>
                            <td><?php echo $data['equip_status']; ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Date put into Service:</td>
                            <td><?php echo date("F j, Y", strtotime($data['date_service'])); ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Person Responsible for the Equipment:</td>
                            <td><?php echo $data['assigned_person']; ?></td>
                        </tr>
                    </table>

                    <div class="pb-2 text-start">
                        <span class=" text-uppercase fw-bold h6">Purchase Details</span>
                    </div>
                    <table class="mb-5 border">
                        <tr class="border">
                            <td scope="col" class="col-5 border">Date Purchased:</td>
                            <td><?php echo date("F j, Y", strtotime($data['date_purchased'])); ?></td>
                        </tr>
                        <tr class="border">
                            <td scope="col" class="col-5 border">Price:</td>
                            <td><?php echo number_format($data['price'], 2, '.', ','); ?></td>
                        </tr>
                    </table>

                    <span class=" text-uppercase fw-bold h6">Remarks</span>
                    <div class="row border m-1">
                        <div class="col-6 mb-3">
                            <div class="">
                                <?php echo $data['notes_remarks']; ?>
                            </div>
                        </div>
                    </div>

                    <div class="pb-2 text-center pt-5">
                        <span class=" text-uppercase fw-bold h6">Maintenance Records</span>
                    </div>
                    <?php
                    $eqID = $data['equipment_id'];
                    $sql = mysqli_query($connect, "SELECT * FROM maintenance_records WHERE equipment_id = '$eqID'  ORDER BY mnt_id DESC LIMIT 1");
                    $mnt = mysqli_fetch_assoc($sql);
                    $id1 = $eqID; ?>

                    <!-- MAINTENANCE INFO -->
                    <div class="overflow-auto">
                        <table class="border text-center">
                            <thead class="border-bottom">
                                <th class="th-bg border-end">Maintenance Date</th>
                                <th class="th-bg border-end">Maintained By</th>
                                <th class="th-bg border-end">Description</th>
                                <th class="th-bg">Notes/Remarks</th>
                            </thead>
                            
                            <?php
                            $eqID = $data['equipment_id'];
                            $select = "SELECT * FROM maintenance_records WHERE equipment_id='$eqID' AND last_mnt IS NOT NULL ORDER BY mnt_id DESC";
                            $result2 = mysqli_query($connect, $select);
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {?>
                                    <tr class="border">
                                        <td><?php if (!empty($row2['last_mnt']) && $row2['last_mnt'] !== "0000-00-00") {
                                                echo date("F j, Y", strtotime($row2['last_mnt']));
                                            } else {
                                                echo "None";
                                            } ?></td>
                                        <td><?php echo $row2['maintained_by']; ?></td>
                                        <td><?php echo $row2['mnt_description']; ?></td>
                                        <td><?php echo $row2['notes_remarks']; ?></td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr class='text-center'><td colspan='6'>no records</td></tr>";
                            } ?>
                        </table>
                    </div>
                </div>
            <?php 
            } else {
                echo '<section id="eq-title" class="d-flex justify-content-center m-3 p-2 ">
                <h1 class="fw-bold ">No equipment record found in the database.</h1>
            </section>';
            } ?>
        </div>
    </div>

</body>

</html>