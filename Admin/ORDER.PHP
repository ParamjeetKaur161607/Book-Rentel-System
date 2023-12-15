<?php
require("ADMIN_PANEL.PHP");
$object_database->all_orders();
// echo "<pre>";
// print_r($object_database->all_orders);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMERS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
    <section class="p-10 ml-80">
        <h1 class="text-5xl sm:text-2xl sm:font-bold">All Orders and Customers</h1>

        <ol class="list-decimal">
            <?php 
            if(isset($object_database->all_orders)):
            foreach ($object_database->all_orders as $key => $value):                
                $object_database->view_book_data($value['book_sku']);
                ?>

                <li class="bg-white mt-7 rounded-xl p-6 flex gap-10">
                    <div class="h-28 w-28 border">
                        <?=
                            '<img src="BOOKS_IMAGES/' . $object_database->row['book_image'] . '" alt=""
                                class="h-full w-full object-fit">'
                            ?>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="space-y-3 w-full">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="font-bold text-2xl"><?= $value['customer_name']; ?></h2>
                                    <div class="flex gap-1 items-center">
                                        <h3>#<?= $value['order_id']; ?></h3>
                                        <p>(Rs. <?= $value['order_id']; ?>)</p>
                                    </div>
                                </div>
                                <div class="space-x-3">
                                    <a href="tel:<?php $value['customer_phone']; ?>"
                                        class="underline"><?= $value['customer_phone']; ?></a>
                                    <a href="mailto:<?php $value['customer_email']; ?>"
                                        class="underline"><?= $value['customer_email']; ?></a>
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <ul class="font-semi-bold text-lg">
                                    <li>Qty: 1</li>
                                    <li><?= $value['book_sku']; ?></li>

                                </ul>
                                <ul>
                                    <li>Order Date: <?= $value['order_date']; ?></li>
                                    <li>Return Date: <?= $value['return_date']; ?></li>
                                </ul>
                                <ul>
                                    <li><?= $value['customer_address']; ?></li>
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