<?php
// Barcode.
$original = 8414533043847;
// Barcode length.
$count = 0;
$number = $original;
// Barcode list of number
$number_list = [];
$control_number = 0;
$number_sum = 0;

// Get number list.
while($number != 0) {
 $number_value = $number % 10;
 $number = ($number - $number_value) / 10;
 $number_list[] = $number_value;
 $count++;
}

// Result of the barcode number sum.
for($i = 0; $i < $count; $i++) {
  if ($i == 0) {
    $control_number = $number_list[$i];
  } elseif (($i % 2) == 0) {
    $number_sum += $number_list[$i] * 1;
  } else {
    $number_sum += $number_list[$i] * 3;
  }
}

// Calculate if divisible by 10.
$result = ($number_sum + $control_number) % 10 == 0 ? "SI" : "NO";

$contry_codes = [
  0 => "EEUU",
  380 => "Bulgaria",
  50 => "Inglaterra",
  539 => "Irlanda",
  560 => "Portugal",
  70 => "Noruega",
  759 => "Venzuela",
  850 => "Cuba",
  890 => "India",
];

// Calculate if the barcode has barcode.
$country_result = "";
$country_found = FALSE;
if ($count > 8 && $count <= 13) {
  foreach ($contry_codes as $code => $contry) {
    $code_length = mb_strlen($code);
    $power_number = ($count - $code_length);
    $code_zero = $code * pow(10, $power_number);
    $result_minus = $original - $code_zero;
    $count_result_minus = mb_strlen($result_minus);
    if ($count_result_minus == $power_number) {
      $country_result = $contry;
      $country_found = TRUE;
    } elseif (!$country_found) {
      $country_result = "Desconocido";
    }
  }
}

// Only print the result if is different of zero.
if ($original != 0) {
  print($result . " " . $country_result . PHP_EOL);
}
