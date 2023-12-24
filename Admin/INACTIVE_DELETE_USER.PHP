<?php
require("ADMIN_PANEL.PHP");
$id=$_GET['user_id'];
$userStatus=$object_CRUD->getRecord('user_registration','status','id',$id);

if (isset($_POST['user_delete'])) {
    $pending_returns=$object_CRUD->getRecord('return_order','sku','user_id',$_GET['user_id']);
    if(empty($pending_returns)){
        $object_CRUD->deleteRecord('validate_return_date', 'user_id', $_GET['user_id']);
        $object_CRUD->deleteRecord('cart', 'id', $_GET['user_id']);
        $object_CRUD->deleteRecord('user_registration', 'id', $_GET['user_id']);
        unset($_SESSION['login']);
        header('location: USER.PHP');
    } else {
        header('location: USER_DELETE_ALERT.PHP');
    }
}

if(isset($_POST['status'])){
    if($userStatus[0]['status']!="INACTIVE"){
        $object_CRUD->updateRecord('user_registration', ['status'=>'INACTIVE'],'id', $id);
        // $object_database->update_user_status("INACTIVE",$object_database->row['user_email']);
        header("location:USER.PHP");
    }else{
        $object_CRUD->updateRecord('user_registration', ['status'=>'ACTIVE'],'id', $id);

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
                        if($userStatus[0]['status']!="INACTIVE"){
                            echo "INACTIVE";
                        }else{
                            echo "ACTIVE";
                        }
                    ?>, if you to delete this acount temprarly.</li>
            </ul>
            <div class="flex gap-5 justify-end">
                <form action="" method="post">
                    <button name="status" class="bg-yellow-600 rounded-md py-2 px-5 text-white"><?php
                        if($userStatus[0]['status']!="INACTIVE"){
                            echo "INACTIVE";
                        }else{
                            echo "ACTIVE";
                        }
                    ?></button>
                </form>
                <form action="" method="post">
                    <button name="user_delete" class="bg-red-800 rounded-md py-2 px-5 text-white">DELETE</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>