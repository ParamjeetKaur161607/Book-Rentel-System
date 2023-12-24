<?php
include("USER_MENU.PHP");

if(isset($_SESSION['login'])){
    $CartList=$object_CRUD->getRecord('cart','sku','id',$_SESSION['login']);
    $ReturnList=$object_CRUD->getRecord('return_order','sku','user_id',$_SESSION['login']);
}

if (isset($_POST['add_to_cart'])) {
    $data = array(
        "id" => "$_SESSION[login]",
        "sku" => "$_GET[id]",
    );
    $found = false;
    foreach ($CartList as $key => $value) {

        if (in_array($_GET['id'], $value)) {
            $found = true;
            break;
        }
    }
    foreach ($ReturnList as $key => $value) {

        if (in_array($_GET['id'], $value)) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $object_CRUD->insertRecord('cart', $data);
        header('location: CART.PHP');
    } else {
        header('location: USER_ALERT.PHP');
    }
}

if (isset($_POST['delete_cart'])) {
    $object_CRUD->deleteRecord('cart', 'sku', "$_GET[id]");
    header("location: CART.PHP");
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <link rel="stylesheet" href="/dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <main>
        <section class="px-96 py-20">
            <ul class=" h-full border p-10 border-gray-200 rounded-md border-shadow">
                <?php
                if (!empty($CartList)):
                    $subtotal = array();
                    echo '<h1 class="text-4xl font-bold pb-10 underline">Your Cart</h1>';
                    foreach ($CartList as $key => $value):
                        $object_CRUD->getJoinbook('books', 'books_price', 'sku', "$value[sku]");
                        ?>

                        <li class="flex items-start gap-5 border-b py-5 h-full">
                            <div class="h-28 w-20 border">
                                <?=
                                    '<img src="../Admin/BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                                    class="h-full w-full object-fit">'
                                    ?>
                            </div>
                            <div class="w-full flex flex-col justify-between h-28">
                                <div class="flex justify-between h-full items-start">
                                    <div class="h-full flex flex-col justify-between">
                                        <div>
                                            <h2>                                                
                                                <?php echo $object_CRUD->row['title'] ?>
                                            </h2>
                                            <h3>
                                                (<?php echo $object_CRUD->row['author'] ?>)
                                            </h3>
                                        </div>
                                        <strong class="">Rs.
                                            <?php
                                            echo $object_CRUD->row['per_day_price']
                                                ?><span class="text-sm">/Per Day</span>
                                        </strong>
                                    </div>
                                    <div>
                                        <span>Quantity:
                                            <?php echo "1"; ?>
                                        </span>
                                    </div>
                                    <form action="CART.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" method="post">
                                        <button name="delete_cart" class="text-gray-400 hover:text-gray-500">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none">
                                                <path
                                                    d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4V4zm2 2h6V4H9v2zM6.074 8l.857 12H17.07l.857-12H6.074zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <form action="ORDER_DETAILS.PHP" method="post">
                        <button class="bg-blue-800 text-white mt-10 px-10 py-2 flex justify-center w-full">Next</button>
                    </form>
                <?php else: ?>
                    <?php echo "Your cart is empty now!"; ?>
                <?php endif; ?>

            </ul>
        </section>
    </main>
</body>

</html>