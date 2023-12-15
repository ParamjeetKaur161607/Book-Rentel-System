<?php 
include("USER_MENU.PHP"); 
$object_database->users_data($_SESSION['login']);

if (isset($_POST['checkout'])) {

    $object_validation->is_duration_valid();
    $object_validation->is_payment_valid();
    $errorVariables = [
        $object_validation->error_duration,
        $object_validation->error_payment,];
    if ($object_validation->is_array_empty($errorVariables)) {
        $object_database->user_cart();
        foreach ($object_database->all_sku as $key => $value) {
            $data_to_insert_in_orders = array(
                "order_id" => uniqid(),
                "customer_email" => "$_SESSION[login]",
                "customer_name" => "$_POST[name]",
                "customer_phone" => "$_POST[phone]",
                "book_sku" => "$value[book_sku]",
                "customer_address" => "$_POST[address]",
                "order_date" => "$object_validation->start_date",
                "return_date" => "$object_validation->duration",
                "payment" => "$_POST[payment]",
                "note" => "$_POST[note]"
            );
            $data_to_insert_in_returns = array(
                "customer_email" => "$_SESSION[login]",
                "book_sku" => "$value[book_sku]",
                "order_date" => "$object_validation->start_date",
                "return_date" => "$object_validation->duration"
            );
            $object_database->insert_to_orders("orders", $data_to_insert_in_orders);
            $object_database->insert_to_return_order("return_order", $data_to_insert_in_returns);
            $object_database->deduct_quantity($value['book_sku']);
            header('location:ORDER_SUMMARY.PHP');
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER PLACE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <main>
        <section class="px-96">           
            <div class="w-full p-10 space-y-10 p-20">
                <h1 class="text-5xl font-bold text-center">ORDER DETAILS</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="py-5 px-10 rounded-lg grid grid-cols-3 gap-8 w-full" enctype="multipart/form-data">   
                <?php
                // $object_validation->is_duration_valid();
                // echo $object_validation->daysDifference;?>  
                    <div class="flex flex-col">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_database->row['user_email'] ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_email ?></span>
                    </div>               
                    <div class="flex flex-col">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_database->row['user_name'] ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_name ?></span>
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_database->row['user_phone'] ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_phone ?></span>
                    </div>                   
                    
                    <div class="flex flex-col col-span-3">
                        <label for="address">Address</label>
                        <textarea name="address" id="" cols="30" rows="1" class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php echo $object_database->row['user_address'] ?></textarea>
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_address; ?></span>
                    </div>  
                    <div class="col-span-3">
                        <label for="duration">Duration<span class="text-red-500">*</span></label>
                        <input type="date" name="duration" id="duration" value="">
                        <div class="text-red-500 text-sm"><?php echo $object_validation->error_duration; ?></div>
                    </div>                                      
                    
                    <div class="col-span-3 space-y-3">
                        <label for="note">Note for Seller</label>
                        <textarea class="border outline-none text-gray-500 p-3" name="note" id="note" cols="108" rows="5"></textarea>
                    </div>   
                    <div class="col-span-3 space-y-3">
                        <label for="payment"><span class="text-red-500">*</span>Payment by credit Card</label>
                        <input type="checkbox" name="payment" id="payment" value="">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_payment; ?></span>
                        <p class="text-red-300">(Note: Payment will be deducted from your credit card as per your order subtotal. If you are unable to return the book on time the fine charge will be Rs.2 per day. When your pending fine will be the same as book on the price and you are unable to return the book, payment of book is automatic deducted from your account)</p>
                        
                    </div>            
                    <div class="flex flex-col col-span-3">
                        <button type="submit" name="checkout" class="outline-none bg-green-400 rounded-lg p-3">Checkout</button>
                    </div>
                </form>
            </div>

        </section>
    </main>
</body>

</html>