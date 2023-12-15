<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}
$object_database->user_cart();
if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['login'])) {

        $object_validation->extra = false;
        if(isset($object_database->all_sku)){
            foreach ($object_database->all_sku as $key => $value) {
                // echo "<pre>";
                // var_dump($value);
                // echo "</pre>";
                if (in_array($_GET['id'], $value)) {
                    $object_validation->extra = true;
                    break; // Break out of the loop once the value is found
                }
            }
            
            if (!$object_validation->extra) {
                $data_to_insert_in_cart = array(
                    "user_email" => "$_SESSION[login]",
                    "book_sku" => "$_GET[id]",
                );
                $object_database->insert_to_cart("cart", $data_to_insert_in_cart);
            }
        }else{
            $data_to_insert_in_cart = array(
                "user_email" => "$_SESSION[login]",
                "book_sku" => "$_GET[id]",
            );
            $object_database->insert_to_cart("cart", $data_to_insert_in_cart);
        }
    } else {
        header('location:../USER/LOGIN.PHP');
    }
}

if (isset($_POST['delete_cart'])) {
    $object_database->delete_cart($_GET['id'],$_SESSION['login']);      
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
        <section class="p-10">
            <!-- <form> -->
            <!-- <h1 class="p-10 font-semibold text-4xl">Cart</h1> -->
            <div class="block xl:flex h-full">
                <div class="bg-white pb-10 xl:w-1/2 h-full p-10">
                    <ul class=" pb-10  h-full">
                        <?php
                        // foreach ($object_database->all_sku as $key => $value){
                        //     $object_database->view_book_data($value['book_sku']);
                        //        print_r($object_database->row);                            
                        // }
                        
                        ?>                        
                        <?php
                        // $object_database->user_cart();
                        // var_dump($object_database->all_sku);
                        // print_r($object_database->all_sku);
                        if ($object_database->all_sku !== null && (is_array($object_database->all_sku) || is_object($object_database->all_sku))):
                            $subtotal = array();
                        foreach ($object_database->all_sku as $item):
                            $object_database->view_book_data($item['book_sku']); 
                            $subtotal[]=$object_database->row['book_sale_price'];   
                                    
                            ?>
                            <li class="flex items-start gap-5 border-b py-10 h-full">
                                <div class="h-40 w-36 border">
                                <?=
                                    '<img src="../Admin/BOOKS_IMAGES/'.$object_database->row['book_image'].'" alt=""
                                    class="h-full w-full object-fit">'
                                    ?>
                                </div>
                                <div class="w-full flex flex-col justify-between gap-24 h-40">
                                    <div class="flex justify-between h-full items-start">
                                        <div class="h-full flex flex-col justify-between">
                                            <div>
                                                <h2>
                                                    <?php echo $object_database->row['book_sku'] ?>
                                                    <?php echo $object_database->row['book_title'] ?>
                                                </h2>
                                                <h3>
                                                    <?php echo $object_database->row['book_author'] ?>
                                                </h3>
                                            </div>
                                            <strong>Rs.
                                                <?php
                                                 echo $object_database->row['book_sale_price'] 
                                                 ?>
                                            </strong>
                                        </div>                                        
                                        <div>
                                            <span>Quantity:<?php echo "1"; ?></span>
                                        </div>
                                        <form action="CART.PHP?id=<?php echo $object_database->row['book_sku']; ?>" method="post">
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
                        <?php else:?>
                            <?php echo "Your cart is empty now!"; ?>
                        <?php endif;?>
                        
                    </ul>
                </div>
                <?php
                    if(isset($subtotal)):?>
                <div class="w-full xl:w-1/2 p-10">
                    <div class="bg-gray-300 p-10">
                        <h2 class="font-bold text-xl px-10">Your Rent for 1 week</h2>
                        <div class="p-10 space-y-5">
                            <div class="flex justify-between">
                                <p>Subtotal</p>
                                <p>Rs.<?php
                                 if(isset($subtotal)){
                                    print_r(array_sum($subtotal));
                                 }else{
                                    echo "00.00";
                                 }
                                ?>
                                </p>
                            </div>                            
                            
                            <form action="ORDER_DETAILS.PHP" method="post">
                                <button name="next" class="w-full py-2 px-10 bg-blue-900 rounded-md text-white">
                                    Next</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- </form> -->
        </section>
    </main>
</body>

</html>