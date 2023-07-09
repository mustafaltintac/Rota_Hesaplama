<?php
// JSON dosyasını okundu
$json = file_get_contents('veriler.json');
// JSON'dan dizi oluşturuldu
$veriler = json_decode($json, true);

// İlk ilin ismini al
$il1Sehir = $_POST['il1'];

// İkinci ilin ismini al
$il2Sehir = $_POST['il2'];

// İki il arasındaki en kısa rotayı hesapla
$shortestPath = dijkstra($veriler, $il1Sehir, $il2Sehir);

if ($shortestPath) {
    echo "<h2>En Kısa Rota:</h2>";
    echo implode(' > ', $shortestPath);
} else {
    echo "<p>İki il arasında geçiş yolu bulunamadı.</p>";
}


function dijkstra($graph, $start, $end) {
    $distances = array(); // Başlangıç noktasından ilerideki her il için minimum mesafeleri tutar
    $previous = array(); // Her il için en kısa yolu sağlayan önceki ilin adını tutar
    $visited = array(); // Ziyaret edilen illeri tutar

    // Başlangıç noktasından her il için başlangıç mesafesini sonsuz olarak ayarla, diğerlerini sonsuz yap
    foreach ($graph as $sehir) {
        $distances[$sehir['sehir']] = ($sehir['sehir'] === $start) ? 0 : INF;
        $previous[$sehir['sehir']] = null;
    }

    $current = $start;

    while ($current !== $end) {
        $visited[] = $current;

        $komsular = getKomsular($graph, $current);

        // Komşuları gezme
        foreach ($komsular as $komsu) {
            $mesafe = $distances[$current] + 1; // Her iki şehir arası mesafeyi 1 olarak  varsay

            if ($mesafe < $distances[$komsu]) {
                $distances[$komsu] = $mesafe;
                $previous[$komsu] = $current;
            }
        }

        // Ziyaret edilmemiş komşu şehirlerden en yakını seç
        $minDistance = INF;
        $next = null;

        foreach ($graph as $sehir) {
            if (!in_array($sehir['sehir'], $visited) && $distances[$sehir['sehir']] < $minDistance) {
                $minDistance = $distances[$sehir['sehir']];
                $next = $sehir['sehir'];
            }
        }

        // Ziyaret edilmemiş komşu şehir yoksa veya hedef şehir bulunamazsa döngüyü sonlandır
        if ($next === null || $next === $end) {
            break;
        }

        $current = $next;
    }

    // En kısa rota için şehirleri oluştur
    $shortestPath = array();
    $current = $end;

    while ($current !== null) {
        array_unshift($shortestPath, $current);
        $current = $previous[$current];
    }

    return $shortestPath;
}
session_start();
$veri = $shortestPath; // rota çizimi için harita.php sayfasına yönlendirme
$_SESSION["aktarilanVeri"] = $veri;



function getKomsular($graph, $sehir) {
    foreach ($graph as $il) {
        if ($il['sehir'] === $sehir) {
            return $il['komsular'];
        }
    }
    return array();
}
?>
