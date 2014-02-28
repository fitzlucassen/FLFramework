<?php
    // On inclue le fichier d'initialisation
    require_once 'Config/bootstrap.php';
    
    // On initialise le routing de base
    $result = $App->ManageRouting();
    // On créée le controller recherché
    $App->ManageController();
    // On instancie le controller cible et on créée l'action
    $App->ManageAction();