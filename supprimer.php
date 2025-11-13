<?php
include 'config.php';
$message = '';

if (isset($_GET['delete_type']) && isset($_GET['delete_date'])) {
    $type = $_GET['delete_type'];
    $date = $_GET['delete_date'];
    
    $sql = "DELETE FROM stock WHERE Type=? AND DateArrivage=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $type, $date);
    
    if ($stmt->execute()) {
        $message = '<div class="message success">Stock supprimé avec succès!</div>';
    } else {
        $message = '<div class="message error">Erreur: ' . $stmt->error . '</div>';
    }
    
    $stmt->close();
}

$sql = "SELECT * FROM stock ORDER BY Type, DateArrivage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Stock - Gestion d'Eau</title>
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
                        <li><a href="supprimer.php" class="active">Supprimer Stock</a></li>
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
                <h2>Supprimer du Stock</h2>
                <p>Supprimez des produits d'eau du stock</p>
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
                                    <td>".$row['Type']."</td>
                                    <td>".$row['Volume']."</td>
                                    <td>".$row['Quantite']."</td>
                                    <td>".$row['DateArrivage']."</td>
                                    <td>
                                        <a href='supprimer.php?delete_type=".$row['Type']."&delete_date=".$row['DateArrivage']."' 
                                           class='btn btn-danger' 
                                           onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce stock?\")'>
                                            Supprimer
                                        </a>
                                    </td>
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