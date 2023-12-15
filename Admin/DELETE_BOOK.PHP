<?php
require("ADMIN_PANEL.PHP");
$id=$_GET['book_sku'];
if(isset($_POST['delete_book'])){
    $object_database->delete_from_book($id);
    header("location:ALL_BOOKS.PHP");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <main class="flex justify-center pt-40 h-screen w-full bg-black/40 pl-80">
        <div class="bg-gray-100 space-y-5 h-fit p-10">
            <div class="flex gap-5 items-center">
                <svg class="w-10 h-10 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1" viewBox="0 0 16 16" fill="currentColor">
                    <path fill="red"
                        d="M8 1l-8 14h16l-8-14zM8 13c-0.6 0-1-0.4-1-1s0.4-1 1-1 1 0.4 1 1c0 0.6-0.4 1-1 1zM7 10v-4h2v4h-2z">
                    </path>
                </svg>
                <h2 class="font-bold text-xl">Are you sure to delete this book(
                    <?= $id?>)!
                </h2>
            </div>
            <p>Once you deleted this book, you can't restore it again</p>
            <div class="flex gap-5 justify-end">
                <a href="ALL_BOOKS.PHP" class="bg-green-700 rounded-md py-2 px-5 text-white">CANCEL</a>
                <form action="" method="post">
                    <button name="delete_book" class="bg-red-700 rounded-md py-2 px-5 text-white">DELETE</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>