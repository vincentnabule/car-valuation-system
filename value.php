<?php

$q = strval($_GET['t']);
require 'main.php';
$usr = $_SESSION['userkey'];

$dates = explode(' ', $q);
$data = $datafetch->filter_dates($dates[0], $dates[1], $usr);

echo '<div class="h5 text-center">Evaluatation From: ' . $dates[0] . '. <br>Evaluatation To: ' . $dates[1] . '. </div>';
if (sizeof($data) == 0) {
    echo '<section>
                <div class="h2 text-danger text-center p-2">No records found within the specified dates</div>
              </section>';
}else {
    echo '<table class="table table-striped ">
    <thead class="table-primary">
        <th scope="col">Car Make</th>
        <th scope="col">Car Model</th>
        <th scope="col">Year</th>
        <th scope="col">Engine</th>
        <th scope="col">Mileage</th>
        <th scope="col">Power</th>
        <th scope="col">Fuel Type</th>
        <th scope="col">Transmission</th>
        <th scope="col">Seats</th>
        <th scope="col">Price</th>
   </thead>
   <tbody>';
    foreach($data as $dt){

            echo '<tr>
                    <td>'.ucfirst(strtolower($dt['car_make'])).'</td>
                    <td>'.ucfirst(strtolower($dt['car_model'])).'</td>
                    <td>'.$dt['manufacture_year'].'</td>';
                    echo '<td>'. number_format($dt['car_engine'], 0,".",",").' CC </td>';
                    echo '<td>'. number_format($dt['mileage'], 0,".",",").'</td>';
                    echo '<td>'. number_format($dt['car_power'], 0,".",",").' bhp </td>';
                    echo '<td>'. $dt['fuel_type'] .' </td>';
                    echo '<td>'. $dt['transmission'] .'</td>';
                    echo '<td>'. $dt['seats'] .'</td>';
                    echo '<td>'. number_format($dt['predicted_amount'], 2, '.', ',').'</td>';
            echo '</tr>';
    }
}
echo '<tbody>';
echo '</table>';
