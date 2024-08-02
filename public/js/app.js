$(function () {
    /*
    // i got errors on safari & chrome with iphones
    navigation.addEventListener("navigate", function(e){
        console.log(`navigate ->`, e);
    });*/

    function linkify(text) {

        return text;
        
        var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        return text.replace(urlRegex, function (url) {
            return '<a class="text-blue-600 underline" href="' + url + '">' + url + '</a>';
        });
    }

    var uniqueStrings = [];
    const randomString = (length) => {
        const chars =
            "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var result = "";
        while (true) {
            for (var i = length; i > 0; --i)
                result += chars[Math.floor(Math.random() * chars.length)];
            if (uniqueStrings.find((p) => p == result)) continue;
            break;
        }
        return result;
    };

    const clearText = (text) => {
        return text
            .trim()
            .replaceAll("\r\n", "<br>")
            .replaceAll("\r", "<br/>")
            .replaceAll("\n", "<br>")
            .replaceAll("\t", "   ")
            .replaceAll('"', '\\\"');
    };

    $("body").on("change", "#file-upload", function (event) {
        var input = event.currentTarget;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#cover-photo-result").css(
                    "background-image",
                    "url(" + e.target.result + ")"
                );
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    const getQuestionComponent = (type, body, isRequired = false, conditions = [], isCheckable = false, isHorizontal = false) => {
        return `
            <div data-type="${type}" conditions='${JSON.stringify(conditions)}' id="question" class="relative border-2 rounded-md border-dashed bg-white dark:bg-gray-800 border-gray-900/25 dark:border-gray-300/25 px-2 pt-2 text-sm m-3">
                <button type="button" class="remove absolute -top-2 -right-3 bg-red-500/80 transition duration-400 shadow-md rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-red-600 focus:outline-none">
                    <span class="sr-only">Close menu</span>

                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                
                <button type="button" class="up absolute top-4 -right-3 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 15L10 9.84985C10.2563 9.57616 10.566 9.35814 10.9101 9.20898C11.2541 9.05983 11.625 8.98291 12 8.98291C12.375 8.98291 12.7459 9.05983 13.0899 9.20898C13.434 9.35814 13.7437 9.57616 14 9.84985L19 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </button>

                <button type="button" class="down absolute top-10 -right-3 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19 9L14 14.1599C13.7429 14.4323 13.4329 14.6493 13.089 14.7976C12.7451 14.9459 12.3745 15.0225 12 15.0225C11.6255 15.0225 11.2549 14.9459 10.9109 14.7976C10.567 14.6493 10.2571 14.4323 10 14.1599L5 9" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </button>

                ${body}

                ${type != "description" ? `
                <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                    <div class="col-span-4">
                        <label class="relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" ${isRequired ? "checked" : ""} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                Zorunlu
                            </span>
                        </label>
                        ${isCheckable ? `
                            <label class="${type == "checkbox" || type == "radio" ? "" : "hidden"} relative inline-flex items-center mb-4 cursor-pointer">
                                <input type="checkbox" ${isHorizontal ? "checked" : ""} class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                    Yatay olarak dizginle
                                </span>
                            </label>
                        ` : ''}
                    </div>
                </div>` : ''}
            </div>
        `;
    }

    $(document).on("click", "#condition-dropdown ul li", (e) => {
        e.preventDefault()

        const question = $(e.currentTarget).parents("#question")
        const answerIndex = $(e.currentTarget).parents("#answer").index()
        const val = $(e.currentTarget).children("input").val()

        var conditions = JSON.parse(question.attr("conditions") ?? "[]")
        
        arrayIndex = conditions.findIndex(p => p.index == answerIndex)
        if(arrayIndex != -1)
        {
            if(val == "none")
                conditions.splice(arrayIndex, 1)
            else
                conditions[arrayIndex].value = val;   
        }
        else
            conditions.push({
                index:  answerIndex,
                value: val
            })


        question.attr("conditions", JSON.stringify(conditions))
        $(e.currentTarget).parents("#condition-dropdown").addClass("hidden")
    })

    $(document).on("click", "#condition", (e) => {

        const dropdown = $(e.currentTarget).next();
        $("#condition-dropdown:not(.hidden)").each((i, ee) => {
            if(dropdown.is($(ee)))
                return;
            
            $(ee).addClass("hidden")
        })

        dropdown.toggleClass("hidden")

        if (dropdown.hasClass("hidden"))
            return false

        const parentIndex = $(e.currentTarget).parents("#answer").index()

        const questions = generate()
        const ul = dropdown.find("ul")
        ul.html("")
        ul.append(`
            <li>
                <input checked type="radio" id="first-condition-element" name="condition-${parentIndex}" value="none" class="hidden peer" required />
                <label for="first-condition-element" class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border border-transparent rounded-lg cursor-pointer dark:hover:text-gray-300 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                Seçili Değil
                </label>
            </li>`)
    
        const question = $(e.currentTarget).parents("#question");
        const questionSlug = question.find("[data-slug]").data("slug");

        var conditions = JSON.parse(question.attr("conditions") ?? "[]")
        
        for (const [k, v] of Object.entries(questions)) {
            if (v.type == "description" || questionSlug == v.slug)
                continue;

            var hasChecked = conditions.findIndex(p => p.index == parentIndex && p.value == v.slug) > -1;

            ul.append(`<li>
                <input type="radio" id="${v.slug}" name="condition-${parentIndex}" value="${v.slug}" class="hidden peer" ${hasChecked ? "checked" : ""} required />
                <label for="${v.slug}" class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-transparent rounded-lg cursor-pointer dark:hover:text-gray-300 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                ${v.title}
                </label>
            </li>`)
        }
    })

    const getAnswerComponent = (body) => {
        return `
            <div id="answer" class="relative mt-2 bg-gray-100 focus:outline-blue-600 rounded-md dark:bg-gray-700 flex content-between">
                <div class="content w-5/6 p-1 m-1 rounded-md focus:outline-blue-600" contenteditable="true">${body}</div>
                <div class="w-1/6 p-2">
                    <div class="if absolute top-50 right-20" style="display:ruby">
                        <button type="button" id="condition" class="bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                            <svg fill="currentColor" class="h-3 w-3" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;}</style></defs><title>align--horizontal-center</title><path d="M24,18H17V14h3a2.0025,2.0025,0,0,0,2-2V8a2.0025,2.0025,0,0,0-2-2H17V2H15V6H12a2.0025,2.0025,0,0,0-2,2v4a2.0025,2.0025,0,0,0,2,2h3v4H8a2.0025,2.0025,0,0,0-2,2v4a2.0025,2.0025,0,0,0,2,2h7v4h2V26h7a2.0025,2.0025,0,0,0,2-2V20A2.0025,2.0025,0,0,0,24,18ZM12,8h8v4H12ZM24,24H8V20H24Z"></path><rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1" width="32" height="32"></rect></g></svg> 
                        </button>
                        <!-- Dropdown menu -->
                        <div id="condition-dropdown" class="dropdown hidden absolute right-0 z-20 w-auto origin-top-right bg-white rounded-lg border dark:border-gray-600 shadow-xl dark:bg-gray-800">
                            <ul class="p-2 space-y-3 text-sm text-gray-700 h-80 min-w-80 overflow-x-auto dark:text-gray-200">
                                
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="down absolute top-50 right-14 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19 9L14 14.1599C13.7429 14.4323 13.4329 14.6493 13.089 14.7976C12.7451 14.9459 12.3745 15.0225 12 15.0225C11.6255 15.0225 11.2549 14.9459 10.9109 14.7976C10.567 14.6493 10.2571 14.4323 10 14.1599L5 9" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button type="button" class="up absolute top-50 right-8 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 15L10 9.84985C10.2563 9.57616 10.566 9.35814 10.9101 9.20898C11.2541 9.05983 11.625 8.98291 12 8.98291C12.375 8.98291 12.7459 9.05983 13.0899 9.20898C13.434 9.35814 13.7437 9.57616 14 9.84985L19 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button type="button" class="remove absolute top-50 right-2 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                        <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        `
    }

    function createCheckableList(
        type,
        questionDummyText,
        answerDummyText,
        slug,
        answers = [],
        isHorizontal = false,
        isRequired = false, 
        conditions = []
    ) {
        var generatedAnswers = "";
        for (const v of Object.values(answers))
            generatedAnswers += getAnswerComponent(v);

        const body = `
            <div contenteditable="true" data-slug="${slug}" class="bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>

            <div class="ml-8 my-3">
                <div id="answers">
                    ${generatedAnswers}
                </div>
                <div id="create-answer" contenteditable="true" class="focus:rounded-lg border-b border-gray-500 my-2 p-2 text-sm focus:outline-blue-600">${answerDummyText}</div>
            </div>        
        `;

        return getQuestionComponent(type, body, isRequired, conditions, true, isHorizontal);
    }

    function createTextArea(questionDummyText, slug, isRequired = true) {
        const body = `<div contenteditable="true" data-slug="${slug}" class="mb-3 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>`;

        return getQuestionComponent("textarea", body, isRequired);
    }

    function createDescription(questionDummyText, slug, subType = 0) {
        const body = `
            <div contenteditable="true" data-slug="${slug}" class="mb-3 h-14 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
                
            <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                <div class="col-span-4">
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md outline-none focus:ring-blue-500 focus:border-blue-500 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0" ${subType == 0 ? "selected" : ""}>Bilgi</option>
                        <option value="1" ${subType == 1 ? "selected" : ""}>Uyarı</option>
                        <option value="2" ${subType == 2 ? "selected" : ""}>Başarı</option>
                        <option value="3" ${subType == 3 ? "selected" : ""}>Tehlike</option>
                    </select>
                </div>
            </div>
        `;

        return getQuestionComponent("description", body);
    }

    const generate = () => {
        const questions = $(".questions #question");
        $(".preview-content").html("");
        var result = [];
        questions.each(function () {
            $this = $(this);
            var slug = $this.find("div:eq(0)").data("slug");
            if (!slug) slug = randomString(6);
            var question = {
                title: clearText($this.find("div:eq(0)").text()),
                slug: slug,
                type: $this.data("type"),
                isRequired: $this.find("input[type=checkbox]:eq(0)").prop("checked"),
                isHorizontal: $this.find("input[type=checkbox]:eq(1)").prop("checked"),
                subType: $this.find("select:eq(0)").val(),
                conditions: JSON.parse($this.attr("conditions") ?? "[]"),
                answers: []
            };
            const answers = $this.find("#answers #answer");
            answers.each(function () {
                const clonedDom = $(this).clone().find("[contenteditable]")

                const answerContent = clonedDom.html().trim();
                question.answers.push(clearText(answerContent));
            });
            result.push(question);
        });
        console.log(result);
        $("form input[name=data]").val(JSON.stringify(result));
        return result;
    };

    const prepareSurveyForEditing = function (formData, jsonData) {
        formData = JSON.parse(formData);
        $("input[name=title]").val(formData.title);
        $("input[name=verifyPhone]").prop("checked", formData.verifyPhone);
        $("input[name=anonymous]").prop("checked", formData.anonymous);

        $("#cover-photo-result").css(
            "background-image",
            `url('/public/images/survey/${formData.photo}')`
        );

        /*$("textarea[name=about]").text(
            formData.about
                .replaceAll("<br/>", "\r\n")
                .replaceAll("<br/>", "\r")
                .replaceAll("<br/>", "\n")
                .replaceAll("\t", "    ")
        )*/

        $("textarea[name=about]").html(formData.about).tinymce()

        for (const [k, v] of Object.entries(JSON.parse(jsonData))) {
            var content = "";
            switch (v.type) {
                case "radio":
                case "checkbox":
                    content = createCheckableList(
                        v.type,
                        v.title,
                        "...",
                        v.slug,
                        v.answers,
                        v.isHorizontal,
                        v.isRequired,
                        v.conditions
                    );
                    break;
                case "textarea":
                    content = createTextArea(v.title, v.slug, v.isRequired, v.conditions);
                    break;
                case "description":
                    content = createDescription(v.title, v.slug, v.subType);
                    break;
            }
            $(".questions").append(content);
        }
    };

    $(document).on("change", "[data-change-tracker]", (e) => {
        e.preventDefault()

        $this = $(e.currentTarget)
        $condition = $this.data("condition");

        const type = $this.attr("type")
        if(type == "radio")
        {
            const inputs = $this.parents("[data-slug]").find("input")
            inputs.each((inputIndex, inputElement) => {
                if($this.is(inputElement))
                    return

                $inputCondition = $(inputElement).data("condition");

                const conditionDiv = $(`[data-slug='${$inputCondition}']`);
                conditionDiv.find("input").prop('checked',false);
                conditionDiv.hide()
            })
        }
        
        $(`[data-slug='${$condition}']`).show()
    })

    const renderFormEntry = (element) => {
        let content = "";
        if (element.type != "description")
            content += `
                <div data-slug="${element.slug}" class="rounded-lg bg-slate-50/30 border mb-3 border-gray-200 shadow-sm p-4 dark:border-gray-600 dark:bg-slate-900"> 
            `;

        if (element.type != "description")
            content += `
                <h1 class="text-clip border-b border-gray-200 pb-3 pt-1 text-lg font-medium dark:border-gray-600 mb-4">
                    ${linkify(element.title.replaceAll('\\\"', '"'))}  ${element.isRequired ? "<b class='text-red-600'>*</b>" : ""}
                </h1>
              `;

        switch (element.type) {
            case "radio":
            case "checkbox":
                let divClass = "inline";
                if (element.isHorizontal)
                    divClass = "w-full space-x-8 grid grid-flow-col flex-nowrap overflow-x-auto scrolling-touch";
                content += `<div class="${divClass}">`;
                break;
            case "textarea":
                content += `<textarea maxlength="1000" name="${element.slug}" class="w-full rounded-lg border mb-3 text-gray-900 dark:text-gray-50 border-gray-200 shadow-sm bg-white p-2 focus:outline-blue-500 dark:focus:outline-blue-600 dark:border-gray-600 dark:bg-slate-900"></textarea>`;
                break;
            case "description":
                const types = ["info", "warning", "success", "danger"];
                content += `
                    <div data-slug="${element.slug}" class="my-3 shadow-sm text-center rounded-md p-3 text-md alert-${types[element.subType]}">
                        ${linkify(element.title.replaceAll('\\\"', '"'))}
                    </div>
                `;
                break;
        }

        element.answers.forEach((answer, i) => {

            const arrayIndex = !element.hasOwnProperty("conditions") ? -1 : element.conditions.findIndex(p => p.index == i)
            const hasCondition = arrayIndex > -1 ? element.conditions[arrayIndex].value : "none"

            content += `
                  <div class="flex w-fit items-center mb-2 mx-1">
                      <input data-condition="${hasCondition}" data-change-tracker="true" id="link-${element.slug + i}" name="${element.type == "radio" ? element.slug : element.slug + i}" type="${element.type}" value="${i}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="link-${element.slug + i}" class="ml-2 text-sm font-normal text-gray-900 dark:text-gray-300" ${element.isHorizontal ? 'style="min-inline-size: max-content;"' : ''}>${linkify(answer.replaceAll('\\\"', '"'))}</label>
                  </div>
              `;
        });

        if (element.type != "description")
            content += "</div>";

        return content;
    };

    window.generateSurvey = generate;
    window.renderFormEntry = renderFormEntry;
    window.prepareSurveyForEditing = prepareSurveyForEditing;

    $(document).on("click", ".remove", function (event) {
        $(this).parent().remove();
    });

    $(document).on("click", ".up, .down", function (event) {

        $parent = $(this).parent()
        const isUpper = $(this).hasClass("up");

        $v = isUpper ? $parent.prev() : $parent.next()

        if ($parent.attr("id") != "answer")
            if (!$v.is("[data-type]"))
                return;

        if (isUpper)
            $parent.insertBefore($v)
        else
            $parent.insertAfter($v)
    });

    $(document).on("click", "#preview", function (event) {
        const data = generate();
        $(".preview-content").html("");
        data.forEach((element) =>
            $(".preview-content").append(renderFormEntry(element))
        )

        data.forEach(element => {
            element.conditions.forEach(condition => $(`.rounded-lg[data-slug='${condition.value}']`).hide())
        })
    })

    $(document).on("keypress", "#create-answer", function (event) {
        if (!event.shiftKey && event.which == 13) {
            $(this).prev("#answers").append(getAnswerComponent($(this).text()));

            $(event.target).text("...");
            window.getSelection().selectAllChildren(event.target);
            return false;
        }
    })

    $(document).on("click", "#survey-crud a", function (event) {
        const type = $(this).attr("type");
        const questionDummyText = $(this).attr("question-text");
        const answerDummyText = $(this).attr("answer-text");
        var content = "";
        var slug = randomString(6);
        switch (type) {
            case "radio":
            case "checkbox":
                content = createCheckableList(
                    type,
                    questionDummyText,
                    answerDummyText,
                    slug
                );
                break;
            case "textarea":
                content = createTextArea(questionDummyText, slug);
                break;
            case "description":
                content = createDescription(questionDummyText, slug);
                break;
        }

        $(".questions").append(content);
    });

    $("[data-json]").on("click", function () {

        const jsonData = $(this).data("json");

        const questionTitle = $(this).parent().parent().parent().prev().text();
        $("#answers-modal-title").text(questionTitle)

        $("#answersModalContent").html("")

        jsonData.forEach(element => {
            $("#answersModalContent").prepend('<div class="dark:bg-gray-700 bg-gray-50 my-2 text-sm text-gray-900 dark:text-gray-200 p-3 rounded-md">' + element.value + '</div>');
        });
    })
});
