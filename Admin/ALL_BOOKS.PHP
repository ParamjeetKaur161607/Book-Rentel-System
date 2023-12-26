<?php
require("ADMIN_PANEL.PHP");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BOOK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <section class="p-10 space-y-10 ml-80">
        <div class="flex justify-between mt-7">
            <h1 class="sm:text-2xl sm:font-bold">All Books</h1>
            <div class="space-x-2 flex ">
                <a href="ADD_BOOK.PHP"
                    class="bg-gray-400 text-white h-10 items-center flex justify-center px-5 rounded-lg">ADD BOOK</a>
                <a href="ADD_BOOK_CATEGORY.PHP" name="add_category"
                    class="bg-gray-400 text-white h-10 items-center flex justify-center px-5 rounded-lg">ADD
                    CATEGORY</a>
                <a href="DELETE_CATEGORY.PHP" name="delete_category"
                    class="bg-red-400 text-white h-10 items-center flex justify-center px-5 rounded-lg">DELETE
                    CATEGORY</a>
            </div>
        </div>
        <div class="flex gap-5">
            <?php $object_validation->category = $object_CRUD->getAllRecords('book_category', 'category');
            foreach ($object_validation->category as $key => $value): ?>
                <form action="BOOK_CATEGORY.PHP?book_category=<?php echo $value; ?>" method="post">
                    <button class="px-2 underline">
                        <?php
                        echo $value; ?>
                    </button>
                </form>
            <?php endforeach; ?>
        </div>
        <ul>
            <?php $all_books = $object_CRUD->getJoinBooks('books', 'books_price', 'sku');
            if (isset($all_books)):
                foreach ($all_books as $key => $value): ?>
                    <li class="bg-gray-100 border mt-7 rounded-xl p-6 flex items-center gap-10 text-gray-700">
                        <div class="h-28 w-24 border">
                            <?=
                                '<img src="BOOKS_IMAGES/' . $value['cover_image'] . '" alt=""
                        class="h-full w-full object-fit">'
                                ?>

                        </div>
                        <div class="flex justify-between items-center w-full">
                            <div class="space-y-5">
                                <div class="flex gap-2 items-center gap-24">
                                    <div class="flex gap-2 items-center">
                                        <h2 class="font-bold text-2xl">
                                            <?= $value['title']; ?>
                                        </h2>
                                        <h3 class="font-bold text-lg">
                                            (
                                            <?= $all_books[$key]['sku']; ?>)
                                        </h3>
                                    </div>

                                </div>
                                <div class="flex font-semi-bold text-lg divide-x">
                                    <dl class="space-y-2 pr-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold">Author:</dt>
                                            <dd>
                                                <?= $all_books[$key]['author']; ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold">category:</dt>
                                            <dd>
                                                <?= $all_books[$key]['category']; ?>
                                            </dd>
                                        </div>

                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold">Fine:</dt>
                                            <dd>Rs.
                                                <?= $all_books[$key]['fine']; ?>
                                            </dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-bold">Per day Price:</dt>
                                            <dd>Rs.
                                                <?= $all_books[$key]['per_day_price']; ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold">Uploaded:</dt>
                                            <dd>
                                                <?= $all_books[$key]['book_uploaded']; ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold">Modified:</dt>
                                            <dd>
                                                <?= $all_books[$key]['book_modified']; ?>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <strong>Quantity:
                                <?= $all_books[$key]['quantity']; ?>
                            </strong>
                            <div class="flex flex-col gap-5 items-center">

                                <form method="post" action="UPDATE_BOOK.PHP?id=<?php echo $value['sku']; ?>" class="">
                                    <button id=""
                                        class="bg-green-700 text-white h-8 items-center flex justify-center px-5 rounded-full">Update</button>
                                </form>
                                <form method="post" action="DELETE_BOOK.PHP?id=<?php echo $value['sku']; ?>" class="">
                                    <button name=""
                                        class="bg-red-800 text-white h-8 items-center flex justify-center px-5 rounded-full">Delete</button>
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
</body>

</html>