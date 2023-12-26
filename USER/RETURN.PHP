<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}
$sku = $object_CRUD->getRecord('return_order', 'sku', 'user_id', $_SESSION['login']);

if (isset($_POST['return'])) {
    $fine = $object_CRUD->getRecord('orders', 'Fine', 'sku', $_GET['id']);
    if ($fine[0]["Fine"] == 0) {
        $object_CRUD->deleteRow('return_order', 'sku', "$_GET[id]", 'user_id', $_SESSION['login']);
        if (!empty($_POST['review'])) {
            $object_CRUD->updateRecord('orders', ['review' => "$_POST[review]"], 'sku', "$_GET[id]");
        }
        $object_CRUD->UpdateQuantity('+', "$_GET[id]");
        header('location: RETURN.PHP');
    } else {
        $object_OrderValidationHandler->is_card_number_valid();
        $object_OrderValidationHandler->is_name_on_card_valid();
        $object_OrderValidationHandler->is_cvv_valid();
        $object_OrderValidationHandler->is_expiry_date_valid();

        $errorVariables = [
            $object_OrderValidationHandler->error_card_number,
            $object_OrderValidationHandler->error_name_on_card,
            $object_OrderValidationHandler->error_cvv,
            $object_OrderValidationHandler->error_card_expiry_month,
            $object_OrderValidationHandler->error_card_expiry_year,
        ];
        if ($object_OrderValidationHandler->is_array_empty($errorVariables)) {
            $object_CRUD->deleteRow('return_order', 'sku', "$_GET[id]", 'user_id', $_SESSION['login']);
            if (!empty($_POST['review'])) {
                $object_CRUD->updateRecord('orders', ['review' => "$_POST[review]"], 'sku', "$_GET[id]");
            }
            $object_CRUD->UpdateQuantity('+', "$_GET[id]");
            header('location: RETURN.PHP');
        }
    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Returns</title>
</head>

<body>
    <main class="p-20">
    <h1 class="text-3xl font-bold">Returns..</h1>
        <ul class="grid grid-cols-3 gap-20 mt-5">
            
            <?php
            if ($sku !== null && (is_array($sku) || is_object($sku))):
                foreach ($sku as $key => $value):
                    $object_CRUD->getJoinOrders('books', 'orders', 'return_order', 'sku', 'sku', "$value[sku]");
                    ?>
                    <li class="border bg-gray-200 p-5 w-full space-y-10">
                        <div class="flex items-center justify-between">
                            <div class="h-28 w-24 border">
                                <?=
                                    '<img src="../Admin/BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                        class="h-full w-full object-fit">'
                                    ?>
                            </div>
                            <div>
                                <p>
                                    <?php echo "<b>Order Date:</b> " . $object_CRUD->row['order_id']; ?>
                                </p>
                                <p>
                                    <?php echo "<b>Book:</b> " . $object_CRUD->row['title']; ?> (
                                    <?= $object_CRUD->row['author']; ?> )
                                </p>
                                <p>
                                    <?php echo "<b>Order Date:</b> " . $object_CRUD->row['order_date']; ?>
                                </p>
                                <p>
                                    <?php echo "<b>Return Date:</b> " . $object_CRUD->row['return_date']; ?>
                                </p>
                                <div class="flex gap-2">                                 
                                    <b>Fine Rs.
                                        <?php $days=$object_OrderValidationHandler->getTotalDays($object_CRUD->row['return_date'],date('Y-m-d'));                                        
                                        ?>
                                        <span class="bg-red-300 px-2 text-sm"><?php echo $object_CRUD->row['Fine']; ?></span> /<?=$days?>days late
                                    </b>
                                </div>
                            </div>
                            
                        </div>
                        <form action="RETURN.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" method="post"
                            class="space-y-5">
                            <?php if(!empty($sku['Fine'])):?>
                            <div class="flex flex-col">
                                <label for="card_number">Credit/Debit Card Number</label>
                                <input type="text" name="card_number" id="card_number"
                                    class="outline-none border-b border-gray-400 bg-gray-200 text-gray-500"
                                    value="<?php echo $object_OrderValidationHandler->card_number ?>">
                                <span class="text-red-500 text-sm">
                                    <?php echo $object_OrderValidationHandler->error_card_number; ?>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <label for="name_on_card">Name on Credit/Debit Card</label>
                                <input type="text" name="name_on_card" id="name_on_card"
                                    class="outline-none border-b border-gray-400 bg-gray-200 text-gray-500"
                                    value="<?php echo $object_OrderValidationHandler->name_on_card ?>">
                                <span class="text-red-500 text-sm">
                                    <?php echo $object_OrderValidationHandler->error_name_on_card; ?>
                                </span>
                            </div>

                            <div class="flex flex-col ">
                                <label for="cvv">CVV</label>
                                <input type="password" name="cvv" id="cvv"
                                    class="outline-none border-b border-gray-400 bg-gray-200 text-gray-500"
                                    value="<?php echo $object_OrderValidationHandler->cvv ?>">
                                <span class="text-red-500 text-sm">
                                    <?php echo $object_OrderValidationHandler->error_cvv; ?>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <label for="month">Card Expiry Month</label>
                                <input type="number" name="month" id="month"
                                    class="outline-none border-b border-gray-400 bg-gray-200 text-gray-500"
                                    value="<?php echo $object_OrderValidationHandler->card_expiry_month ?>">
                                <span class="text-red-500 text-sm">
                                    <?php echo $object_OrderValidationHandler->error_card_expiry_month; ?>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <label for="year">Card Expiry Year</label>
                                <input type="number" name="year" id="year"
                                    class="outline-none border-b border-gray-400 bg-gray-200 text-gray-500"
                                    value="<?php echo $object_OrderValidationHandler->card_expiry_year ?>">
                                <span class="text-red-500 text-sm">
                                    <?php echo $object_OrderValidationHandler->error_card_expiry_year; ?>
                                </span>
                            </div>
                            <?php endif;?>
                            <div class="flex flex-col">
                                <label for="review" class="">Review</label>
                                <textarea name="review" id="review" cols="30" rows="2"
                                    class="border outline-none text-gray-500"></textarea>
                            </div>
                            
                            <button name="return" class="bg-blue-800 text-white px-3 py-1 rounded-md w-full">Return</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <?php echo "Your cart is empty now!"; ?>
            <?php endif; ?>
        </ul>
    </main>
</body>

</html>