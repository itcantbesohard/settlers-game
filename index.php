<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Osadnicy</h1>
    </header>
    <main>
        <p>Witaj w grze Osadnicy! Wybierz jedną z opcji poniżej:</p>
        <form action="login.php" method="post">
            Login: <br> <input type="text" name="login" required><br><br>
            Hasło: <br> <input type="password" name="password" required><br><br>
            <input type="submit" value="Zaloguj się">
        </form>
        
    </main>
    <footer>
        <p>&copy; 2025 Osadnicy. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>