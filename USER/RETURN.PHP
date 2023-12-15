<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}
$object_database->returns($_SESSION['login']);
$object_database->user_returns();
if(isset($_POST['return'])){
    $object_database->delete_from_returns($_GET['id'],$_SESSION['login']);
    $object_database->restoke_quantity($_GET['id']);
    header('location: RETURN.PHP');
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
        <section class="p-10 space-y-10">
            <h1 class="text-3xl font-bold">Returns..</h1>
            <?php
                if ($object_database->all_sku !== null && (is_array($object_database->all_sku) || is_object($object_database->all_sku))):
                foreach ($object_database->all_sku as $item):
                    $object_database->view_book_data($item['book_sku']);              
            ?>
            <div class="border bg-gray-100 flex justify-between items-center p-5">
            <div class="h-36 w-28 border">
                <?=
                    '<img src="../Admin/BOOKS_IMAGES/'.$object_database->row['book_image'].'" alt=""
                    class="h-full w-full object-fit">'
                ?>
            </div>
            <p><?php echo "<b>Book Title:</b> ".$object_database->row['book_title'];?></p>
            <p><?php echo "<b>Order Date:</b> ".$object_database->row1['order_date'];?></p>
            <p><?php echo "<b>Retirn Date:</b> ".$object_database->row1['return_date'];?></p>
            <form action="RETURN.PHP?id=<?php echo $object_database->row['book_sku']; ?>" method="post" class="flex items-center gap-20">
                <div class="flex flex-col">
                    <label for="review" class="">Review</label>
                    <textarea name="review" id="review" cols="30" rows="2" class="border outline-none text-gray-500"></textarea>
                </div>
                <div class="flex gap-2">                    
                    <input type="checkbox" name="fine" id="fine">
                    <label for="fine" class="">Pay Fine <span>Rs.10</span></label>
                </div>
                <button name="return" class="bg-blue-800 text-white px-3 py-1 rounded-md">Return</button>
            </form>
            </div>
            <?php endforeach; ?>
            <?php else:?>
                <?php echo "Your cart is empty now!"; ?>
            <?php endif;?>
        </section>
    </main>
</body>
</html>