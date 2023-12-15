<?php
require("ADMIN_PANEL.PHP");
$id=$_GET['user_id'];
$object_database->users_status($id);
$active="ACTIVE";
$inactive="INACTIVE";
if(isset($_POST['delete_user'])){
    $object_database->delete_user($id,$object_database->row['user_email']);
    header("location:USER.PHP");}

if(isset($_POST['user'])){
    if($object_database->row['user_status']!="INACTIVE"){
        $object_database->update_user_status("INACTIVE",$object_database->row['user_email']);
        header("location:USER.PHP");
    }else{
        $object_database->update_user_status("ACTIVE",$object_database->row['user_email']);
        header("location:USER.PHP");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <main class="flex justify-center pt-40 h-screen w-full bg-black/40 pl-80">
        <div class="bg-gray-100 space-y-5 h-fit p-10">            
            <div class="flex gap-5 items-center">
                <svg class="w-10 h-10 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1" viewBox="0 0 16 16" fill="currentColor">
                    <path fill="red"
                        d="M8 1l-8 14h16l-8-14zM8 13c-0.6 0-1-0.4-1-1s0.4-1 1-1 1 0.4 1 1c0 0.6-0.4 1-1 1zM7 10v-4h2v4h-2z">
                    </path>
                </svg>
                <h2 class="font-bold text-xl">Are you sure to delete this user(
                    <?= $id ?>)!
                </h2>
            </div>
            <ul class="list-disc">
                <li>Click DELETE, if you want to delete parmanelty to this user.</li>
                <li>Click <?php
                        if($object_database->row['user_status']!="INACTIVE"){
                            echo "INACTIVE";
                        }else{
                            echo "ACTIVE";
                        }
                    ?>, if you to delete this acount temprarly.</li>
            </ul>
            <div class="flex gap-5 justify-end">
                <form action="" method="post">
                    <button name="user" class="bg-yellow-600 rounded-md py-2 px-5 text-white"><?php
                        if($object_database->row['user_status']!="INACTIVE"){
                            echo "INACTIVE";
                        }else{
                            echo "ACTIVE";
                        }
                    ?></button>
                </form>
                <form action="" method="post">
                    <button name="delete_user" class="bg-red-800 rounded-md py-2 px-5 text-white">DELETE</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>