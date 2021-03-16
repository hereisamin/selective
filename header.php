<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="Resources/Css/app.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Resources/Images/logo.png">
    <title>Green City</title>
</head>
<body>
<div class="bg-blue-100 h-auto flex w-full justify-center">
    <div class="bg-green-50 h-full shadow-xl w-full max-w-5xl">
        <div class="w-full flex justify-between bg-green-700 h-14 rounded-md shadow-xl py-2">
            <img src="Resources/Images/logo.png" class="px-6"/>
            <div class="text-xl font-bold text-white py-2">Green City Recycling</div>
            <div v-if="canLogin" class=" top-0 right-0 px-6 py-2 text-right">
                <div class="text-lg font-bold text-white">
                    <?php
                    if ($login){
                        echo '<a class="text-red-200 hover:text-red-300 border-b-2 border-red-200 cursor-pointer" href="index.php">Home</a>';
                        echo '&nbsp;&nbsp; | &nbsp;&nbsp;';
                        echo '<a class="text-red-200 hover:text-red-300 border-b-2 border-red-200 cursor-pointer" href="dashboard.php">Dashboard</a>';
                        echo '&nbsp;&nbsp; | &nbsp;&nbsp;';
                        echo '<a class="text-red-200 hover:text-red-300 border-b-2 border-red-200 cursor-pointer" href="logout.php">Logout</a>';
                    }else{
                        echo '<a class="text-red-200 hover:text-red-300 border-b-2 border-red-200 cursor-pointer" href="login.php">Login</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
