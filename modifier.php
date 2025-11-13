<?php
include 'config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $originalType = $_POST['original_type'];
    $originalDate = $_POST['original_date'];
    $type = $_POST['type'];
    $volume = $_POST['volume'];
    $quantite = $_POST['quantite'];
    $dateArrivage = $_POST['date_arrivage'];
    
    $sql = "UPDATE stock SET Type=?, Volume=?, Quantite=?, DateArrivage=? WHERE Type=? AND DateArrivage=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdisss", $type, $volume, $quantite, $dateArrivage, $originalType, $originalDate);
    
    if ($stmt->execute()) {
        $message = '<div class="message success">Stock modifié avec succès!</div>';
    } else {
        $message = '<div class="message error">Erreur: ' . $stmt->error . '</div>';
    }
    
    $stmt->close();
}

$sql = "SELECT * FROM stock ORDER BY Type, DateArrivage";
$result = $conn->query($sql);
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Stock - Gestion d'Eau</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i>💧</i>
                    <h1>Gestion de Stock d'Eau</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="index.php">Ajout Stock</a></li>
                        <li><a href="modifier.php" class="active">Modifier Stock</a></li>
                        <li><a href="supprimer.php">Supprimer Stock</a></li>
                        <li><a href="afficher.php">Afficher Stock</a></li>
                       
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <?php echo $message; ?>
            
            <div class="page-header">
                <h2>Modifier le Stock</h2>
                <p>Modifiez les informations des produits d'eau existants</p>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Volume (L)</th>
                            <th>Quantité</th>
                            <th>Date d'arrivage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <form method='POST' action=''>
                                    <input type='hidden' name='original_type' value='".$row['Type']."'>
                                    <input type='hidden' name='original_date' value='".$row['DateArrivage']."'>
                                    <td><input type='text' name='type' value='".$row['Type']."' class='form-control'></td>
                                    <td><input type='number' name='volume' value='".$row['Volume']."' step='0.01' class='form-control'></td>
                                    <td><input type='number' name='quantite' value='".$row['Quantite']."' class='form-control'></td>
                                    <td><input type='date' name='date_arrivage' value='".$row['DateArrivage']."' class='form-control'></td>
                                    <td><button type='submit' name='update' class='btn'>Mettre à jour</button></td>
                                    </form>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun stock trouvé</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Gestion de Stock d'Eau. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
<?php $conn->close(); ?>