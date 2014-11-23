<?php

    namespace fitzlucassen\FLFramework\Website\MVC\Model;
    
     /*
      Class : HomeModel
      Déscription : Model de donnée pour les pages du controller home
     */
    class HomeModel extends Model{
        public $htmlForm = "";
        public $loginForm = "";

        public function __construct($manager) {
            parent::__construct($manager);
        }
    }
