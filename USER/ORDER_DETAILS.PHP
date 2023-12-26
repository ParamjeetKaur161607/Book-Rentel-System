<?php
include("USER_MENU.PHP");

if(isset($_SESSION['login'])){
    $return_date=$object_CRUD->getRecord('validate_return_date','return_date','user_id',"$_SESSION[login]");
    $object_OrderValidationHandler->all_sku=$object_CRUD->getRecord('validate_return_date','sku','user_id',"$_SESSION[login]");
} else{
    header("Location: LOGIN.PHP");
    exit();
}

foreach ($object_OrderValidationHandler->all_sku as $key => $value){
    $object_CRUD->getJoinbook('books','books_price','sku',"$value[sku]");
    if(isset($return_date[0]['return_date'])){
        $daysDifference = $object_OrderValidationHandler->getTotalDays(date('Y-m-d'), $return_date[0]['return_date']);          
        $rent= $object_CRUD->row['per_day_price']* $daysDifference;
        $total[]="$rent";   
        $subtotal=array_sum($total);
    }
}

if (isset($_POST['place_order'])) {
    $object_validation->is_email_valid();
    $object_validation->is_name_valid();
    $object_validation->is_phone_valid();
    $object_validation->is_address_valid();
    $object_OrderValidationHandler->is_card_number_valid();
    $object_OrderValidationHandler->is_name_on_card_valid();
    $object_OrderValidationHandler->is_cvv_valid();
    $object_OrderValidationHandler->is_expiry_date_valid();
    $object_OrderValidationHandler->is_payment_valid();
        
    $errorVariables = [
        $object_validation->error_email,
        $object_validation->error_phone,
        $object_validation->error_name,
        $object_validation->error_address,
        $object_OrderValidationHandler->error_card_number,
        $object_OrderValidationHandler->error_name_on_card,
        $object_OrderValidationHandler->error_cvv,
        $object_OrderValidationHandler->error_card_expiry_month,
        $object_OrderValidationHandler->error_card_expiry_year,
        $object_OrderValidationHandler->error_payment,
    ];    

    if ($object_OrderValidationHandler->is_array_empty($errorVariables)) {
        $object_OrderValidationHandler->all_sku=$object_CRUD->getRecord('validate_return_date','sku','user_id',"$_SESSION[login]");
        $order_id=$object_CRUD->unique_id();
        foreach ($object_OrderValidationHandler->all_sku as $key => $value) {
            $return=$object_CRUD->getRecordWithConditions('validate_return_date','return_date','user_id',"$_SESSION[login]",'sku', "$value[sku]");
            var_dump($return);
            if(!empty($return)){
                $return_date= $return[0]["return_date"];
                if(!empty($return_date)){
                    $book_return_Date=$return_date;
                }
            }           

            if(date('Y-m-d') > $return_date){
                $daysDifference = $object_OrderValidationHandler->getTotalDays($return_date[0]['return_date'] , date('Y-m-d'));
                $fine= $daysDifference*2;
            }else{
                $fine= 0;
            }                       

            $rent=$object_CRUD->getRecord('books_price','per_day_price','sku',"$value[sku]");
            $book_title=$object_CRUD->getRecord('books','title','sku',"$value[sku]");
            $book_author=$object_CRUD->getRecord('books','author','sku',"$value[sku]");
            $book_cover_image=$object_CRUD->getRecord('books','cover_image','sku',"$value[sku]");

            $data_into_order = array(
                "order_id" => $order_id,
                "user_id" => "$_SESSION[login]",
                "customer_name" => "$_POST[name]",
                "customer_phone" => "$_POST[phone]",
                "sku" => "$value[sku]",
                "customer_address" => "$_POST[address]",
                "order_date" => date('Y-m-d'),
                "return_date" => "$book_return_Date",
                "payment" => $rent[0]["per_day_price"],
                "subtotal" => $subtotal,
                "note" => "$_POST[note]",
                "Fine" => $fine,
                "book_title"=> $book_title[0]['title'],
                "book_author"=>$book_author[0]['author'],
                "book_cover_image"=> $book_cover_image[0]["cover_image"],
            );
            $data_into_return_orders = array(
                "user_id" => "$_SESSION[login]",
                "sku" => "$value[sku]",
                "order_date" => date('Y-m-d'),
                "return_date" => "$book_return_Date",
                "Fine" => $fine,
                "order_id" => $order_id,
            );         
            
            $object_CRUD->insertRecord('orders',$data_into_order);
            $object_CRUD->insertRecord('return_order',$data_into_return_orders);
            $object_CRUD->UpdateQuantity('-',$value['sku']);
            $object_CRUD->deleteRecord('cart','id',"$_SESSION[login]");
            $object_CRUD->deleteRecord('validate_return_date','user_id',"$_SESSION[login]");            
            
        }
        header('location: PAYMENT.PHP');
        exit;
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
        <section class="px-96 py-10">
            <?php $object_CRUD->getAllFields('user_registration', 'id', "$_SESSION[login]");?>
            <div class="w-full p-10 space-y-10 p-5 border rounded-md">
                <h1 class="text-5xl font-bold text-center">ORDER DETAILS</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    class="py-5 px-10 rounded-lg grid grid-cols-3 gap-8 w-full" enctype="multipart/form-data">                    
                    <div class="flex flex-col">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record['email'] ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_email ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record['name'] ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_name ?>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record['phone'] ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_phone ?>
                        </span>
                    </div>

                    <div class="flex flex-col col-span-3">
                        <label for="address">Address</label>
                        <textarea name="address" id="" cols="30" rows="1"
                            class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php echo $object_CRUD->record['address'] ?></textarea>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_address; ?>
                        </span>
                    </div>
                    

                    <div class="flex flex-col">
                        <label for="card_number">Credit/Debit Card Number</label>
                        <input type="text" name="card_number" id="card_number"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_OrderValidationHandler->card_number ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_card_number; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="name_on_card">Name on Credit/Debit Card</label>
                        <input type="text" name="name_on_card" id="name_on_card"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_OrderValidationHandler->name_on_card ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_name_on_card; ?>
                        </span>
                    </div>

                    <div class="flex flex-col ">
                        <label for="cvv">CVV</label>
                        <input type="password" name="cvv" id="cvv"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_OrderValidationHandler->cvv ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_cvv; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="month">Card Expiry Month</label>
                        <input type="number" name="month" id="month"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_OrderValidationHandler->card_expiry_month ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_card_expiry_month; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="year">Card Expiry Year</label>
                        <input type="number" name="year" id="year"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_OrderValidationHandler->card_expiry_year ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_card_expiry_year; ?>
                        </span>
                    </div>

                    <div class="col-span-3 space-y-3 flex flex-col">
                        <label for="note">Note for Seller</label>
                        <textarea class="border border-gray-500 outline-none text-gray-500 p-3" name="note" id="note" cols="108"
                            rows="5"></textarea>
                    </div>
                    <?php if(isset($return_date[0]['return_date'])) :?>
                    <div class="bg-gray-100 col-span-3 p-10 space-y-5">
                        <h2 class="text-center font-bold text-2xl border-b pb-5 border-gray-300">Order Summary</h2>                        
                        <ul class="">
                            <?php
                            $object_OrderValidationHandler->all_sku=$object_CRUD->getRecord('validate_return_date','sku','user_id',"$_SESSION[login]");
                            foreach ($object_OrderValidationHandler->all_sku as $key => $value):

                            $return=$object_CRUD->getRecordWithConditions('validate_return_date','return_date','user_id',"$_SESSION[login]",'sku', "$value[sku]");
                            ?>
                            
                            <li class="flex justify-between items-center border-b py-5 border-gray-300">
                                <?php
                                $object_CRUD->getJoinbook('books','books_price','sku',"$value[sku]");                             
                                ?>                                
                                <div class="flex gap-5">
                                    <div class="h-14 w-10 border">
                                        <?=
                                            '<img src="../Admin/BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                                            class="h-full w-full object-fit">'
                                        ?>
                                    </div>
                                    <div>
                                        <p><?php echo $object_CRUD->row['title'] ?> ( <?php echo $object_CRUD->row['author'] ?> )</p>
                                        <p>Return Date: <?=$return[0]["return_date"]?></p>
                                    </div>
                                </div>
                                <div class="flex gap-20">
                                    <p><b>Rs. <?php echo $object_CRUD->row['per_day_price']."</b>" ?><span class="text-sm">/per day</span></p>
                                    <p><b>Rs.
                                        <?php     
                                            $daysDifference = $object_OrderValidationHandler->getTotalDays(date('Y-m-d'), $return[0]["return_date"]);          
                                            $rent= $object_CRUD->row['per_day_price']* $daysDifference;
                                            echo $rent."</b>";                                       
                                        ?>
                                        <span class="text-sm">/<?=$daysDifference?> day</span>
                                    </p>
                                </div>
                                
                            </li>                            
                            
                            <?php endforeach;?>
                            <div class="flex justify-between items-center py-5">
                                <b>Subtotal</b>
                                <b>Rs. <?php echo $subtotal;?></b>
                                <?php                                    
                                ?>
                            </div>
                        </ul>
                        
                    </div>
                    <?php endif; ?>
                    <div class="col-span-3 space-y-3">
                        <label for="payment"><span class="text-red-500">*</span>Payment</label>
                        <input type="checkbox" name="payment" id="payment" value="">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_OrderValidationHandler->error_payment; ?>
                        </span>
                        <p class="text-red-600">(Note: If you will not return the book on time, fine charge will be Rs.
                            2 per day)</p>
                    </div>
                    <div class="flex flex-col col-span-3">
                        <button type="submit" name="place_order"
                            class="outline-none bg-green-400 rounded-lg p-3">Place Order</button>
                    </div>
                </form>
            </div>

        </section>
    </main>
</body>

</html>