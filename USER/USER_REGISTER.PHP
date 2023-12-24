<?php
include("USER_MENU.PHP");
if (isset($_POST['register_user'])) {
    $object_validation->is_email_valid();
    $object_validation->is_user_email_exists();
    $object_validation->is_phone_valid();
    $object_validation-> is_user_phone_exist();
    $object_validation->is_name_valid();
    $object_validation->is_gender_valid();
    $object_validation->is_dob_valid();
    $object_validation->is_address_valid();
    $object_validation->is_security_question_valid();
    $object_validation->is_password_valid();
    $errorVariables = [
        $object_validation->error_name,
        $object_validation->error_dob,
        $object_validation->error_gender,
        $object_validation->error_email,
        $object_validation->error_phone,
        $object_validation->error_address,
        $object_validation->error_security_question,
        $object_validation->error_password,
    ];
    if ($object_validation->is_array_empty($errorVariables)) {
        $encrypted_password = password_hash($object_validation->password, PASSWORD_DEFAULT);
        if ($_FILES['profile_picture']['name'] != "") {
            $object_validation->is_profile_picture_valid();

            if (!strlen($object_validation->error_profile_picture) && move_uploaded_file($object_validation->profile_picture["tmp_name"], $object_validation->profile_picture_path)) {

                $pp_name = $object_validation->profile_picture_name;

            } else {
                $object_validation->error_file = "file location error";
            }

        } else {
            $pp_name = " ";
        }

        $insert_data = array(
            "id" => $object_CRUD->unique_id(),
            "email" => "$object_validation->email",
            "phone" => "$object_validation->phone",
            "name" => "$object_validation->name",
            "gender" => "$object_validation->gender",
            "dob" => "$object_validation->dob",
            "address" => "$object_validation->address",
            "security_question" => "$object_validation->security_question",
            "password" => "$encrypted_password",
            "status" => "ACTIVE",
            "registration_date" => $object_CRUD->current_date(),
            "modified_date" => $object_CRUD->current_date(),
            "profile_picture" => "$pp_name"
        );

        $object_CRUD->insertRecord("user_registration", $insert_data);

        header('Location: LOGIN.PHP');
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
        <section class="flex">
            <div class="bg-black bg-[url('../IMAGES/STORE.jpeg')] bg-center h-screen w-1/3 py-10 pl-10">

            </div>
            <div class="w-full p-10 space-y-5">
                <h1 class="text-5xl font-bold text-center">REGISTER NOW</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    class="py-5 px-10 rounded-lg grid grid-cols-2 gap-8 w-full" enctype="multipart/form-data">
                    <div class="flex flex-col">
                        <label for="name">Username</label>
                        <input type="text" name="name" id="name"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_validation->name ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_name ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="email">User Email</label>
                        <input type="text" name="email" id="email"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_validation->email ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_email ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone">User Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_validation->phone ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_phone ?>
                        </span>
                    </div>
                    <div class="flex gap-10 justify-between">
                        <div class="flex flex-col flex-1">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender"
                                class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">
                                <option value="none" selected disabled hidden>Select your age</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_gender; ?>
                            </span>
                        </div>
                        <div class="flex flex-col flex-1">
                            <label for="dob">DOB</label>
                            <input type="date" name="dob" id="dob"
                                class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="">
                            <span class="text-red-500 text-sm">
                                <?php echo $object_validation->error_dob; ?>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col col-span-2">
                        <label for="address">Address</label>
                        <textarea name="address" id="" cols="30" rows="1"
                            class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php echo $object_validation->address ?></textarea>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_address; ?>
                        </span>
                    </div>                    
                    <div class="flex flex-col">
                        <label for="user_security">Your favourite author?</label>
                        <input type="password" name="user_security" id="user_security"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_validation->security_question ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_security_question; ?>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500"
                            value="<?php echo $object_validation->password ?>">
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_password ?>
                        </span>
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="flex justify-between">
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="outline-none bg-grayy-200 h-10 border-b border-gray-500">
                            <?php
                            if (isset($_FILES['profile_picture'])) {
                                $fileName = $_FILES['profile_picture']['name'];
                                echo $fileName;
                            }
                            ?>
                        </div>
                        <span class="text-red-500 text-sm">
                            <?php echo $object_validation->error_profile_picture; ?>
                        </span>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <button type="submit" name="register_user"
                            class="outline-none bg-green-400 rounded-lg p-3">Register</button>
                    </div>
                </form>
                <a href="LOGIN.PHP" class="text-blue-600 underline p-10">Login if you already have an account.</a>
            </div>

        </section>
    </main>
</body>

</html>