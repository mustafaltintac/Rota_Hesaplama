<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rota Haritası</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <h1>Rota Haritası</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Harita nesnesini oluştur
        var map = L.map('map').setView([41.0, 38.0], 7); // Başlangıç konumu ve yakınlaştırma seviyesi

        // Harita sağlayıcısını (tiles provider) ayarla
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        <?php
        // JSON dosyasını okundu
        $json = file_get_contents('veriler.json');
        // JSON'dan dizi oluşturuldu
        $iller = json_decode($json, true);

        // İki şehir arasındaki rota alındı
        session_start();

        $rota = $_SESSION["aktarilanVeri"];

        // Enlem ve boylam bilgilerini içeren bir dizi oluştur
        $lokasyonlar = [];
        foreach ($rota as $sehir) {
            foreach ($iller as $il) {
                if ($il['sehir'] == $sehir) {
                    $lokasyonlar[] = [$il['enlem'], $il['boylam']];
                    break;
                }
            }
        }
        ?>

        // Rota çizimi yapıldı
        var rotaCoordinates = <?php echo json_encode($lokasyonlar); ?>;
        L.polyline(rotaCoordinates, { color: 'red' }).addTo(map);
    </script>
</body>
</html>
