<?php 
include("USER_MENU.PHP");
if (isset($_POST['register_user'])) {
    $object_validation->is_name_valid();
    $object_validation->is_dob_valid();
    $object_validation->is_gender_valid();
    $object_validation->is_email_valid();
    $object_validation->is_phone_valid();
    $object_validation->is_address_valid();
    $object_validation->is_security_question_valid();
    $object_validation->is_password_valid();
    $object_validation->is_card_number_valid();
    $object_validation->is_name_on_card_valid();
    $object_validation->is_cvv_valid();
    $object_validation->is_expiry_date_valid();
    $errorVariables = [
        $object_validation->error_name,
        $object_validation->error_dob,
        $object_validation->error_gender,
        $object_validation->error_email,
        $object_validation->error_phone,
        $object_validation->error_address,
        $object_validation->error_card_number,
        $object_validation->error_name_on_card,
        $object_validation->error_cvv,
        $object_validation->error_security_question,
        $object_validation->error_password,
        $object_validation->error_card_expiry_month,
        $object_validation->error_card_expiry_year,
    ];
    if ($object_validation->is_array_empty($errorVariables)) {
        $encrypted_password = password_hash($object_validation->password, PASSWORD_DEFAULT);
        $data_to_insert_in_user_reg = array(
            "user_id" => $object_database->unique_id(),
            "user_email" => "$object_validation->email",
            "user_phone" => "$object_validation->phone",
            "user_name" => "$object_validation->name",
            "user_gender" => "$object_validation->gender",
            "user_dob" => "$object_validation->dob",
            "user_address" => "$object_validation->address",
            "card_number" => "$object_validation->card_number",
            "name_on_card" => "$object_validation->name_on_card",
            "cvv" => "$object_validation->cvv",
            "expiry_month" => "$object_validation->card_expiry_month",
            "expiry_year" => "$object_validation->card_expiry_year",
            "user_security_question" => "$object_validation->security_question",
            "user_password" => "$encrypted_password",
            "user_status" => "ACTIVE",
            "user_created" => $object_database->current_date(),
            "user_modified" => $object_database->current_date()
        );
        if ($object_validation->profile_picture["name"] != "") {
            $object_validation->is_profile_picture_valid();
            if (!strlen($object_validation->error_profile_picture)) {
                if (move_uploaded_file($object_validation->profile_picture["tmp_name"], $object_validation->profile_picture_path)) {
                    $data_to_insert_in_user_file = array(
                        "user_email" => "$object_validation->email",
                        "user_image" => "$object_validation->profile_picture_name",
                        "user_image_path" => "$object_validation->profile_picture_path",
                        "user_image_uniqe_id" => $object_database->unique_id()
                    );
                    $object_database->insert_to_user_reg("user_reg", $data_to_insert_in_user_reg);
                    $object_database->insert_to_user_file("user_fle", $data_to_insert_in_user_file);
                    header('Location: LOGIN.PHP');
                } else {
                    $object_validation->error_file = "file location error";
                }
            }
        } else {
            $object_database->insert_to_user_reg("user_reg", $data_to_insert_in_user_reg);
            $data_to_insert_in_user_file = array(
                "user_email" => "$object_validation->email"
            );
            $data_to_insert_in_user_file = array(
                "user_email" => "$object_validation->email",
            );
            $object_database->insert_to_user_file("user_fle", $data_to_insert_in_user_file);
            header('Location: LOGIN.PHP');
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
        <section class="flex">
            <div class="bg-black bg-[url('../IMAGES/STORE.jpeg')] bg-center h-screen w-1/3 py-10 pl-10">
                
            </div>
            <div class="w-full p-10 space-y-5">
                <h1 class="text-5xl font-bold text-center">REGISTER NOW</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="py-5 px-10 rounded-lg grid grid-cols-2 gap-8 w-full" enctype="multipart/form-data">                    
                    <div class="flex flex-col">
                        <label for="name">Username</label>
                        <input type="text" name="name" id="name" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->name ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_name ?></span>
                    </div>
                    <div class="flex flex-col">
                        <label for="email">User Email</label>
                        <input type="text" name="email" id="email" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->email ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_email ?></span>
                    </div>
                    <div class="flex flex-col">
                        <label for="phone">User Phone</label>
                        <input type="text" name="phone" id="phone" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->phone ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_phone ?></span>
                    </div>
                    <div class="flex gap-10 justify-between">
                    <div class="flex flex-col flex-1">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500">                                
                                <option value="none" selected disabled hidden>Select your age</option>
                                <option value="male"<?php if(isset($_POST['gender']) && $_POST['gender'] == 'male') echo ' selected'; ?>>Male</option>
                                <option value="female"<?php if(isset($_POST['gender']) && $_POST['gender'] == 'female') echo ' selected'; ?>>Female</option>
                                <option value="others"<?php if(isset($_POST['gender']) && $_POST['gender'] == 'others') echo ' selected'; ?>>Others</option>
                            </select>
                            <span class="text-red-500 text-sm"><?php echo $object_validation->error_gender; ?></span>
                        </div>
                    <div class="flex flex-col flex-1">
                        <label for="dob">DOB<?PHP var_dump(empty($object_validation->dob)); ?></label>
                        <input type="date" name="dob" id="dob" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->dob ?>" >
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_dob; ?></span>
                    </div>
                    </div>
                    
                    <div class="flex flex-col col-span-2">
                        <label for="address">Address</label>
                        <textarea name="address" id="" cols="30" rows="1" class="outline-none pb-4 border-b border-gray-500 text-gray-500"><?php echo $object_validation->address ?></textarea>
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_address; ?></span>
                    </div>
                    <div class="flex flex-col">
                        <label for="card_number">Credit/Debit Card Number</label>
                        <input type="text" name="card_number" id="card_number" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->card_number ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_card_number; ?></span>
                    </div>
                    <div class="flex flex-col">
                        <label for="name_on_card">Name on Credit/Debit Card</label>
                        <input type="text" name="name_on_card" id="name_on_card" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->name_on_card ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_name_on_card; ?></span>
                    </div>
                    <div class="flex justify-between gap-5 pr-10">
                        <div class="flex flex-col ">
                            <label for="cvv">CVV</label>                           
                            <input type="password" name="cvv" id="cvv" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->cvv ?>">
                            <span class="text-red-500 text-sm"><?php echo $object_validation->error_cvv; ?></span>
                        </div>
                        <div class="flex flex-col">
                            <label for="month">Month</label>
                            <input type="number" name="month" id="month" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->card_expiry_month ?>">
                            <span class="text-red-500 text-sm"><?php echo $object_validation->error_card_expiry_month; ?></span>
                        </div>
                        <div class="flex flex-col">
                            <label for="year">Year</label>
                            <input type="number" name="year" id="year" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->card_expiry_year ?>">
                            <span class="text-red-500 text-sm"><?php echo $object_validation->error_card_expiry_year; ?></span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="user_security">Your favourite author?</label>
                        <input type="password" name="user_security" id="user_security" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->security_question ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_security_question; ?></span>
                    </div>
                    <div class="flex flex-col">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="outline-none border-b border-gray-500 bg-grayy-200 h-10 text-gray-500" value="<?php echo $object_validation->password ?>">
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_password ?></span>
                    </div>
                    <div class="flex flex-col justify-center">                        
                        <div class="flex justify-between">
                            <input type="file" name="profile_picture" id="profile_picture" class="outline-none bg-grayy-200 h-10 border-b border-gray-500">
                            <?php
                            if (isset($_FILES['profile_picture'])) {
                                $fileName = $_FILES['profile_picture']['name'];
                                echo $fileName;
                            }
                            ?>
                        </div>
                        <span class="text-red-500 text-sm"><?php echo $object_validation->error_profile_picture; ?></span>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <button type="submit" name="register_user" class="outline-none bg-green-400 rounded-lg p-3">Register</button>
                    </div>
                </form>
                <a href="LOGIN.PHP" class="text-blue-600 underline p-10">Login if you already have an account.</a>
            </div>

        </section>
    </main>
</body>

</html>