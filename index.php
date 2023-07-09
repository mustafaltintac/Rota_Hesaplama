<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>İl Seçimi</title>
</head>
<body>
    <h1>İki İl Seçin</h1>
    <form method="post" id="ilForm">
        <label for="il1" >İl 1:</label>
        <select name="il1" id="il1">
            <?php
            // JSON dosyası okundu
            $json = file_get_contents('veriler.json');
            // JSON'dan dizi oluşturuldu
            $iller = json_decode($json, true);

            // İllerin listesini dolduruldu
            foreach ($iller as $il) {
                echo '<option value="' . $il['sehir'] . '">' . $il['sehir'] . '</option>';
            }
            ?>
        </select>

        <br><br>
            
        <label for="il2">İl 2:</label>
        <select name="il2" id="il2">
            <?php
            // İllerin listesini tekrar doldur
            foreach ($iller as $il) {
                echo '<option value="' . $il['sehir'] . '">' . $il['sehir'] . '</option>';
            }
            ?>
        </select>

        <br><br>

        <input type="submit" value="Seç">
    </form>

    <div id="resultDiv"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submit edildiğinde
            document.getElementById('ilForm').addEventListener('submit', function(e) {
                e.preventDefault();

                var il1 = document.getElementById('il1').value;
                var il2 = document.getElementById('il2').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'hesaplama.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {

                        document.getElementById('resultDiv').innerHTML = xhr.responseText;
                    } else if (xhr.readyState === 4) {
                        
                        console.log('AJAX request failed.');
                    }
                };
                xhr.send('il1=' + encodeURIComponent(il1) + '&il2=' + encodeURIComponent(il2));
            });
        });
    </script>
</body>
</html>
