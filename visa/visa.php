<?php

$file = "countries.csv";
$sum = 0;
$country = implode(" ", array_slice($argv, 1));

$fp = fopen($file, 'r');
  while (($row = fgetcsv($fp, 100, ',')) !== FALSE) {

    if (count($row) < 3) { //Исключение пустых строк, или стран без возможности въезда
      continue;
    }
    if ($country == $row[1]) {
      $sum++;
      echo $country." ".$row[4];
    }

  }

if ($sum == 0) {
    echo "Попробуйте ввести другое название страны.";
}
