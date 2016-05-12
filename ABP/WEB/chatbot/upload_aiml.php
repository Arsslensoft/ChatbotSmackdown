<?php
session_start();
require_once(dirname(__FILE__)."/classes/su.inc.php");

$CBSDUM = new CBSDUserManagement();
$content_dir = $GLOBALS["platform_path"]."/" .$_POST["id"]."/aiml/";
    $tmp_file = $_FILES["aiml"]['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES["aiml"]['type'];

    $name_file = $_FILES["aiml"]['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
            exit("Impossible de copier le fichier dans $content_dir");

$CBSDUM->addAimlSet(intval($_POST["id"]), $name_file);
header("Location: profile.php?id=".$_POST["id"]);
exit;


?>
