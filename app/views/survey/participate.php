<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/favicon.png" sizes="16x16 32x32" type="image/png">
    <title> {$title} </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js" integrity="sha512-nIwdJlD5/vHj23CbO2iHCXtsqzdTTx3e3uAmpTm4x2Y8xCIFyWu4cSIV8GaGe2UNVq86/1h9EgUZy7tn243qdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {acss("app")|noescape}
    {njs("jquery/dist/jquery.min")|noescape}
    {njs("sdeasy/sdeasy")|noescape}
    {ajs("app")|noescape}
</head>

<body class="bg-slate-200/75 text-slate-900 dark:bg-slate-900 dark:text-slate-50">

    <div class="max-w-2xl mx-auto my-5 overflow-hidden bg-white rounded-lg dark:bg-gray-800 relative shadow-xl ring-1 ring-gray-900/5">
        <img n:if="!empty($survey->photo)" class="object-cover w-full h-64" src="/public/images/survey/{$survey->photo}" alt="Article">

        <div class="p-6">
            <a href="#" class="text-center block my-1 text-xl font-semibold text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 hover:underline" tabindex="0" role="link">{$survey->title}</a>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{$survey->about|noescape}</p>

            <div class="mt-4 hidden">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <img class="object-cover h-10 rounded-full" src="https://images.unsplash.com/photo-1586287011575-a23134f797f9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=48&q=60" alt="Avatar">
                        <a href="#" class="mx-2 font-semibold text-gray-700 dark:text-gray-200" tabindex="0" role="link">Jone Doe</a>
                    </div>
                    <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">21 SEP 2015</span>

                    <button class="bg-blue-600 ml-auto rounded-md text-white p-2 text-sm">Participate</button>
                </div>
            </div>

            <div class="msg fixed bottom-0 right-2 z-10 my-5 text-lg"></div>
            <form class="mt-4 border-t" role="form" method="post" action="/participate/apply" data-content=".msg" data-redirect = "/:2000">
                
                <div class="py-5">
                    <div class="generated-form">
                        <script>$(()=>{ window.buildForm(`{$survey->data|noescape}`) })</script>
                    </div>
                    <button class="bg-blue-600 px-5 m-auto rounded-md text-white py-2">DEVAM ET...</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>