<?php
require("ADMIN_PANEL.PHP");
$all_users = $object_database->all_users();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALL USERS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
    <section class="p-10 ml-80">
        <h1 class="text-5xl sm:text-2xl sm:font-bold">All Users</h1>
        <ul>
            <?php if (isset($all_users)):
                foreach ($all_users as $key => $value): ?>
                    <li class="bg-white mt-7 rounded-xl p-6 flex items-center gap-10">
                        <div class="h-28 w-28 border rounded-full">
                            <?php echo '<img src="../USER/USER_IMAGES/' . $object_database->all_users[$key]['user_image'] . '" alt=""
                                class="h-full w-full object-fit rounded-full">'; ?>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <div class="space-y-5 w-full">
                                <div class="flex justify-between">
                                    <div class="flex gap-10 w-full">
                                        <h2 class="font-bold text-2xl">
                                            <?= $object_database->all_users[$key]['user_name'] ?>
                                            (
                                            <?= $object_database->all_users[$key]['user_id'] ?>)
                                        </h2>
                                        <?php
                                        if ($object_database->all_users[$key]['user_status'] == "active") {
                                            echo '<span
                                                class="h-fit px-2 rounded-full bg-blue-200">' . $object_database->all_users[$key]['user_status'] .
                                                '</span>';
                                        } else {
                                            echo '<span
                                                class="h-fit px-2 rounded-full bg-blue-200">' . $object_database->all_users[$key]['user_status'] .
                                                '</span>';
                                        }
                                        ?>
                                    </div>
                                    <form method="post"
                                        action="INACTIVE_DELETE_USER.PHP?user_id=<?php echo $object_database->all_users[$key]['user_id'] ?>" class="">
                                        <button name=""
                                            class="bg-red-800 text-white h-10 items-center flex justify-center px-5 rounded-full">Delete</button>
                                    </form>
                                </div>
                                <div class="flex font-semi-bold text-lg divide-x">
                                    <dl class="space-y-2 pr-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Phone:</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_phone'] ?>
                                            </dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Email:</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_email'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">DOB:</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_dob'] ?>
                                            </dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Gender:</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_gender'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Address:</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_address'] ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">sequrity question</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_name'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">User Created</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_created'] ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">User modified</dt>
                                            <dd>
                                                <?= $object_database->all_users[$key]['user_modified'] ?>
                                            </dd>
                                        </div>
                                    </dl>

                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="flex items-center justify-center p-28 itelic text-gray-400">
                    <?= "No user yet"; ?>
                </div>
            <?php endif ?>
        </ul>
    </section>
</body>

</html>