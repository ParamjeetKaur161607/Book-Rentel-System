<?php
include("../VALIDATION.PHP");
$object_database->admin($_SESSION['admin_login']);
$object_database->super_admin($_SESSION['admin_login']);
if (!isset($_SESSION['admin_login'])) {
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

<body>
    <aside
        class="bg-gray-900 border-r h-screen w-[20rem] fixed leading-10 flex flex-col gap-5 items-center justify-between">
        <div class="w-full flex flex-col items-center gap-20">
            <button class="p-6 bg-gray-500 w-full">
                <img src="../IMAGES/logo.png" alt="" class="h-full w-full object-fit">
            </button>
            <nav class="w-full">
                <ul class="font-semi-bold text-xl divide-y w-full font-bold text-gray-400">
                    <li class="p-5 pl-10"><a href="ADMIN_DASHBOARD.PHP" target="iframe">DASHBOARD</a></li>
                    <li class="p-5 pl-10"><a href="ALL_BOOKS.PHP" target="iframe">Listings</a></li>
                    <li class="p-5 pl-10"><a href="ORDER.PHP" target="iframe">Orders & Customers</a></li>
                    <li class="p-5 pl-10"><a href="USER.PHP" target="iframe">Users</a></li>
                    <li class="p-5 pl-10"><a href="RENTED_BOOK.PHP" target="iframe">Rented Books</a></li>
                    <?php
                    if (isset($object_database->row1['s_admin_id'])) :?>                     
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
        <header class="flex justify-between items-center border-b bg-gray-500 border-gray-400 px-10 py-5">
            <p class="text-xl font-bold text-gray-200">Welcome,
                <?php
                if (isset($object_database->row['admin_name'])) {
                    echo $object_database->row['admin_name'];
                } else {
                    echo $object_database->row1['s_admin_name'];
                }
                ?>
            </p>
            <form action="post" class="space-x-2">
                <input type="search" name="search" placeholder="Search by name or email..."
                    class="w-96 h-10 rounded-lg px-5 border border-gray-300 bg-gray-300">
                <input type="submit" value="Search"
                    class="bg-blue-900 text-white h-10 px-10 rounded-lg sm:px-2 sm:w-auto">
            </form>
            <div class="flex gap-10 items-center">
                <?php
                if (isset($object_database->row1['s_admin_id'])) :?>
                <a href="ADMIN_REGISTER.PHP" class="text-white underline">Add a admin</a>
                <?php endif;?>
                <?php
                if (isset($object_database->row['admin_image'])): ?>
                    <form action="ADMIN_UPDATE.PHP?admin_id=<?= $object_database->row['admin_id'] ?>" method="post">
                        <button name="update_login" class="h-14 w-14 rounded-full border">
                            <?=
                                '<img src="ADMINS_PROFILE_PICS/' . $object_database->row['admin_image'] . '" alt=""
                            class="h-full w-full object-fit rounded-full">'
                                ?>
                        </button>
                    </form>
                <?php else: ?>
                    <form action="ADMIN_UPDATE.PHP?admin_id=<?= $object_database->row1['s_admin_id'] ?>" method="post">
                        <button name="update_login" class="h-14 w-14 rounded-full border">
                            <?=
                                '<img src="ADMINS_PROFILE_PICS/' . $object_database->row1['s_admin_image'] . '" alt=""
                            class="h-full w-full object-fit rounded-full">'
                                ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </header>
    </div>
</body>

</html>