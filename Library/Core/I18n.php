<?php
	 
	namespace fitzlucassen\FLFramework\Library\Core;

	use fitzlucassen\FLFramework\Library\Helper;

	/*
		Class : I18n
		Déscription : 
	 */
	class I18n {
		// define constants
		private $_localeDir;
		private $_defaultLocale;
		private $_supportedLocales;
		private $_encoding;

		public function __construct($locale = 'fr_FR', $locales = ['fr_FR'], $encoding = 'UTF-8'){
			$this->_defaultLocale = $locale;
			$this->_encoding = $encoding;
			$this->_supportedLocales = $locales;
			$this->_localeDir = __locale_directory__;
		}

		public function setLocale($locale = ''){
			if(!empty($locale))
				$this->_defaultLocale = $locale;
			else {
				$S = new Helper\Session();
				if($S->containsKey('lang'))
					$this->_defaultLocale = Locale::getLocale($S->read('lang'));
			}
		}

		public function initialize(){
			// gettext setup
			T_setlocale(LC_MESSAGES, $this->_defaultLocale);
			// Set the text domain as 'messages'
			$domain = 'traduction';
			bindtextdomain($domain, $this->_localeDir);
			// bind_textdomain_codeset is supported only in PHP 4.2.0+
			if (function_exists('bind_textdomain_codeset')) 
			  bind_textdomain_codeset($domain, $this->_encoding);
			textdomain($domain);
		}
	}