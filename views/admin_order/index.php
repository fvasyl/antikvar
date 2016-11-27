<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>
                        
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo MyDomain;?>/admin">Адмінпанель</a></li>
                    <li class="active">Управління замовленнями</li>
                </ol>
            </div>

            <h4>Список замовлень</h4>

            <br/>

            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID замовлення</th>
                    <th>Ім&rsquo;я покупця</th>
                    <th>Телефон покупателя</th>
                    <th>Дата оформления</th>
                    <th>Статус</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($ordersList as $order): ?>
                    <tr>
                        <td>
                            <a href="<?php echo MyDomain;?>/admin/order/view/<?php echo $order['id']; ?>">
                                <?php echo $order['id']; ?>
                            </a>
                        </td>
                        <td><?php echo $order['user_name']; ?></td>
                        <td><?php echo $order['user_phone']; ?></td>
                        <td><?php echo $order['date']; ?></td>
                        <td><?php echo Order::getStatusText($order['status']); ?></td>    
                        <td><a href="<?php echo MyDomain;?>/admin/order/view/<?php echo $order['id']; ?>" title="Переглянути"><i class="fa fa-eye"></i></a></td>
                        <td><a href="<?php echo MyDomain;?>/admin/order/update/<?php echo $order['id']; ?>" title="Редагувати"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="<?php echo MyDomain;?>/admin/order/delete/<?php echo $order['id']; ?>" title="Видалити"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

