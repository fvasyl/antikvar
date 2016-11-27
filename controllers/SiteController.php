<?php

/**
 * Контроллер SiteController
 */
class SiteController
{

    /**
     * Action для головної сторінки
     */
    public function actionIndex()
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // список остайніх 6-товарів
        $latestProducts = Product::getLatestProducts(6);

        // список товарів для слайдера
        $sliderProducts = Product::getRecommendedProducts();

        // підключаємо вид
        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    /**
     * Action для сторінки "Контакти"
     */
    public function actionContact()
    {

        // змінні для форми
        $userEmail = false;
        $userText = false;
        $result = false;

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено 
            // отримуємо дані із форми
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            // індекатор помилок
            $errors = false;

            // валідація полів
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправельний email';
            }

            if ($errors == false) {
                // якщо помилок немає
                // відправляємо листа адміністратору 
                $adminEmail = 'fat_lover@gmail.com';
                $message = "Повідомлення: {$userText}. Від {$userEmail}";
                $subject = 'Тема повідомлення';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }

        // підключаємо вид
        require_once(ROOT . '/views/site/contact.php');
        return true;
    }
    
    /**
     * Action для сторінки "Про магазин"
     */
    public function actionAbout()
    {
        // підключаємо вид
        require_once(ROOT . '/views/site/about.php');
        return true;
    }

}
