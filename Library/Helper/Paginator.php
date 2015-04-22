<?php
	namespace fitzlucassen\FLFramework\Library\Helper;

	use fitzlucassen\FLFramework\Library\Core;
	
	/*
		Class : Paginator
		Déscription : Permet de gérer la pagination
	 */
	class Paginator extends Helper {
		private $_currentPage;
		private $_nextPage;
		private $_previousPage;
		private $_lastPage;
		private $_firstPage;

		private $_numberOfPage;
		private $_numberOfItem;
		private $_itemPerPage;

		private $_config = array(
			'paramPage' => 'p',
			'paramItemPerPar' => 'nb',
			'itemPerPage' => 20
		);

		public function __construct($nbItem, $config = array()){
			$this->_config = array_merge($this->_config, $config);

			$this->_currentPage = 1;
			$this->_firstPage = 1;
			$this->_previousPage = 1;
			$this->_numberOfItem = $nbItem;
			$this->_numberOfPage = floor(($this->_numberOfItem / ($this->_config['itemPerPage'] + 1))) + 1;
			$this->_lastPage = $this->_numberOfPage;

			if($this->_numberOfPage > 1)
				$this->_nextPage = 2;
			else
				$this->_nextPage = 1;
		}

		public function managePaginator(){
			if(Request::isGet() || Request::isPost()){
				$data = Request::cleanRequest();

				if(isset($data[$this->_config['paramPage']])){
					$requestedPage = isset($data[$this->_config['paramPage']]) ? $data[$this->_config['paramPage']] : 1;
					$requestedNbItem = isset($data[$this->_config['paramItemPerPar']]) ? $data[$this->_config['paramItemPerPar']] : $this->_config['itemPerPage'];
				}
			}

			$this->_config['itemPerPage'] = $requestedNbItem;
			$this->_numberOfPage = floor(($this->_numberOfItem / ($this->_config['itemPerPage'] + 1))) + 1;

			if($requestedPage <= $this->_numberOfPage && $requestedPage >= 1){
				$this->_currentPage = $requestedPage;
				$this->_lastPage = $this->_numberOfPage;

				if($this->_currentPage == 1)
					$this->_previousPage = 1;
				else
					$this->_previousPage = $this->_currentPage - 1;

				if($this->_currentPage == $this->_numberOfPage)
					$this->_nextPage = $this->_currentPage;
				else
					$this->_nextPage = $this->_currentPage + 1;

				return true;
			}
			return false;
		}

		/***********
		 * GETTERS *
		 ***********/
		public function getPagination($echo = true){
			$this->managePaginator();

			$html = '<div class="paginator">';
			$html .= '<a href="?' . $this->_config["paramPage"] . '=' . $this->_firstPage . '&' . $this->_config["paramItemPerPar"] . '=' . $this->_config["itemPerPage"] . '">&nbsp;<<&nbsp;</a>';
			$html .= '<a href="?' . $this->_config["paramPage"] . '=' . $this->_previousPage . '&' . $this->_config["paramItemPerPar"] . '=' . $this->_config["itemPerPage"] . '">&nbsp;<&nbsp;</a>';
			$html .= '<span class="currentPage">&nbsp;' . $this->_currentPage . '&nbsp;</span>';
			$html .= '<a href="?' . $this->_config["paramPage"] . '=' . $this->_nextPage . '&' . $this->_config["paramItemPerPar"] . '=' . $this->_config["itemPerPage"] . '">&nbsp;>&nbsp;</a>';
			$html .= '<a href="?' . $this->_config["paramPage"] . '=' . $this->_lastPage . '&' . $this->_config["paramItemPerPar"] . '=' . $this->_config["itemPerPage"] . '">&nbsp;>>&nbsp;</a>';
			$html .= '</div>';

			if($echo)
				echo $html;
			else
				return $html;
		}

		public function getCurrentPage(){
			return $this->_currentPage;
		}
		public function getNextPage(){
			return $this->_nextPage;
		}
		public function getPreviousPage(){
			return $this->_previousPage;
		}
		public function getFirstPage(){
			return $this->_firstPage;
		}
		public function getLastPage(){
			return $this->_lastPage;
		}

		/***********
		 * SETTERS *
		 ***********/
	}
