<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h3>Кабінет користувача</h3>
            
            <h4>Привіт, <?php echo $user['name'];?>!</h4>
            <ul>
                <li><a href="<?php echo MyDomain;?>/cabinet/edit">Редагувати дані</a></li>
                <!--<li><a href="/cabinet/history">Список покупок</a></li>-->
            </ul>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>