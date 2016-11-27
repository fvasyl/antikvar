<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo MyDomain;?>/admin">Адмінпанель</a></li>
                    <li><a href="<?php echo MyDomain;?>/admin/product">Управління товарами</a></li>
                    <li class="active">Видалити товар</li>
                </ol>
            </div>


            <h4>Видалити товар #<?php echo $id; ?></h4>


            <p>Ви дійсно хочете видалити цей товар?</p>

            <form method="post">
                <input type="submit" name="submit" value="Видалити" />
            </form>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

