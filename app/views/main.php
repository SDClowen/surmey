<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {$title}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js" integrity="sha512-nIwdJlD5/vHj23CbO2iHCXtsqzdTTx3e3uAmpTm4x2Y8xCIFyWu4cSIV8GaGe2UNVq86/1h9EgUZy7tn243qdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    {acss("surmey")|noescape}
    {njs("jquery/dist/jquery.min")|noescape}
    {njs("sdeasy/sdeasy")|noescape}
    {ajs("app")|noescape}
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full">
        <nav class="bg-blue-700 d-none">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8" width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(1, 0, 0, 1, 0, 0)" stroke="#fff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#fff" stroke-width="0.048"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.6" d="M20.1004 6.93998C20.1004 7.47998 19.8104 7.96995 19.3504 8.21995L17.6104 9.15995L16.1304 9.94999L13.0604 11.61C12.7304 11.79 12.3704 11.88 12.0004 11.88C11.6304 11.88 11.2704 11.79 10.9404 11.61L4.65039 8.21995C4.19039 7.96995 3.90039 7.47998 3.90039 6.93998C3.90039 6.39998 4.19039 5.90995 4.65039 5.65995L6.62039 4.59996L8.1904 3.74998L10.9404 2.27C11.6004 1.91 12.4004 1.91 13.0604 2.27L19.3504 5.65995C19.8104 5.90995 20.1004 6.39998 20.1004 6.93998Z" fill="#292D32"></path>
                                    <path opacity="0.6" d="M9.9007 12.7899L4.05069 9.85989C3.60069 9.62989 3.0807 9.65989 2.6507 9.91989C2.2207 10.1799 1.9707 10.6399 1.9707 11.1399V16.6699C1.9707 17.6299 2.50069 18.4899 3.36069 18.9199L9.21069 21.8399C9.41069 21.9399 9.63071 21.9899 9.85071 21.9899C10.1107 21.9899 10.3707 21.9199 10.6007 21.7699C11.0307 21.5099 11.2807 21.0499 11.2807 20.5499V15.0199C11.2907 14.0799 10.7607 13.2199 9.9007 12.7899Z" fill="#192D32"></path>
                                    <path opacity="0.6" d="M22.0309 11.1502V16.6801C22.0309 17.6301 21.501 18.4901 20.641 18.9201L14.791 21.8501C14.591 21.9501 14.3709 22.0001 14.1509 22.0001C13.8909 22.0001 13.631 21.9302 13.391 21.7802C12.971 21.5202 12.7109 21.0601 12.7109 20.5601V15.0401C12.7109 14.0801 13.241 13.2201 14.101 12.7901L16.2509 11.7201L17.7509 10.9701L19.951 9.87013C20.401 9.64013 20.921 9.66012 21.351 9.93012C21.771 10.1901 22.0309 10.6502 22.0309 11.1502Z" fill="#292D32"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="hidden md:block">
                            <ul class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <li><a class="transition-colors duration-300 transform text-gray-100 hover:bg-blue-900 hover:text-white rounded-md px-3 py-2 text-sm font-medium d-flex" aria-current="page" href="/" live="true" data-content="#container" spinner="false">Dashboard</a></li>
                                <li><a class="transition-colors duration-300 transform text-gray-100 hover:bg-blue-900 hover:text-white rounded-md px-3 py-2 text-sm font-medium" href="/surveys" live="true" data-content="#container" spinner="false">Surveys</a></li>
                                <li><a class="transition-colors duration-300 transform text-gray-100 hover:bg-blue-900 hover:text-white rounded-md px-3 py-2 text-sm font-medium" href="/reports" live="true" data-content="#container" spinner="false">Reports</a></li>
                                <li><a class="transition-colors duration-300 transform text-gray-100 hover:bg-blue-900 hover:text-white rounded-md px-3 py-2 text-sm font-medium" href="/settings" live="true" data-content="#container" spinner="false">Settings</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <a href="/logout" live="true"  class="transition-colors duration-300 transform text-gray-100 hover:bg-red-950 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calendar</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Reports</a>
                </div>
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                            <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                        </div>
                        <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white" href="/settings" live="true" data-content="#container">Settings</a>
                        <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white" href="/logout" live="true" data-content="#container">Sign out</a>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm border-b dark:bg-slate-800 dark:border-slate-700">
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <h1 class="flex items-center font-semibold">
                    <svg class="h-8 w-8 mr-2" width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(1, 0, 0, 1, 0, 0)" stroke="#fff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#999999" stroke-width="0.048"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path opacity="0.6" d="M20.1004 6.93998C20.1004 7.47998 19.8104 7.96995 19.3504 8.21995L17.6104 9.15995L16.1304 9.94999L13.0604 11.61C12.7304 11.79 12.3704 11.88 12.0004 11.88C11.6304 11.88 11.2704 11.79 10.9404 11.61L4.65039 8.21995C4.19039 7.96995 3.90039 7.47998 3.90039 6.93998C3.90039 6.39998 4.19039 5.90995 4.65039 5.65995L6.62039 4.59996L8.1904 3.74998L10.9404 2.27C11.6004 1.91 12.4004 1.91 13.0604 2.27L19.3504 5.65995C19.8104 5.90995 20.1004 6.39998 20.1004 6.93998Z" fill="#292D32"></path>
                            <path opacity="0.6" d="M9.9007 12.7899L4.05069 9.85989C3.60069 9.62989 3.0807 9.65989 2.6507 9.91989C2.2207 10.1799 1.9707 10.6399 1.9707 11.1399V16.6699C1.9707 17.6299 2.50069 18.4899 3.36069 18.9199L9.21069 21.8399C9.41069 21.9399 9.63071 21.9899 9.85071 21.9899C10.1107 21.9899 10.3707 21.9199 10.6007 21.7699C11.0307 21.5099 11.2807 21.0499 11.2807 20.5499V15.0199C11.2907 14.0799 10.7607 13.2199 9.9007 12.7899Z" fill="#492D32"></path>
                            <path opacity="0.6" d="M22.0309 11.1502V16.6801C22.0309 17.6301 21.501 18.4901 20.641 18.9201L14.791 21.8501C14.591 21.9501 14.3709 22.0001 14.1509 22.0001C13.8909 22.0001 13.631 21.9302 13.391 21.7802C12.971 21.5202 12.7109 21.0601 12.7109 20.5601V15.0401C12.7109 14.0801 13.241 13.2201 14.101 12.7901L16.2509 11.7201L17.7509 10.9701L19.951 9.87013C20.401 9.64013 20.921 9.66012 21.351 9.93012C21.771 10.1901 22.0309 10.6502 22.0309 11.1502Z" fill="#292D32"></path>
                        </g>
                    </svg>
                    <span class="text-gray-500">Surmey - <small class="text-gray-400 font-thin">A simple survey system</small></span>
                    <small class="text-gray-400 ml-auto font-thin font">
                        Copyright © <?= date("Y") ?> <a href="https://github.com/SDClowen">All rights reserved.</a>
                    </small>
                </h1>
            </div>
        </header>
        <main>
            <div id="container" class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 m-3 rounded-md border shadow-sm bg-white dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                {$content|noescape}
            </div>
        </main>
    </div>
</body>

</html>