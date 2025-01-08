<?php
include 'config.php'; // Datenbankverbindung

// SQL-Abfrage mit optionaler Suche
try {
    $sql = "SELECT * FROM mediums";

    if (!empty($searchQuery)) {
        // Wenn ein Suchbegriff vorhanden ist, führe die Suche auf allen Spalten durch
        $sql .= " WHERE Autor LIKE :search OR Standort LIKE :search OR Title LIKE :search";
    }

    $stmt = $pdo->prepare($sql);

    // Wenn ein Suchbegriff vorhanden ist, binde ihn an die Abfrage
    if (!empty($searchQuery)) {
        $stmt->execute(['search' => "%" . $searchQuery . "%"]);
    } else {
        $stmt->execute();
    }

    $mediums = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Fehler beim Abrufen der Daten: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <link rel="stylesheet" href="./style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script>
        function search() {
            window.location.replace("./search.php")
        }
        function add() {
            window.location.replace("./add.php")
        }
    </script>
</head>

<body>
    <nav>
        <h1>Buchverwaltung</h1>
    </nav>
    <div class="center">
        <button onclick="search()">Suchen</button>
        <button onclick="add()">Hinzufügen oder Löschen</button>
    </div>
    <?php if (!empty($meldung)): ?>
        <p><strong><?php echo htmlspecialchars($meldung); ?></strong></p>
    <?php endif; ?>

    <!-- Prüfen, ob die Tabelle leer ist -->
    <?php if (empty($mediums)): ?>
        <p id="Db-nothing"><strong>Die Tabelle ist leer!!!</strong></p>
    <?php else: ?>
        <!-- Tabelle mit allen Medien -->
        <table>
            <thead>
                <tr>
                    <td class="th">Autor:</td>
                    <td class="th">Standort:</td>
                    <td class="th">Titel:</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mediums as $medium): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medium['Autor']); ?></td>
                        <td><?php echo htmlspecialchars($medium['Standort']); ?></td>
                        <td><?php echo htmlspecialchars($medium['Title']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>