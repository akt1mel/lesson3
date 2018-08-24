<?php

$file = "countries.csv";
$sum = 0;
$country = implode(" ", array_slice($argv, 1));
$link = "https://data.gov.ru/opendata/7704206201-country/data-20180609T0649-structure-20180609T0649.csv?encoding=UTF-8";

if(file_exists($file)) {
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
  fclose($fp);
  if ($sum == 0) {
      echo "Попробуйте ввести другое название страны.";
  }
} else {
  echo "Файл countries.csv не существует. Попробуйте еще раз";
  $data = file_get_contents($link);
  file_put_contents($file, $data);
}
