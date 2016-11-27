<?php

/**
 * Класс Cart
 * Компонент для работи з корзиною
 */
class Cart
{

    /**
     * Додавання товару в корзину (сесія)
     * @param int $id <p>id товару</p>
     * @return integer <p>К-сть товарів у корзині</p>
     */
    public static function addProduct($id)
    {
        // Переводимо $id до типу integer
        $id = intval($id);
        
        //пустий масив для товарів в козині
        $productsInCart = array();
        
        // якшо уже є товари у корзині (використовується сесія)
        if (isset($_SESSION['products'])) {
            // заповнюємо массив товарами
            $productsInCart = $_SESSION['products'];
        }

        // Проверяем есть ли уже такой товар в корзине
        // якшо товар з таким id є уже у корзині то:
        if (array_key_exists($id, $productsInCart)) {
            // збільшуємо к-сть на 1
            $productsInCart[$id] ++;
        } else {
            // нема, додаємо id, к-сть = 1
            $productsInCart[$id] = 1;
        }

        // записуємо масив у сесію
        $_SESSION['products'] = $productsInCart;

        // повертаємо к-сть товарів
        return self::countItems();
    }

    /**
     * підрахунок к-сті товарів у кошику (в сесії)
     * @return int <p>к-сть товарів у кошику</p>
     */
    public static function countItems()
    {
        // перевіряємо чи у корзині є якісь товари
        if (isset($_SESSION['products'])) {
            // якщо масив з товарами є
            // рахуємо і повертаємо їх к-сть
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            // якщо товарів нема повертаємо 0
            return 0;
        }
    }

    /**
     * повертає масив з індефікаторів і к-стями товарів у корзині
     * якщо товарів нема, то повертає false;
     * @return mixed: boolean or array
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * повертає загальну вартість переданих товарів
     * @param array $products <p>інформація про товари</p>
     * @return integer <p>загальна вартість</p>
     */
    public static function getTotalPrice($products)
    {
        // получаємо масив з індефікаторів і к-стями товарів у корзині
        $productsInCart = self::getProducts();
        
        // рахуємо загальну вартість
        $total = 0;
        if ($productsInCart) {
            // якщо корзина не порожня
            // проходимо по масиві товарів
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                // загальна вартість = ціна товару * к-сть товарів 
                // (результат додаєми до попередньої ітерації)
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * очищуємо корзину
     */
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * видаляємо товар із вказаним id з корзини
     * @param integer $id <p>id товару</p>
     */
    public static function deleteProduct($id)
    {
        // получаємо масив з індефікаторів і к-стями товарів у корзині
        $productsInCart = self::getProducts();

        // видаляємо товар із вказаним id з корзини
        unset($productsInCart[$id]);

        // записуємо масив у сесію 
        $_SESSION['products'] = $productsInCart;
    }

}
