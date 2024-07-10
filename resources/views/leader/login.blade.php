<!DOCTYPE html>
<html>

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
                <div class="text-center">
                    <img src="{{ url('/../../../assets/img/icons/Vector.png') }}" alt="" style="width: 100%;height:100%;margin-top:-20px;">
                </div>
                <div class="text-center">
                    <img src="{{ url('/../../../assets/img/icons/clean_pro_logo.png') }}" alt="" style="width: 100%;height:100%;margin-top:-70px;">
                </div>
                <div class="text-center">
                    <form action="{{ url('/leader-check-list') }}" method="get" style="margin-top:-100px;">
                        <div class="panel-body pn mv10">
                                @if (session('message'))
                                    <div class="alert {{session('class')}}">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            <div class="section">
                                <label for="name" class="field prepend-icon">
                                    <input type="text" name="name" id="name" class="gui-input" placeholder="name">
                                    <label for="name" class="field-icon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </label>
                                </label>
                            </div>
                            <!-- -------------- /section -------------- -->
    
                            <div class="section">
                                <label for="password" class="field prepend-icon">
                                    <input type="password" name="password" id="password" class="gui-input" placeholder="Password">
                                    <label for="password" class="field-icon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </label>
                                </label>
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

<!-- -------------- jQuery -------------- -->
<script src="assets/js/jquery/jquery-1.11.3.min.js"></script>
<script src="assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

<!-- -------------- CanvasBG JS -------------- -->
<script src="assets/js/plugins/canvasbg/canvasbg.js"></script>

<!-- -------------- Theme Scripts -------------- -->
<script src="assets/js/utility/utility.js"></script>
<script src="assets/js/demo/demo.js"></script>
<script src="assets/js/main.js"></script>

<!-- -------------- Page JS -------------- -->
<script type="text/javascript">
    jQuery(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init CanvasBG
        CanvasBG.init({
            Loc: {
                x: window.innerWidth / 5,
                y: window.innerHeight / 10
            }
        });

    });
</script>

<!-- -------------- /Scripts -------------- -->

</body>

</html>