<?php

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentUser($user){ // Recibe el id del usuario que se loguea
        $_SESSION['user'] = $user; // Lo guarda en la session
    }

    public function getCurrentUser(){
        return $_SESSION['user'];
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}

?>
