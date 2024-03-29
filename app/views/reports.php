<div x-data="{ isAnswerModalOpened: false, dropIsOpen: false, current: 1 }" x-on:keydown.escape="isAnswerModalOpened = false">
    <h1 class="text-center">{$surveyTitle}</h1>
    <div class="flex justify-between content-between w-full mb-3">
        <div class="inline-flex overflow-hidden relative bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse shadow-sm dark:border-gray-700 dark:divide-gray-700">
            <a id="preview" href="javascript:void(0)" class="cursor-default inline-flex items-center px-4 py-1 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300" x-on:click="current = 1" x-bind:class="{ 'text-white bg-blue-600 dark:bg-blue-800': current === 1 }">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-1 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span class="ml-1">Tablo</span>
            </a>
            <a href="javascript:void(0)" class="cursor-default inline-flex items-center px-4 py-1 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300" x-on:click="current = 2" x-bind:class="{ 'text-white bg-blue-600 dark:bg-blue-800': current === 2 }">
                <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 22C15.8082 21.9947 14.0267 20.2306 14 18.039V16H9.99996V18.02C9.98892 20.2265 8.19321 22.0073 5.98669 22C3.78017 21.9926 1.99635 20.1999 2.00001 17.9934C2.00367 15.7868 3.79343 14 5.99996 14H7.99996V9.99999H5.99996C3.79343 9.99997 2.00367 8.21315 2.00001 6.00663C1.99635 3.8001 3.78017 2.00736 5.98669 1.99999C8.19321 1.99267 9.98892 3.77349 9.99996 5.97999V7.99999H14V5.99999C14 3.79085 15.7908 1.99999 18 1.99999C20.2091 1.99999 22 3.79085 22 5.99999C22 8.20913 20.2091 9.99999 18 9.99999H16V14H18C20.2091 14 22 15.7909 22 18C22 20.2091 20.2091 22 18 22ZM16 16V18C16 19.1046 16.8954 20 18 20C19.1045 20 20 19.1046 20 18C20 16.8954 19.1045 16 18 16H16ZM5.99996 16C4.89539 16 3.99996 16.8954 3.99996 18C3.99996 19.1046 4.89539 20 5.99996 20C6.53211 20.0057 7.04412 19.7968 7.42043 19.4205C7.79674 19.0442 8.00563 18.5321 7.99996 18V16H5.99996ZM9.99996 9.99999V14H14V9.99999H9.99996ZM18 3.99999C17.4678 3.99431 16.9558 4.2032 16.5795 4.57952C16.2032 4.95583 15.9943 5.46784 16 5.99999V7.99999H18C18.5321 8.00567 19.0441 7.79678 19.4204 7.42047C19.7967 7.04416 20.0056 6.53215 20 5.99999C20.0056 5.46784 19.7967 4.95583 19.4204 4.57952C19.0441 4.2032 18.5321 3.99431 18 3.99999ZM5.99996 3.99999C5.4678 3.99431 4.95579 4.2032 4.57948 4.57952C4.20317 4.95583 3.99428 5.46784 3.99996 5.99999C3.99428 6.53215 4.20317 7.04416 4.57948 7.42047C4.95579 7.79678 5.4678 8.00567 5.99996 7.99999H7.99996V5.99999C8.00563 5.46784 7.79674 4.95583 7.42043 4.57952C7.04412 4.2032 6.53211 3.99431 5.99996 3.99999Z" fill="currentColor"></path>
                </svg>
                <span class="ml-1">Grafik</span>
            </a>
            <a n:if="!$anonymous" href="javascript:void(0)" class="cursor-default inline-flex items-center px-4 py-1 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300" x-on:click="current = 3" x-bind:class="{ 'text-white bg-blue-600 dark:bg-blue-800': current === 3 }">
                <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M19 14C21.2091 14 23 16 23 17.5C23 18.3284 22.3284 19 21.5 19H21M17 11C18.6569 11 20 9.65685 20 8C20 6.34315 18.6569 5 17 5M5 14C2.79086 14 1 16 1 17.5C1 18.3284 1.67157 19 2.5 19H3M7 11C5.34315 11 4 9.65685 4 8C4 6.34315 5.34315 5 7 5M16.5 19H7.5C6.67157 19 6 18.3284 6 17.5C6 15 9 14 12 14C15 14 18 15 18 17.5C18 18.3284 17.3284 19 16.5 19ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span class="relative ml-1">
                    Katılanlar <b>({count($participators)})</b>
                </span>
            </a>
        </div>
        <div class="flex justify-items-end">
            <div class="relative inline-flex">
                <button id="dropdownMenuIconButton" @click="dropIsOpen = !dropIsOpen" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownRadioHelper" x-show="dropIsOpen" @click.away="dropIsOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="absolute right-0 top-8 py-2 mt-2 overflow-hidden origin-top z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-60 border dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="p-1 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioHelperButton">
                        <li>
                            <a href="/reports/csv/{$surveyId}" target="blank" class="flex items-center content-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.5" d="M4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12L4 12Z" fill="#1C274C"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5303 7.53033C15.2374 7.82322 14.7626 7.82322 14.4697 7.53033L12.75 5.81066L12.75 14C12.75 14.4142 12.4142 14.75 12 14.75C11.5858 14.75 11.25 14.4142 11.25 14L11.25 5.81066L9.53033 7.53033C9.23744 7.82322 8.76256 7.82322 8.46967 7.53033C8.17678 7.23744 8.17678 6.76256 8.46967 6.46967L11.4697 3.46967C11.7626 3.17678 12.2374 3.17678 12.5303 3.46967L15.5303 6.46967C15.8232 6.76256 15.8232 7.23744 15.5303 7.53033Z" fill="#1C274C"></path>
                                    </g>
                                </svg>
                                <div class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <div>CSV</div>
                                    <p id="helper-radio-text-4" class="text-xs font-normal text-gray-500 dark:text-gray-300">
                                        Sonuçları CSV olarak dışarı aktar
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-url="/reports/reset/{$surveyId}" class="flex items-center content-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z" fill="#1C274C"></path>
                                        <path opacity="0.5" d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z" fill="#1C274C"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z" fill="#1C274C"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z" fill="#1C274C"></path>
                                    </g>
                                </svg>
                                <div class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <div>Katılımcıları Sıfırla</div>
                                    <p id="helper-radio-text-4" class="text-xs font-normal text-gray-500 dark:text-gray-300">
                                        Geçerli ankete katılan tüm katılımcıları siler ve temizler.
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="relative">

        <div x-show="current === 1">
            <div class="dark:bg-gray-900 bg-gray-100 rounded-lg m-1 my-2 p-3 shadow-sm" n:foreach="$data as $key => $value">
                <h1 class="text-xl text-center">{$key}</h1>
                <div class="grid grid-cols-1 xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 content-between mt-2">
                    <div class="dark:bg-gray-800 bg-white rounded-xl m-1 my-3 overflow-hidden" n:foreach="$value['answers'] as $aK => $aV">
                        <span class="block text-center bg-blue-600 text-white p-1">{$aK}</span>
                        <span class="block text-4xl text-center text-gray-500 p-1 dark:text-gray-300">
                            {if $value["type"] != "radio" && $value["type"] != "checkbox" && $aK != "Boş"}
                            <button @click="isAnswerModalOpened = !isAnswerModalOpened" title="Anonim Cevapları Göster" class="text-blue-500 underline dark:text-blue-400 font-bold hover:bg-blue-500 rounded-xl transition-colors duration-200 hover:text-white" data-json='{$value["list-json"]|noescape}'>{$aV}</button>
                            {else}
                            {$aV}
                            {/if}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div x-show="current === 2">

            <div id="chart"></div>

            <script>
                $(function () {
                    function showAnswers(data) {
                        data = JSON.parse(data);

                        for (const [k, v] of Object.entries(data))
                            console.log("Key:" + k + "  " + v);
                    }

                    $("[data-json]").on("click", function () {

                        const jsonData = $(this).data("json");

                        const questionTitle = $(this).parent().parent().parent().prev().text();
                        $("#answers-modal-title").text(questionTitle)

                        $("#answersModalContent").html("")

                        jsonData.forEach(element => {
                            $("#answersModalContent").prepend('<div class="dark:bg-gray-700 bg-gray-50 my-2 text-sm text-gray-900 dark:text-gray-200 p-3 rounded-md">' + element.value + '</div>');
                        });
                    })
                })
            </script>

            <div class="dark:bg-gray-900 bg-gray-100 rounded-lg m-1 my-2 p-3 shadow-sm" n:foreach="$data as $key => $value">
                <h1 class="text-xl text-center">{$key}</h1>
                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 content-between mt-2">
                    <div class="dark:bg-gray-800 bg-white rounded-xl m-1 my-3 overflow-hidden" n:foreach="$value['answers'] as $aK => $aV">
                        <!-- Progress -->
                        <div class="p-4">
                            <div class="mb-2 flex justify-between items-center">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{$aK}</h3>
                                <span class="text-sm text-gray-800 dark:text-white">{round($aV * 100 / ($value["total"] == 0 ? 1 : $value["total"]), 1)}%</span>
                            </div>
                            <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: {round($aV * 100 / ($value['total']==0 ? 1 : $value['total']), 1)|noescape}%"></div>
                            </div>
                        </div>
                        <!-- End Progress -->
                    </div>
                </div>
            </div>
        </div>

        <div n:if="!$anonymous" x-show="current === 3" x-transition class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <button class="flex items-center gap-x-3 focus:outline-none">
                                <span>Fullname</span>

                                <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                </svg>
                            </button>
                        </th>

                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <button class="flex items-center gap-x-3 focus:outline-none">
                                <span>Phone</span>

                                <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                </svg>
                            </button>
                        </th>

                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <button class="flex items-center gap-x-3 focus:outline-none">
                                <span>Status</span>

                                <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                    <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                </svg>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                    <tr n:foreach="$participators as $participator">
                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                            <div>
                                <h2 class="font-medium text-gray-800 dark:text-white">{$participator->fullname}</h2>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                            <div>
                                <h2 class="font-medium text-gray-800 dark:text-white">{(empty($participator->phone1) ? $participator->phone2 : $participator->phone1)}</h2>
                            </div>
                        </td>
                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                            <div class="inline px-3 py-1 text-sm font-normal rounded-full gap-x-2 {$participator->status == 1 ? ' text-emerald-500 bg-emerald-100/60' : 'text-gray-500 bg-gray-100 dark:text-gray-400'} dark:bg-gray-800">
                                {$participator->status == 1 ? 'ACTIVE' : 'DEACTIVE'}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div x-show="isAnswerModalOpened" @click="isAnswerModalOpened = false" class="fixed z-30 bg-black/50 backdrop-blur-sm top-0 left-0 w-full h-full outline-none"></div>
        <div class="z-40 fixed top-0 left-0 w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="answersModalScrollable" tabindex="-1" aria-labelledby="answersModalScrollableLabel" aria-hidden="true" x-show="isAnswerModalOpened" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95" x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100" x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95">
            <div class="sm:h-[calc(100%-3rem)] max-w-2xl my-6 mx-auto relative w-auto pointer-events-none">
                <div class="max-h-full overflow-hidden border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 dark:text-gray-50 bg-clip-padding rounded-lg outline-none text-current">
                    <div class="flex flex-shrink-0 items-center justify-between p-2 border-b border-gray-200 dark:border-gray-600 rounded-t-md">
                        <h5 class="text-xl flex font-medium leading-normal text-gray-800 dark:text-gray-200" id="answersModalScrollableLabel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <span class="ml-2" id="answers-modal-title">Loading....</span>
                        </h5>

                        <button @click="isAnswerModalOpened = false" class="box-content w-full mt-2 tracking-wide text-gray-700 capitalize transition-colors duration-300 transform rounded-md sm:mt-0 sm:w-auto sm:mx-2 dark:text-gray-200  hover:text-red-600  focus:outline-none focus:ring focus:ring-opacity-40">
                            <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.4" d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2Z" fill="currentColor"></path>
                                    <path d="M13.0594 12.0001L15.3594 9.70011C15.6494 9.41011 15.6494 8.93011 15.3594 8.64011C15.0694 8.35011 14.5894 8.35011 14.2994 8.64011L11.9994 10.9401L9.69937 8.64011C9.40937 8.35011 8.92937 8.35011 8.63938 8.64011C8.34938 8.93011 8.34938 9.41011 8.63938 9.70011L10.9394 12.0001L8.63938 14.3001C8.34938 14.5901 8.34938 15.0701 8.63938 15.3601C8.78938 15.5101 8.97937 15.5801 9.16937 15.5801C9.35937 15.5801 9.54937 15.5101 9.69937 15.3601L11.9994 13.0601L14.2994 15.3601C14.4494 15.5101 14.6394 15.5801 14.8294 15.5801C15.0194 15.5801 15.2094 15.5101 15.3594 15.3601C15.6494 15.0701 15.6494 14.5901 15.3594 14.3001L13.0594 12.0001Z" fill="currentColor"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-auto overflow-y-auto relative p-4">
                        <div id="answersModalContent" class="mt-2"></div>
                    </div>
                    <div class="p-4 mt-5 sm:flex sm:items-center sm:justify-between">
                        <div class="sm:flex sm:items-center ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>