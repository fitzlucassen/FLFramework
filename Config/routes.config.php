<?php
	// Définie les chemins d'accès à tous les dossiers importants
	define("__host_absolute__", "");
	
	define("__data_directory__", __host_absolute__ . "Data");
	define("__library_directory__", __host_absolute__ . "Library");
	define("__website_directory__", __host_absolute__ . "Website");
	define("__log_directory__", __host_absolute__ . "Logs");
	define("__cache_directory__", __host_absolute__ . "Cache");
	define("__module_directory__", __host_absolute__ . "Module");
	define("__locale_directory__", __host_absolute__ . "Locale");
	
	define("__helper_directory__", __library_directory__ . "/" . "Helper");
	define("__adapter_directory__", __library_directory__ . "/" . "Adapter");
	define("__core_directory__", __library_directory__ . "/" . "Core");
	
	define("__repository_directory__", __data_directory__ . "/" . "Repository");
	define("__entity_directory__", __data_directory__ . "/"  . "Entity");
	
	define("__js_directory__", __website_directory__ . "/" . "Content/Js");
	define("__css_directory__", __website_directory__ . "/" . "Content/Css");
	define("__image_directory__", __website_directory__ . "/" . "Content/Media/Image");
	define("__video_directory__", __website_directory__ . "/" . "Content/Media/Video");
	define("__partial_directory__", __website_directory__ . "/" . "Partial");
	define("__view_directory__", __website_directory__ . "/" . "MVC/View");
	define("__controller_directory__", __website_directory__ . "/" . "MVC/Controller");
	define("__model_directory__", __website_directory__ . "/" . "MVC/Model");
	
	define("__layout_directory__", __view_directory__ . "/" . "Layout");
	define("__email_directory__", __view_directory__ . "/" . "Email");
