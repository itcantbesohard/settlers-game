
<?php
session_start();
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
   
    $sql = "SELECT Login, Password FROM users WHERE Login = '$login' AND Password = '$password'";
    $sql2 = "SELECT users.UserID as ID, users.Login, users.FirstName, users.LastName, users.Email, inventories.Wood as Wood, inventories.Stone as Stone, inventories.Cereal as Cereal, subscriptions.isActive as IsActive FROM users LEFT JOIN inventories on users.UserID = inventories.UserID LEFT JOIN subscriptions on users.UserID = subscriptions.UserID WHERE login = '$login'";

    if($result = $connection->query($sql))
    {
        if ($result->num_rows > 0)
        {
            
            if ($userData = $connection->query($sql2))
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
    
            // Przekierowanie do gry
            $result->free();
            header("Location: game.php");
        }
        else
        {
            echo "Nieprawidłowy login lub hasło.";
        }

    }
    else
    {
        echo "Błąd zapytania: " . $connection->error;
    }
}

$connection->close()

?>