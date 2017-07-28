<?php
include_once '../private/app/init-ajax.php';

// On accepte les requetes 'POST' uniquement
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	print_r($_POST);


	    $save = true;
	// Récupération des données du $_POST
	$pwd_old = isset($_POST['pwd_old']) ? $_POST['pwd_old'] : null;
    $pwd_new = isset($_POST['pwd_new']) ? $_POST['pwd_new'] : null;
    $pwd_repeat = isset($_POST['pwd_repeat']) ? $_POST['pwd_repeat'] : null;


	// Controle des données

	 // - Controle du mot de passe actuel
  // --
  // -> le mot de passe ne doit pas être vide
  // -> le mot de passe doit correspondre avec celui deja enregistré dans la BDD
    if (empty($pwd_old)) {
        $save = false;
        // setFlashbag("danger", "Remplir le mot de passe");
        echo json_encode(array(
         	"state" => "danger",
         	"message" => "Remplir le mot de passe" ));
    }

    if (!$pwd_old = $pdo ) {
    	$save = false;
    	// setFlashbag("danger", "le mot de passe ne correspond pas à celui qui est enregistré dans la base de données");
    	echo json_encode(array(
         	"state" => "danger",
         	"message" => "le mot de passe ne correspond pas à celui qui est enregistré dans la base de données" ));
    }


  // - Controle du nouveau mot de passe
  // --
  // -> doit contenir au moins 8 caractères
  // -> doit contenir au plus 16 caractères
  // -> doit avoir au moins un caractère de type numérique
  // -> doit avoir au moins un caractère en majuscule
  // -> doit avoir au moins un caractère spécial (#@!=+-_)

    if (strlen($pwd_new) < 8 || strlen($pwd_new) > 16) {
        $save = false;
        // setFlashbag("danger", "Le mot de passe doit avoir 8 caractères minimum et 16 caractères maximum");
        echo json_encode(array(
         	"state" => "danger",
         	"message" => "Le mot de passe doit avoir 8 caractères minimum et 16 caractères maximum" ));
    }

     if(!preg_match("/(([a-z][0-9])|([0-9][a-z])|[A-Z][0-9]|([0-9][A-Z]))/", $pwd_new)) {
        $save = false;
    // setFlashbag("danger", "Le mot de passe doit comporter des majuscules et des chiffres");
         echo json_encode(array(
         	"state" => "danger",
         	"message" => "Le mot de passe doit comporter des majuscules et des chiffres" ));
}

    if (!preg_match("/(#|@|!|=|\+|-|_)/", $pwd_new)) {
        $save = false;
        // setFlashbag("danger", "Le mot de passe doit contenir un caractère spéciaux");
         echo json_encode(array(
         	"state" => "danger",
         	"message" => "Le mot de passe doit contenir des caractères spéciaux" ));  
    }

  // - Controle de la répétition du nouveau mot de passe
  // --
  // -> Les mots de passe doivent être identique
    if ($pwd_repeat != $pwd_new) {
    	$save = false;
    	// setFlashbag("danger", "Le mot de passe n'est pas identique"); 
    	echo json_encode(array(
         	"state" => "danger",
         	"message" => "Le mot de passe n'est pas identique" ));    
    }


  if ($save) {

    // Cryptage du nouveau mot de passe
    $pwd_new = password_hash($pwd_new, PASSWORD_DEFAULT);

    // Requete de modification du mot de passe dans la BDD
    //global $pdo;
    //$db = 'UPDATE `".TABLE_USERS."` SET password ="' . $pwd_new .'" WHERE email="' . $SESSION['email'] . '"';
    	//$db = $pdo->prepare($q);
    	//$db->bindValue(':password', $pwd_new, PDO::PARAM_STR);
    	//$db->execute();
    	//return $db->fetch(PDO::FETCH_OBJ);

    // Definition du message de réponse + encodage de la reponse en JSON
    
  }

}


// Si les requêtes ne sont pas en POST, on refuse l'accès.
else {
	echo "Vous n'avez pas l'autorisation d'afficher ce fichier.";
}
