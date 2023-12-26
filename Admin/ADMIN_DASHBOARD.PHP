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
                    <h2 class="text-center text-4xl text-bold ">
                        <?php $object_CRUD->getSum('subtotal', 'orders');
                        echo $object_CRUD->row["SUM(subtotal)"]; ?>/-
                    </h2>
                </div>
            </div>

            <div class="border bg-blue-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Pending Returns</h3>
                </div>
                <div class="bg-blue-100 h-full flex justify-between items-center p-10 ">
                    <h2 class="text-center text-4xl text-bold ">
                        <?php $object_CRUD->getTotal('sku', 'return_order');
                        echo $object_CRUD->row["COUNT(sku)"]; ?>
                    </h2>
                </div>
            </div>
            <div class="border bg-green-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 justify-center items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Listings</h3>
                </div>
                <div class="bg-green-100 h-full flex justify-between items-center p-10">
                    <h2 class="text-center text-[3rem] text-bold">
                        <?php $object_CRUD->getTotal('sku', 'books');
                        echo $object_CRUD->row["COUNT(sku)"]; ?>
                    </h2>
                </div>
            </div>
            <div class="border bg-yellow-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Orders</h3>
                </div>
                <div class="bg-yellow-100 h-full flex justify-between items-center p-10">
                    <h2 class="text-center text-[3rem] text-bold">
                        <?php $object_CRUD->getTotal('order_id', 'orders');
                        echo $object_CRUD->row["COUNT(order_id)"]; ?>
                    </h2>
                </div>
            </div>

            <div class="border bg-purple-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Users</h3>
                </div>
                <div class="bg-purple-100 h-full flex justify-between items-center p-10">
                    <h2 class="text-center text-[3rem] text-bold">
                        <?php $object_CRUD->getTotal('email', 'user_registration');
                        echo $object_CRUD->row["COUNT(email)"]; ?>
                    </h2>
                </div>
            </div>

            <div class="border bg-gray-200 border flex items-center justify-between shadow-xl">
                <div class="flex flex-col gap-3 items-center p-10 w-full">
                    <p class="text-xl">Total</p>
                    <h3 class="text-center text-4xl text-semi-bold">Categories</h3>
                </div>
                <div class="bg-gray-100 h-full flex justify-between items-center p-10">
                    <h2 class="text-center text-[3rem] text-bold">
                        <?php $object_CRUD->getTotal('category', 'book_category');
                        echo $object_CRUD->row["COUNT(category)"]; ?>
                    </h2>
                </div>
            </div>

        </div>

    </main>

</body>

</html>