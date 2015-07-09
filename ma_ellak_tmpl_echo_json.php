<?php
/*
Template Name: JSON echo
*/

$project_name = trim($_GET['prj']);

$json_url = 'http://sourceforge.net/api/project/name/'.$project_name.'/json';

echo file_get_contents($json_url);
?>