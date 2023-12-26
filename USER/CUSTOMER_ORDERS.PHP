<?php
require("USER_MENU.PHP");
if(isset($_SESSION['login'])){
    $all_orders=$object_CRUD->getRecord('orders','sku','user_id',$_SESSION['login']);
}else{
    header('location: LOGIN.PHP');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMERS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <section class="p-10 ">
        <h1 class="text-5xl sm:text-2xl sm:font-bold">My Orders</h1>

        <ol class="list-decimal grid grid-cols-3 gap-10">
            <?php 
            
            if(isset($all_orders)):
            foreach ($all_orders as $key => $value):  
                // $object_CRUD->getJoinOrders('orders','books','books_price','sku','sku',$value['sku']);
                $emails=$object_CRUD->getRecord('user_registration','email','id',$_SESSION['login']); 
                $object_CRUD->getAllFields('orders','user_id',$_SESSION['login']);
                             
                ?>

                <li class="bg-gray-100 border mt-7 rounded-xl p-6 flex gap-10">
                    <div class="h-28 w-28 border">
                        <?=
                            '<img src="../Admin/BOOKS_IMAGES/' . $object_CRUD->record['book_cover_image'] . '" alt=""
                                class="h-full w-full object-fit">'
                            ?>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="space-y-3 w-full">
                            <div class="flex justify-between items-center">
                                <div class="flex gap-2 items-center">
                                    <h2 class="font-bold text-2xl"><?= $object_CRUD->record['customer_name']; ?></h2>
                                    <h3 class="text-sm">#<?= $object_CRUD->record['order_id']; ?></h3>
                                    <p>(Rs. <?= $object_CRUD->record['payment']; ?>)</p>
                                </div>
                                <div class="space-x-3 flex flex-col items-center">
                                    <a href="tel:<?php $object_CRUD->record['customer_phone']; ?>"
                                        class="underline"><?= $object_CRUD->record['customer_phone']; ?></a>
                                        <?php foreach($emails as $key => $values):?>
                                    <a href="mailto:<?php $emails[0]['email'] ?>"
                                        class="underline"><?= $values['email']; ?></a>  
                                        <?php  endforeach;?> 
                                    <p>Payment: <?= $object_CRUD->record['payment']?></p>                                      
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <ul class="font-semi-bold text-lg">
                                    <li><b>Quantity: </b> 1</li>
                                    <li><b>Title: </b><?=$object_CRUD->record['book_title']; ?></li>
                                    <li><b>Author: </b><?=$object_CRUD->record['book_author']; ?></li>
                                    <li><b>Order Date: </b><?= $object_CRUD->record['order_date']; ?></li>
                                    <li><b>Return Date: </b><?= $object_CRUD->record['return_date']; ?></li>
                                    <li><b>Address: </b><?= $object_CRUD->record['customer_address']; ?></li>
                                </ul>
                                
                            </div>
                        </div>


                    </div>


                </li>
            <?php endforeach; ?>
            <?php else: echo"NO orders yet"; ?>
            <?php endif; ?>
        </ol>

    </section>
</body>

</html>