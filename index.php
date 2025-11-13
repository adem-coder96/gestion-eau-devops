<?php
include 'config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $volume = $_POST['volume'];
    $quantite = $_POST['quantite'];
    $dateArrivage = $_POST['date_arrivage'];
    
    $sql = "INSERT INTO stock (Type, Volume, Quantite, DateArrivage) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdis", $type, $volume, $quantite, $dateArrivage);
    
    if ($stmt->execute()) {
        $message = '<div class="message success">
            <div class="message-icon">✓</div>
            <div class="message-content">
                <strong>Succès!</strong> Le stock a été ajouté avec succès.
            </div>
        </div>';
    } else {
        $message = '<div class="message error">
            <div class="message-icon">⚠</div>
            <div class="message-content">
                <strong>Erreur!</strong> ' . $stmt->error . '
            </div>
        </div>';
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Stock - Gestion de Stock d'Eau</title>
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

    </header>

    <section class="modern-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Ajouter un Nouveau Stock</h1>
                <p>Gérez efficacement votre inventaire d'eau en bouteille avec notre interface moderne et intuitive. Ajoutez de nouveaux produits en quelques clics.</p>
            </div>
            <div class="hero-visual">
                <div class="hero-icon">📦</div>
            </div>
        </div>
    </section>

    <main>
        <div class="container">
            <?php echo $message; ?>
            
            <!-- Liens rapides vers les autres pages -->
            <div class="quick-links">
                <a href="index.php" class="quick-link-card" style="border-color: #667eea; background: linear-gradient(135deg, #f8f9ff, #ffffff);">
                    <span class="quick-link-icon">➕</span>
                    <h3>Ajout Stock</h3>
                    <p>Ajouter de nouveaux produits au stock</p>
                </a>
                
                <a href="modifier.php" class="quick-link-card">
                    <span class="quick-link-icon">✏️</span>
                    <h3>Modifier Stock</h3>
                    <p>Modifier les informations des produits existants</p>
                </a>
                
                <a href="supprimer.php" class="quick-link-card">
                    <span class="quick-link-icon">🗑️</span>
                    <h3>Supprimer Stock</h3>
                    <p>Supprimer des produits du stock</p>
                </a>
                
                <a href="afficher.php" class="quick-link-card">
                    <span class="quick-link-icon">👁️</span>
                    <h3>Afficher Stock</h3>
                    <p>Consulter tout le stock disponible</p>
                </a>
            </div>

            <div class="modern-form-container">
                <div class="form-header">
                    <h2>Formulaire d'Ajout de Stock</h2>
                    <p>Remplissez les informations du nouveau produit à ajouter au stock</p>
                </div>
                
                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group-modern">
                            <label for="type">Type d'Eau</label>
                            <div class="input-with-icon">
                                <span class="input-icon">🏷️</span>
                                <input type="text" id="type" name="type" class="form-control-modern" 
                                       placeholder="Ex: Aqualine, Jektis, Marwa..." required>
                            </div>
                            <small style="color: #718096; margin-top: 5px; display: block;">
                                Nom de la marque ou type d'eau
                            </small>
                        </div>
                        
                        <div class="form-group-modern">
                            <label for="volume">Volume (Litres)</label>
                            <div class="input-with-icon">
                                <span class="input-icon">💧</span>
                                <input type="number" id="volume" name="volume" class="form-control-modern" 
                                       step="0.01" min="0.01" placeholder="Ex: 1.5, 0.5, 19.0" required>
                            </div>
                            <small style="color: #718096; margin-top: 5px; display: block;">
                                Volume en litres de chaque unité
                            </small>
                        </div>
                        
                        <div class="form-group-modern">
                            <label for="quantite">Quantité</label>
                            <div class="input-with-icon">
                                <span class="input-icon">📊</span>
                                <input type="number" id="quantite" name="quantite" class="form-control-modern" 
                                       min="1" placeholder="Ex: 50, 100, 200" required>
                            </div>
                            <small style="color: #718096; margin-top: 5px; display: block;">
                                Nombre d'unités en stock
                            </small>
                        </div>
                        
                        <div class="form-group-modern">
                            <label for="date_arrivage">Date d'Arrivage</label>
                            <div class="input-with-icon">
                                <span class="input-icon">📅</span>
                                <input type="date" id="date_arrivage" name="date_arrivage" class="form-control-modern" required>
                            </div>
                            <small style="color: #718096; margin-top: 5px; display: block;">
                                Date de réception du stock
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-modern">
                            <span class="btn-icon">➕</span>
                            Ajouter au Stock
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistiques rapides -->
            <?php
            $sql_stats = "SELECT 
                COUNT(*) as total_types,
                SUM(Quantite) as total_stock,
                AVG(Volume) as avg_volume
                FROM stock";
            $result_stats = $conn->query($sql_stats);
            $stats = $result_stats->fetch_assoc();
            ?>
            
            <div class="quick-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo $stats['total_types'] ?? 0; ?></span>
                    <span class="stat-label">Types d'Eau</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $stats['total_stock'] ?? 0; ?></span>
                    <span class="stat-label">Total Stock</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format($stats['avg_volume'] ?? 0, 1); ?>L</span>
                    <span class="stat-label">Volume Moyen</span>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="feature-cards">
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h4>Ajout Rapide</h4>
                    <p>Interface optimisée pour une saisie rapide et sans erreur des nouveaux stocks</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h4>Vérification en Temps Réel</h4>
                    <p>Validation immédiate des données pour éviter les doublons et les erreurs</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h4>Statistiques Live</h4>
                    <p>Visualisation immédiate de l'impact sur votre inventaire global</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Gestion de Stock d'Eau. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Animation et améliorations UX
        document.addEventListener('DOMContentLoaded', function() {
            // Focus sur le premier champ
            document.getElementById('type').focus();
            
            // Animation des champs au focus
            const inputs = document.querySelectorAll('.form-control-modern');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Date par défaut = aujourd'hui
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date_arrivage').value = today;
            
            // Animation des cartes de liens au survol
            const linkCards = document.querySelectorAll('.quick-link-card');
            linkCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
<?php 
if (isset($result_stats)) {
    $result_stats->free();
}
$conn->close();
?>