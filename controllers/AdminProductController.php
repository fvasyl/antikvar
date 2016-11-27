<?php

/**
 * Контроллер AdminProductController
 * управління товарами в адмінпанелі
 */
class AdminProductController extends AdminBase
{

    /**
     * Action для сторінки "Управління товарами"
     */
    public function actionIndex()
    {
        // перевірка доступу
        self::checkAdmin();

        // отримуємо список товарів
        $productsList = Product::getProductsList();

        // підключаємо вид
        require_once(ROOT . '/views/admin_product/index.php');
        return true;
    }

    /**
     * Action для сторінки "Додати товар"
     */
    public function actionCreate()
    {
        // перевірка доступу
        self::checkAdmin();

        // отримуємо список категорій для випадаючого списку
        $categoriesList = Category::getCategoriesListAdmin();

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено
            // отримуємо дані із форми
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['country'] = $_POST['country'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // індикатор помилок у формі
            $errors = false;

            // валідація ( не порожньо)
            if (!isset($options['name']) || empty($options['name'])) {
                $errors[] = 'Будь ласка заповніть поля';
            }

            if ($errors == false) {
                // якщо помилок немає
                // додаємо новий товар
                $id = Product::createProduct($options);

                // якщо запис було додано
                if ($id) {
                    // первірка, чи було завантажено через форму зображення
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // якщо завантажувалось, переміщуємо його в потрібну папку з новим ім'ям
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/site_1/upload/images/products/{$id}.jpg");
                    }
                };

                // перенаправляємо користувача на сторінку управління товарами
                header("Location: ".MyDomain."/admin/product");
            }
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * Action для сторінки "Редагувати товар"
     */
    public function actionUpdate($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // отримуємо список категорій для випадаючого списку
        $categoriesList = Category::getCategoriesListAdmin();

        // отримуємо дані про конкретний товар
        $product = Product::getProductById($id);

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено
            // отримуємо дані з форми редагування, при необхідності можна валідувати значення
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['country'] = $_POST['country'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // зберігаємо зміни
            if (Product::updateProductById($id, $options)) {

                // якщо запис було збережено
                // превірка, чи було завантажено через форму зображення
               // print_r($_FILES["image"]); die();
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                   // print_r($_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");

                    // якщо завантажувалося, переміщуємо його в потрібну папку з потрібним ім'ям
                   move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/site_1/upload/images/products/{$id}.jpg");
                }
            }

            // перенаправлення користувача на сторінку управління товарами
            header("Location: ".MyDomain."/admin/product");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_product/update.php');
        return true;
    }

    /**
     * Action для сторінки "Видалити товар"
     */
    public function actionDelete($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено
            // видаляємо товар
            Product::deleteProductById($id);

            // перенаправляємо користувача на сторінку управління товарами
            header("Location: ".MyDomain."/admin/product");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_product/delete.php');
        return true;
    }

}
