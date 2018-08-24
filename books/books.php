<?php

if ($argc < 2) {
  echo "Введите название книги";
} else {
  $query = implode(" ", array_slice($argv, 1)); //Считываем введенное название и записываем в строку.

  $url = "https://www.googleapis.com/books/v1/volumes?q=".urlencode($query);

  $booksData = json_decode(file_get_contents($url), true);

  switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            echo ' - Достигнута максимальная глубина стека';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Некорректные разряды или несоответствие режимов';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Некорректный управляющий символ';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Синтаксическая ошибка, некорректный JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Некорректные символы UTF-8, возможно неверно закодирован';
        break;
    }



  $file = fopen('books.csv', 'w');
    if ($booksData["totalItems"] == 0) {
      echo "Данных по книгам с таким названием нет.";
    } else {
      foreach ($booksData["items"] as $book) {
        if (isset($book["volumeInfo"]["authors"][0])) {
          fputcsv($file, [$book["volumeInfo"]["title"], $book["volumeInfo"]["authors"][0]]);
        } else { // Если автора нет, записываем Wihout authors
          fputcsv($file, [$book["volumeInfo"]["title"], "Without authors"]);
        }
      }
    fclose($file);
    }

}
