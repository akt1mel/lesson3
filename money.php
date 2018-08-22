<?php

if ($argc < 2) {
  echo "Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}";
} elseif ($argv[1] == '--total') {
  $total = 0;
  if(file_exists('report.csv')){
    $fp = fopen('report.csv', 'r');  //Подсчет расходов за текущую дату
      if ($fp !== FALSE) {
        while (($row = fgetcsv($fp, 100, ',')) !== FALSE) {
          if ($row[0] === date('Y-m-d')) {
            $total += $row[1];
          }
        }
        echo "Расход за день: $total";
      }
    fclose($fp);
  } else {
    echo "Файл учета расходов не существует";
  }
} else {
$date = date('Y-m-d');
$price = $argv[1]; //цена
$goods = implode(" ", array_slice($argv, 2)); //название товара
$list = [$date, $price, $goods];
$fp = fopen('report.csv', 'a');
  fputcsv($fp, $list);
  echo "Добавлена строка: $date, $price, $goods";
fclose($fp);

}
