<?php
include("../VALIDATION.PHP");
if(isset($_SESSION['admin_login']))
{
    $login=$object_CRUD->getRecords('admin');
    // $object_database->getAdmin($_SESSION['admin_login']);
}

if(isset($_SESSION['super_admin_login']))
{
    $login=$object_CRUD->getRecords('super_admin');

    // $object_database->getSuperAdmin($_SESSION['super_admin_login']);
}

if (!isset($_SESSION['super_admin_login']) && !isset($_SESSION['admin_login'])) {
    header("Location: ADMIN_LOGIN.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN MENU</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<?php foreach($login as $key => $value): ?>
<body>
    <aside
        class="bg-gray-900 border-r h-screen w-[20rem] fixed leading-10 flex flex-col gap-5 items-center justify-between">
        <div class="w-full flex flex-col items-center gap-20 ">
            <button class="bg-gray-700 p-6 w-full shadow-md">
                <div class="bg-gray-700 px-5 py-2">
                    <img src="../IMAGES/logo.png" alt="" class="h-full w-full object-fit">
                </div>
            </button>
            <nav class="w-full">
                <ul class="font-semi-bold text-gray-400 text-xl divide-y divide-gray-400 w-full font-bold">
                    <li class="p-5 pl-10"><a href="ADMIN_DASHBOARD.PHP" target="iframe">DASHBOARD</a></li>
                    <li class="p-5 pl-10"><a href="ALL_BOOKS.PHP" target="iframe">Listings</a></li>
                    <li class="p-5 pl-10"><a href="ORDER.PHP" target="iframe">Orders & Customers</a></li>
                    <li class="p-5 pl-10"><a href="USER.PHP" target="iframe">Users</a></li>
                    <li class="p-5 pl-10"><a href="RENTED_BOOK.PHP" target="iframe">Rented Books</a></li>
                    <?php
                    if (isset($_SESSION['super_admin_login'])) :?>                     
                        <li class="p-5 pl-10"><a href="ADMINS.PHP" target="iframe">Admins</a>
                    <?php endif; ?>
                    
                </ul>
            </nav>

        </div>
        <footer class="w-full text-gray-300 font-bold text-xl">
            <form action="ADMIN_LOGIN.PHP" method="post">
                <button name="log_out_admin" class="bg-red-700 w-full py-5">Log Out</button>
            </form>
        </footer>
    </aside>
    <div class="ml-80 sticky top-0 ">
        <header class="flex justify-between items-center border-b bg-white px-10 py-6 shadow-md">
            <p class="text-xl font-bold">Welcome,
                <?php
                echo $value['name'];                
                ?>
            </p>
            <form action="ADMIN_DASHBOARD.PHP" method="post" class="border bg-white shadow-md">
                <select name="search_category" id="category" class="h-10 px-2 border-r">
                    <option value="none" selected disabled hidden>Select</option>
                    <option value="all">All</option>
                    <option value="author">Author</option>
                    <option value="title">Title</option>
                    <option value="category">Category</option>
                    <option value="SKU">SKU</option>
                </select>
                <input type="search" name="search_data" placeholder="Search..."
                    class="w-96 h-10 px-5 outline-none">
                <button name="search" value="search"
                    class="bg-blue-900 text-white h-10 px-5 w-auto">Search</button>
            </form>
            <div class="flex gap-10 items-center">
                <form action="ADMIN_UPDATE.PHP?id=<?php echo $value['id']; ?>" method="post">
                    <button name="update_login" class="h-14 w-14 rounded-full border border-gray-300">
                        <?=
                            '<img src="ADMINS_PROFILE_PICS/' . $value['profile_picture'] . '" alt=""
                        class="h-full w-full object-fit rounded-full">'
                            ?>
                    </button>
                </form>
                
            </div>
        </header>
    </div>
    
</body>
<?php endforeach; ?>
</html>