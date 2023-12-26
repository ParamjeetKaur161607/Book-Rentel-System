<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}
if (isset($_SESSION['login'])) {
    $CartList = $object_CRUD->getRecord('cart', 'sku', 'id', $_SESSION['login']);
    $ReturnList = $object_CRUD->getRecord('return_order', 'sku', 'user_id', $_SESSION['login']);
}
if (isset($_POST["returnDates"])) {
    $object_OrderValidationHandler->duration = $_POST["returnDates"];
    $isValid = true;
    $allUserIds = $object_CRUD->getAllRecords('validate_return_date', 'user_id');
    $allSKU = $object_CRUD->getAllRecords('validate_return_date', 'sku');
    foreach ($object_OrderValidationHandler->duration as $sku => $returnDate) {
        if (empty($returnDate)) {
            $object_OrderValidationHandler->error_duration = "Please select valid date for!";
            $isValid = false;
        }
        if ($returnDate < date("Y-m-d") && !empty($returnDate)) {
            $object_OrderValidationHandler->error_duration = "Please select valid date for!";
            $isValid = false;
        } else {
            if (!strlen($object_OrderValidationHandler->error_duration)) {
                if (in_array("$_SESSION[login]", $allUserIds) && in_array("$sku", $allSKU)) {
                    $object_CRUD->updateRecordWithConditions('validate_return_date', ['return_date' => $returnDate], 'user_id', "$_SESSION[login]", 'sku', $sku);
                    header('location: ORDER_DETAILS.PHP');

                } else {
                    $object_CRUD->insertRecord('validate_return_date', ["user_id" => "$_SESSION[login]", 'return_date' => $returnDate, 'sku' => $sku]);
                    header('location: ORDER_DETAILS.PHP');
                }
            }

        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Date</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <main>
        <section class="px-96 py-20">
            <ul class=" h-full border p-10 border-gray-200 rounded-md border-shadow">
                <form action="" method="post">
                    <?php
                    if (!empty($CartList)):
                        $subtotal = array();
                        echo '<h1 class="text-4xl font-bold pb-10 underline">Select Return Date...</h1>';

                        foreach ($CartList as $key => $value):
                            $object_CRUD->getJoinbook('books', 'books_price', 'sku', "$value[sku]");
                            ?>

                            <li class="flex items-start gap-5 border-b py-5 h-full justify-between">
                                <div class="h-28 w-20 border">
                                    <?=
                                        '<img src="../Admin/BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                                    class="h-full w-full object-fit">'
                                        ?>
                                </div>
                                <div class="h-full flex justify-between items-center">
                                    <h2>
                                        <?php echo $object_CRUD->row['title'] ?>
                                    </h2>
                                    <h3>
                                        (
                                        <?php echo $object_CRUD->row['author'] ?>)
                                    </h3>

                                </div>
                                <div class="flex flex-col justify-end">
                                    <?php
                                    echo "<label for='returnDates[$value[sku]]'>Return Date:</label>";
                                    echo "<input type='date' value='returnDates[$value[sku]]' name='returnDates[$value[sku]]' \>";

                                    echo "<br>";
                                    ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <button name="duration_date" class="bg-red-300 p-2 rounded-sm mt-10 w-full">Validate Date</button>
                        <p class="py-10 text-red-600">
                            <?php echo $object_OrderValidationHandler->error_duration; ?>
                        </p>
                    </form>
                <?php else: ?>
                    <?php echo "Your cart is empty now!"; ?>
                <?php endif; ?>

            </ul>
        </section>
    </main>
</body>

</html>