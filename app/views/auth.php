<!DOCTYPE html>
<html class="h-full" lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surmey - {$title}</title>
    {acss("app")|noescape}
    {njs("jquery/dist/jquery.min")|noescape}
    {njs("sdeasy/sdeasy")|noescape}
</head>

<body class="flex flex-wrap min-h-screen w-full content-center justify-center bg-gray-200 dark:bg-slate-700 dark:text-gray-200 py-10">
    <!-- Login component -->
    <div class="flex shadow-md relative">
        <!-- Login form -->
        <div class="auth-message absolute bottom-0 w-4/5 ml-5"></div>
        <div class="flex flex-wrap content-center justify-center rounded-l-md bg-white dark:bg-slate-900" style="width: 24rem; height: 32rem;">
            <div class="w-72">
                <!-- Heading -->
                <h1 class="text-xl font-semibold">Welcome back</h1>
                <small class="text-gray-400">Please enter your details</small>

                <form role="form" class="space-y-6" action="/auth" method="post" data-content=".auth-message">
                    {csrf()|noescape}
                    <div class="mb-3">
                        <label class="mb-2 block text-xs font-semibold">{lang("username.or.email")}</label>
                        <input type="text" name="userNameOrEmail" placeholder="Enter your username or email" class="transition-colors transition-duration-200 block w-full rounded-md border border-gray-300 focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700 p-2 text-gray-700 dark:text-gray-200 dark:border-slate-600 dark:bg-gray-900" />
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 block text-xs font-semibold">{lang("password")}</label>
                        <input type="password" name="password" placeholder="•••••••" class="transition-colors transition-duration-200 block w-full rounded-md border border-gray-300 focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700 p-2 text-gray-700 dark:text-gray-200 dark:border-slate-600 dark:bg-gray-900" />
                    </div>

                    <div class="mb-3 flex flex-wrap content-center">
                        <input id="remember" type="checkbox" class="mr-1 checked:bg-purple-700" /> <label for="remember" class="mr-auto text-xs font-semibold">Remember for 30 days</label>
                        <!--<a href="#" class="text-xs font-semibold text-purple-700">Forgot password?</a>-->
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="mb-1.5 block w-full text-center text-white bg-blue-700 hover:bg-blue-900 transition-colors transition-duration-200 px-2 py-1.5 rounded-md">Sign in</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-wrap content-center justify-center rounded-r-md" style="width: 24rem; height: 32rem;">
            <img id="loginImage" class="w-full h-full bg-center bg-no-repeat bg-cover rounded-r-md" src="https://i.imgur.com/WqEWifN.jpeg">
        </div>

    </div>

    <div class="mt-3 w-full">
        <p class="text-center text-gray-500 dark:text-gray-400">Copyright ©
            <?= date("Y") ?> <a href="https://github.com/SDClowen">All rights reserved.</a>
        </p>
    </div>


    <script>
        const images = [
            "https://i.imgur.com/IefNfih.jpeg",
            "https://i.imgur.com/9l1A4OS.jpeg",
            "https://i.imgur.com/WqEWifN.jpeg"
        ]

        const domImage = document.querySelector("#loginImage");
        if (domImage) {
            domImage.src = images[Math.floor(Math.random() * 3)]
        }

    </script>
</body>

</html>