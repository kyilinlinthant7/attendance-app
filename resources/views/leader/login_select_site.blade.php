<!DOCTYPE html>
<html lang="en">
<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Cleanpro Attendance</title>
    <meta name="keywords" content="HTML5, Bootstrap 3, Admin Template, UI Theme"/>
    <meta name="description" content="Alliance - A Responsive HTML5 Admin UI Framework">
    <meta name="author" content="ThemeREX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>

    <!-- -------------- CSS - theme -------------- -->
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">

    <!-- -------------- CSS - allcp forms -------------- -->
    <link rel="stylesheet" type="text/css" href="assets/allcp/forms/css/forms.css">

    <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <style>
        #main{
            max-width: 100%;
        }
        body.utility-page #main {
            background-image: url('/../../../assets/img/icons/home.png');
            /* Full height */
            height: 100vh;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /* Make the background image fixed */
            background-attachment: fixed;
            /* Optional: add a background color to make the text more readable */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
        }
        
    </style>
</head>
<body class="utility-page sb-l-c sb-r-c">

<!-- -------------- Body Wrap  -------------- -->
<div id="main" class="animated fadeIn">

    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">

        <!-- -------------- Content -------------- -->
        <section id="content" style="margin-top: 50px;">

            <!-- -------------- Login Form -------------- -->
            <div class="allcp-form theme-primary" id="login" style="max-width: 300px !important;">
                <div>
                    <h3>Hello, {{ $name }}</h3>
                </div>

                <div class="text-center">
                    <form action="{{ route('get.leader.home', [$emp_id]) }}" method="get" style="margin-top: 50px;">
                        <input type="hidden" name="user_id" value="{{ $emp_id }}">
                        <input type="hidden" name="user_name" value="{{ $name }}">
                        <div class="panel-body pn mv10">
                            @if (session('message'))
                                <div class="alert {{session('class')}}">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="section">
                                <select name="site" id="site" class="gui-input">
                                    <option>Select Site</option>
                                    @foreach($sites_id as $sites)
                                        @foreach($sites as $site)
                                            <option value="{{ $site->project->id }}">{{ $site->project->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <!-- -------------- /section -------------- -->
    
                            <div class="section">
                                <select name="shift" id="shift" class="gui-input">
                                    <option>Select Shift</option>
                                </select>
                            </div>
                            <!-- -------------- /section -------------- -->
    
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <button type="submit" class="btn btn-bordered btn-outline-primary btn-block btn-lg" style="border-radius: 10px;">Log in</button>
                                    </div>
                                </div>
                            </div>
                            <!-- -------------- /section -------------- -->
    
                        </div>
                        <!-- -------------- /Form -------------- -->
                    </form>
                </div>
                
                <!-- -------------- /Panel -------------- -->
            </div>
            <!-- -------------- /Spec Form -------------- -->

        </section>
        <!-- -------------- /Content -------------- -->

    </section>
    <!-- -------------- /Main Wrapper -------------- -->

</div>
<!-- -------------- /Body Wrap  -------------- -->

<!-- -------------- Scripts -------------- -->

<!-- -------------- Page JS -------------- -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#site").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        $('#site').change(function(){
            var siteId = $(this).val();
            $.ajax({
                url: "{{ route('get.leader.shifts', ['siteId' => ':siteId']) }}".replace(':siteId', siteId),
                type: 'GET',
                success: function(response){
                    $('#shift').empty();
                    $.each(response, function(index, shift){
                        $('#shift').append('<option value="'+ shift.id +'">'+ shift.name +'</option>');
                    });
                }
            });
        });
    });
</script>

<!-- -------------- /Scripts -------------- -->

</body>
</html>