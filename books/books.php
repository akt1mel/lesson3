<?php

$query = implode(" ", array_slice($argv, 1)); //Считываем введенное название и записываем в строку.

$url = "https://www.googleapis.com/books/v1/volumes?q=".urlencode($query);

$f = json_decode(file_get_contents($url), true);

if (!json_last_error_msg()) {  //Выводим ошибку запроса json, если она существует
  echo json_last_error_msg();
}

$file = fopen('books.csv', 'w');
  foreach ($f["items"] as $book) {
    if (isset($book["volumeInfo"]["authors"][0])) {
      fputcsv($file, [$book["volumeInfo"]["title"], $book["volumeInfo"]["authors"][0]]);
    } else { // Если автора нет, записываем Wihout authors
      fputcsv($file, [$book["volumeInfo"]["title"], "Without authors"]);
    }
  }
fclose($file);
