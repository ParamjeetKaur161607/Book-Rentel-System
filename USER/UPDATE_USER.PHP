<?php
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}

$object_CRUD->getAllFields('user_registration', 'id', $_SESSION['login']);

if (isset($_POST['delete_user'])) {
    $pending_returns = $object_CRUD->getRecord('return_order', 'sku', 'user_id', $_SESSION['login']);
    if (empty($pending_returns)) {
        $object_CRUD->deleteRecord('validate_return_date', 'user_id', $_SESSION['login']);
        $object_CRUD->deleteRecord('cart', 'id', $_SESSION['login']);
        $object_CRUD->deleteRecord('user_registration', 'id', $_SESSION['login']);
        unset($_SESSION['login']);
        header('location:LOGIN.PHP');
    } else {
        $object_validation->alert = "Your returns are pending, Can't delete account";

    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <main>
        <section class="flex w-full">
            <div class="bg-black bg-[url('../IMAGES/STORE.jpeg')] bg-center h-screen w-1/3 p-5">
            </div>
            <div class="w-full p-10 space-y-5">
                <h1 class="text-5xl font-bold text-center underline">UPDATE</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    class="py-5 px-10 rounded-lg grid grid-cols-3 gap-10" enctype="multipart/form-data">
                    <div class="flex flex-col">
                        <label for="name">Username</label>
                        <input type="text" name="name" id="name"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record["name"]; ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_name ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="email">User Email</label>
                        <input type="text" name="email" id="email"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record["email"]; ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_email ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone">User Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record["phone"]; ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_phone ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record["gender"];
                            ; ?>">
                            <option value="male" <?php echo ($object_CRUD->record["gender"] === 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($object_CRUD->record["gender"] === 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="others" <?php echo ($object_CRUD->record["gender"] === 'others') ? 'selected' : ''; ?>>Others</option>
                        </select>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_gender; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="dob">DOB</label>
                        <input type="date" name="dob" id="dob"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_CRUD->record["dob"]; ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_dob; ?>
                        </span>
                    </div>
                    <div class="flex flex-col col-span-3">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" cols="30" records="1"
                            class="outline-none pb-2 border-b border-gray-500 text-gray-500"><?php echo $object_CRUD->record["address"]; ?></textarea>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_address; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="old_password">Old Password <span class="text-red-500">*</span></label>
                        <input type="password" name="old_password" id="old_password"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->old_password; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_password; ?>
                        </span>

                    </div>
                    <div class="flex flex-col">
                        <div class="flex justify_between">
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="outline-none bg-grayy-200 h-10 rounded-md" value="">
                            <span>
                                <?php echo $object_CRUD->record["profile_picture"]; ?>
                            </span>
                        </div>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_profile_picture; ?>
                        </span>
                    </div>
                    <div class="flex flex-col col-span-3">
                        <button type="submit" name="update_user"
                            class="outline-none bg-green-400 rounded-lg p-3">Update</button>
                    </div>
                </form>
                <div class="flex justify-between items-center w-full">
                    <a href="LOGIN.PHP" class="text-blue-600 underline p-10">Go to login-></a>
                    <form action="" method="post" class="flex flex-col gap-3">
                        <button name="delete_user" class="bg-red-800 text-white px-5 py-1 rounded-md">Delete
                            Account</button>
                        <span class="text-red-500">
                            <?php echo $object_validation->alert; ?>
                        </span>
                    </form>
                </div>
            </div>

        </section>
    </main>
</body>

</html>