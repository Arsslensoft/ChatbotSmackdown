<?php
/**
 * Created by PhpStorm.
 * User: Arsslen
 * Date: 13/05/2016
 * Time: 11:59
 */
$time = DateTime::createFromFormat('m/d/Y H:i:s', '08/20/2009 14:00:56');
echo date("Y-m-d H:i:s",$time->getTimestamp());
?>