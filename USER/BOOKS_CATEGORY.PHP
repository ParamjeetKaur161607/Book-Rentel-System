<?php include("USER_MENU.PHP");
$id=$_GET['book_category'];
$sku=$object_CRUD->getRecord('books','sku','category',$_GET['book_category']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
    <link rel="stylesheet" href="/dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <main class="space-y-10">

        <section class="px-20 space-y-10 pb-20 py-10">
            <div class="flex divide-x justify-center border-b shadow py-3">
            <?php $object_validation->category = $object_CRUD->getAllRecords('book_category', 'category');
                foreach ($object_validation->category as $key => $value):
                    if ($value == 'None') {
                        continue;
                    }
                    ?>
                    <form action="BOOKS_CATEGORY.PHP?book_category=<?php echo $value; ?>" method="post">
                        <button class="px-5 text-xl">
                            <?php
                            echo $value; ?>
                        </button>
                    </form>
                <?php endforeach; ?>
            </div>
            <ul class="grid grid-cols-5 gap-20">
            <?php
            if (isset($sku) or empty($sku)):
                foreach ($sku as $key => $value): 
                $object_CRUD->getJoinbook('books','books_price','sku', $value['sku']);
                ?>
                    <li class="w-full h-full">
                        <div class="rounded-md h-fit ">
                            <div
                                class="border bg-yellow-900/5 border-gray-300 p-4 text-center space-y-2 h-full peer relative rounded-lg">
                                <div class="w-full h-64">
                                    <?=
                                        '<img src="../admin/BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                            class="h-full border border-gray-300 w-full object-fit">'
                                        ?>
                                </div>
                                <h2 class="font-bold text-lg">
                                    <?= $object_CRUD->row['title']; ?>
                                </h2>
                                <h3 class="text-sm text-gray-500">
                                    <?= $object_CRUD->row['author']; ?>
                                </h3>
                                <p class="text-xl font-bold">
                                    <?= $object_CRUD->row['per_day_price']; ?>/-
                                </p>
                                <form action="CART.PHP" method="post">
                                    <button name="add_to_cart" class="bg-yellow-900/60 text-white py-1 px-3 rounded-lg">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="flex items-center justify-center p-28 itelic text-gray-400">
                    <?= "No book published yet"; ?>
                </div>

            <?php endif ?>
            </ul>
        </section>
    </main>

</body>

</html>