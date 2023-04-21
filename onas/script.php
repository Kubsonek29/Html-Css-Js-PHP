<?php
error_reporting(E_ALL ^ E_WARNING);
$uploadDirectory = '/home/313034/public_html/opss/';
$files = scandir($uploadDirectory);
$files = array_diff($files,array('.','..'));
$files = array_values($files);
$errors=array();

if(isset($_POST['name'])){
    $database = new PDO('sqlite:../register/database.db');
    $login = trim($_POST['name']);
    $pass = trim($_POST['pass']);
    $sql ='SELECT * FROM users WHERE name = :username AND pass = :password';
    $statement = $database->prepare("SELECT * FROM users WHERE name = :name AND pass = :pass");
    $statement->execute(array(':name' => $login, ':pass' => $pass));
    $row = $statement->fetch();
    if ($row['name'] == $login && $row['pass'] == $pass){
            $_SESSION['username']=$_POST['name'];
            header("Location: index.php");
            exit();
        }
        else{
            echo "<h1 style='color:red;'>Podałeś/aś niepoprawne dane!</h1><br/><p style='color:white;'>Za 3 sekundy powrócisz na stronę startową</p>";
            header("refresh: 3; url=index.php");
            exit();
        }
}

if(!isset($_SESSION['username']))
echo ' <h1 style="margin-left: 180px;">Upload plików z logowaniem<br>Formularz logowania</h1>

        <div id="for">
        <form name="form" action="" method="POST">

            <label for="name">Login:</label>
            <input type="text" id="name" name="name"><br>
            <label for="pass">Hasło:</label>
            <input type="password" id="pass" name="pass"><br>

            <button type="submit" id="but2">Wyślij</button>
            <button type="reset" id="but">Wyczyść</button>
            <br>
        </form>
    </div>    ';



if(isset($_SESSION['username'])){
    $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";
    if(!strpos($_SERVER['REQUEST_URI'], "index.php"))
        header("Location: index.php");
    if (!is_dir($userUploadDirectory)){
        mkdir($userUploadDirectory, 0777);
    }

    if (isset($_GET['logout'])){
        session_destroy();
        echo '<h1 style="color:white;">Zostaniesz wylogowany/a za 3 sekundy</h1>';
        header("refresh: 3; url=index.php");
    }
    else{
        echo "<h1 style='margin-left: 180px; text-shadow: 8px 5px 10px rgba(7, 26, 231, 1);'>Witaj " .$_SESSION['username']. "</h1><h1 style='margin-left: 180px; font-size: 21px;'>zostałeś poprawnie zalogowany/a</h1><div class='wyloged'><h3><a href ='?logout' style='margin-left: 180px; text-decoration: none; appearance: none; color:red;'?logout'>(Wyloguj)</a></h3></div><br/><h2 style='margin-left: 180px;'>Upload plików na serwer</h2>";
        echo "<div id='for'>

              <form name='form' action='' method='POST' enctype='multipart/form-data'>

              <p>Pliki do przesłania</p>
              <div class='toppo'>
			        <label for='files'>Pliki: </label>
                
			        <input multiple type='file' name='files[]'  >
			        </div>
			        <br>
              <button type='submit' id='but2'>Wyślij</button>
              <button type='reset' id='but'>Wyczyść</button>
           
              </form>
              </div>
              <h2 style='text-align: center; margin-left:180px;'>Pliki w twoim folderze:</h2>";
    }
}

function wczytaj(){
    $style="<div id='for' style='width: 400px; padding-left: 35px; margin-left:220px; height: 5px; text-align: left; '>";
    $uploadDirectory = '/home/313034/public_html/opss/';
    $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";
    $files = scandir($userUploadDirectory);
    $files = array_diff($files,array('.','..'));
    $files = array_values($files);
    for($i=0;$i<count($files);$i++){
        echo $style."<a title='Usuń Plik' style='color: red;' href='?remove=".$files[$i]."'>X</a>".$files[$i]."</div>";
    }
}

function Mess($errors){
    $style="class='mes' style='width: 250px;
    text-align: left;
    height: 30px;
    font-size: 15px;
    margin: auto;
    margin-right: 15px;
    padding-top:5px;
    margin-top:15px;
    border-style: dotted;
    border-width: 2px;
    ";
    $str=implode("+", $errors);
    $str=explode("+", $str);

    for($i=0;$i<count($str);$i++){
        $errors=explode(":",$str[$i]);
        if($errors[0]==1){
            echo "<div ".$style."
            border-color: yellow;
            background-color: green; color:white; margin-left:250px; width: 500px; height: 50px; '>Plik ".$errors[1]." Został zapisany poprawine</div>";
        }
        else if($errors[0]==2){
            echo "<div ".$style."border-color: red;
            background-color: red; color:white; margin-left:250px;'>Plik ".$errors[1]." Został usunięty</div>";
        }
        else if($errors[0]==3){
            echo "<div ".$style."border-color: orange;
            background-color: orange; color:white; margin-left:250px;'>Niewłaściwy typ pliku ".$errors[1]." </div>";
        }
    }
    $errors=array_diff($errors,$errors);
}


if(isset($_GET['remove'])){
    $fileToRemove = basename($_GET['remove']);
    unlink($userUploadDirectory."/".$fileToRemove);
    $errors=array(0=>"2:".$fileToRemove);
}



if(isset($_FILES['files'])){
    $errors=array_diff($errors,$errors);
    foreach ($_FILES['files']['error'] as $key => $error){
        if ($error === UPLOAD_ERR_OK){
            $tmpName = $_FILES['files']['tmp_name'][$key];
            $fileName = basename($_FILES['files']['name'][$key]);
            $type=explode(".",$fileName);
            if($type[1]!="jpg"&&$type[1]!="gif"&&$type[1]!="png"&&$type[1]!="pdf"&&$type[1]!="docx"&&$type[1]!="txt")
                array_push($errors,"3:".$fileName);
            else{
                array_push($errors,"1:".$fileName);
                move_uploaded_file($tmpName, "$userUploadDirectory/$fileName");
            }
	      }
    }
}

if(isset($_SESSION['username'])&&!isset($_GET['logout'])){
    wczytaj();
    Mess($errors);
}
?>
