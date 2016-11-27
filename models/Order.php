<?php

/**
 * Клас Order - модель для роботи із замовленнями
 */
class Order
{

    /**
     * збереження замовлення 
     * @param string $userName <p>ім я</p>
     * @param string $userPhone <p>Телефон</p>
     * @param string $userComment <p>Коментарій</p>
     * @param integer $userId <p>id користувача</p>
     * @param array $products <p>Масив з товарами</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
                . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

        $products = json_encode($products);

        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * повертає список замовлень
     * @return array <p>Список замовлень</p>
     */
    public static function getOrdersList()
    {
        // конект з БД
        $db = Db::getConnection();

        // отримання і повернення результату
        $result = $db->query('SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }
        return $ordersList;
    }

    /**
     * повертає текстове пояснення статусу для замовлення
     * @param integer $status <p>Статус</p>
     * @return string <p>Текстовое пояснення</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Нове замовлення';
                break;
            case '2':
                return 'Обробляється';
                break;
            case '3':
                return 'Доставляється';
                break;
            case '4':
                return 'Закрите';
                break;
        }
    }

    /**
     * повертає замовлення з вказаним id 
     * @param integer $id <p>id</p>
     * @return array <p>Массив з інформацією про замовлення</p>
     */
    public static function getOrderById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM product_order WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // вказуємо, що результат має бути масивом
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // виконуємо запит
        $result->execute();

        // повертаємо результат
        return $result->fetch();
    }

    /**
     * видаляє замовлення з вказаним id
     * @param integer $id <p>id замовлення</p>
     * @return boolean <p>результат виконання методу</p>
     */
    public static function deleteOrderById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'DELETE FROM product_order WHERE id = :id';

        // отримання та повернення результатів(виконується підготовчий запит)
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редагування замовлення із вказаним id
     * @param integer $id <p>id товару</p>
     * @param string $userName <p>ім'я клієнта</p>
     * @param string $userPhone <p>Телефон клієнта</p>
     * @param string $userComment <p>Коментарій клієнта</p>
     * @param string $date <p>Дата оформлення</p>
     * @param integer $status <p>Статус <i>(включено "1", виключено "0")</i></p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = "UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status 
            WHERE id = :id";

        // отримання та повернення результатів (використовується пвдготовчий запит)
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

}
