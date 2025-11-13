<?php
// verification-finale.php
echo "<h1>Vérification finale</h1>";

$files = ['index.php', 'modifier.php', 'supprimer.php', 'afficher.php'];
foreach($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color:green'>✅ $file - EXISTE</p>";
        echo "<p><a href='$file' target='_blank'>Ouvrir $file</a></p>";
    } else {
        echo "<p style='color:red'>❌ $file - MANQUANT</p>";
    }
}
?>