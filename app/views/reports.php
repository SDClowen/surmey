<div x-data="{ isAnswerModalOpened: false, current: 2 }" x-on:keydown.escape="isAnswerModalOpened = false">
    <!--<div class="inline-flex overflow-hidden mb-3 bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse shadow-sm dark:border-gray-700 dark:divide-gray-700">
        <a href="javascript:void(0)" class="cursor-default inline-flex items-center px-4 py-1 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300" x-on:click="current = 1" x-bind:class="{ 'text-white bg-blue-600 dark:bg-blue-800': current === 1 }">
            <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 22C15.8082 21.9947 14.0267 20.2306 14 18.039V16H9.99996V18.02C9.98892 20.2265 8.19321 22.0073 5.98669 22C3.78017 21.9926 1.99635 20.1999 2.00001 17.9934C2.00367 15.7868 3.79343 14 5.99996 14H7.99996V9.99999H5.99996C3.79343 9.99997 2.00367 8.21315 2.00001 6.00663C1.99635 3.8001 3.78017 2.00736 5.98669 1.99999C8.19321 1.99267 9.98892 3.77349 9.99996 5.97999V7.99999H14V5.99999C14 3.79085 15.7908 1.99999 18 1.99999C20.2091 1.99999 22 3.79085 22 5.99999C22 8.20913 20.2091 9.99999 18 9.99999H16V14H18C20.2091 14 22 15.7909 22 18C22 20.2091 20.2091 22 18 22ZM16 16V18C16 19.1046 16.8954 20 18 20C19.1045 20 20 19.1046 20 18C20 16.8954 19.1045 16 18 16H16ZM5.99996 16C4.89539 16 3.99996 16.8954 3.99996 18C3.99996 19.1046 4.89539 20 5.99996 20C6.53211 20.0057 7.04412 19.7968 7.42043 19.4205C7.79674 19.0442 8.00563 18.5321 7.99996 18V16H5.99996ZM9.99996 9.99999V14H14V9.99999H9.99996ZM18 3.99999C17.4678 3.99431 16.9558 4.2032 16.5795 4.57952C16.2032 4.95583 15.9943 5.46784 16 5.99999V7.99999H18C18.5321 8.00567 19.0441 7.79678 19.4204 7.42047C19.7967 7.04416 20.0056 6.53215 20 5.99999C20.0056 5.46784 19.7967 4.95583 19.4204 4.57952C19.0441 4.2032 18.5321 3.99431 18 3.99999ZM5.99996 3.99999C5.4678 3.99431 4.95579 4.2032 4.57948 4.57952C4.20317 4.95583 3.99428 5.46784 3.99996 5.99999C3.99428 6.53215 4.20317 7.04416 4.57948 7.42047C4.95579 7.79678 5.4678 8.00567 5.99996 7.99999H7.99996V5.99999C8.00563 5.46784 7.79674 4.95583 7.42043 4.57952C7.04412 4.2032 6.53211 3.99431 5.99996 3.99999Z" fill="currentColor"></path>
            </svg>
            <span class="ml-1">Grafik</span>
        </a>
        <a id="preview" href="javascript:void(0)" class="cursor-default inline-flex items-center px-4 py-1 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300" x-on:click="current = 2" x-bind:class="{ 'text-white bg-blue-600 dark:bg-blue-800': current === 2 }">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-1 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            <span class="ml-1">Tablo</span>
        </a>
    </div>-->
    <div class="relative rounded-lg p-2 shadow-md bg-slate-100 border-slate-100 dark:border-slate-600 dark:bg-slate-700">
        <div x-show="current === 1">

            <div id="chart"></div>

            <script>

                // TODO: Parse from json!!!
                let ajaxSeries = [];
                let ajaxLabels = [];

                var options = {
                    series: [66, 55, 13, 43, 22],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: ["A", "B", "C", "D", "E"],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();

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

                        //$("#answersModalContent").html("")

                        jsonData.forEach(element => {
                            $("#answersModalContent").prepend('<div class="dark:bg-gray-700 bg-gray-50 my-2 text-sm text-gray-900 dark:text-gray-200 p-3 rounded-md">' + element.value + '</div>');
                        });
                    })
                })
            </script>

            <div n:for="$i = 0; $i < 6; $i++" class="p-4 mb-2 border-b">
                <h1 class="text-gray-900 dark:text-slate-100 border-b mb-3">Deneme soru başlığı</h1>
                <div class="chart bg-gray-100 rounded-md">
                    <div class="w-32 h-32 m-6 text-center rounded-full bg-red-100">test</div>
                </div>
            </div>
        </div>
        <div class="p-2" x-show="current === 2">
            <div class="dark:bg-gray-900 bg-white rounded-lg m-1 my-2 p-3 shadow-sm" n:foreach="$data as $key => $value">
                <h1 class="text-xl text-center">{$key}</h1>
                <div class="grid grid-flow-col mt-2">
                    <div class="dark:bg-gray-700 bg-gray-100 rounded-xl m-1 my-3 overflow-hidden" n:foreach="$value['answers'] as $aK => $aV">
                        <span class="block text-center bg-blue-500 text-white p-1">{$aK}</span>
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