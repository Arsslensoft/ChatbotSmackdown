<?php
session_start();
require_once(dirname(__FILE__)."/classes/su.inc.php");

$CBSDUM = new CBSDUserManagement();
$content_dir = $GLOBALS["platform_path"]."/" .$_POST["id"]."/config/";
$tmp_file = $_FILES["setting"]['tmp_name'];

if( !is_uploaded_file($tmp_file) )
{
    exit("Le fichier est introuvable");
}

// on vérifie maintenant l'extension
$type_file = $_FILES["setting"]['type'];

$name_file = $_FILES["setting"]['name'];

if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    exit("Impossible de copier le fichier dans $content_dir");

$personalities = $CBSDUM->getAllPersonalities(intval($_POST["id"]));
if(count($personalities) == 1) {
    $personality = Personality::retrieveByPK($personalities[0]->Id);
    $personality->PersonalityFile = $name_file;
    $personality->save();
}
else
  $CBSDUM->addPersonality(intval($_POST["id"]),$name_file);

header("Location: profile.php?id=".$_POST["id"]);
exit;

?>
