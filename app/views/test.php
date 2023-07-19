<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    {njs("sdeasy/sdeasy")|noescape}
</head>

<body class="container">
    <div class="p-0 vstack m-5">
        <form role="form" action="/survey" method="post" class="list-group shadow-sm rounded-4 overflow-hidden border" data-content=".result">
            <div class="bg-danger list-group-item list-group-item-action border-0 border-bottom"></div>
            <div class="result"></div>
            <div class="list-group-item list-group-item-action border-0 border-bottom display-6 text-center p-4 text-muted">This is testing title</div>
            <label for="answer1" class="p-4 list-group-item list-group-item-action border-0 border-bottom">
                <div class="d-flex">
                    <input id="answer1" class="align-self-start form-check-input me-3" type="radio" name="answer" value="0" checked>
                    <h5 class="mb-1">List group item heading</h5>
                </div>
                <p class="mb-1">Some placeholder content in a paragraph.</p>
                <small>And some small print.</small>
            </label>
            <label for="answer2" class="p-4 list-group-item list-group-item-action border-0 border-bottom">
                <div class="d-flex">
                    <input id="answer2" class="align-self-start form-check-input me-3" type="radio" name="answer" value="1">
                    <h5 class="mb-1">List group item heading</h5>
                </div>
                <p class="mb-1">Some placeholder content in a paragraph.</p>
                <small class="text-body-secondary">And some muted small print.</small>
            </label>
            <button class="rounded-0 m-0 btn btn-lg btn-light shadow-sm">CONTINUE</button>
</form>
    </div>
</body>

</html>