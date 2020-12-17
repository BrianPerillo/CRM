<?php

include_once 'includes/user.php';
include_once 'includes/user_session.php';
include_once 'includes/tables.php';

include('includes/detectar_dispositivo.php');

$userSession = new UserSession();
$user = new User();
$tables = new Table();

if(isset($_SESSION['user'])){
    //echo "hay sesion";
    $user->setUser($userSession->getCurrentUser());

    if ($mobile_browser > 0) {
        // Si es dispositivo mobil has lo que necesites
          include_once 'vistas_mobile/home.php';
        }
    else {
        // Si es ordenador de escritorio has lo que necesites
         //include_once 'vistas_mobile/home.php';
         include_once 'vistas/home.php';
    }
}else if(isset($_POST['username']) && isset($_POST['password'])){

    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    $user = new User();

    if($user->userExists($userForm, $passForm)){
        //echo "Existe el usuario";
        $userSession->setCurrentUser($userForm);
        /*$user->setUser($userForm);
        if ($tablet_browser > 0) {
        // Si es tablet has lo que necesites
           print 'es tablet';
        }*/

        if ($mobile_browser > 0) {
        // Si es dispositivo mobil has lo que necesites
          include_once 'vistas_mobile/home.php';
        }
        else {
        // Si es ordenador de escritorio has lo que necesites
          //include_once 'vistas_mobile/home.php';
            include_once 'vistas/home.php';
        }

    }else{
        //echo "No existe el usuario";
        $errorLogin = "Nombre de usuario y/o password incorrecto";
        include_once 'vistas/login.php';
    }
}else{
    //echo "login";
    include_once 'vistas/login.php';
}



?>
