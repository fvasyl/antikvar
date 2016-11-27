<?php

/**
 * Контроллер AdminController
 * головна сторінка у адмінпанелі
 */
class AdminController extends AdminBase
{
    /**
     * Action для стартової сторінки "Панель адміністратора"
     */
    public function actionIndex()
    {
        // перевірка доступу
        self::checkAdmin();

        // підключаємо вид
        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

}
