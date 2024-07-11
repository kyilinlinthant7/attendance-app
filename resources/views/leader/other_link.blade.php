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
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
        *{
            font-family: 'Roboto', sans-serif;
        }

        .text-dark {
            color: #343434;
        }

        .footer-icon {
            font-size: 25px;
        }

        .link {
            text-decoration: none;
            color: white;
        }
        
        body {
            height: 100vh;
        }

        #main1 {
            max-width: 100%;
            height: 84%;
            background-image: url('/../../../assets/img/icons/bg.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
        }
        .header {
            background-image: url('/../../../assets/img/icons/header.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            height: 8%;
        }
        #logo {
            margin-top: 10px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .footer-div {
            padding-top: 10px;
        }
        .footer {
            background-image: url('/../../../assets/img/icons/footer.png');
            height: 8%;
            color: white !important;
        }
        #timebar {
            height: 20%;
        }
        .grid {
            height: 26.8%;
            color: #343434;
            padding-top: 12px;
        }
        #blank {
            height: 5%;
        }
        .icon-imgs {
            width: 60%;
            height: 70%;
            /* background: linear-gradient(#49B870, #005FA5); */
            background-image: url('/../../../assets/img/icons/header.png');
            border-radius: 18px;
            padding: 10px;
        }
        .icon-imgs-att {
            width: 60%;
            height: 70%;
            /* background: linear-gradient(#49B870, #005FA5); */
            background-image: url('/../../../assets/img/icons/header.png');
            border-radius: 18px;
            padding: 10px 10px 10px 15px;
        }
        .p-bold {
            font-size: 14px;
        }
        #editBtn {
            border: 1px solid lightseagreen;
            border-radius: 20px;
            width: 50%;
        }
        .btn-div {
            width: 90%;
            height: 40px;
            margin: auto;
            padding: 10px;
            background: seagreen;
            border-radius: 10px;
            /* padding-top: 13px; */
            margin-top: 10px;
        }
        .icon {
            font-size: 20px;
        }
    </style>
</head>
<body class="utility-page sb-l-c sb-r-c">
    <div class="header" style="padding-top: 12px;">
        <div class="col-xs-12 text-center">
            <h4 style="color: white;">Profile</h4>
        </div>
    </div>

    <!-- -------------- Body Wrap  -------------- -->
    <div id="main1">
        <div class="text-center" style="margin-bottom: 20px;">
            <img src="/../../../assets/img/icons/profile.jpg" id="logo">
            <h4 class="text-dark">{{ $user->name }}</h4>
            <p style="color: gray">{{ $user->employee_id }}</p>
            <a class="btn" id="editBtn">Edit Profile</a>
        </div>
        
        <div>
            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="btn-div">
                <div class="col-xs-2">
                    <i class="fa fa-info-circle icon"></i> 
                </div>
                <div class="col-xs-8">
                    <span class="p-bold btn-text">Clean Pro အကြောင်း</span>
                </div>
                <div class="col-xs-2">
                    <i class="fa fa-chevron-right icon" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------- /Body Wrap  -------------- -->

    <div class="footer text-center">
        <div class="col-xs-6 footer-div">
            <a href="{{ route('get.leader.home', [$userId]) }}" class="link">
                <i class="fa fa-home footer-icon" aria-hidden="true"></i>
                <br>
                <span>Home</span>
            </a>
        </div>
        <div class="col-xs-6 footer-div">
            <a href="" class="link">
                <i class="fa fa-user footer-icon" aria-hidden="true"></i>
                <br>
                <span>Other</span>
            </a>
        </div>
    </div>

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
    <!-- -------------- /Scripts -------------- -->

    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        realTime();
    });
    
    function realTime() 
    {
        var date = new Date();
        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();
        var halfday = "AM";
        halfday = (hour >= 12) ? "PM" : "AM";
        hour = (hour == 0) ? 12 : ((hour > 12) ? (hour - 12): hour);
        hour = update(hour);
        min = update(min);
        sec = update(sec);
        document.getElementById("h").innerText = hour;
        document.getElementById("m").innerText = min;
        document.getElementById("s").innerText = sec;
        document.getElementById("ap").innerText = halfday;
    
        setTimeout(realTime, 1000);
    }
    
    function update(k) {
        if (k < 10) { 
            return "0" + k; 
        } else { 
            return k; 
        } 
    }
</script>
</body>
</html>