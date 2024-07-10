<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title> Cleanpro Attendance</title>
    <meta name="description" content="HRMS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{csrf_token()}}">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="assets/img/favicon.png">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.8/sweetalert2.min.css" rel="stylesheet">


    <!----for select2------->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet">

    
    <link rel="stylesheet" type="text/css"  href="{{URL::asset('assets/allcp/forms/css/forms.css')}}">



     <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/c3charts/c3.min.css') }}">
  
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/magnific/magnific-popup.css') }}">
    <!-- Scripts -->
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--<script src="http://code.jquery.com/jquery.js"></script>-->

    
    



    <!-----------------select2---------------------->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"  defer></script> 

    


    
    <!-- -------------- CSS - theme -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/skin/default_skin/css/theme.css') }}">
   
    <!--  Custom css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/custom.css') }}">

    <style>
        #content {
            margin-top: 50px;
        }
    </style>

</head>




<body class="dashboard-page">

<!-- -------------- Customizer -------------- -->
 <div id="customizer" class="hidden-xs">
    
</div>
<!-- -------------- /Customizer -------------- -->

<!-- -------------- Body Wrap  -------------- -->
<div id="main">
    <!-- -------------- Header  -------------- -->
    @include('hrms.layouts.header')
    <!-- -------------- /Header  -------------- -->

    <!-- -------------- Sidebar  -------------- -->
    <aside id="sidebar_left" class="nano nano-light affix">

        <!-- -------------- Sidebar Left Wrapper  -------------- -->
        <div class="sidebar-left-content nano-content">

            <!-- -------------- Sidebar Header -------------- -->
            <header class="sidebar-header">

                <!-- -------------- Sidebar - Author -------------- -->
            @include('hrms.layouts.sidebar')

            <!-- -------------- Sidebar Hide Button -------------- -->
            <div class="sidebar-toggler" style="margin-left:20px">
                <a href="#"  >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </a>
            </div>
            <!-- -------------- /Sidebar Hide Button -------------- -->

        </div>
        <!-- -------------- /Sidebar Left Wrapper  -------------- -->

    </aside>

    <!-- -------------- /Sidebar -------------- -->



    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">
        <!-- YIELD CONTENT -->
        @yield('content')
        <!-- /YIELD CONTENT -->

        <!-- -------------- Page Footer -------------- -->
        <!--<footer id="content-footer" class="affix">-->
        <!--    <div class="row">-->
        <!--        <div class="col-md-6">-->
        <!--            <span class="footer-legal">Cleanpro Att © 2023 All rights reserved. By Cleanpro Attendance</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-6 text-right">-->
        <!--            <span class="footer-meta"></span>-->
        <!--            <a href="#content" class="footer-return-top">-->
        <!--                <span class="fa fa-angle-up"></span>-->
        <!--            </a>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</footer>-->
        <!-- -------------- /Page Footer -------------- -->
    </section>
    <!-- -------------- /Main Wrapper -------------- -->
</div>
<!-- -------------- /Body Wrap  -------------- -->





<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->

{{-- <script src="{{ URL::asset('assets/js/jquery/jquery-1.11.3.min.js') }}"></script> 
<script src="{{ URL::asset('assets/js/jquery/jquery-2.2.4.min.js') }}"></script> --}}
<script src="{{ URL::asset('assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>


<script src="{{ URL::asset('assets/js/plugins/c3charts/c3.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/c3charts/d3.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/magnific/jquery.magnific-popup.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/magnific/jquery.magnific-popup.min.js') }}"></script>

<!-- -------------- FullCalendar Plugin -------------- -->
<script src="{{ URL::asset('assets/js/plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<!-- -------------- Date/Month - Pickers -------------- -->
<script src="{{ URL::asset('assets/allcp/forms/js/jquery-ui-monthpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/allcp/forms/js/jquery-ui-datepicker.min.js') }}"></script>


<!-- -------------- Theme Scripts -------------- -->
<script src="{{ URL::asset('assets/js/utility/utility.js') }}"></script>
<script src="{{ URL::asset('assets/js/demo/demo.js') }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>


<!-- -------------- Widget JS -------------- -->
<script src="{{ URL::asset('assets/js/demo/widgets.js') }}"></script>
<script src="{{ URL::asset('assets/js/demo/widgets_sidebar.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/dashboard1.js') }}"></script>




