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
    <main class="pl-80 h-screen">
        <div class="px-20 pt-20">
            <div class="flex justify-between">
                <h1 class="font-semi-bold text-2xl">What's new, Second Story Book Store?</h1>
                <a href="../USER/INDEX.PHP" class="text-blue-500 underline">Second Story Book Store </a>                
            </div>
        </div>
        <div class="p-20 w-full grid grid-cols-3">            
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Listings</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold"><?php $object_database->count_books(); echo $object_database->row["COUNT(book_sku)"]; ?></h2>                
            </div>
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Users</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold"><?php $object_database->count_users(); echo $object_database->row["COUNT(user_email)"]; ?></h2>                
            </div>
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Customers</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold">10</h2>                
            </div>       
        </div>
        <div class="p-20 pt-0 w-full grid grid-cols-3">            
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Listings</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold">10</h2>                
            </div>
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Users</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold">10</h2>                
            </div>
            <div class="p-10 border bg-gray-100 border flex flex-col gap-5 items-center">
                <div class="flex gap-3 items-center">
                    <h3 class="text-center text-[1rem] text-semi-bold">Total Customers</h3>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><polygon points="16.172 9 10.101 2.929 11.515 1.515 20 10 19.293 10.707 11.515 18.485 10.101 17.071 16.172 11 0 11 0 9"></polygon></svg>
                </div>
                <h2 class="text-center text-[3rem] text-bold">10</h2>                
            </div>       
        </div>
    </main>      
</body>

</html>