<!-- <?php

$request=$_SERVER['REQUEST_URI'];
$router=str_replace('BOOK-RENTEL-SYSTEM/Admin','',$request);

if($router=='/'){
    require 'ADMIN_LOGIN.PHP';
}else if($router=='/ADD_BOOK'){
    require 'ADD_BOOK.PHP';
}
else if($router=='/ADMIN_REGISTER'){
    require 'ADMIN_REGISTER.PHP';
}
else if($router=='/ADMIN_UPDATE'){
    require 'ADMIN_UPDATE.PHP';
}
else if($router=='/ADMINS'){
    require 'ADMINS.PHP';
}
else if($router=='/ALL_BOOKS'){
    require 'ALL_BOOK.PHP';
}
else if($router=='/BOOK_CATEGORY'){
    require 'BOOK_CATEGORY.PHP';
}
else if($router=='/CATEGORY'){
    require 'CATEGORY.PHP';
}
else if($router=='/DELETE_BOOK'){
    require 'DELETE_BOOK.PHP';
}else if($router=='/DELETE_CATEGORY'){
    require 'DELETE_CATEGORY.PHP';
}else{

}


// $routes=[
//     '$routes==/'=>'ADMIN_login.PHP',
//     '/ADD_BOOK'=>'ADD_BOOK.PHP',
//     '/ADMIN_LOGIN'=>'ADMIN_LOGIN.PHP',
//     '/ADMIN_REGISTER'=>'ADMIN_REGISTER.PHP',
//     '/ADMIN_UPDATE'=>'ADMIN_UPDATE.PHP',
//     '/ADMINS'=>'ADMINS.PHP',
//     '/ALL_BOOKS'=>'ALL_BOOK.PHP',
//     '/BOOK_CATEGORY'=>'ADMINS',
//     '/CATEGORY'=>'CATEGORY.PHP',
//     '/DELETE_BOOK'=>'DELETE_BOOK.PHP',
//     '/DELETE_CATEGORY'=>'DELETE_CATEGORY.PHP',
//     '/INACTIVE_DELETE_USER'=>'INACTIVE_DELETE_USER.PHP',
//     '/ORDER'=>'ORDER.PHP',
//     '/RENTED_BOOK'=>'RENTED_BOOK.PHP',
//     '/UPDATE_BOOK'=>'UPDATE_BOOK.PHP',
//     '/USER'=>'USER.PHP',
//     '/router'=>'router.PHP',
// ];

// function routeToController($uri,$routes){
//     if(array_key_exists($uri,$routes)){

//         require $routes[$uri];
//     }else{
//         // print_r($uri);
//         // print_r($routes);
//         echo "page not found";
//         die();
//     }
// }

// routeToController($uri,$routes);



?> -->