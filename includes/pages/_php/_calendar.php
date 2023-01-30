<?php
require_once('../../connection.php');
$func = new functions();
$data = array();
$query = "SELECT * FROM casedetails,clientdetails WHERE casedetails.client_fk = clientdetails.client_id  ORDER BY casedetails.case_id";
$result = mysqli_query($connection, $query);
$func->verify_query($result);
$dataa = mysqli_fetch_all($result);
// echo "<pre>";
// print_r($dataa);
// echo "</pre>";
foreach ($dataa as $d) {
    switch ($d[7]) {
        case 'DEED':
            $color = 'red';
            break;
        case 'SUBMISSION':
            $color = 'green';
            break;
        
        case 'CHARGE SHEET':
            $color = '#a3a127';
            break;
        case 'ESTATE CASE':
            $color = 'orange';
            break;
        case 'URBAN CONCIL-PRADESHEEYA SABHA':
            $color = '#21f8ff';
            break;
        case 'HIGH COURT':
            $color = '#ff2197';
            break;
        case 'BAIL':
            $color = '#f542dd';
            break;
        case 'ARBITRATION(ENTHARAWASI)':
            $color = '#aeff21';
            break;
        case 'AGREEMENTS':
            $color = '#c352de';
            break;
        case 'FAMILY MATTERS':
            $color = '#fac18e';
            break;
        case 'S-LIST':
            $color = '#fa998e';
            break;
        
        default:
            $color = 'blue';
            break;
    }
    $title = $d[12].' '.$d[2];
    $data[] = array(
        'allDay' => true,
        'title' => $title ,
        'start' => $d[9],
        'end' => $d[9],
        'description' => $d[7],
        'color' => $color,
        'caseId' => $d[0],
        'clientId' => $d[1]
    );
}

echo json_encode($data);
