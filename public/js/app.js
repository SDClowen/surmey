$(function () {
    navigation.addEventListener("navigate", (e) => {
        console.log(`navigate ->`, e);
    });
    $("#file-upload").on("change", function (event) {
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
    function createCheckableList(
        type,
        questionDummyText,
        answerDummyText,
        slug,
        answers = [],
        isHorizontal = false,
        isRequired = true
    ) {
        var generatedAnswers = "";
        for (const v of Object.values(answers))
            generatedAnswers += `<div class="relative mt-2 bg-gray-100 focus:outline-blue-600 rounded-md p-2 dark:bg-gray-700" contenteditable="true">
                                      <button type="button" class="remove absolute top-50 right-2 bg-gray-300 dark:bg-gray-600 transition duration-400 rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-gray-400 focus:outline-none">
                                          <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                          </svg>
                                      </button>
                                      ${v}
                                  </div>`;
        return `
              <div data-type="${type}" id="question" class="relative border-2 rounded-md border-dashed bg-white dark:bg-gray-800 border-gray-900/25 dark:border-gray-300/25 px-2 pt-2 text-sm m-3">
                  <button type="button" class="remove absolute -top-3 -right-3 bg-red-500/80 transition duration-400 shadow-md rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-red-600 focus:outline-none">
                      <span class="sr-only">Close menu</span>
  
                      <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
  
                  <div contenteditable="true" data-slug="${slug}" class="bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
  
                  <div class="ml-8 my-3">
                      <div id="answers">
                          ${generatedAnswers}
                      </div>
                      <div id="create-answer" contenteditable="true" class="focus:rounded-lg border-b border-gray-500 my-2 p-2 text-sm focus:outline-blue-600">${answerDummyText}</div>
                  </div>
                  <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                      <div class="col-span-4">
                          <label class="relative inline-flex items-center mb-4 cursor-pointer">
                              <input type="checkbox" ${isRequired ? "checked" : ""
            } class="sr-only peer">
                              <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                              <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                  Zorunlu
                              </span>
                          </label>
                          <label class="${type == "checkbox" || type == "radio" ? "" : "hidden"
            } relative inline-flex items-center mb-4 cursor-pointer">
                              <input type="checkbox" ${isHorizontal ? "checked" : ""
            } class="sr-only peer">
                              <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                              <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">
                                  Yatay olarak dizginle
                              </span>
                          </label>
                      </div>
                  </div>
              </div>
          `;
    }
    function createTextArea(questionDummyText, slug, isRequired = true) {
        return `
              <div data-type="textarea" id="question" class="relative border-2 border-dashed border-gray-400 bg-white dark:bg-gray-800 dark:border-gray-600 px-2 pt-2 text-sm m-3">
              <button type="button" class="remove absolute -top-3 -right-3 bg-red-500/80 transition duration-400 shadow-md rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-red-600 focus:outline-none">
                  <span class="sr-only">Close menu</span>
  
                  <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
              </button>
              <div contenteditable="true" data-slug="${slug}" class="mb-3 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
              <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                  <div class="col-span-4">
                      <label class="relative inline-flex items-center mb-4 cursor-pointer">
                          <input type="checkbox" ${isRequired ? "checked" : ""
            } class="sr-only peer">
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
    function createDescription(questionDummyText, slug, subType = 0) {
        return `
              <div data-type="description" id="question" class="relative border-2 border-dashed border-gray-400 bg-white dark:bg-gray-800 dark:border-gray-600 px-2 pt-2 text-sm m-3">
                  <button type="button" class="remove absolute -top-3 -right-3 bg-red-500/80 transition duration-400 shadow-md rounded-full p-1 inline-flex items-center justify-center text-white hover:bg-red-600 focus:outline-none">
                      <span class="sr-only">Close menu</span>
  
                      <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
                  <div contenteditable="true" data-slug="${slug}" class="mb-3 h-14 bg-gray-100 focus:outline-blue-600 dark:bg-gray-700 rounded-md px-4 py-2">${questionDummyText}</div>
              
                  <div class="rounded-t-lg bg-yellow-100 dark:bg-gray-900 p-2">
                      <div class="col-span-4">
                          <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md outline-none focus:ring-blue-500 focus:border-blue-500 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <option value="0" ${subType == 0 ? "selected" : ""
            }>Bilgi</option>
                              <option value="1" ${subType == 1 ? "selected" : ""
            }>Uyarı</option>
                              <option value="2" ${subType == 2 ? "selected" : ""
            }>Başarı</option>
                              <option value="3" ${subType == 3 ? "selected" : ""
            }>Tehlike</option>
                          </select>
                      </div>
                  </div>
              </div>
          `;
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
            .replace("\r\n", "<br>")
            .replace("\r", "<br/>")
            .replace("\n", "<br>")
            .replace("\t", "   ");
    };
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
                answers: []
            };
            const answers = $this.find("#answers div");
            answers.each(function () {
                question.answers.push(clearText($(this).text().trim()));
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
        $("#cover-photo-result").css({
            backgroundImage: `url('/public/images/survey/${formData.photo}')`
        });
        $("textarea[name=about]").text(
            formData.about
                .replaceAll("<br/>", "\r\n")
                .replaceAll("<br/>", "\r")
                .replaceAll("<br/>", "\n")
                .replaceAll("\t", "    ")
        );
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
                        v.isRequired
                    );
                    break;
                case "textarea":
                    content = createTextArea(v.title, v.slug, v.isRequired);
                    break;
                case "description":
                    content = createDescription(v.title, v.slug, v.subType);
                    break;
            }
            $(".questions").append(content);
        }
    };
    const renderFormEntry = (element) => {
        let content = "";
        if (element.type != "description")
            content += `
                  <div class="rounded-lg bg-slate-50/30 border mb-3 border-gray-200 shadow-sm p-4 dark:border-gray-600 dark:bg-slate-900"> 
              `;
        if (element.type != "description")
            content += `
                  <h1 data-slug="${element.slug}" class="text-clip border-b border-gray-200 pb-3 pt-1 text-lg font-medium dark:border-gray-600 mb-4">
                      ${element.title}  ${element.isRequired ? "<b class='text-red-600'>*</b>" : ""}
                  </h1>
              `;
        switch (element.type) {
            case "radio":
            case "checkbox":
                let divClass = "inline";
                if (element.isHorizontal)
                    divClass = "grid max-[980px]:grid-flow-col justify-stretch";
                content += `<div class="${divClass}">`;
                break;
            case "textarea":
                content +=
                    '<textarea name="' +
                    element.slug +
                    '" class="w-full rounded-lg border mb-3 text-gray-900 dark:text-gray-50 border-gray-200 shadow-sm bg-white p-2 focus:outline-blue-500 dark:focus:outline-blue-600 dark:border-gray-600 dark:bg-slate-900"></textarea>';
                break;
            case "description":
                const types = ["info", "warning", "success", "danger"];
                content += `
                      <div class="my-3 shadow-sm text-center rounded-md p-3 text-md ${types[element.subType]
                    }">
                          ${element.title}
                      </div>
                  `;
                break;
        }
        element.answers.forEach((answer, i) => {
            content += `
                  <div class="flex items-center mb-2 mx-1">
                      <input id="link-${element.slug + i}" name="${element.type == "radio" ? element.slug : element.slug + i
                }" type="${element.type
                }" value="${i}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="link-${element.slug + i
                }" class="ml-2 text-sm font-normal text-gray-900 dark:text-gray-300">${answer}</label>
                  </div>
              `;
        });
        if (element.type != "description") content += "</div>";
        return content;
    };
    window.generateSurvey = generate;
    window.prepareSurveyForEditing = prepareSurveyForEditing;
    $.fn.buildForm = function(data) {
        data = JSON.parse(data);
        $(".generated-form").html("");
        for (const [k, element] of Object.entries(data))
            $(".generated-form").append(renderFormEntry(element));
    };

    $(document).on("click", ".remove", function (event) {
        $(this).parent().remove();
    });
    $(document).on("click", "#preview", function (event) {
        const array = generate();
        $(".preview-content").html("");
        array.forEach((element) =>
            $(".preview-content").append(renderFormEntry(element))
        );
    });
    $(document).on("keypress", "#create-answer", function (event) {
        if (!event.shiftKey && event.which == 13) {
            $(this).prev("#answers").append(`
                  <div class="mt-2 bg-gray-100 focus:outline-blue-600 rounded-md p-2 dark:bg-gray-700" contenteditable="true">${$(
                this
            ).text()}</div>
              `);
            $(event.target).text("...");
            window.getSelection().selectAllChildren(event.target);
            return false;
        }
    });
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
});
