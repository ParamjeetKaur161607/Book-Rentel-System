<?php include("USER_MENU.PHP");

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
        <section class="h-[55rem] pb-10">
            <div class="bg-[url('../IMAGES/STORE.jpeg')] bg-center object-fit h-full flex justify-center items-center">
                <h1 class="font-bold text-[5rem] text-red-500 bg-white/70 px-10">Second Story Book Store</h1>
            </div>
        </section>
        <section class="px-20 space-y-10 pb-20"> 
        <h1 class="text-5xl font-bold text-center">CATEGORY</h1>   
        <div class="flex divide-x justify-center bg-yellow-900/5 py-3">                
                    <?php $object_validation->category = $object_database->get_all_category();
                    foreach ($object_validation->category as $key => $value): ?>
                        <form action="BOOKS_CATEGORY.PHP?book_category=<?php echo $value; ?>" method="post">
                            <button class="text-3xl font bold capitalize px-5">
                                <?php
                                echo $value; ?>
                            </button>
                        </form>
                    <?php endforeach; ?>
                </div>        
            <div class="flex gap-5">                
                
            </div>
            <ul class="grid grid-cols-5 gap-20">
            <?php $all_books = $object_database->books_data();
            if(isset($all_books)):
            foreach ($all_books as $key => $value): 
            if(($all_books[$key]['book_quantity'])<1){
                continue;
            }
            ?>
                <li class="w-full h-full">
                    <div class="rounded-md h-fit ">
                        <div class="border bg-yellow-900/5 border-gray-300 p-4 text-center space-y-2 h-full peer relative rounded-lg">
                            <div class="w-full h-64">
                            <?=
                                '<img src="../admin/BOOKS_IMAGES/'.$all_books[$key]['book_image'].'" alt=""
                                class="h-full border border-gray-300 w-full object-fit">'
                                ?>
                            </div>
                            <h2 class="font-bold text-lg"><?= $all_books[$key]['book_title']; ?></h2>
                            <h3 class="text-sm text-gray-500"><?= $all_books[$key]['book_author']; ?></h3>
                            <p class="text-xl font-bold"><?= $all_books[$key]['book_sale_price']; ?>/-</p>
                            <form action="CART.PHP?id=<?php echo $all_books[$key]['book_sku']; ?>" method="post">
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