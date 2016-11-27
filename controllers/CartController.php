<?php

/**
 * Контроллер CartController
 * Корзина
 */

class CartController
{

    /**
     * Action для довавання товару в корзину синхронізованим способом
     * @param integer $id <p>id товара</p>
     
    public function actionAdd($id)
    {
        // додаємо товар у корзину
        Cart::addProduct($id);

        // повертаємо користувача на чторінку звідки він прийшов
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }*/

    /**
     * Action для додавання товару в корзину за допомогою асинхронного запиту (ajax)
     * @param integer $id <p>id товара</p>
     */
    public function actionAddAjax($id)
    {
        // додаємо товар в корзину і висвітлюємо результат: к-сть товарів у кошику
        echo Cart::addProduct($id);
        return true;
    }
    
    /**
     * Action для видалення товару з корзини синхронним запитом
     * @param integer $id <p>id товару</p>
     */
    public function actionDelete($id)
    {
        // видаляємо товар з корзини
        Cart::deleteProduct($id);

        // направляємо користувача до корзини
        header("Location:".MyDomain."/cart");
    }

    /**
     * Action для сторінки "Корзина"
     */
    public function actionIndex()
    {
        // список категорій меню (зліва)
        $categories = Category::getCategoriesList();
        
        // отримуємо ідентифікатори і к-сть товарів у корзині
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // якщо у корзині є товари, отримуємо всю інформацію для списку
            // отримуємо масив ідентифікаторів товарів
            $productsIds = array_keys($productsInCart);

            //  отримуємо всю інформацію про товари для списку
            $products = Product::getProdustsByIds($productsIds);

            // отримуємо загальну вартість товарів у корзині
            $totalPrice = Cart::getTotalPrice($products);
        }

        // підключаємо вид
        require_once(ROOT . '/views/cart/index.php');
        return true;
    }

    /**
     * Action для сторінки "Оформлення покупки"
     */
    public function actionCheckout()
    {
        // отримуємо дані із корзини    
        $productsInCart = Cart::getProducts();

        // якщо товарів нема, перенаправляємо користувача на хомяка
        if ($productsInCart == false) {
            header("Location: ".MyDomain);
        }

        // список категорій (зліва)
        $categories = Category::getCategoriesList();

        // знаходимо загальну вартість
        $productsIds = array_keys($productsInCart);
        $products = Product::getProdustsByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);

        // к-сть товарів
        $totalQuantity = Cart::countItems();

        // поля для форми
        $userName = false;
        $userPhone = false;
        $userComment = false;

        // статус успішнього виконання
        $result = false;

        // превіряємо чи користувач є гостем
        if (!User::isGuest()) {
            // якщо користувач не є гостем
            // получаємо про нього інформацію з БД
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {
            // якщо користувавч - гість то очищуємо форми
            $userId = false;
        }

        // робота із формою
        if (isset($_POST['submit'])) {
            // якщо форму відправлено
            // отримуємо із неї дані
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // індикатор помилки
            $errors = false;

            // валідація полів
            if (!User::checkName($userName)) {
                $errors[] = 'Неправельне ім&rsquo;я';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправельний телефон';
            }


            if ($errors == false) {
                // якщо нема помилок
                // зберігаємо замовлення у базі даних
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // якщо замовлення успішно збережено у БД 
                    // сповіщуємо адміністратора по імейлу                
                    $adminEmail = 'fat_lover@gmail.com';
                    $message = '<a href="http://digital-mafia.net/admin/orders">Список замовлень</a>';
                    $subject = 'нове замовлення!';
                    mail($adminEmail, $subject, $message);

                    // очищуємо корзину
                    Cart::clear();
                }
            }
        }

        // Підключаємо вид
        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }

}