<script src="{{URL::asset('assets/allcp/forms/js/jquery.spectrum.min.js')}}"></script>
<script  src="{{URL::asset('assets/allcp/forms/js/jquery.validate.min.js')}}"></script>
<script  src="{{URL::asset('assets/allcp/forms/js/jquery.stepper.min.js')}}" ></script>

<script  src="{{URL::asset('assets/allcp/forms/js/jquery.steps.min.js')}}" ></script>
<script src="{{URL::asset('assets/js/emp_wiz_latest.js')}}"></script>
<script src="{{URL::asset('assets/js/pages/forms-widgets.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $('#datetimepicker2').datetimepicker();

        
        //for all select box
    $(document).ready(function() {
        $('.select2-multiple').select2();
    });


        //for user random password
    $( document ).ready(function() {
        $('#genpass').on("click",function(){
                
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$&";

        // Generate a random password of length 6
        let password = "";
        for (let i = 0; i < 6; i++) {
        // Pick a random character from the allowed characters
            const index = Math.floor(Math.random() * chars.length);
            password += chars[index];
            }
            $('#password').val(password);
        });
    });
    
    
    $(document).ready(function(){
        $('#datepicker4').on("change",function(){
            var start_date = $( "#datepicker1" ).val();
            var end_date = $( "#datepicker4" ).val();
            if(start_date == end_date){
                $('#half').attr('disabled',false);
                $('#full').attr('disabled',false);
            }else{
                $('#half').attr('disabled',true);
                $('#full').attr('disabled',true);
            }
            var st= new Date(start_date);
            var ed= new Date(end_date);
            
            console.log(st);
            console.log(ed);
            //timeDiff
            var timeDiff = Math.abs(ed.getTime() - st.getTime());

            console.log(timeDiff);

            //days difference
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24))+1;

            console.log(diffDays);
            $('#total_days').val(diffDays);
            // $('#half').attr('disabled',false);
        });


        $('#datepicker1').on("change",function(){
            var start_date = $( "#datepicker1" ).val();
            var end_date = $( "#datepicker4" ).val();
            if(start_date == end_date){
                $('#half').attr('disabled',false);
                $('#full').attr('disabled',false);
            }else{
                $('#half').attr('disabled',true);
                $('#full').attr('disabled',true);
            }
            var st= new Date(start_date);
            var ed= new Date(end_date);
            
            //timeDiff
            var timeDiff = Math.abs(ed.getTime() - st.getTime());

            console.log(timeDiff);

            //days difference
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24))+1;

            console.log(diffDays);
            $('#total_days').val(diffDays);
            // $('#half').attr('disabled',false);
           
        });

        $('#half').on("click", function(){
            var days=$('#total_days').val();
            console.log(days);
            var x=parseInt(days)*0.5;
            console.log(x);
            $('#total_days').val(x);

            $('#half').attr('disabled',true);
            $('#full').attr('disabled',false);
        });

        $('#full').on("click", function(){
            var start_date = $( "#datepicker1" ).val();
            var end_date = $( "#datepicker4" ).val();
            var st= new Date(start_date);
            var ed= new Date(end_date);
            
            console.log(st);
            console.log(ed);

            var timeDiff = Math.abs(ed.getTime() - st.getTime());

            console.log(timeDiff);

            //days difference
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24))+1;

            console.log(diffDays);
            $('#total_days').val(diffDays);
            $('#half').attr('disabled',false);
            $('#full').attr('disabled',true);
        });
        
        $('#close').on("click",function(){
            window.location.reload();
           
        });
        

        $("#addimage").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
        });

        $("body").on("click",".btn-danger",function(){ 
            $(this).parents(".control-group").remove();
        });

    });
    
    
    $(document).ready(function(){
        $('#joindate').on('change',function(){
           // alert(1);
            var date = $('#joindate').val();

           // alert(date);

            var userInputDate = new Date(date);
            var currentDate = new Date();

            var timeDiff = Math.abs(currentDate.getTime() - userInputDate.getTime());
            var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            //alert(daysDiff);

            var days = daysDiff;
            const years = Math.floor(days / 365);
            const remainingDaysOfYear = days % 365;
            const months = Math.floor(remainingDaysOfYear / 30);
            const remainingDaysOfMonth = remainingDaysOfYear % 30;
            var service =(years + " years, " + months + " months, and " + remainingDaysOfMonth + " days");

           // alert(service);

            $('#service').val(service);

        });
    });

</script>
@yield('custom_js')
</body>
</html>