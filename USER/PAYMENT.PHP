<?php 
include("USER_MENU.PHP");
if (!isset($_SESSION['login'])) {
    header("Location: LOGIN.PHP");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">
    <main class="flex items-center justify-center h-screen">
        <div class="flex flex-col gap-10 items-center">
            <svg class="w-36 h-36" fill="green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>
            <h2 class="font-bold text-4xl">Payment Successfull</h2>
            <h3 class="text-xl">Thank you for your order.</h3>
            <a href="INDEX.PHP" class="text-blue-500 font-bold underline">Continue Shopping-></a>
        </div>
    </main>
</body>
</html>