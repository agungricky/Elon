<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="white-box res-mg-t-30 table-mg-t-pro-n">
        <h3 class="box-title">Sensor Tanah</h3>
        <ul class="country-state">
            {{-- <li>
                <h2><span>AirHumidity</span></h2> <small>From Australia</small>
                <div class="pull-right"><span id="airHumidity"></span> <i class="fa fa-level-up text-danger ctn-ic-1"></i></div>
                <div class="progress" id="airHumidity">
                    <div class="progress-bar progress-bar-danger ctn-vs-1" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                    </div>
                </div>
            </li> --}}
            <li>
                <h2><span>Konduktifitas</span></h2> <small id="st_konduktivitas"></small>
                <div class="pull-right"><span id="conductivityValue"></span> <i id="i_konduktivitas"
                        class="fa text-success ctn-ic-2"></i></div>
                <div class="progress" id="conductivityValue">
                    <div class="progress-bar progress-bar-info ctn-vs-2" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                    </div>
                </div>
            </li>
            <li>
                <h2><span>Kelembapan Tanah</span></h2> <small id="st_kelembaban"></small>
                <div class="pull-right"><span id="moistureValue"></span>
                    <i id="i_kelembaban" class="fa text-success ctn-ic-3"></i>
                </div>
                <div class="progress" id="moistureValue">
                    <div class="progress-bar progress-bar-success ctn-vs-3" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                    </div>
                </div>
            </li>
            <li>
                <h2><span>Kadar Nitrogen</span></h2> <small id="st_nitrogen"></small>
                <div class="pull-right"><span id="nitrogenValue"></span>
                    <i id="i_nitrogen" class="fa text-success ctn-ic-4"></i>
                </div>
                <div class="progress" id="nitrogenValue">
                    <div class="progress-bar progress-bar-success ctn-vs-4" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                    </div>
                </div>
            </li>
            <li>
                <h2><span>Kadar pH</span></h2> <small id="st_ph"></small>
                <div class="pull-right"><span id="phValue"></span><i id="i_ph"
                        class="fa text-success ctn-ic-5"></i>
                </div>
                <div class="progress" id="phValue">
                    <div class="progress-bar progress-bar-inverse ctn-vs-5" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                    </div>
                </div>
            </li>

            <li>
                <h2><span>Kadar Posfor</span></h2> <small id="st_p"></small>
                <div class="pull-right"><span id="phosphorusValue"></span>
                    <i id="i_p" class="fa text-success ctn-ic-5"></i>
                </div>
                <div class="progress" id="phosphorusValue">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                        aria-valuemax="100" style="width:0%; background-color: yellow;">
                    </div>
                </div>
            </li>
            <li>
                <h2><span>Kadar Kalium</span></h2> <small id="st_k"></small>
                <div class="pull-right"><span id="potassiumValue">
                    </span><i id="i_k" class="fa text-success ctn-ic-5"></i></div>
                <div class="progress" id="potassiumValue">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                        aria-valuemax="100" style="width:0%; background-color: purple;">
                    </div>
                </div>
            </li>
            <li>
                <h2><span>Suhu Tanah</span></h2> <small id="st_temperatur"></small>
                <div class="pull-right"><span id="temperatureValue"></span><i id="i_temperatur" class="fa ctn-ic-5"></i></div>
                <div class="progress" id="temperatureValue">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                        aria-valuemax="100" style="width:0%; background-color: brown;">
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<style>
    .text-danger-ku {
        color: #dc3545 !important;
    }

    .text-success-ku {
        color: #28a745 !important;
    }

    .text-primary-ku {
        color: #007bff !important;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                type: "GET",
                url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/soilSensor.json",
                dataType: "json",
                success: function(response) {
                    // var airHumidityPersen = (response.airHumidity / 255) * 100;
                    // $('#airHumidity').text(response.airHumidity);
                    // $('#airHumidity .progress-bar').css('width', airHumidityPersen + '%');

                    var conductivityValuePersen = (response.conductivityValue / 1.0) * 100;
                    $('#conductivityValue').text(response.conductivityValue);
                    $('#conductivityValue .progress-bar').css('width',
                        conductivityValuePersen + '%');
                    konduktivitasTanah(response.conductivityValue);

                    var moistureValuePersen = (response.moistureValue / 81) * 100;
                    $('#moistureValue').text(response.moistureValue);
                    $('#moistureValue .progress-bar').css('width', moistureValuePersen +
                        '%');
                    kelembabanTanah(response.moistureValue);

                    var nitrogenValuePersen = (response.nitrogenValue / 0.75) * 100;
                    $('#nitrogenValue').text(response.nitrogenValue);
                    $('#nitrogenValue .progress-bar').css('width', nitrogenValuePersen +
                        '%');
                    nitrogen(response.nitrogenValue);

                    var phValuePersen = (response.phValue / 8.5) * 100;
                    $('#phValue').text(response.phValue);
                    $('#phValue .progress-bar').css('width', phValuePersen + '%');
                    ph(response.phValue);

                    var phosphorusValuePersen = (response.phosphorusValue / 15) * 100;
                    $('#phosphorusValue').text(response.phosphorusValue);
                    $('#phosphorusValue .progress-bar').css('width', phosphorusValuePersen +
                        '%');
                    posfor(response.phosphorusValue);

                    var potassiumValuePersen = (response.potassiumValue / 1) * 100;
                    $('#potassiumValue').text(response.potassiumValue);
                    $('#potassiumValue .progress-bar').css('width', potassiumValuePersen +
                        '%');
                    kalium(response.potassiumValue);

                    var temperatureValuePersen = (response.temperatureValue / 30) * 100;
                    $('#temperatureValue').text(response.temperatureValue);
                    $('#temperatureValue .progress-bar').css('width',
                        temperatureValuePersen + '%');
                    temperaturUdara(response.temperatureValue);
                    
                },
                error: function(xhr, status, error) {
                    console.error("Gagal:", error);
                }
            });
        }, 1000);

        function nitrogen(nilai) {
            if (nilai < 0.1) {
                $('#st_nitrogen').text('Sangat Rendah');
                $('#i_nitrogen').attr('class', 'fa fa-level-down text-dange-ku ctn-ic-4');
            } else if (nilai >= 0.1 && nilai <= 0.2) {
                $('#st_nitrogen').text('Rendah');
                $('#i_nitrogen').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai > 0.2 && nilai <= 0.5) {
                $('#st_nitrogen').text('Sedang');
                $('#i_nitrogen').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 0.5 && nilai <= 0.75) {
                $('#st_nitrogen').text('Tinggi');
                $('#i_nitrogen').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else if (nilai > 0.75) {
                $('#st_nitrogen').text('Sangat Tinggi');
                $('#i_nitrogen').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function posfor(nilai) {
            if (nilai <= 4) {
                $('#st_p').text('Sangat Rendah');
                $('#i_p').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 5 && nilai <= 7) {
                $('#st_p').text('Rendah');
                $('#i_p').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 8 && nilai <= 10) {
                $('#st_p').text('Sedang');
                $('#i_p').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai >= 11 && nilai <= 15) {
                $('#st_p').text('Tinggi');
                $('#i_p').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else if (nilai > 15) {
                $('#st_p').text('Sangat Tinggi');
                $('#i_p').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function kalium(nilai) {
            if (nilai < 0.1) {
                $('#st_k').text('Sangat Rendah');
                $('#i_k').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 0.1 && nilai <= 0.3) {
                $('#st_k').text('Rendah');
                $('#i_k').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 0.4 && nilai <= 0.5) {
                $('#st_k').text('Sedang');
                $('#i_k').attr('class', 'fa fa-check text-primary-ku ctn-ic-4');
            } else if (nilai >= 0.6 && nilai <= 1.0) {
                $('#st_k').text('Tinggi');
                $('#i_k').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else if (nilai > 1.0) {
                $('#st_k').text('Sangat Tinggi');
                $('#i_k').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function ph(nilai) {
            if (nilai < 4.5) {
                $('#st_ph').text('Sangat Masam');
                $('#i_ph').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 4.5 && nilai <= 5.5) {
                $('#st_ph').text('Masam');
                $('#i_ph').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 5.5 && nilai <= 6.5) {
                $('#st_ph').text('Agak Masam');
                $('#i_ph').attr('class', 'fa fa-check text-danger-ku ctn-ic-4');
            } else if (nilai >= 6.6 && nilai <= 7.5) {
                $('#st_ph').text('Netral');
                $('#i_ph').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai >= 7.6 && nilai <= 8.5) {
                $('#st_ph').text('Agak Alkalis');
                $('#i_ph').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else if (nilai > 8.5) {
                $('#st_ph').text('Alkalis');
                $('#i_ph').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else {
                $('#st_ph').text('Data Tidak Valid');
                $('#i_ph').attr('class', 'fa fa-question text-primary-ku ctn-ic-4');
            }
        }

        function kelembabanTanah(nilai) {
            if (nilai < 20) {
                $('#st_kelembaban').text('Sangat Kering');
                $('#i_kelembaban').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 20 && nilai <= 40) {
                $('#st_kelembaban').text('Kering');
                $('#i_kelembaban').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 41 && nilai <= 60) {
                $('#st_kelembaban').text('Lembab');
                $('#i_kelembaban').attr('class', 'fa fa-check text-success ctn-ic-4');
            } else if (nilai >= 61 && nilai <= 80) {
                $('#st_kelembaban').text('Basah');
                $('#i_kelembaban').attr('class', 'fa fa-level-up text-success ctn-ic-4');
            } else if (nilai >= 81) {
                $('#st_kelembaban').text('Sangat Basah');
                $('#i_kelembaban').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else {
                $('#st_kelembaban').text('Data Tidak Valid');
                $('#i_kelembaban').attr('class', 'fa fa-question text-primary-ku ctn-ic-4');
            }
        }

        function konduktivitasTanah(nilai) {
            if (nilai < 0.1) {
                $('#st_konduktivitas').text('Rendah');
                $('#i_konduktivitas').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 0.1 && nilai <= 1.0) {
                $('#st_konduktivitas').text('Sedang');
                $('#i_konduktivitas').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 1.0) {
                $('#st_konduktivitas').text('Tinggi');
                $('#i_konduktivitas').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            } else {
                $('#st_konduktivitas').text('Data Tidak Valid');
                $('#i_konduktivitas').attr('class', 'fa fa-question text-primary-ku ctn-ic-4');
            }
        }

        function temperaturUdara(nilai) {            
            if (nilai < 20) {
                $('#st_temperatur').text('Dingin');
                $('#i_temperatur').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 20 && nilai <= 30) {
                $('#st_temperatur').text('Suhu Normal');
                $('#i_temperatur').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 30) {
                $('#st_temperatur').text('Panas');
                $('#i_temperatur').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }
    });
</script>
