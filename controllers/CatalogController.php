<?php

/**
 * Контроллер CatalogController
 * Каталог товарів
 */
class CatalogController
{

    /**
     * Action для сторінки "Каталог товарів"
     */
    public function actionIndex($page = 1)
    {
        //$countProductInPage=9;
        // Список категорій для лівого меню
        $categories = Category::getCategoriesList();
        
        // к-сть товарів
        $total = Product::getTotalProducts();
       // print_r($total);

        // список товарів
        $latestProducts = Product::getProductsListByPage($page);
        //print_r($latestProducts);
        
         
        // створюємо об'єкт Pagination - для навігації із сторінками
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT_KATALOG, 'page-');

        // підключаємо вид
        require_once(ROOT . '/views/catalog/index.php');
        return true;
    }

    /**
     * Action для сторінки "Категорія товарів"
     */
    public function actionCategory($categoryId, $page = 1)
    {
        // список категорій для лівого меню
        $categories = Category::getCategoriesList();

        // список товарів в категорії
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        // загальна кількість товарів категорії
        $total = Product::getTotalProductsInCategory($categoryId);
        
        // створюємо об'єкт Pagination - для навігації із сторінками
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        // підключаємо вид
        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }

}
