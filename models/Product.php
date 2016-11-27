<?php

/**
 * Клас Product - модель для роботи з товарами
 */
class Product
{

    // К-сть товарів що відображатимуться на сторінці
    const SHOW_BY_DEFAULT = 6;  // головна + категорії
    const SHOW_BY_DEFAULT_KATALOG = 9; // каталог

    /**
     * повертає масив остайніх товарів 
     * @param type $count [optional] <p>Кількість</p>
     * @param type $page [optional] <p>номер поточної сторінки</p>
     * @return array <p>Масив з товарами</p>
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" ORDER BY id DESC '
                . 'LIMIT :count';

        // використання підготовчого запиту
        $result = $db->prepare($sql);
        $result->bindParam(':count', $count, PDO::PARAM_INT);

        // вказуємо, що результат має бути масивом
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        // виконання запиту
        $result->execute();

        // отримання і повернення результатів
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /**
     * повертає список товарів у вказаній категорії
     * @param integer $categoryId <p>id категорії</p>
     * @param type $page [optional] <p>Номер строрінки</p>
     * @return array <p>Масив с товарами</p>
     */
    public static function getProductsListByCategory($categoryId, $page = 1)
    {
        $limit = Product::SHOW_BY_DEFAULT;
       // print_r($limit);
        // зміщення (для запиту)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
      //  print_r($page);

        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = 1 AND category_id = :category_id '
                . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';

        // використовується підготовчий запит
        $result = $db->prepare($sql);
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        // виконання запиту
        $result->execute();

        // отримання і повернення результатів
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        // print_r($products);
        return $products;
    }
    
    
    /**
     * Повертає список товарів для відображення із сторінками
     * @param type $page [optional] <p>Номер сторінки</p>
     * @return array <p>Масив з товарами</p>
     */
    public static function getProductsListByPage($page = 1)
    {
        $limit = Product::SHOW_BY_DEFAULT_KATALOG;
       // print_r($limit);
        // зміщення (для запиту)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT_KATALOG;
       // print_r($offset);

        // конект БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = 1 '
                . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';

        // використовується підготовчий запит
        $result = $db->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        // виконання запиту
        $result->execute();

        // отримання і повернення результату
        $i = 0;
        
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        //print_r($products);
        return $products;
    }

    /**
     * повертає товар з вказаним id
     * @param integer $id <p>id товару</p>
     * @return array <p>Масив з інформацією про товар</p>
     */
    public static function getProductById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT * FROM product WHERE id = :id';

        // використовується підготовчий запит
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // вказуємо, що результат має бути масивом
       $result->setFetchMode(PDO::FETCH_ASSOC);

        // виконання запиту
        $result->execute();

        // отримання і повернення результатів
        return $result->fetch();
    }

    /**
     * повертає к-сть товарів з вказаної категорії
     * @param integer $categoryId <p>id товару</p>
     * @return integer <p>к-сть товарів</p>
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT count(id) AS count FROM product WHERE status="1" AND category_id = :category_id';

        // використовується підготовчий запит
        $result = $db->prepare($sql);
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        // виконання запиту
        $result->execute();

        // повертаємо count - к-сть
        $row = $result->fetch();
        return $row['count'];
    }

    
    /**
     * Повертаємо кількість активних товарів з БД
     * @param integer $categoryId <p>id категорії</p>
     * @return integer  <p>к-сть товарів</p
     */
    public static function getTotalProducts()
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'SELECT count(id) AS count FROM product WHERE status="1"';

        // використовується підготовчий запит
        $result = $db->prepare($sql);
        //$result->bindParam(PDO::FETCH_ASSOC);

        // виконання запиту
        $result->execute();

        // повертає count - к-сть
        $row = $result->fetch();
        return $row['count'];
    }
    
    /**
     * повертає список товарів з вказаними ідентифікаторами
     * @param array $idsArray <p>Масив з ідентифікаторами</p>
     * @return array <p>Масив з списком товарів</p>
     */
    public static function getProdustsByIds($idsArray)
    {
        // конект з БД
        $db = Db::getConnection();

        // перетворємо масив врядок для формування умови в запиті
        $idsString = implode(',', $idsArray);

        // Текст запиту до БД
        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);

        // вказуємо, що результат має бути масивом
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // отримання і повернення результатів
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    /**
     * повертає список рекомендованих товарів
     * @return array <p>Масив з товарами</p>
     */
    public static function getRecommendedProducts()
    {
        // конект з БД
        $db = Db::getConnection();

        // текст запиту до БД, отримання і повернення результатів
        $result = $db->query('SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" AND is_recommended = "1" '
                . 'ORDER BY id DESC');
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /**
     * повертає список товарів
     * @return array <p>Масив з товарами</p>
     */
    public static function getProductsList()
    {
        // конект з БД
        $db = Db::getConnection();

        // текст запиту до БД, отримання і повернення результатів
        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $i++;
        }
        return $productsList;
    }

    /**
     * видаляє товар з вказаним id
     * @param integer $id <p>id товару</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function deleteProductById($id)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'DELETE FROM product WHERE id = :id';

        // отримання і повернення результатів. використовується підготовчий запит
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редагування товару із заданим id
     * @param integer $id <p>id товару</p>
     * @param array $options <p>Масив з інформацією про товар</p>
     * @return boolean <p>Результат виконання запиту</p>
     */
    public static function updateProductById($id, $options)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = "UPDATE product
            SET 
                name = :name, 
                code = :code, 
                price = :price, 
                category_id = :category_id, 
                country = :country, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status
            WHERE id = :id";

        // отримання і повернення результатів, використовується підготовчий запит 
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':country', $options['country'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * додавання нового товару
     * @param array $options <p>Масив з інформацією про товар</p>
     * @return integer <p>id добавленого в таблицю запису</p>
     */
    public static function createProduct($options)
    {
        // конект з БД
        $db = Db::getConnection();

        // Текст запиту до БД
        $sql = 'INSERT INTO product '
                . '(name, code, price, category_id, country, availability,'
                . 'description, is_new, is_recommended, status)'
                . 'VALUES '
                . '(:name, :code, :price, :category_id, :country, :availability,'
                . ':description, :is_new, :is_recommended, :status)';

        // отримання і повернення результатів
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':country', $options['country'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // якщо запит виконано успішно, повертаємо id добавленого запису
            return $db->lastInsertId();
        }
        // інакше повертаємо 0
        return 0;
    }

    /**
     * повертає текстове пояснення значення статусу
     * @param integer $availability <p>Статус</p>
     * @return string <p>Текстовое пояснення</p>
     */
    public static function getAvailabilityText($availability)
    {
        switch ($availability) {
            case '1':
                return 'Є в наявності';
                break;
            case '0':
                return 'Для замовлення';
                break;
        }
    }

    /**
     * повертає шлях до зображення
     * @param integer $id <p>ідентифікатор зображення</p>
     * @return string <p>шлях до зображення</p>
     */
    public static function getImage($id)
    {
        // альтернативне зображення
        $noImage = 'no-image.jpg';

        // шлях до папки з зображеннями
        $path = '/site_1/upload/images/products/';

        // шлях до зображення товару
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // якщо зображення для товару існує
            // повертає шлях зображення товару
            return $pathToProductImage;
        }

        // повертаємо шлях альтернативного зображення
        return $path . $noImage;
    }

}
