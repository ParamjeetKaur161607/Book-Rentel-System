<?php
require("ADMIN_PANEL.PHP");
$object_database->all_returns();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTED BOOKS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
    <section class="p-10 ml-80">
        <h1 class="text-5xl sm:text-2xl sm:font-bold">RENTED BOOKS</h1>
        <ol class="list-decimal">
            <?php if(isset($object_database->all_returns)):?>
            <?php foreach ($object_database->all_returns as $key => $value):
                $object_database->books_orders($value['book_sku']);
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
                                    <h2 class="font-bold text-2xl"><?=$object_database->row['book_sku'];?></h2>
                                    <div class="flex gap-1 items-center">
                                        <h3>#<?=$object_database->row['order_id'];?></h3>
                                        <p>(Rs.<?=$object_database->row['book_sale_price'];?>)</p>
                                    </div>
                                </div>
                                <div class="space-x-3">
                                    <a href="tel:<?$object_database->row['customer_phone'];?>" class="underline"><?=$object_database->row['customer_phone'];?></a>
                                    <a href="mailto:<?$object_database->row['customer_email'];?>" class="underline"><?=$object_database->row['customer_email'];?></a>
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <ul class="font-semi-bold text-lg flex justify-between w-full">
                                    <!-- <li><?=$object_database->row['customer_email'];?></li> -->
                                    <li>Book Title: <?=$object_database->row['book_title'];?></li>
                                    <li>Book Author: <?=$object_database->row['book_author'];?></li>
                                    <li>Order Date: <?=$object_database->row['order_date'];?></li>
                                    <li>Return Date: <?=$object_database->row['return_date'];?></li>
                                    <!-- <li>subtotal pending</li> -->
                                </ul>
                            </div>
                        </div>


                    </div>


                </li>
            <?php endforeach; ?>
            <?php else: ?>
                <?= "No return Pending"; ?>
                <?php endif; ?>

        </ol>

    </section>
</body>

</html>