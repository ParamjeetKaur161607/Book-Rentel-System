<?php
require("ADMIN_PANEL.PHP");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searching</title>
</head>
<body>
        <main class="pl-80">
        <?php if(isset($sku)):?>
            <ul class="p-10">
            <?php
            foreach ($sku as $key => $value): 
            $object_CRUD->getJoinbook('books','books_price','sku', $value['sku']);?>
                <li class="bg-gray-100 border mt-7 rounded-xl p-6 flex items-center gap-10 text-gray-700">
                    <div class="h-28 w-24 border">
                        <?=
                            '<img src="BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                    class="h-full w-full object-fit">'
                            ?>

                    </div>
                    <div class="flex justify-between items-center w-full">
                        <div class="space-y-5">
                            <div class="flex gap-2 items-center gap-24">
                                <div class="flex gap-2 items-center">
                                    <h2 class="font-bold text-2xl">
                                        <?= $object_CRUD->row['title']; ?>
                                    </h2>
                                    <h3 class="font-bold text-lg">
                                        (
                                        <?= $object_CRUD->row['sku']; ?>)
                                    </h3>
                                </div>

                            </div>
                            <div class="flex font-semi-bold text-lg divide-x">
                                <dl class="space-y-2 pr-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Author:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['author']; ?>
                                        </dd>
                                    </div>

                                    <div class="flex gap-2">
                                        <dt class="font-bold">category:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['category']; ?>
                                        </dd>
                                    </div>

                                </dl>
                                <dl class="space-y-2 px-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">MRP:</dt>
                                        <dd>Rs.
                                            <?= $object_CRUD->row['mrp']; ?>
                                        </dd>
                                    </div>
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Per day Price:</dt>
                                        <dd>Rs.
                                            <?= $object_CRUD->row['per_day_price']; ?>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="space-y-2 px-5">
                                    <div class="flex gap-2">
                                        <dt class="font-bold">Uploaded:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['book_uploaded']; ?>
                                        </dd>
                                    </div>

                                    <div class="flex gap-2">
                                        <dt class="font-bold">Modified:</dt>
                                        <dd>
                                            <?= $object_CRUD->row['book_modified']; ?>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <strong>Quantity:
                            <?= $object_CRUD->row['quantity']; ?>
                        </strong>
                        <div class="flex flex-col gap-5 items-center">

                            <form method="post" action="UPDATE_BOOK.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" class="">
                                <button id=""
                                    class="bg-green-700 text-white h-8 items-center flex justify-center px-5 rounded-full">Update</button>
                            </form>
                            <form method="post" action="DELETE_BOOK.PHP?id=<?php echo $object_CRUD->row['sku']; ?>" class="">
                                <button name=""
                                    class="bg-red-800 text-white h-8 items-center flex justify-center px-5 rounded-full">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>            
            </ul>
        <?php elseif(isset($orders)):?>
            <ol class="list-decimal">
            <?php 
            foreach ($orders as $key => $value):  
                $object_CRUD->getAllFields('orders','sku', $value['sku']);                
                $emails=$object_CRUD->getRecord('user_registration','email','id',$object_CRUD->record['user_id']); 
                          
                ?>

                <li class="bg-white mt-7 rounded-xl p-6 flex gap-10">
                    <div class="h-28 w-28 border">
                        <?=
                            '<img src="BOOKS_IMAGES/' . $object_CRUD->record['book_cover_image'] . '" alt=""
                            class="h-full w-full object-fit">'
                        ?>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="space-y-3 w-full">
                            <div class="flex justify-between">
                                <div class="flex gap-2 items-center">
                                    <h2 class="font-bold text-2xl"><?= $object_CRUD->record['customer_name']; ?></h2>
                                    <h3 class="text-sm">#<?= $object_CRUD->record['order_id']; ?></h3>
                                    <p>(Rs. <?= $object_CRUD->record['payment']; ?>)</p>
                                </div>
                                <div class="space-x-3 flex gap-3 items-center">
                                    <a href="tel:<?php $object_CRUD->record['customer_phone']; ?>"
                                        class="underline"><?=$object_CRUD->record['customer_phone']; ?></a>
                                        <?php foreach($emails as $key => $values):?>
                                    <a href="mailto:<?php $emails[0]['email'] ?>"
                                        class="underline"><?= $values['email']; ?></a>  
                                        <?php  endforeach;?>                                      
                                    <p class="bg-blue-100 px-2 rounded-lg font-bold"><?= $object_CRUD->record['user_id']; ?></p>
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <ul class="font-semi-bold text-lg">
                                    <li><b>Quantity: </b> 1</li>
                                    <li><b>SKU: </b><?=$object_CRUD->record['sku']; ?></li>

                                </ul>
                                <ul class="font-semi-bold text-lg">
                                <li><b>Title: </b><?=$object_CRUD->record['book_title']; ?></li>
                                    <li><b>Author: </b><?=$object_CRUD->record['book_author']; ?></li>

                                </ul>
                                <ul>
                                    <li><b>Order Date: </b><?= $object_CRUD->record['order_date']; ?></li>
                                    <li><b>Return Date: </b><?= $object_CRUD->record['return_date']; ?></li>
                                </ul>
                                <ul>
                                    <li><b>Address: </b><?= $object_CRUD->record['customer_address']; ?></li>
                                </ul>
                            </div>
                        </div>


                    </div>


                </li>
            <?php endforeach; ?>

            </ol>
        <?php elseif(isset($user)):?>
            <ul class="p-20">
                <?php foreach ($user as $key => $value):
                 $object_CRUD->getAllFields('user_registration','id',$value['id']);
                    ?>
                    <li class="bg-gray-100 mt-7 rounded-xl p-6 flex items-center gap-10 border">
                        <div class="h-28 w-28 rounded-full">                            
                            <?php
                                if($object_CRUD->record['profile_picture']==" "):?>
                                    <svg class="h-24 w-24 rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" aria-hidden="true">
                                    <path d="M12 22.01c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10z" opacity=".4"></path>
                                    <path d="M12 6.94c-2.07 0-3.75 1.68-3.75 3.75 0 2.03 1.59 3.68 3.7 3.74h.18a3.743 3.743 0 003.62-3.74c0-2.07-1.68-3.75-3.75-3.75zM18.78 19.36A9.976 9.976 0 0112 22.01c-2.62 0-5-1.01-6.78-2.65.24-.91.89-1.74 1.84-2.38 2.73-1.82 7.17-1.82 9.88 0 .96.64 1.6 1.47 1.84 2.38z"></path>
                                  </svg>                                   
                                <?php else:
                                    echo '<img src="../USER/USER_IMAGES/' . $object_CRUD->record['profile_picture'] . '" alt=""
                        class="h-full w-full object-fit rounded-full border">'?>
                                <?php endif; ?>
                            
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <div class="space-y-5 w-full">
                                <div class="flex justify-between">
                                    <div class="flex gap-10 w-full">
                                        <h2 class="font-bold text-2xl">
                                            <?= $object_CRUD->record['name'] ?>
                                            (
                                            <?= $object_CRUD->record['id'] ?>)
                                        </h2>
                                        <?php
                                        if ($object_CRUD->record['status'] == "active") {
                                            echo '<span
                                                class="h-fit px-2 rounded-full bg-blue-200">' . $object_CRUD->record['status'] .
                                                '</span>';
                                        } else {
                                            echo '<span
                                                class="h-fit px-2 rounded-full bg-blue-200">' . $object_CRUD->record['status'] .
                                                '</span>';
                                        }
                                        ?>
                                    </div>
                                    <form method="post"
                                        action="INACTIVE_DELETE_USER.PHP?user_id=<?php echo $object_CRUD->record['id'] ?>" class="">
                                        <button name=""
                                            class="bg-red-800 text-white h-10 items-center flex justify-center px-5 rounded-full">Delete</button>
                                    </form>
                                </div>
                                <div class="flex font-semi-bold text-lg divide-x">
                                    <dl class="space-y-2 pr-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Phone:</dt>
                                            <dd>
                                                <?= $object_CRUD->record['phone'] ?>
                                            </dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Email:</dt>
                                            <dd>
                                                <?= $object_CRUD->record['email'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">DOB:</dt>
                                            <dd>
                                                <?= $object_CRUD->record['dob'] ?>
                                            </dd>
                                        </div>
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Gender:</dt>
                                            <dd>
                                                <?= $object_CRUD->record['gender'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">Address:</dt>
                                            <dd>
                                                <?= $object_CRUD->record['address'] ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">sequrity question</dt>
                                            <dd>
                                                <?= $object_CRUD->record['security_question'] ?>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="space-y-2 px-5">
                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">User Created</dt>
                                            <dd>
                                                <?= $object_CRUD->record['registration_date'] ?>
                                            </dd>
                                        </div>

                                        <div class="flex gap-2">
                                            <dt class="font-bold text-gray-500">User modified</dt>
                                            <dd>
                                                <?= $object_CRUD->record['modified_date'] ?>
                                            </dd>
                                        </div>
                                    </dl>

                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>            
            </ul>
        <?php elseif(isset($rented)):?>
            <ol class="p-10">
            <?php foreach ($rented as $key => $value):
                $object_CRUD->getJoinOrders('books','orders','return_order','sku','sku',"$value[sku]");
                $emails=$object_CRUD->getRecord('user_registration','email','id',$object_CRUD->row['user_id']);
                ?>
                <li class="bg-gray-100 mt-7 rounded-xl p-6 flex gap-10 border">
                    <div class="h-28 w-28 border">
                        <?=
                            '<img src="BOOKS_IMAGES/' . $object_CRUD->row['cover_image'] . '" alt=""
                        class="h-full w-full object-fit">'
                            ?>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="space-y-3 w-full">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="font-bold text-2xl"><?=$object_CRUD->row['sku'];?></h2>
                                    <div class="flex gap-1 items-center">
                                        <h3>#<?=$object_CRUD->row['order_id'];?></h3>
                                        <p>(Rs.<?=$object_CRUD->row['payment'];?>)</p>
                                    </div>
                                </div>
                                <div class="space-x-3">
                                    <a href="tel:<?$object_CRUD->row['customer_phone'];?>" class="underline"><?=$object_CRUD->row['customer_phone'];?></a>
                                    <?php foreach($emails as $key => $values):?>
                                    <a href="mailto:<?php $emails[0]['email'] ?>"
                                        class="underline"><?= $values['email']; ?></a>  
                                    <?php  endforeach;?> 
                                    <span class="bg-blue-200 px-2 py-1 rounded-full">(<?=$object_CRUD->row['user_id'];?>)</span>                         
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <ul class="font-semi-bold text-lg flex justify-between w-full">
                                    <li>Cutomer: <?=$object_CRUD->row['customer_name'];?></li>
                                    <li>Book Title: <?=$object_CRUD->row['title'];?></li>
                                    <li>Book Author: <?=$object_CRUD->row['author'];?></li>
                                    <li>Order Date: <?=$object_CRUD->row['order_date'];?></li>
                                    <li>Return Date: <?=$object_CRUD->row['return_date'];?></li>
                                    <li>Fine: 
                                        <span class="bg-red-600 p-1 text-white rounded-md">Rs. 
                                            <?php if(isset($object_CRUD->row['Fine'])){
                                                echo $object_CRUD->row['Fine'];
                                            } else {
                                                echo "0";
                                            }
                                            ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>


                </li>
            <?php endforeach; ?>
        </ol>
        <?php else:?>
            <div class="flex items-center justify-center p-20 text-gray-400">
                <?php echo $object_validation->search;?>
            </div>        
        <?php endif;?>
        </main>        
</body>
</html>