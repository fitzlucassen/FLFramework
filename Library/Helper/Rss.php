<?php

	namespace fitzlucassen\FLFramework\Library\Helper;

	/*
	  Class : Rss
	  Déscription : Permet de générer un flux RSS.
	 */
	class Rss extends Helper {
		private $_title;	    	// String				Titre du flux RSS.
		private $_link;		    	// String				Lien du flux RSS.
		private $_description;	    // String				Description du flux RSS.
		private $_pubDate;			// String 				Date de publication
		private $_items;	    	// String				Collection des items du flux.

		/*
			Constructeur
		 */
		public function __construct() {
			parent::__construct();
		}

		/**********
		  Setters *
		 **********/

		public function setTitle($title) {
			$this->_title = $title;
			return $this;
		}
		public function setLink($link) {
			$this->_link = $link;
			return $this;
		}
		public function setDescription($description) {
			$this->_description = $description;
			return $this;
		}
		public function setPublicationDate($date) {
			$this->_pubDate = $date;
			return $this;
		}
		public function setItems($items) {
			if(is_array($items))
				$this->_items = $items;
			else
				return false;
		}

		/**
		 * display -> affiche le RSS
		 */
		public function display($echo = false) {
			$html = "";
			$html .= "<rss version=\"2.0\">\n\t<channel>\n\t\t<title>" . $this->_title . "</title>\n\t\t<link>" . $this->_link . "</link>\n\t\t<description>" . $this->_description . "</description>\n";

			if(isset($this->_pubDate) && !empty($this->_pubDate))
				$html .= "\t\t<pubDate>" . $this->_pubDate . "</pubDate>\n";

			foreach ($this->_items as $item) {
				if (is_array($item)) {
					if(isset($item["title"]))
						$title = $item["title"];
					if(isset($item["link"]))
						$link = $item["link"];
					if(isset($item["guid"]))
						$guid = $item["guid"];
					if(isset($item["description"]))
						$description = $item["description"];
					if(isset($item["pubDate"]))
						$pubDate = $item["pubDate"];
					if(isset($item["pubDate"]))
						$author = $item["author"];
				}
				else
					return false;

				$html .= "\t<item>\n";
				if (isset($title))
					$html .= "\t\t<title>" . $title . "</title>\n";
				if (isset($link))
					$html .= "\t\t<link>" . $link . "</link>\n";
				if (isset($description))
					$html .= "\t\t<description><![CDATA[" . strip_tags($description) . "]]></description>\n";
				if (isset($guid))
					$html .= "\t\t<guid isPermaLink=\"true\">" . $guid . "</guid>\n";
				if (isset($pubDate))
					$html .= "\t\t<pubDate>" . $pubDate . "</pubDate>\n";
				if (isset($author))
					$html .= "\t\t<author>" . $author . "</author>\n";
				
				$html .=  "\t</item>\n";
			}
			$html .=  "</channel>\n</rss>";

			if($echo)
				echo $html;
			else
				return $html;
		}
	}
