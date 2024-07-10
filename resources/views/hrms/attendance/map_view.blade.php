@extends('hrms.layouts.base')

    <style>
        .gray-box {
            background-color: #f7f8ff;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .small-text {
            font-size: 10px;
        }
        .img-detail {
            width: 150px !important;
            height: 150px !important;
            object-fit: cover;
        }
    </style>


@section('content')
    
<div class="content">
    <!-- -------------- Content -------------- -->
    
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-body" style="margin-top: -10px">
                                <div class="text-left"><h5>Site Name - <b>{{ $attendance->projects->name }}</b></h5> <h5>Leader Name - <b>{{ $attendance->leaders->name }}</b></h5> </div>
                                <div class="row mt-2 mb-2" style="border-style:ridge">
                                    <iframe width="100%"
                                        height="450px"
                                        frameborder="0"
                                        scrolling="no"
                                        marginheight="0"
                                        marginwidth="0"
                                        src = "https://maps.google.com/maps?q={{ $attendance->lat }},{{ $attendance->long }}&hl=es;z=14&amp;output=embed">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-body" style="margin-top: -10px">
                                <div class="text-left">
                                    <h5>Site Name - <b>{{ $attendance->projects->name }}</b></h5>
                                    <h5>Leader Name - <b>{{ $attendance->leaders->name }}</b></h5>
                                </div>
                                <div class="row mt-2 mb-2" style="border-style:ridge">
                                    <div id="map" style="width: 100%; height: 450px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <!--</div>-->
    </section>
    
    <script>
        function initMap() {
            var siteLatLng = { lat: {{ $attendance->lat }}, lng: {{ $attendance->long }} };
    
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: siteLatLng
            });
    
            var marker = new google.maps.Marker({
                position: siteLatLng,
                map: map,
                label: '{{ $attendance->projects->name }}', // Set the label to the site name
                title: '{{ $attendance->projects->name }}' // Set the title (tooltip) to the site name
            });
        }
    </script>
    
    <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>-->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
</div>
@endsection