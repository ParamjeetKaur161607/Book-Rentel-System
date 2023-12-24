<?php
require("ADMIN_PANEL.PHP");

$id=$_GET['id'];
$admin=$object_CRUD->getRecord('admin','id','id',$id);
$super_admin=$object_CRUD->getRecord('super_admin','id','id',$id);

if($admin==null){
    foreach ($super_admin as $key => $value) {
        $object_CRUD->getAllFields('super_admin','id',"$value[id]");
    }    
}else{
    foreach ($admin as $key => $value) {
        $object_CRUD->getAllFields('admin','id',"$value[id]");
    } 
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
    <main>
    <?php  ?>
        <section class="flex pl-80">

            <div class="w-full p-20 space-y-5">
                <h1 class="text-5xl font-bold text-center">UPDATE ADMIN</h1>
                <form action="" method="post" class="py-5 px-10 rounded-lg grid grid-cols-2 gap-8 w-full"
                    enctype="multipart/form-data">
                    <div class="flex flex-col">
                        <label for="name">Admin Name</label>
                        <input type="text" name="name" id="name"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            echo $object_CRUD->record['name'];                            
                            ?>">

                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_name ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="email">Admin Email</label>
                        <input type="text" name="email" id="email"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            echo $object_CRUD->record['email'];
                            
                            ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_email ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone">Admin Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            echo $object_CRUD->record['phone'];                            
                            ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_phone ?>
                        </span>
                    </div>
                    <div class="flex gap-10 justify-between">
                        <div class="flex flex-col flex-1">
                            <label for="gender">Admin Gender</label>
                            <select name="gender" id="gender"
                                class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">                                
                                <option value="male" <?php echo ($object_CRUD->record["gender"] === 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($object_CRUD->record["gender"] === 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="others" <?php echo ($object_CRUD->record["gender"] === 'others') ? 'selected' : ''; ?>>Others</option>
                            </select>
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_gender; ?>
                            </span>
                        </div>
                        <div class="flex flex-col flex-1">
                            <label for="dob">Admin's DOB</label>
                            <input type="date" name="dob" id="dob"
                                class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_CRUD->record["dob"];?>">
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_dob; ?>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col col-span-2">
                        <label for="address">Admin Address</label>
                        <textarea name="address" id="" cols="30" rows="1"
                            class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php
                            echo $object_CRUD->record['address'];                            
                            ?>

                        </textarea>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_address; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="old_password">Password</label>
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
                            <?php echo $object_validation->error_password ?>
                        </span>
                    </div>
                    <div class="flex flex-col justify-end col-span-2">
                        <div class="flex justify-between border-b border-gray-500">
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="outline-none bg-grayy-200 h-10">
                            <?php
                            echo $object_CRUD->record['profile_picture'];
                            
                            ?>
                        </div>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_profile_picture ?>
                        </span>
                    </div>
                    <?php if (isset($_SESSION['admin_login'])): ?>
                        <div class="flex flex-col col-span-2">
                            <button type="submit" name="update_admin"
                                class="outline-none bg-green-400 rounded-lg p-3">Update</button>
                        </div>
                    <?php else: ?>
                        <div class="flex flex-col col-span-2">
                            <button type="submit" name="update_super_admin"
                                class="outline-none bg-green-400 rounded-lg p-3">Update</button>
                        </div>
                    <?php endif; ?>

                </form>
                <?php if(isset($_SESSION['admin_login'])):?>
                <form action="" method="post" class="pr-10 flex justify-end">
                    <button name="delete_admin_self" class="bg-red-800 text-white px-5 py-1 rounded-md">Delete Account</button>
                </form>
                <?php endif;?>
            </div>

        </section>
        <?php ?>
    </main>
</body>

</html>