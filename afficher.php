<?php
include 'config.php';

$sql = "SELECT * FROM stock ORDER BY Type, DateArrivage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher Stock - Gestion d'Eau</title>
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
                        <li><a href="modifier.php">Modifier Stock</a></li>
                        <li><a href="supprimer.php">Supprimer Stock</a></li>
                        <li><a href="afficher.php" class="active">Afficher Stock</a></li>
                       
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h2>Afficher le Stock</h2>
                <p>Consultez l'ensemble du stock d'eau disponible</p>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Volume (L)</th>
                            <th>Quantité</th>
                            <th>Date d'arrivage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>".$row['Type']."</td>
                                    <td>".$row['Volume']."</td>
                                    <td>".$row['Quantite']."</td>
                                    <td>".$row['DateArrivage']."</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Aucun stock trouvé</td></tr>";
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