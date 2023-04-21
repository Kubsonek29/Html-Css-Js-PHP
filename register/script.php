<?php
error_reporting(E_ERROR | E_PARSE);
$database = new PDO('sqlite:database.db');

$login = trim($_POST['name']);
$pass = trim($_POST['pass']);
$email = trim($_POST['email']);

if(!empty($_POST['name'])&&!empty($_POST['pass'])&&!empty($_POST['email']))
{

    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);
    if($uppercase > 0 && $lowercase > 0 & $number > 0 & $specialChars > 0 & strlen($pass) >= 8 && filter_var($email, FILTER_VALIDATE_EMAIL))
    {

        $statement = $database->prepare("SELECT * FROM users WHERE name=:login");
        $statement->bindParam(':login',$login, PDO::PARAM_STR);
        $statement->execute();

        $data=$statement->fetchAll();

        if($data)
        {
            echo 'Podany login jest zajęty';
        }
        else
        {
            $sql ='Insert into Users (login,password,email) values (":login",":password",":email")';
            $statement = $database->prepare('Insert into users (name,pass,email) values (:login,:password,:email)');
            $statement->execute(array(':login' => $login,':password' => $pass , ':email' => $email));
            $statement->fetch();

            echo "Zarejestrowano";
        }
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo 'Nie poprawny email';
    }
    else
    {
        echo 'Hasło powinno mieć przynajmniej 8 znaków oraz zawierać przynajmniej jedną dużą litere, jedną liczbę oraz znak specjalny';
    }
}
else
{
    echo "Wszystkie pola muszą być wypełnione";
}


?>