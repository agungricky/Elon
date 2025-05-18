<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="white-box res-mg-t-30 table-mg-t-pro-n">
        <h3 class="box-title">Sensor Udara</h3>
        <ul class="country-state">
            <li>
                <h2><span>CO2</span></h2> <small id="st_co2"></small>
                <div class="pull-right"><span id="co2"></span><i id="i_co2" class="fa text-danger ctn-ic-1"></i>
                </div>
                <div class="progress" id="co2">
                    <div class="progress-bar progress-bar-danger ctn-vs-1" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h2><span>Kelembapan Udara</span></h2> <small id="st_kelembaban_udara"></small>
                <div class="pull-right"><span id="hum"></span><i id="i_kelembaban_udara" class="fa text-success ctn-ic-2"></i>
                </div>
                <div class="progress" id="hum">
                    <div class="progress-bar progress-bar-info ctn-vs-2" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h2><span>Temperatur Udara</span></h2> <small id="st_temperatur_udara"></small>
                <div class="pull-right"><span id="temp"></span><i id="i_temperatur_udara" class="fa text-success ctn-ic-3"></i>
                </div>
                <div class="progress" id="temp">
                    <div class="progress-bar progress-bar-success ctn-vs-3" role="progressbar" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                </div>
            </li>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                type: "GET",
                url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/SCD41.json",
                dataType: "json",
                success: function(response) {
                    var co2Persen = (response.CO2 / 4000) * 100;
                    $('#co2').text(response.CO2);
                    $('#co2 .progress-bar').css('width', co2Persen + '%');
                    co2(response.CO2);

                    var humPersen = (response.hum / 80) * 100;
                    $('#hum').text(response.hum);
                    $('#hum .progress-bar').css('width', humPersen + '%');
                    kelembabanUdara(response.hum);

                    var tempPersen = (response.temp / 30) * 100;
                    $('#temp').text(response.temp);
                    $('#temp .progress-bar').css('width', tempPersen + '%');
                    temperaturUdara(response.temp);
                },
                error: function(xhr, status, error) {
                    console.error("Gagal:", error);
                }
            });
        }, 1000);

        function co2(nilai) {
            if (nilai < 1000) {
                $('#st_co2').text('Rendah');
                $('#i_co2').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 1000 && nilai <= 1200) {
                $('#st_co2').text('Normal');
                $('#i_co2').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 1200) {
                $('#st_co2').text('Tinggi');
                $('#i_co2').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function kelembabanUdara(nilai) {
            if (nilai < 60) {
                $('#st_kelembaban_udara').text('Kering');
                $('#i_kelembaban_udara').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 60 && nilai <= 80) {
                $('#st_kelembaban_udara').text('Ideal');
                $('#i_kelembaban_udara').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 80) {
                $('#st_kelembaban_udara').text('Sangat Lembab');
                $('#i_kelembaban_udara').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function temperaturUdara(nilai) {
            if (nilai < 20) {
                $('#st_temperatur_udara').text('Dingin');
                $('#i_temperatur_udara').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 20 && nilai <= 30) {
                $('#st_temperatur_udara').text('Suhu Normal');
                $('#i_temperatur_udara').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 30) {
                $('#st_temperatur_udara').text('Panas');
                $('#i_temperatur_udara').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }
    });
</script>
