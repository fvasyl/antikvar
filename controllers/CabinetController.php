<?php

/**
 * Контроллер CabinetController
 * Кабінет користувача
 */
class CabinetController
{

    /**
     * Action для сторінки "Кабінет користувача"
     */
    public function actionIndex()
    {
        // отримуємо ідентифікатор користувача із сесії
        $userId = User::checkLogged();

        // отримуємо інформацію про користувача із БД
        $user = User::getUserById($userId);

        // підключаємо вид
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
     * Action для сторінки "Редагування даних користувача"
     */
    public function actionEdit()
    {
        // отримуємо ідентифікатор користувача із сесії
        $userId = User::checkLogged();

        // отримуємо інформацію про користувача з БД
        $user = User::getUserById($userId);

        // заповнюємо змінні для полів форми
        $name = $user['name'];
        $password = $user['password'];

        // індекатор результату
        $result = false;

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форма відправлена
            // отримуємо дані із форми 
            $name = $_POST['name'];
            $password = $_POST['password'];

            // індекатор помилок
            $errors = false;

            // валідація значення
            if (!User::checkName($name)) {
                $errors[] = 'Ім я не має бути коротшим 2-х символів';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не має бути коротшим 6-ти символів';
            }

            if ($errors == false) {
                // якщо помилок немає, зберігаємо зміни
                $result = User::edit($userId, $name, $password);
            }
        }

        // підключаємо вид
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

}
