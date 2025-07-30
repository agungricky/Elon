@extends('Main')
@section('content')
    <div class="courses-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <div class="white-box">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">MAPS Lokasi Pengguna</h2>
                                <p class="font-weight-500">Lokasi Anda saat ini diperbarui menggunakan data sensor GPS. Peta
                                    di
                                    bawah
                                    akan terus menampilkan posisi terbaru Anda sesuai dengan data yang diterima dari sensor.
                                    Pastikan sensor GPS Anda aktif untuk mendapatkan hasil yang akurat.</p>
                                <div id="map" style="height: 500px; width: 100%; position: relative;"></div>
                                <p id="location-info" class="mt-1">Menunggu data GPS...</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 mb-3">
                                <div>
                                    <h4 class="mb-4">Data Sensor Udara</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th class="text-center">Jenis Sensor</th>
                                                <th class="text-center">Keterangan</th>
                                                <th class="text-center">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td>CO<sub>2</sub></td>
                                                <td id="st_co2"></td>
                                                <td id="co2"></td>
                                            </tr>
                                            <tr>
                                                <td>Kelembapan Udara</td>
                                                <td id="st_hum"></td>
                                                <td id="hum"></td>
                                            </tr>
                                            <tr>
                                                <td>Temperatur Udara</td>
                                                <td class="st_temp"></td>
                                                <td id="temp"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <div>
                                    <h4 class="mb-4">Data Sensor Cahaya</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-warning text-center">
                                            <tr>
                                                <th>Jenis Parameter</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td>Intensitas Cahaya</td>
                                                <td id="st_cahaya"></td>
                                                <td class="luminosity"></td>
                                            </tr>
                                            <tr>
                                                <td>Pertumbuhan Vegetatif</td>
                                                <td id="st_cahaya_vegetatif"></td>
                                                <td class="luminosity"></td>
                                            </tr>
                                            <tr>
                                                <td>Pembungaan</td>
                                                <td id="st_cahaya_pembungaan"></td>
                                                <td class="luminosity"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <div>
                                    <h4 class="mb-4">Data Sensor Tanah</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th>Jenis Parameter</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td>Konduktifitas</td>
                                                <td id="st_konduktivitas"></td>
                                                <td id="conductivityValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Kelembapan Tanah</td>
                                                <td id="st_kelembaban"></td>
                                                <td id="moistureValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Kadar Nitrogen</td>
                                                <td id="st_nitrogen"></td>
                                                <td id="nitrogenValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Kadar pH</td>
                                                <td id="st_ph"></td>
                                                <td id="phValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Kadar Posfor</td>
                                                <td id="st_p"></td>
                                                <td id="phosphorusValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Kadar Kalium</td>
                                                <td id="st_k"></td>
                                                <td id="potassiumValue"></td>
                                            </tr>
                                            <tr>
                                                <td>Suhu Tanah</td>
                                                <td class="st_temp"></td>
                                                <td id="temperatureValue"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toDMS(deg, isLat) {
            const absolute = Math.abs(deg);
            const degrees = Math.floor(absolute);
            const minutesNotTruncated = (absolute - degrees) * 60;
            const minutes = Math.floor(minutesNotTruncated);
            const seconds = Math.floor((minutesNotTruncated - minutes) * 60);

            const direction = deg >= 0 ?
                (isLat ? 'N' : 'E') :
                (isLat ? 'S' : 'W');

            return `${degrees}°${minutes}'${seconds}" ${direction}`;
        }

        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let firstUpdate = true;
        let marker;

        $(document).ready(function() {
            let prevLat = null;
            let prevLng = null;

            setInterval(() => {
                $.ajax({
                    type: "GET",
                    url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/maps.json",
                    dataType: "JSON",
                    success: function(response) {
                        if (response && response.lat && response.lng) {
                            let lat = response.lat;
                            let lng = response.lng;

                            // Ambil data dari SQLite
                            $.getJSON('/data', function(sqliteData) {
                                const dataSudahAda = sqliteData.some(item =>
                                    parseFloat(item.lat) === lat && parseFloat(item.lng) === lng
                                );

                                if (dataSudahAda) {
                                    $('#location-info').text('Lokasi sudah tersimpan di database.');
                                    return;
                                }

                                if (lat === prevLat && lng === prevLng) {
                                    return;
                                }

                                prevLat = lat;
                                prevLng = lng;

                                // Ubah tampilan map
                                if (firstUpdate) {
                                    map.setView([lat, lng], 12);
                                    firstUpdate = false;
                                } else {
                                    map.setView([lat, lng], map.getZoom());
                                }

                                // Reverse geocoding
                                $.get(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`, function(data) {
                                    let namaTempat = (data && data.display_name) ? data.display_name : `Lat: ${lat}, Lng: ${lng}`;

                                    if (marker) {
                                        map.removeLayer(marker);
                                    }

                                    marker = L.marker([lat, lng]).addTo(map)
                                        .bindPopup(`📍 ${namaTempat}`)
                                        .openPopup();

                                    $('#location-info').text(`Lokasi: ${namaTempat}`);
                                });
                            });
                        } else {
                            $('#location-info').text('Data GPS tidak ditemukan.');
                        }
                    },
                    error: function() {
                        $('#location-info').text('Gagal mengambil data GPS.');
                    }
                });
            }, 2000);

            $.ajax({
                type: "GET",
                url: "data", // pastikan ini route Laravel yang return JSON
                dataType: "json",
                success: function (response) {
                    response.forEach(item => {
                        // Parse index_id JSON
                        let indexData = {};
                        try {
                            indexData = JSON.parse(item.index_id);
                        } catch (e) {
                            console.warn("Gagal parse index_id", e);
                        }

                        // const color = indexData.color ?? "#ff0000"; // fallback merah
                        const tempat = item.location_name ?? "Tanpa Nama";

                        // Buat icon standar peta dengan warna custom (pakai SVG base64 warna custom jika mau dinamis)
                        const iconSVG = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64">
                            <path d="M32 0C19 0 8 11 8 24c0 14.3 17.7 34.4 22.6 40.1a2 2 0 0 0 2.9 0C38.3 58.4 56 38.3 56 24 56 11 45 0 32 0zm0 34a10 10 0 1 1 0-20 10 10 0 0 1 0 20z" fill="${item.index.color}"/>
                            <path d="M27 26l4 4 8-8-2-2-6 6-2-2z" fill="#fff"/>
                            </svg>
                        `;

                        const icon = L.divIcon({
                            html: iconSVG,
                            className: "", 
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                            popupAnchor: [0, -32]
                        });

                        const rawTanggal = item.index.tanggal ?? null;
                        let formattedTanggal = '-';

                        if (rawTanggal) {
                            const dateObj = new Date(rawTanggal);
                            formattedTanggal = dateObj.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                        }

                        const popupText = `
                            <div id="popup-${item.id}" style="cursor:pointer; max-width: 250px;">
                                📍 ${tempat}<br><hr>
                                diambil : ${formattedTanggal ?? '-'} <br>
                                <small id="extra-${item.id}">(klik untuk info selengkapnya)</small>
                                <p id="info-${item.id}"></p>
                            </div>
                        `;

                        const marker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon })
                                        .addTo(map)
                                        .bindPopup(popupText);

                        marker.on('popupopen', function () {
                            const infoElement = $(`#info-${item.id}`);
                            const extraElement = $(`#extra-${item.id}`);

                            extraElement.on('click', function () {
                                if (infoElement.is(':empty')) {
                                    infoElement.html(`
                                        <strong>Data Sensor:</strong><br>
                                        CO<sub>2</sub>: ${item.co2} ppm<br>
                                        Kelembapan Udara: ${item.hum} %<br>
                                        Temperatur Udara: ${item.temp} °C<br>
                                        Cahaya: ${item.luminosity} lux<br>
                                        Kelembapan Tanah: ${item.airHumidity} %<br>
                                        Konduktivitas: ${item.conductivityValue} mS/cm<br>
                                        Nitrogen: ${item.nitrogenValue} ppm<br>
                                        pH: ${item.phValue} pH<br>
                                        Posfor: ${item.phosphorusValue} ppm<br>
                                        Kalium: ${item.potassiumValue} ppm<br>
                                        Suhu Tanah: ${item.temperatureValue} °C
                                    `);
                                    extraElement.text('(klik untuk sembunyikan info)');
                                } else {
                                    infoElement.empty();
                                    extraElement.text('(klik untuk info selengkapnya)');
                                }
                            });
                        });
                    });

                    if (response.length > 0) {
                        const last = response[response.length - 1];
                        const lastLat = parseFloat(last.lat);
                        const lastLng = parseFloat(last.lng);

                        map.setView([lastLat, lastLng], 13); // bisa ubah angka 13 untuk zoom level
                    }
                },
                error: function () {
                    console.error("Gagal ambil data lokasi dari SQLite.");
                }
            });


            setInterval(() => {
                $.ajax({
                    type: "GET",
                    url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/maps/Button.json",
                    dataType: "json",
                    success: function(response) {
                        if (response == true) {
                            $.ajax({
                                url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/maps.json",
                                type: "PATCH",
                                data: JSON.stringify({
                                    Button: false
                                }),
                                contentType: "application/json",
                                success: function(response) {

                                    $.ajax({
                                    type: "GET",
                                    url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/.json",
                                    dataType: "json",
                                    success: function(sensor) {
                                        $.ajax({
                                            type: "GET",
                                            url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/maps.json",
                                            dataType: "json",
                                            success: function(maps) {
                                                let lat = maps.lat;
                                                let lng = maps.lng;

                                                function getRandomColor() {
                                                    const letters = '0123456789ABCDEF';
                                                    let color = '#';
                                                    for (let i = 0; i < 6; i++) {
                                                        color += letters[Math.floor(Math.random() * 16)];
                                                    }
                                                    return color;
                                                }

                                                $.get(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`, function(data) {
                                                    let namaTempat = data.display_name || `Lat: ${lat}, Lng: ${lng}`;

                                                    let form = {
                                                        _token: '{{ csrf_token() }}',
                                                        tanggal: new Date().toISOString().slice(0, 10),
                                                        color: getRandomColor(),
                                                        button: false,

                                                        latitude: lat,
                                                        longitude: lng,
                                                        lokasi: namaTempat,

                                                        // Data Udara
                                                        co2: sensor.SCD41.CO2,
                                                        hum: sensor.SCD41.hum,
                                                        temp: sensor.SCD41.temp,

                                                        // Cahaya
                                                        luminosity: sensor.ldr.luminosity,

                                                        // Data Tanah
                                                        airHumidity: sensor.soilSensor.airHumidity,
                                                        conductivityValue: sensor.soilSensor.conductivityValue,
                                                        moistureValue: sensor.soilSensor.moistureValue,
                                                        nitrogenValue: sensor.soilSensor.nitrogenValue,
                                                        phValue: sensor.soilSensor.phValue,
                                                        phosphorusValue: sensor.soilSensor.phosphorusValue,
                                                        potassiumValue: sensor.soilSensor.potassiumValue,
                                                        temperatureValue: sensor.soilSensor.temperatureValue,
                                                    };

                                                    // Kirim data setelah form lengkap
                                                   $.ajax({
                                                        type: "POST",
                                                        url: "data",
                                                        data: form,
                                                        dataType: "json",
                                                        success: function(response) {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Berhasil',
                                                                text: 'Data berhasil disimpan!',
                                                                timer: 2000,
                                                                showConfirmButton: false
                                                            }).then(() => {
                                                                location.reload();
                                                            });
                                                            console.log("Berhasil kirim:", response);
                                                        },
                                                        error: function(xhr, status, error) {
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Gagal',
                                                                text: `Terjadi kesalahan: ${xhr.status} - ${xhr.responseText}`,
                                                                timer: 2000,
                                                                showConfirmButton: false
                                                            });
                                                            console.error("Gagal kirim:", xhr.status, xhr.responseText);
                                                        }
                                                    });

                                                });
                                            }
                                        });
                                    },
                                    error: function(err) {
                                        console.error("Gagal ambil data:", err);
                                    }
                                });

                                },
                                error: function(err) {
                                    console.error("Gagal update:", err);
                                }
                            });
                            
                            
                        }
                    }
                });
            }, 1000);


            setInterval(() => {
                $.ajax({
                    type: "GET",
                    url: "https://elon-2025-default-rtdb.asia-southeast1.firebasedatabase.app/.json",
                    dataType: "json",
                    success: function(response) {
                        // UDARA
                        $('#co2').text(response.SCD41.CO2 + ' ppm');
                        co2(response.SCD41.CO2);

                        $('#hum').text(response.SCD41.hum + ' %');
                        kelembabanUdara(response.SCD41.hum);

                        $('#temp').html(response.SCD41.temp + ' &deg;C');
                        temperaturUdara(response.SCD41.temp);

                        // CAHAYA
                        $('.luminosity').text(response.ldr.luminosity + ' lux');
                        cahaya(response.ldr.luminosity);

                        $('.luminosity').text(response.ldr.luminosity + ' lux');
                        cahayaVegetatif(response.ldr.luminosity);

                        $('.luminosity').text(response.ldr.luminosity + ' lux');
                        cahayaPembungaan(response.ldr.luminosity);


                        // TANAH
                        $('#conductivityValue').text(response.soilSensor.conductivityValue +
                            ' mS/cm');
                        konduktivitasTanah(response.soilSensor.conductivityValue);

                        $('#moistureValue').text(response.soilSensor.moistureValue + ' %');
                        kelembabanTanah(response.soilSensor.moistureValue);

                        $('#nitrogenValue').text(response.soilSensor.nitrogenValue + ' ppm');
                        nitrogen(response.soilSensor.nitrogenValue);

                        $('#phValue').text(response.soilSensor.phValue + ' pH');
                        ph(response.soilSensor.phValue);

                        $('#phosphorusValue').text(response.soilSensor.phosphorusValue +
                            ' ppm');
                        posfor(response.soilSensor.phosphorusValue);

                        $('#potassiumValue').text(response.soilSensor.potassiumValue + ' ppm');
                        kalium(response.soilSensor.potassiumValue);

                        $('#temperatureValue').text(response.soilSensor.temperatureValue +
                            ' °C');
                        temperaturUdara(response.soilSensor.temperatureValue);
                    }
                });
            }, 1000);

            // ===================== UDARA ===================== //
            function co2(nilai) {
                if (nilai < 1000) {
                    $('#st_co2').text('Rendah');
                } else if (nilai >= 1000 && nilai <= 1200) {
                    $('#st_co2').text('Normal');
                } else if (nilai > 1200) {
                    $('#st_co2').text('Tinggi');
                }
            }

            function kelembabanUdara(nilai) {
                if (nilai < 60) {
                    $('#st_hum').text('Kering');
                } else if (nilai >= 60 && nilai <= 80) {
                    $('#st_hum').text('Ideal');
                } else if (nilai > 80) {
                    $('#st_hum').text('Sangat Lembab');
                }
            }

            function temperaturUdara(nilai) {
                if (nilai < 20) {
                    $('.st_temp').text('Dingin');
                } else if (nilai >= 20 && nilai <= 30) {
                    $('.st_temp').text('Suhu Normal');
                } else if (nilai > 30) {
                    $('.st_temp').text('Panas');
                }
            }

            // ===================== Cahaya ===================== //
            function cahaya(nilai) {
                if (nilai < 1000) {
                    $('#st_cahaya').text('Rendah');
                } else if (nilai >= 1000 && nilai <= 4000) {
                    $('#st_cahaya').text('Pertumbuhan Optimal');
                } else if (nilai > 4000) {
                    $('#st_cahaya').text('Terlalu Tinggi');
                }
            }

            function cahayaVegetatif(nilai) {
                if (nilai < 15000) {
                    $('#st_cahaya_vegetatif').text('Tidak optimal');
                } else if (nilai >= 15000 && nilai <= 50000) {
                    $('#st_cahaya_vegetatif').text('Optimal');
                } else if (nilai > 50000) {
                    $('#st_cahaya_vegetatif').text('Tidak optimal');
                }
            }

            function cahayaPembungaan(nilai) {
                if (nilai < 45000) {
                    $('#st_cahaya_pembungaan').text('Tidak optimal');
                } else if (nilai >= 45000 && nilai <= 70000) {
                    $('#st_cahaya_pembungaan').text('Optimal');
                } else if (nilai > 70000) {
                    $('#st_cahaya_pembungaan').text('Tidak optimal');
                }
            }

            // ===================== Tanah ===================== //
            function nitrogen(nilai) {
                if (nilai < 0.1) {
                    $('#st_nitrogen').text('Sangat Rendah');
                } else if (nilai >= 0.1 && nilai <= 0.2) {
                    $('#st_nitrogen').text('Rendah');
                } else if (nilai > 0.2 && nilai <= 0.5) {
                    $('#st_nitrogen').text('Sedang');
                } else if (nilai > 0.5 && nilai <= 0.75) {
                    $('#st_nitrogen').text('Tinggi');
                } else if (nilai > 0.75) {
                    $('#st_nitrogen').text('Sangat Tinggi');
                }
            }

            function posfor(nilai) {
                if (nilai <= 4) {
                    $('#st_p').text('Sangat Rendah');
                } else if (nilai >= 5 && nilai <= 7) {
                    $('#st_p').text('Rendah');
                } else if (nilai >= 8 && nilai <= 10) {
                    $('#st_p').text('Sedang');
                } else if (nilai >= 11 && nilai <= 15) {
                    $('#st_p').text('Tinggi');
                } else if (nilai > 15) {
                    $('#st_p').text('Sangat Tinggi');
                }
            }

            function kalium(nilai) {
                if (nilai < 0.1) {
                    $('#st_k').text('Sangat Rendah');
                } else if (nilai >= 0.1 && nilai <= 0.3) {
                    $('#st_k').text('Rendah');
                } else if (nilai >= 0.4 && nilai <= 0.5) {
                    $('#st_k').text('Sedang');
                } else if (nilai >= 0.6 && nilai <= 1.0) {
                    $('#st_k').text('Tinggi');
                } else if (nilai > 1.0) {
                    $('#st_k').text('Sangat Tinggi');
                }
            }

            function ph(nilai) {
                if (nilai < 4.5) {
                    $('#st_ph').text('Sangat Masam');
                } else if (nilai >= 4.5 && nilai <= 5.5) {
                    $('#st_ph').text('Masam');
                } else if (nilai >= 5.5 && nilai <= 6.5) {
                    $('#st_ph').text('Agak Masam');
                } else if (nilai >= 6.6 && nilai <= 7.5) {
                    $('#st_ph').text('Netral');
                } else if (nilai >= 7.6 && nilai <= 8.5) {
                    $('#st_ph').text('Agak Alkalis');
                } else if (nilai > 8.5) {
                    $('#st_ph').text('Alkalis');
                } else {
                    $('#st_ph').text('Data Tidak Valid');
                }
            }

            function kelembabanTanah(nilai) {
                if (nilai < 20) {
                    $('#st_kelembaban').text('Sangat Kering');
                } else if (nilai >= 20 && nilai <= 40) {
                    $('#st_kelembaban').text('Kering');
                } else if (nilai >= 41 && nilai <= 60) {
                    $('#st_kelembaban').text('Lembab');
                } else if (nilai >= 61 && nilai <= 80) {
                    $('#st_kelembaban').text('Basah');
                } else if (nilai >= 81) {
                    $('#st_kelembaban').text('Sangat Basah');
                } else {
                    $('#st_kelembaban').text('Data Tidak Valid');
                }
            }

            function konduktivitasTanah(nilai) {
                if (nilai < 0.1) {
                    $('#st_konduktivitas').text('Rendah');
                } else if (nilai >= 0.1 && nilai <= 1.0) {
                    $('#st_konduktivitas').text('Sedang');
                } else if (nilai > 1.0) {
                    $('#st_konduktivitas').text('Tinggi');
                } else {
                    $('#st_konduktivitas').text('Data Tidak Valid');
                }
            }

            // function temperaturUdara(nilai) {
            //     if (nilai < 20) {
            //         $('#st_temperatur').text('Dingin');
            //     } else if (nilai >= 20 && nilai <= 30) {
            //         $('#st_temperatur').text('Suhu Normal');
            //     } else if (nilai > 30) {
            //         $('#st_temperatur').text('Panas');
            //     }
            // }
        });
    </script>
@endsection
