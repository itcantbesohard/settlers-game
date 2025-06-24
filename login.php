
<?php
session_start();

if (isset($_POST['login']) && isset($_POST['password']))
{
    // Sprawdzenie, czy użytkownik jest już zalogowany
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
    {
        header("Location: game.php");
        exit();
    }
}

require_once 'connect.php';

$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno)
{
    echo "Błąd połączenia z bazą danych: " . $connection->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $password = htmlentities($password, ENT_QUOTES, "UTF-8");

    $sql = "SELECT Login, Password FROM users WHERE Login = '$login' AND Password = '$password'";
    $sql2 = "SELECT users.UserID as ID, users.Login, users.FirstName, users.LastName, users.Email, inventories.Wood as Wood, inventories.Stone as Stone, inventories.Cereal as Cereal, subscriptions.isActive as IsActive FROM users LEFT JOIN inventories on users.UserID = inventories.UserID LEFT JOIN subscriptions on users.UserID = subscriptions.UserID WHERE login = '$login'";

    if($result = $connection->query(
        sprintf("SELECT Login, Password FROM users WHERE Login = '%s' AND Password = '%s'",
        $connection->real_escape_string($login),
        $connection->real_escape_string($password))))
    {
        if ($result->num_rows > 0)
        {
            // Ustawienie flagi zalogowania
            $_SESSION['loggedIn'] = true; 
            // Pobranie danych użytkownika
            if ($userData = $connection->query(
                sprintf("SELECT users.UserID as ID, users.Login, users.FirstName, users.LastName, users.Email, inventories.Wood as Wood, inventories.Stone as Stone, inventories.Cereal as Cereal, subscriptions.isActive as IsActive FROM users LEFT JOIN inventories on users.UserID = inventories.UserID LEFT JOIN subscriptions on users.UserID = subscriptions.UserID WHERE login = '%s'",
                $connection->real_escape_string($login))))
            {
                $userData = $userData->fetch_assoc();
                // Zapisz dane użytkownika w sesji
                $_SESSION['user'] = $userData['Login'];
                $_SESSION['firstName'] = $userData['FirstName'];
                $_SESSION['lastName'] = $userData['LastName'];
                $_SESSION['email'] = $userData['Email'];
                $_SESSION['wood'] = $userData['Wood'];
                $_SESSION['stone'] = $userData['Stone'];
                $_SESSION['cereal'] = $userData['Cereal'];
                $_SESSION['userID'] = $userData['ID'];
                $_SESSION['isActive'] = $userData['IsActive'];
            }
            else
            {
                echo "Błąd pobierania danych użytkownika: " . $connection->error;
                exit();
            }
            
            unset($_SESSION['error']); // Usunięcie błędu, jeśli był ustawiony
            // Ustawienie ciasteczka na 30 dni
            setcookie("user", $userData['Login'], time() + (30 * 24 * 60 * 60), "/"); // Ciasteczko ważne przez 30 dni
            // Przekierowanie do gry
            $result->free();
            header("Location: game.php");
        }
        else
        {
            $_SESSION['error'] = "<span style='color:red;'>Nieprawidłowy login lub hasło.</span>";
            $result->free();
            header("Location: index.php");
        }

    }
    else
    {
        echo "Błąd zapytania: " . $connection->error;
    }
}

$connection->close()

?>