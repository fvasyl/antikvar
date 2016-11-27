<?php

/**
 * Клас Category - модель для роботи із категоріями товарів
 */
class Category
{

    /**
     * повертає масив категорій для списку на сайті
     * @return array <p>масив з категоріями</p>
     */
    public static function getCategoriesList()
    {
        // конект з БД
        $db = Db::getConnection();

        // запит до БД
        $result = $db->query('SELECT id, name FROM category WHERE status = "1" ORDER BY sort_order, name ASC');

        // отримання і повернення результатів
        $i = 0;
        $categoryList = array();
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }
        return $categoryList;
    }

    /**
     * повертає масив категорій для списку в адмінпанелі
     * при цьому в результат попадають і включені і виключені категорії
     * @return array <p>Массив категорий</p>
     */
    public static function getCategoriesListAdmin()
    {
        // конект з БД
        $db = Db::getConnection();

        // запит до БД
        $result = $db->query('SELECT id, name, sort_order, status FROM category ORDER BY sort_order ASC');

        // отримання і повернення результатів
        $categoryList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoryList;
    }

    /**
     * видаленнч категорії з заданим id
     * @param integer $id
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function deleteCategoryById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // запит до БД
        $sql = 'DELETE FROM category WHERE id = :id';

        // отримання та повернення результатів
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редагування категорії із заданим id
     * @param integer $id <p>id категорії</p>
     * @param string $name <p>Назва</p>
     * @param integer $sortOrder <p>Порядковий номер</p>
     * @param integer $status <p>Статус <i>(включено "1", виключено "0")</i></p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function updateCategoryById($id, $name, $sortOrder, $status)
    {
        // конект з БД
        $db = Db::getConnection();

        // запит до БД
        $sql = "UPDATE category
            SET 
                name = :name, 
                sort_order = :sort_order, 
                status = :status
            WHERE id = :id";

        // отримання і повернення результатів
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * повертає категорію з вказаним id
     * @param integer $id <p>id категорії</p>
     * @return array <p>Масив з інформацією про категорію</p>
     */
    public static function getCategoryById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // запит до БД
        $sql = 'SELECT * FROM category WHERE id = :id';

        // підготовчий запит
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
     * повертає текстове значення статусу категорії
     * <i>0 - приховано, 1 - відображається</i>
     * @param integer $status <p>Статус</p>
     * @return string <p>Текстове пояснення</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Відображається';
                break;
            case '0':
                return 'Приховано';
                break;
        }
    }

    /**
     * додає нову категорію
     * @param string $name <p>Назва</p>
     * @param integer $sortOrder <p>Порядковий номер</p>
     * @param integer $status <p>Статус <i>(включено "1", виключено "0")</i></p>
     * @return boolean <p>Результат додавання запису у таблицю</p>
     */
    public static function createCategory($name, $sortOrder, $status)
    {
        // коннект з БД
        $db = Db::getConnection();

        // запит до БД
        $sql = 'INSERT INTO category (name, sort_order, status) '
                . 'VALUES (:name, :sort_order, :status)';

        // отримання і повернення результатів
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

}
