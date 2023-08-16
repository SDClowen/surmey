<!DOCTYPE html>
<html class="h-full" lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    {acss("app")|noescape}
    {njs("jquery/dist/jquery.min")|noescape}
    {ajs("jquery.inputmask.min")|noescape}
    {njs("sdeasy/sdeasy")|noescape}
    <script>
        $(function () {
            $(":input[name=phone]").inputmask({ "mask": "(999) 999 99 99" });
        })
    </script>
</head>

<body class="flex flex-wrap min-h-screen w-full content-center justify-center bg-gray-200 dark:bg-slate-700 dark:text-gray-200 py-10 px-3">
    <div class="flex shadow-md relative overflow-hidden rounded-xl">
        <div class="message absolute bottom-0 w-4/5 ml-5"></div>
        <div class="flex flex-wrap content-center justify-center bg-white dark:bg-slate-900" style="width: 24rem; height: 32rem;">
            <div width="192" class="text-black dark:text-white mb-14 mx-auto min-[980px]:hidden"> 
                {include '..\..\..\public\images\logo.svg'}
            </div>
            <div class="w-72">

                <h1 class="text-2xl font-semibold">Hoşgeldiniz</h1>
                <small class="text-gray-400">{$survey->title}</small>
                <i class="text-gray-300 font-thin text-xs">Ankete katılmak için lütfen telefon numaranız ile giriş yapınız...</i>
                <form role="form" class="space-y-6" action="/participate/verify-step1" method="post" data-content=".message">
                    {csrf()|noescape}
                    <div class="mb-3">
                        <label class="mb-2 block text-xs font-semibold">{lang("type.phone")}</label>
                        <input type="text" name="phone" placeholder="(555) 555 55 55" class="transition-colors transition-duration-200 block w-full rounded-md border border-gray-300 focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700 p-2 text-gray-700 dark:text-gray-200 dark:border-slate-600 dark:bg-gray-900" />
                    </div>

                    <div class="mb-3">
                        <button class="mb-1.5 block w-full text-center text-white bg-blue-700 hover:bg-blue-900 transition-colors transition-duration-200 px-2 py-1.5 rounded-md">DEVAM ET</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white text-black flex flex-wrap content-center justify-center max-[980px]:hidden" style="width: 24rem; height: 32rem;">
            {include '..\..\..\public\images\logo.svg'}
        </div>

    </div>

    <div class="mt-3 w-full">
        <p class="text-center text-gray-500 dark:text-gray-400">Copyright © {date("Y")} All rights <a href="https://github.com/SDClowen">reserved.</a>
        </p>
    </div>
</body>

</html>