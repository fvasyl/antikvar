<?php

/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action для сторінки "Реєстрація"
     */
   
    public function actionRegister()
    {
        // змінні для форми
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        // Обробка форми
        if (isset($_POST['submit'])) {
            //print_r($_POST);
            // якщо форма була відправлена 
            // отримуємо дані із форми
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // індекатор помилок
            $errors = false;

            // валідація полів
            if (!User::checkName($name)) {
                $errors[] = 'Ім&rsquo;я не має бути коротшим 2-х символів';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправельний email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не має бути коротшим 6-ти символів';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такий email уже використовується';
            }
            
            if ($errors == false) {
                // якщо помилок нема
                // реєструємо користувача
                $result = User::register($name, $email, $password);
                //print_r($result);
                $userId = User::checkUserData($email, $password);
                User::auth($userId);
                header("Location: ".MyDomain."/cabinet");
            }
        }

        // підключаємо вид
        require_once(ROOT . '/views/user/register.php');
        return true;
    }
    
    /**
     * Action для сторінки "Вхід на сайт"
     */
    public function actionLogin()
    {
        // змінні для форми
        $email = false;
        $password = false;
         print_r("adff");
        // Обробка форми
        if (isset($_POST['submit'])) {
            // якщо форма відправлена
            // отримуємо дані із форми
            $email = $_POST['email'];
            $password = $_POST['password'];

            // індекатор помилок
            $errors = false;

            // валідація полів
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправельний email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не має бути коротшим 6-ти символів';
            }

            // провірка, чи існує користувач
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                // якщо дані неправельні показуємо помилки
                $errors[] = 'Неправельні дані для входу на сайт';
            } else {
                // якщо дані правельні, запам'ятовуємо користувача (у сесії)
                User::auth($userId);
                
                // отримуємо дані про користувача 
                $user = User::getUserById($userId);
                
                // перевіряємо чи користувач не є дміністратором
                if ($user['role'] == 'admin') 
                {
                    // якщо є то перенаправляємо його до адмінпанелі
                    header("Location: ".MyDomain."/admin");
                }
                else
                // перенаправляємо користувача у закриту частину - кабінет
                header("Location: ".MyDomain."/cabinet");
                
            }
        }

        // підключаємо вид
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * видалення даних про користувача із сесії
     */
    public function actionLogout()
    {
        // старт сесії
        session_start();
        
        // видаляємо дані про користувача із сесії
        unset($_SESSION["user"]);
        
        // перенаправляємо користувача на головну сторінку
        header("Location: ".MyDomain);
    }

}
