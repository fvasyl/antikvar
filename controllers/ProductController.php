<?php

/**
 * Контроллер ProductController
 * Товар
 */
class ProductController
{

    /**
     * Action для сторінки перегляду товару
     * @param integer $productId <p>id товару</p>
     */
    public function actionView($productId)
    {
        // список категорій для лівого меню
        $categories = Category::getCategoriesList();

        // отримуємо інформацію про товар
        $product = Product::getProductById($productId);

        // підключаємо вид
        require_once(ROOT . '/views/product/view.php');
        return true;
    }

}
