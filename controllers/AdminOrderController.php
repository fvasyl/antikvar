<?php

/**
 * Контроллер AdminOrderController
 * управління замовленнями в адмінпанелі
 */
class AdminOrderController extends AdminBase
{

    /**
     * Action для сторінки "Управління замовленнями"
     */
    public function actionIndex()
    {
        // первірка доступу
        self::checkAdmin();

        // отримуємо список замовлень
        $ordersList = Order::getOrdersList();

        // підключаємо вид
        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /**
     * Action для сторінки "Редагування замовлень"
     */
    public function actionUpdate($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // отримуємо дані про конкретне замовлення
        $order = Order::getOrderById($id);

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було вівправлено   
            // отримуємо дані із форми
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            // зберігаємо зміни
            Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);

            // перенаправляємо користувача на сторінку управління замовленнями
            header("Location: ".MyDomain."/admin/order/view/$id");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }

    /**
     * Action для сторінки "Перегляд замовлення"
     */
    public function actionView($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // отримуємо дані про конкретне замовлення
        $order = Order::getOrderById($id);

        // отримуємо масив з ідентифікаторами і кількістю товарів
        $productsQuantity = json_decode($order['products'], true);

        // отримуємо масив з ідентифікаторами товарів
        $productsIds = array_keys($productsQuantity);

        // отримуємо список товарів в замовленню
        $products = Product::getProdustsByIds($productsIds);

        // підключаємо вид
        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }

    /**
     * Action для сторінки "Видалити замовлення"
     */
    public function actionDelete($id)
    {
        // перевірка доступу
        self::checkAdmin();

        // обробка форми
        if (isset($_POST['submit'])) {
            // якщо форму було відправлено
            // видаляємо замовлення
            Order::deleteOrderById($id);

            //перенаправляємо користувача на сторінку управління замовленнями
            header("Location: ".MyDomain."/admin/order");
        }

        // підключаємо вид
        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }

}
