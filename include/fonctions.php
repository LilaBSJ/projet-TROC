<?php

function debug($var, $mode=1){

    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "Debug demandé à la ligne <strong>" . $trace['line']. "</strong>, dans le fichier <strong>" . $trace['file'] . "</strong>";

    if($mode == 1){
        echo "<pre>"; print_r($var) ;echo '</pre>';
    }else{
        echo "<pre>"; var_dump($var) ;echo '</pre>';
    }

}

function connexionUser(){
    if(!isset($_SESSION['user'])){
        return FALSE;
    } else {
        return TRUE;
    }
}


function connexionAdmin(){
    if(connexionUser() && $_SESSION['user']['statut'] == 1  ){
        return TRUE;
    }else{
        return FALSE;
    }

}

