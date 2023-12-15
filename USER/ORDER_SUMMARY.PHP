<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}

if (isset($_POST['place-order'])) {
    $object_database->delete_from_cart($_SESSION['login']);
    header('location:PAYMENT.PHP');
}
$object_database->orders($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER SUMMARY</title>
</head>

<body>
    <main class="px-96 py-40">
        <div class="bg-gray-300 p-10 col-span-3 space-y-5">
            <h2 class="font-bold text-2xl px-10 pb-5 text-center underline">Order Summary</h2>
            <ul class="flex justify-between w-full">
                <li><b><?=$object_database->row1['customer_email'];?></b></li>
                <li><b><?=$object_database->row1['customer_phone'];?></li>
                <li><?=$object_database->row1['customer_address'];?></b></li>
                <li><?="<b>order Date:</b> ".$object_database->row1['order_date'];?></li>
                <li><?="<b>Return Date:</b> ".$object_database->row1['return_date'];?></li>
            </ul>
            <?php
            $object_database->user_cart();
            foreach ($object_database->all_sku as $item):
                $object_database->view_book_data($item['book_sku']); ?>
                
                <div>
                <div class="space-y-5 border-b">
                    <div class="flex justify-between py-2 border-b border-gray-300 items-center">
                    <div class="h-28 w-24 border">
                        <?=
                        '<img src="../Admin/BOOKS_IMAGES/'.$object_database->row['book_image'].'" alt=""
                        class="h-full w-full object-fit">'
                        ?>                        
                    </div>
                        <span>
                            <?php echo $object_database->row['book_title']; ?>
                        </span>
                        <span>
                            <?php    
                            $date1 = new DateTime($object_database->row1['order_date']);
                            $date2 = new DateTime($object_database->row1['return_date']);
                            $interval = $date1->diff($date2);
                            $daysDifference = $interval->days;                    
                            switch ($daysDifference) {
                                case $daysDifference <= 7:
                                    $price= $object_database->row['book_sale_price'];
                                    break;
                                case $daysDifference > 7 && $daysDifference <= 20:
                                    $price= $object_database->row['book_sale_price'] * 2;
                                    break;
                                case $daysDifference > 20 && $daysDifference <= 35:
                                    $price= $object_database->row['book_sale_price'] * 3;
                                    break;
                                case $daysDifference > 35 && $daysDifference <= 49:
                                    $price= $object_database->row['book_sale_price'] * 4;
                                    break;
                                case $daysDifference > 49 && $daysDifference <= 60:
                                    $price= $object_database->row['book_sale_price'] * 5;
                                    break;
                                default:                                    
                                    break;
                            }  
                            echo $price;
                            $total[]=$price;                         
                            ?>
                        </span>                        
                    </div>
                </div>
                <div class="flex justify-between py-5">
                    <b>Subtotal</b>
                    <strong><?= array_sum($total);?></strong>
                </div>
                </div>
            <?php endforeach; ?>

            <form action="" method="post" class="py-10 px-20">
                <button name="place-order" class="w-full py-2 px-10 bg-blue-900 rounded-md text-white">
                    Place Order</button>
            </form>
        </div>
    </main>
</body>

</html>