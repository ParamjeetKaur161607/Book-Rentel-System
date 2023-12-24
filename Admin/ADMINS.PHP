<?php 
require("ADMIN_PANEL.PHP");
if (isset($_POST['delete_admin'])) {
    $object_CRUD->deleteRecord('admin','id',"$_GET[admin_id]");
    // $object_database->delete_admin($_GET['admin_id']);      
    header("location: ADMINS.PHP");                                      
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body clas="p-20">
    <main class="pl-80">
        <section class="p-10">
            <div class="flex justify-between">
                <h2 class="text-3xl font-semi-bold">All Admins</h2>
                <a href="ADMIN_REGISTER.PHP" name="add_category"
                        class="bg-blue-400 text-white h-10 items-center flex justify-center px-5 rounded-lg">+ ADD ADMIN</a>
            </div>
            <ul>
                <?php $all_admins=$object_CRUD->getRecords('admin');
                if (isset($all_admins)):
                    foreach ($all_admins as $key => $value): ?>
                        <li class="bg-gray-100 border mt-7 rounded-xl p-6 flex items-center gap-10 text-gray-700">
                            <div class="h-24 w-24 rounded-full">                                
                                <?php
                                if($all_admins[$key]['profile_picture']==" "):?>
                                    <svg class="h-24 w-24 rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" aria-hidden="true">
                                    <path d="M12 22.01c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10z" opacity=".4"></path>
                                    <path d="M12 6.94c-2.07 0-3.75 1.68-3.75 3.75 0 2.03 1.59 3.68 3.7 3.74h.18a3.743 3.743 0 003.62-3.74c0-2.07-1.68-3.75-3.75-3.75zM18.78 19.36A9.976 9.976 0 0112 22.01c-2.62 0-5-1.01-6.78-2.65.24-.91.89-1.74 1.84-2.38 2.73-1.82 7.17-1.82 9.88 0 .96.64 1.6 1.47 1.84 2.38z"></path>
                                  </svg>                                   
                                <?php else:
                                    echo '<img src="ADMINS_PROFILE_PICS/' . $value['profile_picture'] . '" alt=""
                        class="h-full w-full object-fit rounded-full">'?>
                                <?php endif; ?>

                            </div>
                            <div class="flex justify-between items-center w-full">
                                <div class="space-y-5">
                                    <div class="flex gap-2 items-center">
                                        <h2 class="font-bold text-2xl">
                                            <?= $value['name']; ?>
                                        </h2>
                                        <h3 class="font-bold text-lg">
                                            (
                                            <?= $value['id']; ?>)
                                        </h3>
                                    </div>
                                    <div class="flex font-semi-bold text-lg divide-x">
                                        <dl class="space-y-2 pr-5">
                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin email:</dt>
                                                <dd>
                                                    <?= $value['email']; ?>
                                                </dd>
                                            </div>

                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin Phone:</dt>
                                                <dd>
                                                    <?= $value['phone']; ?>
                                                </dd>
                                            </div>

                                        </dl>
                                        <dl class="space-y-2 px-5">
                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin gender:</dt>
                                                <dd>
                                                    <?= $value['gender']; ?>
                                                </dd>
                                            </div>
                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin dob</dt>
                                                <dd>
                                                    <?= $value['dob']; ?>
                                                </dd>
                                            </div>
                                        </dl>
                                        <dl class="space-y-2 px-5">
                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin Created:</dt>
                                                <dd>
                                                    <?= $value['admin_created']; ?>
                                                </dd>
                                            </div>

                                            <div class="flex gap-2">
                                                <dt class="font-bold">Admin Modified:</dt>
                                                <dd>
                                                    <?= $value['admin_modified']; ?>
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                                <div class="flex gap-5">
                                    <!-- <form method="post"
                                        action="ADMIN_UPDATE.PHP?id=<?php echo $value['id']; ?>" class="">
                                        <button id=""
                                            class="bg-green-700 text-white h-10 items-center flex justify-center px-5 rounded-full">Update</button>
                                    </form> -->
                                    <form method="post"
                                        action="ADMINS.PHP?id=<?php echo $value['id']; ?>" class="">
                                        <button name="delete_admin"
                                            class="bg-red-800 text-white h-10 items-center flex justify-center px-5 rounded-full">Delete</button>
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
    </main>
</body>

</html>