<?php
    session_start();
    if (!isset($_SESSION['loggedIn'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - Gra</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        echo "<p>Witaj, " . $_SESSION['firstName'] . "!</p>";
        echo "<p>Twoje zasoby:</p>";
        echo "<ul>";
        echo "<li>Drewno: " . $_SESSION['wood'] . "</li>";
        echo "<li>Kamień: " . $_SESSION['stone'] . "</li>";
        echo "<li>Zboże: " . $_SESSION['cereal'] . "</li>";
        if($_SESSION ['isActive']) echo "<li>Subskrypcja Premium: Aktywna"  . "</li>";
        echo "</ul>";

        echo "<p><a href='logout.php'>Wyloguj się</a></p>";

    ?>
</body>    
    <footer>
        <p>&copy; 2025 Osadnicy. Wszelkie prawa zastrzeżone.</p>
    </footer>