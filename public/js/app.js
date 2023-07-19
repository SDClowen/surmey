$(function () {

    function createCheckableList(type, questionDummyText, answerDummyText) {
        return `
            <div data-type="${type}" id="question" class="border-2 rounded-md border-dashed bg-white dark:bg-gray-800 border-gray-900/25 dark:border-gray-300/25 px-2 pt-2 text-sm m-3">
                <div contenteditable="true" class="bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>

                <div class="ml-8 my-3">
                    <div id="answers">
                        
                    </div>
                    <div id="create-answer" contenteditable="true" class="focus:rounded-lg border-b border-gray-500 my-2 p-2 text-sm focus:outline-blue-600">${answerDummyText}</div>
                </div>
                <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                    <div class="col-span-4">
                        <label class="${type == 'checkbox' || type == 'radio' ? '' : 'hidden'} relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                Yatay olarak dizginle
                            </span>
                        </label>
                        <label class="relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" checked="false" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                Zorunlu
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        `;
    }

    function createTextArea(questionDummyText) {
        return `
            <div data-type="textarea" id="question" class="border-2 border-dashed border-gray-400 bg-white dark:bg-gray-800 dark:border-gray-600 px-2 pt-2 text-sm m-3">
            <div contenteditable="true" class="mb-3 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
            <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                <div class="col-span-4">
                    <label class="relative inline-flex items-center mb-4 cursor-pointer">
                        <input type="checkbox" checked="false" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                            Zorunlu
                        </span>
                    </label>
                </div>
            </div>
        </div>
        `
    }

    function createDescription(questionDummyText) {
        return `
            <div data-type="description" id="question" class="border-2 border-dashed border-gray-400 bg-white dark:bg-gray-800 dark:border-gray-600 px-2 pt-2 text-sm m-3">
                <div contenteditable="true" class="mb-3 h-14 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
            
                <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                    <div class="col-span-4">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md outline-none focus:ring-blue-500 focus:border-blue-500 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="0">Bilgi</option>
                            <option value="1">Uyarı</option>
                            <option value="2">Başarı</option>
                            <option value="3">Tehlike</option>
                        </select>
                    </div>
                </div>
            </div>
        `
    }

    const generate = () => {
        const questions = $(".questions #question")

        var result = [];
        questions.each(function () {
            $this = $(this)
            var question = {
                title: $this.find("div:eq(0)").text(),
                type: $this.data("type"),
                isHorizontal: $this.find("input[type=checkbox]:eq(0)").prop("checked"),
                isRequired: $this.find("input[type=checkbox]:eq(1)").prop("checked"),
                subType: $this.find("select:eq(0)").val(),
                answers: []
            }

            const answers = $this.find("#answers div");
            answers.each(function () {
                question.answers.push($(this).text())
            })

            result.push(question)
        });

        console.log(result)

        $("form input[name=data]").val(JSON.stringify(result))

        return result
    }

    window.generateSurvey = generate
    
    $(document).on("click", "#preview", function (event) {
        const array = generate()

        $(".preview-content").html("")

        array.forEach(element => {

            let content = `
                <div class="rounded-lg border mb-3 border-gray-200 shadow-sm bg-white p-4 dark:border-gray-600 dark:bg-slate-900"> 
            `

            if (element.type != "description")
                content += `
                    <h1 class="text-clip border-b border-gray-200 pb-3 pt-1 text-3xl font-thin dark:border-gray-600 mb-4">
                        ${element.title}
                    </h1>
                `;

            switch (element.type) {
                case "radio":
                case "checkbox":
                    let divClass = "inline"
                    if (element.isHorizontal)
                        divClass = "grid grid-flow-col justify-stretch"

                    content += `<div class="${divClass}">`;
                    break
                case "textarea":
                    content += '<textarea class="w-full rounded-lg border mb-3 text-gray-900 dark:text-gray-50 border-gray-200 shadow-sm bg-white p-2 focus:outline-blue-500 dark:focus:outline-blue-600 dark:border-gray-600 dark:bg-slate-900"></textarea>'
                    break

                case "description":

                    const types = ["info", "warning", "success", "danger"]

                    content+=`
                        <div class="alert ${types[element.subType]}">
                            ${element.title}
                        </div>
                    `;

                    break
            }

            element.answers.forEach((answer, i) => {
                content += `
                    <div class="flex items-center mb-2">
                        <input id="link-${element.type}-${i}" type="${element.type}" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="link-${element.type}-${i}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">${answer}</label>
                    </div>
                `
            })

            content += "</div>";

            $(".preview-content").append(content)
        })
    })

    $(document).on("keypress", "#create-answer", function (event) {
        if (!event.shiftKey && event.which == 13) {
            $(this).prev("#answers").append(`
                <div class="mt-2 bg-gray-100 focus:outline-blue-600 rounded-md p-2 dark:bg-gray-700" contenteditable="true">${$(this).text()}</div>
            `)

            $(event.target).text("...")
            window.getSelection().selectAllChildren(event.target)

            return false
        }
    })

    $(document).on("click", "#create-survey a", function (event) {
        const type = $(this).attr("type");
        const questionDummyText = $(this).attr("question-text");
        const answerDummyText = $(this).attr("answer-text");

        var content = ''

        switch (type) {
            case "radio":
            case "checkbox":
                content = createCheckableList(type, questionDummyText, answerDummyText);
                break
            case "textarea":
                content = createTextArea(questionDummyText)
                break
            case "description":
                content = createDescription(questionDummyText)
                break
        }

        $(".questions").append(content);
    })
})