<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo MyDomain;?>/admin">Адмінпанель</a></li>
                    <li><a href="<?php echo MyDomain;?>/admin/order">Управління замовленнями</a></li>
                    <li class="active">Видалити замовлення</li>
                </ol>
            </div>


            <h4>Видалити замовлення #<?php echo $id; ?></h4>


            <p>Ви дійсно хочете видалити замовлення?</p>

            <form method="post">
                <input type="submit" name="submit" value="Видалити" />
            </form>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

