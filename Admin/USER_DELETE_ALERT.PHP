<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete user</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <main class="flex justify-center items-center h-screen w-full bg-black/20 ">
        <div class="bg-gray-100 space-y-5 h-fit p-10">
            <div class="flex gap-5 items-center">
                <svg class="w-10 h-10 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1" viewBox="0 0 16 16" fill="currentColor">
                    <path fill="red"
                        d="M8 1l-8 14h16l-8-14zM8 13c-0.6 0-1-0.4-1-1s0.4-1 1-1 1 0.4 1 1c0 0.6-0.4 1-1 1zM7 10v-4h2v4h-2z">
                    </path>
                </svg>
                <h2 class="font-bold text-xl">Error: Unable to delete user. A return is pending for this account.</h2>
            </div>
            <div class="flex gap-5 justify-end">
                <a href="USER.PHP" class="bg-green-700 rounded-md py-2 px-5 text-white">OK</a>                
            </div>
        </div>
    </main>
</body>

</html>