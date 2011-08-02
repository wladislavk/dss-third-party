<?php

function create_salt(){
$salt = substr(sha1(uniqid(rand(), true)), 0, 12);
return $salt;
}

function gen_password($p, $s){
return hash('sha256', $p.$s);
}

?>
