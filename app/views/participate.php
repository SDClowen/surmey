<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js" integrity="sha512-nIwdJlD5/vHj23CbO2iHCXtsqzdTTx3e3uAmpTm4x2Y8xCIFyWu4cSIV8GaGe2UNVq86/1h9EgUZy7tn243qdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?= acss("surmey") ?>
    <?= njs("jquery/dist/jquery.min") ?>
    <?= njs("sdeasy/sdeasy") ?>
    <?= ajs("app") ?>
</head>
<body class="bg-slate-200 text-slate-900 dark:bg-slate-900 dark:text-slate-50">
    <div class="mt-5 shadow-sm w-6/12 text-center mx-auto p-6 bg-white border text-gray-900 rounded-md dark:border-slate-600 dark:bg-slate-700 dark:text-gray-50">
        
        Hello this is <?=$survey->title ?><br>
        <span class="font-bold">The survey token is <?=$survey->token?></span>
        <div class="border-t border-slate-200 dark:border-slate-600 my-4"></div>
        <button class="bg-blue-600 rounded-md text-white p-2 text-sm">Participate</button>

    </div>
</body>
</html>