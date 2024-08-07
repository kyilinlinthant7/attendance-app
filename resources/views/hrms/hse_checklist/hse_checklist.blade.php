<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>HSE Checklists</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <div>
        <h1 class="text-center text-primary mt-3">HSE Checklists</h1>
        <div class="row mt-5 text-center">
            <div class="col-sm-12 col-md-6">
                <a class="btn btn-info text-light mb-5" href="{{ Request::url() }}/opt-checklist"><i class="fa fa-street-view" aria-hidden="true"></i> OPT HSE Checklist</a>
            </div>
            <div class="col-sm-12 col-md-6">
                <a class="btn btn-info text-light mb-5" href="{{ Request::url() }}/rat-checklist"><i class="fa fa-universal-access" aria-hidden="true"></i> RAT HSE Checklist</a>
            </div>
        </div>
    </div>
</body>
</html>