<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="white-box res-mg-t-30 table-mg-t-pro-n">
        <h3 class="box-title">Sensor Cahaya</h3>
        <ul class="country-state">
            <li>
                <h2><span>Intensitas Cahaya</span></h2> <small id="st_cahaya"></small>
                <div class="pull-right"><span class="luminosity"></span><i id="i_cahaya" class="fa text-danger ctn-ic-1"></i></div>
                <div class="progress" id="intensitas_cahaya">
                    <div class="progress-bar progress-bar-danger ctn-vs-1" role="progressbar"
                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h2><span>Pertumbuhan Vegetatif</span></h2> <small id="st_cahaya_vegetatif"></small>
                <div class="pull-right"><span class="luminosity"></span><i id="i_cahaya_vegetatif" class="fa text-danger ctn-ic-1"></i></div>
                <div class="progress" id="vegetatif">
                    <div class="progress-bar progress-bar-info ctn-vs-2" role="progressbar"
                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h2><span>Pembungaan</span></h2> <small id="st_cahaya_pembungaan"></small>
                <div class="pull-right"><span class="luminosity"></span><i id="i_cahaya_pembungaan" class="fa text-danger ctn-ic-1"></i></div>
                <div class="progress" id="pembungaan">
                    <div class="progress-bar progress-bar-success ctn-vs-3" role="progressbar"
                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
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
                url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/ldr.json",
                dataType: "json",
                success: function(response) {
                    var intensitas_c = (response.luminosity / 4000) * 100;
                    $('.luminosity').text(response.luminosity);
                    $('#intensitas_cahaya .progress-bar').css('width', intensitas_c + '%');
                    cahaya(response.luminosity);

                    var vegetatif_v = (response.luminosity / 50000) * 100;
                    $('.luminosity').text(response.luminosity);
                    $('#vegetatif .progress-bar').css('width', vegetatif_v + '%');
                    cahayaVegetatif(response.luminosity);

                    var pembungaan_p = (response.luminosity / 70000) * 100;
                    $('.luminosity').text(response.luminosity);
                    $('#pembungaan .progress-bar').css('width', pembungaan_p + '%');
                    cahayaPembungaan(response.luminosity);
                },
                error: function(xhr, status, error) {
                    console.error("Gagal:", error);
                }
            });
        }, 1000);

        function cahaya(nilai) {
            if (nilai < 1000) {
                $('#st_cahaya').text('Rendah');
                $('#i_cahaya').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 1000 && nilai <= 4000) {
                $('#st_cahaya').text('Pertumbuhan Optimal');
                $('#i_cahaya').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 4000) {
                $('#st_cahaya').text('Terlalu Tinggi');
                $('#i_cahaya').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function cahayaVegetatif(nilai) {
            if (nilai < 15000) {
                $('#st_cahaya_vegetatif').text('Tidak optimal');
                $('#i_cahaya_vegetatif').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 15000 && nilai <= 50000) {
                $('#st_cahaya_vegetatif').text('Optimal');
                $('#i_cahaya_vegetatif').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 50000) {
                $('#st_cahaya_vegetatif').text('Tidak optimal');
                $('#i_cahaya_vegetatif').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }

        function cahayaPembungaan(nilai) {
            if (nilai < 45000) {
                $('#st_cahaya_pembungaan').text('Tidak optimal');
                $('#i_cahaya_pembungaan').attr('class', 'fa fa-level-down text-danger-ku ctn-ic-4');
            } else if (nilai >= 45000 && nilai <= 70000) {
                $('#st_cahaya_pembungaan').text('Optimal');
                $('#i_cahaya_pembungaan').attr('class', 'fa fa-check text-success-ku ctn-ic-4');
            } else if (nilai > 70000) {
                $('#st_cahaya_pembungaan').text('Tidak optimal');
                $('#i_cahaya_pembungaan').attr('class', 'fa fa-level-up text-primary-ku ctn-ic-4');
            }
        }
    });
</script>