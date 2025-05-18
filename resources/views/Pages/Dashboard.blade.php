@extends('Main')
@section('content')
    <div class="courses-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Sensor Status</h3>
                        <ul class="basic-list">
                            <li class="sensor">
                                Sensor Udara
                                <span id="su" class="pull-right label-1 label"></span>
                            </li>
                            <li class="sensor">
                                Sensor Cahaya
                                <span id="sc" class="pull-right label-1 label"></span>
                            </li>
                            <li class="sensor">
                                Sensor Tanah
                                <span id="st" class="pull-right label-1 label"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="courses-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                @include('Section.SCD41')
                @include('Section.Ldr')
                @include('Section.Soil')
            </div>
        </div>
    </div>

    <style>
        .label-success {
            background-color: rgb(21, 148, 21) !important;
            color: white !important;
            padding: 10px 10px !important;
            border-radius: 3px !important;
        }

        .label-danger {
            background-color: rgb(224, 30, 30) !important;
            color: white !important;
            padding: 10px 10px !important;
            border-radius: 3px !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            setInterval(() => {
                $.ajax({
                    type: "GET",
                    url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/.json",
                    dataType: "json",
                    success: function(response) {
                        const SCD41 = response.SCD41;
                        const LDR = response.ldr;
                        const Soil = response.soilSensor;

                        if ((SCD41.CO2 == 0) || (LDR.hum == 0) || (Soil.temp == 0)) {
                            $('#su').text("Not Running").removeClass('label-success').addClass(
                                'label-danger');
                        } else {
                            $('#su').text("Running").removeClass('label-danger').addClass(
                                'label-success');
                        }

                        if (LDR.luminosity == 0) {
                            $('#sc').text("Not Running").removeClass('label-success').addClass(
                                'label-danger');
                        } else {
                            $('#sc').text("Running").removeClass('label-danger').addClass(
                                'label-success');
                        }

                        if ((Soil.conductivityValue == 0) || (Soil.moistureValue == 0) || (Soil
                                .nitrogenValue == 0) ||
                            (Soil.phValue == 0) || (Soil.phosphorusValue == 0) || (Soil
                                .potassiumValue == 0) ||
                            (Soil.temperatureValue == 0)) {
                            $('#st').text("Not Running").removeClass('label-success').addClass(
                                'label-danger');
                        } else {
                            $('#st').text("Running").removeClass('label-danger').addClass(
                                'label-success');
                        }
                    }
                });
            }, 1000);
        });
    </script>
@endsection
