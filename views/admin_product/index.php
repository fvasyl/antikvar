<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo MyDomain;?>/admin">Адмінпанель</a></li>
                    <li class="active">Управління товарами</li>
                </ol>
            </div>

            <a href="<?php echo MyDomain;?>/admin/product/create" class="btn btn-default back">
                <i class="fa fa-plus"></i>
                Додати товар</a>
            
            <h4>Список товарів</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID товару</th>
                    <th>Артикул</th>
                    <th>Назва товару</th>
                    <th>Ціна (грн)</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['code']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>  
                        <td><a href="<?php echo MyDomain;?>/admin/product/update/<?php echo $product['id']; ?>" title="Редагувати"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="<?php echo MyDomain;?>/admin/product/delete/<?php echo $product['id']; ?>" title="Видалити"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

