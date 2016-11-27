<?php

/**
 * Функція __autoload для автоматичного підключення класів
 */
function __autoload($class_name)
{
    // масив папок, в яких можуть бути класи
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    // проходимо по масиву
    foreach ($array_paths as $path) {

        // Формируем имя и путь к файлу с классом
        // формування імені і шляху для файлу із класом
        $path = ROOT . $path . $class_name . '.php';

        // якщо файл існує підключаємо його
        if (is_file($path)) {
            include_once $path;
        }
    }
}
