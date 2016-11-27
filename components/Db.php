<?php

/**
 * Клас Db
 * Компонент для роботи із БД
 */
class Db
{

    /**
     * Конект із БД
     * @return \PDO <p>Об єкт  PDO для роботи з БД</p>
     */
    public static function getConnection()
    {
        // отримуємо параметри підключення із файлу
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        // встановлюється з'єднання
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        // utf8
        $db->exec("set names utf8");

        return $db;
    }

}
