<!DOCTYPE html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/favicon.png" sizes="16x16 32x32" type="image/png">
    <title>{$title}</title>
    {acss("app")|noescape}
    {njs("jquery/dist/jquery.min")|noescape}
    {ajs("jquery.inputmask.min")|noescape}
    {njs("sdpower/sdeasy")|noescape}
    <script>
        $(function () {

            setInterval(() => {
                $.ajax({
                    url: "/results",
                    dataType: "json",
                    type: "post",
                    success: (data) => {
                        const dom1 = $("#result-1");
                        const dom2 = $("#result-2");

                        dom1.text(data.option1Count)
                        dom2.text(data.option2Count)

                        if (data.option1Count != 0)
                            $(".resultPercent1").text((data.option1Count / data.answerCount * 100).toFixed(1))

                        if (data.option2Count != 0)
                            $(".resultPercent2").text((data.option2Count / data.answerCount * 100).toFixed(1))

                        $(".total").text(data.answerCount);
                        $(".total-percent").text((data.answerCount / data.personalCount * 100).toFixed(1));

                        if (data.option1Count > data.option2Count) {
                            dom1.removeClass("success").removeClass("danger").addClass("success")

                            dom2.removeClass("success").removeClass("danger").addClass("danger")
                        }
                        else if (data.option2Count > data.option1Count) {
                            dom2.removeClass("success").removeClass("danger").addClass("success")

                            dom1.removeClass("success").removeClass("danger").addClass("danger")
                        }
                        else {
                            dom1.removeClass("success").removeClass("danger").addClass("success")
                            dom2.removeClass("success").removeClass("danger").addClass("success")
                        }
                    }
                })
            }, 1000)
        })
    </script>
</head>

<body n:for="$i = 0; $i < 1; $i++" class="flex flex-wrap min-h-screen w-full content-center justify-center bg-gray-200 dark:bg-slate-700 dark:text-gray-200 py-10">
    <div class="text-9xl flex flex-col w-50 content-center justify-center p-6 mr-4">
        <span class="total rounded-xl text-center drop-shadow-sm bg-white dark:bg-slate-800 mb-3 px-3 text-slate-600 dark:text-slate-300">0</span>
        <span class="rounded-xl text-center drop-shadow-sm bg-white dark:bg-slate-800 px-3"><span class="total-percent text-slate-600 dark:text-slate-300"></span><span class="text-slate-400 dark:text-slate-500">%</span></span>
    </div>
    <div class="flex mb-2 shadow-md relative overflow-hidden rounded-xl">
        <div class="border-r flex flex-wrap content-center justify-center bg-white dark:border-slate-800 dark:bg-slate-900" style="width: 24rem; height: 32rem;">
            <div class="w-72 justify-items-center">

                <h1 class="text-md flex justify-items-stretch font-semibold">
                    <span class="px-4 py-2 border border-gray-100 rounded-md shadow-md bg-gray-50 text-gray-500 dark:bg-gray-700 dark:text-white dark:border-transparent">08:30 - 17:30</span>
                    <span class="ml-3 px-4 py-2 border rounded-md border-blue-500 shadow-md bg-blue-500 text-gray-50">08:30 - 16:30</span>
                </h1>
                <h1 class="text-center mt-5">Seçenek 1</h1>

                <small class="text-9xl text-center block mt-20 p-10 rounded-xl alert" id="result-1">0</small>
                <small class="text-6xl text-center block px-5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500"><span class="resultPercent1 text-slate-600 dark:text-slate-400">0.0</span><span class="text-slate-400 dark:text-slate-600">%</span></small>
            </div>
        </div>

        <div class="flex flex-wrap content-center justify-center bg-white dark:bg-slate-900" style="width: 24rem; height: 32rem;">
            <div class="w-72 justify-items-center">

                <h1 class="text-md flex justify-items-stretch font-semibold">
                    <span class="px-4 py-2 border border-gray-100 rounded-md shadow-md bg-gray-50 text-gray-500 dark:bg-gray-700 dark:text-white dark:border-transparent">08:00 - 17:00</span>
                    <span class="ml-3 px-4 py-2 border rounded-md border-blue-500 shadow-md bg-blue-500 text-gray-50">08:00 - 16:00</span>
                </h1>
                
                <h1 class="text-center mt-5">Seçenek 2</h1>

                <small class="text-9xl text-center block mt-20 p-10 rounded-xl alert" id="result-2">0</small>
                <small class="text-6xl text-center block px-5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500"><span class="resultPercent2 text-slate-600 dark:text-slate-400">0.0</span><span class="text-slate-400 dark:text-slate-600">%</span></small>
            </div>

        </div>

    </div>
</body>

</html>