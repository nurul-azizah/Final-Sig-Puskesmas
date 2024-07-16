<?php include 'lib/head.php'; ?>

<?php
include 'konek.php';

$id = $_GET['id_lokasi'];

$tampil = mysqli_query($konek, "SELECT * FROM tb_lokasi WHERE id_lokasi='$id'");
$hasil = mysqli_fetch_array($tampil);

$latlng = $hasil['latlng'];
$keterangan_tempat = $hasil['keterangan_tempat'];
$jalan = $hasil['jalan'];
$kecamatan = $hasil['kecamatan'];
$gambar = $hasil['gambar'];
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div id="map" class="text-center"></div>
            </div>
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="Data">
                                <form action="prosesEdit.php" method="post" enctype="multipart/form-data">
                                    <div class="form-groub">
                                        <label for="id_lokasi"></label>
                                        <input type="hidden" class="form-control" id="id_lokasi" name="id_lokasi" value="<?php echo $id; ?>">
                                    </div>
                                    <div class="form-groub">
                                        <label for="latlng">Latitude, Longitude</label>
                                        <input type="text" class="form-control" id="latlng" name="latlng" value="<?php echo $latlng; ?>">
                                    </div>
                                    <div class="form-groub">
                                        <label for="keterangan_tempat">Keterangan Tempat</label>
                                        <input type="text" class="form-control" id="keterangan_tempat" name="keterangan_tempat" value="<?php echo $keterangan_tempat; ?>">
                                    </div>
                                    <div class="form-groub">
                                        <label for="jalan">Jalan</label>
                                        <input type="text" class="form-control" id="jalan" name="jalan" value="<?php echo $jalan; ?>">
                                    </div>
                                    <div class="form-groub">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $kecamatan; ?>">
                                    </div>
                                    <div class="form-groub">
                                        <label for="gambar">Gambar</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar">
                                    </div>
                                    <div class="form-groub mb-3 mt-3">
                                        <button type="submit" class="btn btn-primary form-control" name="btnEdit" value="edit">Edit Data</button>
                                    </div>
                                </form>
                                <div class="form-groub mb-3 mt-3">
                                    <a href="tabel.php"><button type="button" class="btn btn-primary form-control">Kembali</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



</body>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map = L.map('map').setView([<?php echo $latlng; ?>], 18);

    // tileLayer
    var tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    // Google map layer
    var Googlemap = googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // Hybrid
    var Hybrid = googleHybrid = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    // Terrain
    var Terrain = googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    // Layer Control
    var baseLayers = {
        "TileLayer": tileLayer,
        "GoogleStreets": Googlemap,
        "Hybrid": Hybrid,
        "Terrain": Terrain
    };

    var overlays = {
        // "Marker": Googlemap
    };

    L.control.layers(baseLayers, overlays).addTo(map);


    var popup = L.popup();

    function onMapClick(e) {
        var latlng = e.latlng;
        var lat = latlng.lat.toFixed(6);
        var lng = latlng.lng.toFixed(6);
        var latlng_format = lat + ', ' + lng;

        console.log('Latlng: ' + latlng_format); // Add this line to debug
        document.getElementById('latlng').value = latlng_format;

        popup
            .setLatLng(e.latlng)
            .setContent("Titik Koordinat nya adalah <br> " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);

    var redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
    var marker = L.marker([<?php echo $latlng ?>], {
        icon: redIcon
    }).addTo(map);
    marker.bindPopup("<b><?php echo $keterangan_tempat ?></b><br><b><?php echo $jalan ?></b><br><img src='gambar/<?php echo $gambar ?>' alt='gambar' width='160px'>");
</script>

</html>