<?php
require("ADMIN_PANEL.PHP");
$id = $_GET['admin_id'];

if (isset($_POST['delete_admin_self'])) {
    $object_database->delete_admin($_GET['admin_id']);  
    unset($_SESSION['admin_login']);    
    header("location: ADMIN_LOGIN.PHP");                                      
}

$object_database->admin($id);
$object_database->super_admin($id);
if (isset($_POST['update_admin'])) {
    $object_validation->is_name_valid();
    $object_validation->is_dob_valid();
    $object_validation->is_gender_valid();
    $object_validation->is_email_valid();
    $object_validation->is_phone_valid();
    $object_validation->is_address_valid();    
    $object_validation->is_password_valid(); 
    $errorVariables = [
        $object_validation->error_name,
        $object_validation->error_dob,
        $object_validation->error_gender,
        $object_validation->error_email,
        $object_validation->error_phone,
        $object_validation->error_address,        
        $object_validation->error_password,
    ];
    if ($object_validation->is_array_empty($errorVariables)) {        
        if ($_FILES["profile_picture"]["name"] != "") {
            $object_validation->is_admin_file_valid();
            if (!strlen($object_validation->error_profile_picture)) {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $object_validation->profile_picture_path)) {
                    $object_database->update_to_admin($id,$_POST['phone'],$_POST['name'],$_POST['gender'],$_POST['dob'],$_POST['address'],$object_database->current_date());
                    $object_database->update_admin_file($id,$object_validation->profile_picture_name);
                    header("location: ADMIN_DASHBOARD.PHP");
                } else {
                    $object_validation->error_file = "file location error";
                }
            }
        } else {
            $object_database->update_to_admin($id,$_POST['phone'],$_POST['name'],$_POST['gender'],$_POST['dob'],$_POST['address'],$object_database->current_date());
            header("location: ADMIN_DASHBOARD.PHP");
        }        
    }     
}

if (isset($_POST['update_super_admin'])) {
    $object_validation->is_name_valid();
    $object_validation->is_dob_valid();
    $object_validation->is_gender_valid();
    $object_validation->is_email_valid();
    $object_validation->is_phone_valid();
    $object_validation->is_address_valid();    
    $object_validation->is_password_valid();
    $errorVariables = [
        $object_validation->error_name,
        $object_validation->error_dob,
        $object_validation->error_gender,
        $object_validation->error_email,
        $object_validation->error_phone,
        $object_validation->error_address,        
        $object_validation->error_password,
    ];
    $date = date("Y-m-d");
    if ($object_validation->is_array_empty($errorVariables)) {        
        if ($_FILES["profile_picture"]["name"] != "") {
            $object_validation->is_admin_file_valid();
            if (!strlen($object_validation->error_profile_picture)) {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $object_validation->profile_picture_path)) {
                    if(isset($object_database->row))
                    $object_database->update_to_super_admin($id,$_POST['phone'],$_POST['name'],$_POST['gender'],$_POST['dob'],$_POST['address'],$object_database->current_date());

                    $object_database->update_super_admin_file($id,$object_validation->profile_picture_name);

                    header("location: ADMIN_DASHBOARD.PHP");
                } else {
                    $object_validation->error_file = "file location error";
                }
            }
        } else {
            $object_database->update_to_super_admin($id,$_POST['phone'],$_POST['name'],$_POST['gender'],$_POST['dob'],$_POST['address'],$object_database->current_date());
            header("location: ADMIN_DASHBOARD.PHP");
        }        
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
        <section class="flex pl-80">

            <div class="w-full p-20 space-y-5">
                <h1 class="text-5xl font-bold text-center">UPDATE ADMIN</h1>
                <form action="" method="post" class="py-5 px-10 rounded-lg grid grid-cols-2 gap-8 w-full"
                    enctype="multipart/form-data">
                    <div class="flex flex-col">
                        <label for="name">Admin Name</label>
                        <input type="text" name="name" id="admin_name"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            if (isset($object_database->row['admin_name'])) {
                                echo $object_database->row['admin_name'];
                            } else {
                                echo $object_database->row1['s_admin_name'];
                            }
                            ?>">

                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_name ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="email">Admin Email</label>
                        <input type="text" name="email" id="email"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            if (isset($object_database->row['admin_email'])) {
                                echo $object_database->row['admin_email'];
                            } else {
                                echo $object_database->row1['s_admin_email'];
                            }
                            ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_email ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone">Admin Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                            if (isset($object_database->row['admin_phone'])) {
                                echo $object_database->row['admin_phone'];
                            } else {
                                echo $object_database->row1['s_admin_phone'];
                            }
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
                                <?php
                                if (isset($object_database->row['admin_gender'])) {
                                    echo $object_database->row['admin_gender'];
                                } else {
                                    echo $object_database->row1['s_admin_gender'];
                                }
                                ?>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_gender; ?>
                            </span>
                        </div>
                        <div class="flex flex-col flex-1">
                            <label for="dob">Admin's DOB</label>
                            <input type="date" name="dob" id="dob"
                                class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php
                                if (isset($object_database->row['admin_dob'])) {
                                    echo $object_database->row['admin_dob'];
                                } else {
                                    echo $object_database->row1['s_admin_dob'];
                                }
                                ?>">
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_dob; ?>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col col-span-2">
                        <label for="address">Admin Address</label>
                        <textarea name="address" id="" cols="30" rows="1"
                            class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php
                            if (isset($object_database->row['admin_address'])) {
                                echo $object_database->row['admin_address'];
                            } else {
                                echo $object_database->row1['s_admin_address'];
                            }
                            ?>

                        </textarea>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_address; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_password ?>
                        </span>
                    </div>
                    <div class="flex flex-col justify-end">
                        <div class="flex justify-between">
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="outline-none bg-grayy-200 h-10 border-b border-gray-500">
                            <?php
                            if (isset($object_database->row['admin_image'])) {
                                echo $object_database->row['admin_image'];
                            } else {
                                echo $object_database->row1['s_admin_image'];
                            }
                            ?>
                        </div>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_profile_picture ?>
                        </span>
                    </div>
                    <?php if (isset($object_database->row['admin_id'])): ?>
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
                <?php if(isset($object_database->row['admin_id'])):?>
                <form action="" method="post" class="pr-10 flex justify-end">
                    <button name="delete_admin_self" class="bg-red-800 text-white px-5 py-1 rounded-md">Delete Account</button>
                </form>
                <?php endif;?>
            </div>

        </section>
    </main>
</body>

</html>