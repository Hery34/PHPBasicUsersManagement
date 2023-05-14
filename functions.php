<?php

// This function is used to display the contents of a variable in a formatted way
function cleanDisplay($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

// This function is used to display all the rows in a result set
function display_all($r){
    while ($donnees = $r->fetch_assoc()) {
        echo 'Name : ' . $donnees['name'];
        echo "<br>";
        echo ' Email : ' . $donnees['email'];
        echo '<br>';
        echo '<h3>-------------------------------</h3>';
    }
};

// This function is used to check if a given name or email already exists in the database
function name_exists($name, $email, $result)
{
    $count = 0;
    
    try {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $k => $v) {
                if ($v == $name) {
                    echo "Nom déjà existant !";
                    $count++;
                } elseif ($v == $email) {
                    echo "Email déjà existant !";
                    $count++;
                } else {
                    // Do nothing
                }
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    };
    return $count;
}

// This function is used to insert a new user into the database
function insertUser($name,$email,$dbObj,$insertUser)
{
    try {
        $query = $dbObj->prepare($insertUser);
        $query->bind_param("ss", $name, $email);
        $query->execute();
        echo "<h2>Nouvel utilisateur " . $name . " ajouté avec succès !</h2>";
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    };
}

// This function is used to check if a user already exists in the database and insert them if they don't
function check_user()
{
    if ($dbObj = check_db()) {
        include('queries_lib.php');
        $stmt = $dbObj->prepare($getAllUsers);
        $requete = $stmt->execute();
        $results = $stmt->get_result();
        $name = $_POST['user_name'];
        $email  = $_POST['user_email'];
        $fl_is_in_db  = name_exists($name, $email, $results);
        mysqli_data_seek($results, 0);
        if ($fl_is_in_db == 0) {
            insertUser($name,$email,$dbObj,$insertUser);
            display_all($results);
        }
    } else {
        return "erreur de connexion BDD !";
    }
}

// This function is used to establish a connection to the database
function check_db()
{
    include_once('db_info.php');
    if ($db_handler = mysqli_connect($host, $user, $pw, $db)) {
        return $db_handler;
    } else {
        return FALSE;
    }
}
