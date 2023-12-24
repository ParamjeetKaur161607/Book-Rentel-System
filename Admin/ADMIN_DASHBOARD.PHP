<?php
require("ADMIN_PANEL.PHP");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style type="text/css">
        ::-webkit-scrollbar {
            width: 0px;
            height: 0px;
        }
        
    </style>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="text-lg sm:text-base">
    <?php if(isset($sku)):?>
        <main class="pl-80">
        <ul class="p-10">
            <?php
            foreach ($sku as $key => $value): 
            $object_CRUD->getJoinbook('books','books_price','sku', $value['sku']);?>
                <li class="bg-gray-100 border mt-7 rounded-xl p-6 flex items-center gap-10 text-gray-700">
                    <div class="h-28 w-24 border">
                        <?=
                            '<img src="BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                    class="h-full w-full object-fit">'
                            ?>

                    </div>
                    <div class="flex justify-between items-center w-full">
                        <div class="space-y-5">
                            <div class="flex gap-2 items-center gap-24">
                                <div class="flex gap-2 items-center">
                                    <h2 class="font-bold text-2xl">
                                        <?= $object_CRUD->row['title']; ?>
                                    </h2>
                                    <h3 class="font-bold text-lg">
                                        (
                                        <?= $object_CRUD->row['sku']; ?>)
                                    </h3>
                                </div>

                            </div>
                            <div class="flex font-semi-bold text-lg divide-x">
                                <dl class="space-y-2 pr-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Author:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['author']; ?>
                                        </dd>
                                    </div>

                                    <div class="flex gap-2">
                                        <dt class="font-bold">category:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['category']; ?>
                                        </dd>
                                    </div>

                                </dl>
                                <dl class="space-y-2 px-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">MRP:</dt>
                                        <dd>Rs.
                                            <?= $object_CRUD->row['mrp']; ?>
                                        </dd>
                                    </div>
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Per day Price:</dt>
                                        <dd>Rs.
                                            <?= $object_CRUD->row['per_day_price']; ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="space-y-2 px-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Uploaded:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['book_uploaded']; ?>
                                        </dd>
                                    </div>

                                    <div class="flex gap-2">
                                        <dt class="font-bold">Modified:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['book_modified']; ?>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <strong>Quantity:
                            <?= $object_CRUD->row['quantity']; ?>
                        </strong>
                        <div class="flex flex-col gap-5 items-center">

                            <form method="post" action="UPDATE_BOOK.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" class="">
                                <button id=""
                                    class="bg-green-700 text-white h-8 items-center flex justify-center px-5 rounded-full">Update</button>
                            </form>
                            <form method="post" action="DELETE_BOOK.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" class="">
                                <button name=""
                                    class="bg-red-800 text-white h-8 items-center flex justify-center px-5 rounded-full">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>            
        </ul>
        </main>    
    <?php else:?> 
    <main class="pl-80 ">
        <div class="px-20 pt-20">
            <div class="flex justify-between">
                <h1 class="font-semi-bold text-2xl">What's new, Second Story Book Store?</h1>
                <a href="../USER/INDEX.PHP" class="text-blue-500 underline">Second Story Book Store </a>                
            </div>
        </div>
        <div class="p-20 w-full grid grid-cols-3 gap-10">
            <div class="border bg-red-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Revenue</h3>
                </div>
                <div class="bg-red-100 h-full flex justify-between items-center p-10 ">
                    <h2 class="text-center text-4xl text-bold "><?php $object_CRUD->getSum('subtotal','orders'); echo $object_CRUD->row["SUM(subtotal)"]; ?>/-</h2>
                </div>                
            </div>
            
            <div class="border bg-blue-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Pending Returns</h3>
                </div>
                <div class="bg-blue-100 h-full flex justify-between items-center p-10 ">
                    <h2 class="text-center text-4xl text-bold "><?php $object_CRUD->getTotal('sku','return_order'); echo $object_CRUD->row["COUNT(sku)"]; ?></h2>
                </div>                
            </div>
            <div class="border bg-green-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 justify-center items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Listings</h3>
                </div>
                <div class="bg-green-100 h-full flex justify-between items-center p-10">
                <h2 class="text-center text-[3rem] text-bold"><?php $object_CRUD->getTotal('sku','books'); echo $object_CRUD->row["COUNT(sku)"]; ?></h2>
                </div>                
            </div>    
            <div class="border bg-yellow-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Orders</h3>
                </div>
                <div class="bg-yellow-100 h-full flex justify-between items-center p-10">
                <h2 class="text-center text-[3rem] text-bold"><?php $object_CRUD->getTotal('order_id','orders'); echo $object_CRUD->row["COUNT(order_id)"]; ?></h2>
                </div>                
            </div>    
            
            <div class="border bg-purple-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Users</h3>
                </div>
                <div class="bg-purple-100 h-full flex justify-between items-center p-10">
                <h2 class="text-center text-[3rem] text-bold"><?php $object_CRUD->getTotal('email','user_registration'); echo $object_CRUD->row["COUNT(email)"]; ?></h2>
                </div>                
            </div> 
            
            <div class="border bg-gray-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Categories</h3>
                </div>
                <div class="bg-gray-100 h-full flex justify-between items-center p-10">
                <h2 class="text-center text-[3rem] text-bold"><?php $object_CRUD->getTotal('category','book_category'); echo $object_CRUD->row["COUNT(category)"]; ?></h2>
                </div>                
            </div>       
            
        </div>
        
    </main>   
    <?php endif;?>   
</body>

</html>