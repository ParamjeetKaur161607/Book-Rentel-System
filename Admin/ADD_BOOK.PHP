<?php
require("ADMIN_PANEL.PHP");

if (isset($_POST['publish_book'])) {
    $object_BookValidationHandler->is_book_sku_valid();
    $object_BookValidationHandler->is_book_title_valid();
    $object_BookValidationHandler->is_book_author_valid();
    $object_BookValidationHandler->is_book_category_valid();
    $object_BookValidationHandler->is_book_discription_valid();
    $object_BookValidationHandler->is_book_quantity_valid();
    $object_BookValidationHandler->is_book_price_valid();
    $object_BookValidationHandler->is_book_image_valid();

    $errorVariables = [
        $object_BookValidationHandler->error_book_sku,
        $object_BookValidationHandler->error_book_title,
        $object_BookValidationHandler->error_book_author,
        $object_BookValidationHandler->error_book_category,
        $object_BookValidationHandler->error_book_discription,
        $object_BookValidationHandler->error_book_quantity,
        $object_BookValidationHandler->error_book_price,
        $object_BookValidationHandler->error_book_image,
    ];
    if ($object_BookValidationHandler->is_array_empty($errorVariables)) {
        $data_into_book = array(
            "id" => $object_CRUD->unique_id(),
            "sku" => "$object_BookValidationHandler->book_sku",
            "title" => "$object_BookValidationHandler->book_title",
            "author" => "$object_BookValidationHandler->book_author",
            "category" => "$object_BookValidationHandler->book_category",
            "discription" => "$object_BookValidationHandler->book_discription",
            "quantity" => "$object_BookValidationHandler->book_quantity",
            "cover_image" => "$object_BookValidationHandler->book_image_name",
            "book_uploaded" => $object_CRUD->current_date(),
            "book_modified" => $object_CRUD->current_date()
        );

        $data_into_bookPrice = array(
            "sku" => "$object_BookValidationHandler->book_sku",
            "mrp" => "$object_BookValidationHandler->book_price",
            "per_day_price" => round($object_BookValidationHandler->book_price * 5 / 100, 0)
        );

        if (move_uploaded_file($_FILES['book_file']["tmp_name"], $object_BookValidationHandler->book_image_path)) {
            $object_CRUD->insertRecord("books", $data_into_book);
            $object_CRUD->insertRecord("books_price", $data_into_bookPrice);
            header('Location: ALL_BOOKS.PHP');
        } else {
            $object_BookValidationHandler->error_book_image = "file location error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BOOK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="pb-34 bg-200">
    <main class="ml-80">
        <section class="flex flex-col items-center justify-center py-10 px-80">
            <h1 class="text-4xl font-bold bg-gray-400 text-center w-full py-5">ADD BOOK</h1>
            <form action="" method="post" enctype="multipart/form-data"
                class="bg-gray-300 px-5 py-10 w-full grid grid-cols-2 gap-10 text-lg">
                <div class="flex flex-col">
                    <label for="book_sku">Book SKU</label>
                    <input type="text" name="book_sku" id="book_sku"
                        class="p-2 border-gray-400 h-10 bg-gray-300 border-b outline-none"
                        value="<?php echo $object_BookValidationHandler->book_sku ?>">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_sku; ?>
                    </span>
                </div>
                <div class="flex flex-col">
                    <label for="book_title">Book Title</label>
                    <input type="text" name="book_title" id="book_title"
                        class="p-2 h-10 bg-gray-300 border-b outline-none border-gray-400"
                        value="<?php echo $object_BookValidationHandler->book_title ?>">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_title; ?>
                    </span>

                </div>
                <div class="flex flex-col">
                    <label for="book_author">Book Author</label>
                    <input type="text" name="book_author" id="book_author"
                        class="p-2 h-10 bg-gray-300 border-b outline-none border-gray-400"
                        value="<?php echo $object_BookValidationHandler->book_author ?>">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_author; ?>
                    </span>

                </div>
                <div class="flex flex-col">
                    <label for="book_category">Book Category</label>
                    <select name="book_category" id="book_category"
                        class=" border-gray-400 h-10 p-2 h-10 bg-gray-300 border-b outline-none"
                        value="<?php echo $object_BookValidationHandler->book_category ?>">
                        <option value="none" selected disabled hidden>Select Book category</option>
                        <?php
                        $object_BookValidationHandler->category = $object_CRUD->getAllRecords('book_category', 'category');
                        foreach ($object_BookValidationHandler->category as $category) {
                            if ($category == 'None') {
                                continue;
                            }
                            echo "<option value=\"$category\">$category</option>";
                            echo '';
                        }
                        ?>
                    </select>
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_category; ?>
                    </span>

                </div>

                <div class="flex flex-col col-span-2">
                    <label for="book_discription">Book Discription</label>
                    <textarea name="book_discription" id="book_discription"
                        class="p-2 bg-gray-300 border outline-none border-gray-400" cols="30"
                        rows="5"><?php echo $object_BookValidationHandler->book_discription ?></textarea>
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_discription; ?>
                    </span>

                </div>

                <div class="flex flex-col">
                    <label for="book_quantity">Book Quantity</label>
                    <input type="number" name="book_quantity" id="book_quantity"
                        class="p-2 h-10 bg-gray-300 border-b outline-none border-gray-400"
                        value="<?php echo $object_BookValidationHandler->book_quantity ?>">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_quantity; ?>
                    </span>

                </div>
                <div class="flex flex-col">
                    <label for="book_price">Book Price</label>
                    <input type="text" name="book_price" id="book_price"
                        class="p-2 h-10 bg-gray-300 border-b outline-none border-gray-400"
                        value="<?php echo $object_BookValidationHandler->book_price ?>">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_price; ?>
                    </span>
                </div>
                <div class="flex flex-col col-span-2">
                    <input type="file" name="book_file" id="book_file" aria-labelledby="book_cover"
                        class="rounded-lg h-10 outline-none">
                    <span class="text-red-500 text-sm">
                        <?php echo $object_BookValidationHandler->error_book_image; ?>
                    </span>
                </div>
                <div class="flex flex-col col-span-2">
                    <input type="submit" name="publish_book" id="publish_book" value="Publish"
                        class="rounded-lg h-10 text-black bg-gray-400 outline-none">
                </div>
            </form>
        </section>
    </main>
</body>

</html>