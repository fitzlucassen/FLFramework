<?php

	namespace fitzlucassen\FLFramework\Library\Helper;

	/*
		Class : UploadValidator
		Déscription : Permet de gérer les validations d'upload
	 */
	class UploadValidator extends Helper {
		public $_maxFilesize = 1;
		public $_maxFilename = 10;
		public $_availableExtensions = array(
			'image/jpeg',
			'image/gif',
			'image/png',
			'image/tiff'
		);

		public function check_name_length($object) {
			if (mb_strlen($object->file['original_filename']) > $this->_maxFilename) {
				$object->set_error('File name is too long.');
			}
		}

		public function check_extension($object) {
			if (!in_array($object->file['mime'], $this->_availableExtensions)) {
				$object->set_error('File type is not authorized.');
			}
		}

		public function check_file_size($object) {
			if ($object->bytes_to_mb($object->file['size_in_bytes']) > $this->_maxFilesize) {
				$object->set_error('File size is too big.');
			}
		}
	}
