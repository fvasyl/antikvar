<?php

/**
 * Контроллер AdminCategoryController
 * управління категоріями товарів в адмінпанелі
 */
class AdminCategoryController extends AdminBase
{

    /**
     * Action для сторінки "Управління категоріями"
     */
    public function actionIndex()
    {
        // перевірка доступу
        self::checkAdmin();

        // получаємо список категорій
        $categoriesList = Category::getCategoriesListAdmin();

        // підключаємо вид
        require_once(ROOT . '/views/admin_category/index.php');
        return true;
    }

    /**
     * Action для сторінки "Додати категорію"
     */
    public function actionCreate()
    {
        // перевірка доступу
        self::checkAdmin();

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форма було відправлено
            // отримуємо дані із форми
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // індикатор помилок у формі
            $errors = false;

            // проста валідація (не порожньо)
            if (!isset($name) || empty($name)) {
                $errors[] = 'Будь ласка заповніть поля';
            }


            if ($errors == false) {
                // якщо помилок немає
                // додаємо мову категорію
                Category::createCategory($name, $sortOrder, $status);

                // перенаправляємо користувача на сторінку управління категоріями
                header("Location: ".MyDomain."/admin/category");
            }
        }

        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }

    /**
     * Action для сторінки "Редагувати категорію"
     */
    public function actionUpdate($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // одержання інформації про конкретну категорію
        $category = Category::getCategoryById($id);

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено  
            // отримуємо дані з форми
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // зберігаємо зміни
            Category::updateCategoryById($id, $name, $sortOrder, $status);

            // перенаправляємо користувача на сторінку управління категоріями
            header("Location: ".MyDomain."/admin/category");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }

    /**
     * Action для сторінки "Видалити категорію"
     */
    public function actionDelete($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено
            // видаляємо категорію
            Category::deleteCategoryById($id);

            // пернаправляємо користувача на сторінку управління категоріями
            header("Location: ".MyDomain."/admin/category");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_category/delete.php');
        return true;
    }

}
