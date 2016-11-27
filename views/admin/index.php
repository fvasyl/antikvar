<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">
            
            <br/>
            
            <h4>Доброго дня, адміністратор!</h4>
            
            <br/>
            
            <p>Вам доступні такі операції:</p>
            
            <br/>
            
            <ul>
                <li><a href="<?php echo MyDomain;?>/admin/product">Управління товарами</a></li>
                <li><a href="<?php echo MyDomain;?>/admin/category">Управління категоріями</a></li>
                <li><a href="<?php echo MyDomain;?>/admin/order">Управління замовленнями</a></li>
            </ul>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

