<?php

class UploadFile {

	protected $destination;
	public $errors = [];
	private $file_extension;
	const MAX_FILE_SIZE = 3072; // 3KB = 1024 * 3 = 3072B
	const ALLOWED_MIME_TYPES = ['image/png'. 'image/jpg', 'image/jpeg'];
	const ALLOWED_EXTENSIONS = ['png', 'jpg', 'jpeg'];

	public function __construct($upload_folder) {
		$this->destination = $upload_folder;
	}

	/* ----------------- VALIDATION -------------------------------*/
	public function validate($file) {
		
		if(!$this->validate_upload_error($file)) {
			return false;
		}

		if(!$this->validate_file_size($file)) {
			return false;
		}


		if(!$this->validate_file_extension($file)) {
			return false;
		}

		if(!$this->validate_file_type($file)) {
			return false;
		}

		if(!$this->validate_photo_dimenssion($file)) {
			return false;
		}

		if(!$this->validate_file_name($file)) {
			return false;
		}

		if(!$this->validate_file_contents($file)) {
			return false;
		}

		return true;

	}

	private function validate_file_size($file) {
		if($file['size'] > self::MAX_FILE_SIZE) {
			$this->errors[] = $file['name'] . 'is too big. Max size of the file must be ' . self::MAX_FILE_SIZE . '.';
			return false;
		}
		return true;
	}

	private function validate_file_type($file) {
		if(has_exclusion_of($file['type'], self::ALLOWED_MIME_TYPES)) {
			$this->errors[] = 'Fajl koji upload-ujete mora biti jpg, png ili jpeg formata';
			return false;
		}
		return true;
	}

	private function validate_file_extension($file) {
		$path_parts = pathinfo($file['name']);
		$this->file_extension = $path_parts['extension'];
		if(has_exclusion_of($this->file_extension, self::ALLOWED_EXTENSIONS)) {
			$this->errors[] = 'Fajl koji upload-ujete mora biti jpg, png ili jpeg formata. ekstenzija';
			return false;
		}
		return true;
	}

	private function validate_photo_dimenssion($file) {
		if(getimagesize($file['tmp_name']) === false) {
			$this->errors[] = 'Upload-ujte validnu sliku.';
			return false;
		}
		return true;
	}

	private function validate_file_name($file) {
		if(strpos($file['name'], 'php') !== false) {
			$this->errors[] = 'Upload-ujte validnu sliku.';
			return false;
		}
		return true;
	}

	private function validate_file_contents($file) {
		$contents = file_get_contents($file['tmp_name']);
		if(strpos($contents, '<?php') !== false) {
			$this->errors[] = 'Upload-ujte ispravan fajl';
			return false;
		}
		return true;
	}

	private function validate_upload_error($file) {
		if($file['error'] == 0) {
			//  UPLOAD_ERR_OK Value: 0 -> There is no error, the file uploaded with success.
			return true;
		} else {
			switch ($file['error']) {
				case '1':
					$this->errors[] = $file['name'] . ' je velicine '. $file['size']  . 'KB . Max size of the file must be ' . ini_get('upload_max_filesize') . 'B';
				break;
				case '2':
					$this->errors[] = $file['name'] . ' is too big. Max size of the file is ' . self::MAX_FILE_SIZE/1024 . 'KB';
				break;
				case '3':
					$this->errors[] = $file['name'] . ' file was only partially uploaded.';
				break;
				case '4':
					$this->errors[] = 'No file was uploaded.';
				break;
				default:
					$this->errors[] = 'There was some problem with uploading your file ' . $file['name'];
				break;
			}
			return false;
		}
	}




	/*---------------------- UPLOAD FILE ------------------------------ */

	public function upload($user_id) {
		$file = current($_FILES);
		if($this->validate($file)) {
			var_dump($this->errors);
			// the file was passed validation and can be moved to destination folder
			if(move_uploaded_file($file['tmp_name'], $this->destination . $user_id . '.jpg' )) {
				return true;
			} else {
				return $this->errors[] = 'Some problems with move uploaded file';
			}
			
		} else {
			return $this->errors;
		}
	}

	public function delete() {

	}

}