<?php
    // On inclue le fichier d'initialisation
    require_once 'bootstrap.php';
    
    // On initialise le routing de base
    $result = $App->ManageRouting();
    
    // On redirige si page par défaut
    if(!$result && $App->getIsInErrorPage()){
	header('location:' . $App->getRewrittingUrl()->getUrlMatched());
	die();
    }
    // On vérifie que la page existe
    $App->Manage404Route();
    // On créée le controller recherché
    $App->ManageController();
    // On instancie le controller cible et on créée l'action
    $App->ManageAction();