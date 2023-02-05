<?php
require 'main.php';

$q = strval($_GET['q']);
$models = $datafetch->car_model($q);

echo '<label for="" class="form-label col-6">Car Model <span class="text-danger text-bold">*</span></label>';
echo '<select class="form-input col-6" name="c_model" required">';
echo '<option value="" disabled selected>Select Model</option>';
foreach ($models as $model) {
    echo '<option value="' .$model['car_model'].'">' .$model['car_model']. '</option>';
}
echo '</select>';