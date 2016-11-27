<?php

/**
 * Клас User - модель для роботи з користувачами
 */
class User
{

    /**
     * реєстрація користувача 
     * @param string $name <p>ім'я</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>результат виконання</p>
     */
    public static function register($name, $email, $password)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';

        // отримання і повернення результатів
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * редагування даних користувача
     * @param integer $id <p>id користувача</p>
     * @param string $name <p>ім'я</p>
     * @param string $password <p>пароль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function edit($id, $name, $password)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";

        // отримання і повернення результату
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * провірка чи існує користувач з вказаним $email і $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        // отримання і повернення результату
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();

        // звертаємося до запису
        $user = $result->fetch();

        if ($user) {
            // якщо запис існує, то повертаємо id користувача
            return $user['id'];
        }
        return false;
    }

    /**
     * запам'ятовування користувача
     * @param integer $userId <p>id користувача</p>
     */
    public static function auth($userId)
    {
        // записуємо ідентифікатор користувача в сесію
        $_SESSION['user'] = $userId;
    }

    /**
     * повертає ідентифікатор користувача, якщо він авторизований.<br/>
     * інакше перенаправляє на сторінку входу
     * @return string <p>індефікатор користувача</p>
     */
    public static function checkLogged()
    {
        // якщо сесія є то повертає ідентифікатор користувача
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        
        // інакше перенаправляє на сторінку входу
        header("Location:".MyDomain."/user/login");
    }

    /**
     * перевіряє чи є користувач гостем
     * @return boolean <p>результат виконання методу</p>
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * перевіряє чи ім'я не менше 2-х символів
     * @param string $name <p>ім'я</p>
     * @return boolean <p>результат виконання методу</p>
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * перевіряє чи телефон не менше 10 символів
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    /**
     * перевіряє чи строка не менше 6 - символів
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * перевіряє email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * перевіряє чи зайнятий email іншим користувачем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>результат виконання методу</p>
     */
    public static function checkEmailExists($email)
    {
        // конект з БД        
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        // отримання і повернення результату
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * повертає користувача з вказаним id
     * @param integer $id <p>id користувача</p>
     * @return array <p>масив з інформацією про користувача</p>
     */
    public static function getUserById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM user WHERE id = :id';

        // отримання і повернення результату
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // вказуємо, що результат має бути у вигляді масиву
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

}
