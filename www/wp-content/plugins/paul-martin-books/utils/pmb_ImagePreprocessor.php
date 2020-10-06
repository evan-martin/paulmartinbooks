<?php

	class pmb_ImagePreprocessor{
		
		private static $IMG_EXT = '.png';
		
		//private $_srcDir = '/Users/ascanlon/projects/braazi/trunk/www/wp-content/themes/bones/library/images/parts/';
		//private $_destDir = '/Users/ascanlon/projects/braazi/trunk/www/wp-content/themes/bones/library/images/parts/med';
		private $_srcDir = '/Users/ascanlon/projects/paulmartinbooks_wp/trunk/assets/pauls_photos_retouch/';
		private $_destDir = '/Users/ascanlon/projects/paulmartinbooks_wp/trunk/assets/pauls_photos_retouch_processed/';
		//private $_height = 395; //Image will first be resized to this height (preserving the aspect ratio)
		private $_width = 150;//624; //Image will then be cropped to this width to make images a small as possible
		
		public function run(){
			
			//Search for and process the images
			error_log('Preprocessing images in ' . $this->_srcDir);
			$this->findImages($this->_srcDir);
		}
		
		/**
		 * Searches for images in the srcDir
		 */
		private function findImages($dir){
			
			$files = scandir($dir);
			foreach($files as $file){
				
				if (0===strpos($file, '.'))
					continue;
				
				$absFile = $dir. '/' . $file;
				if (is_dir($absFile)){
					error_log('Searching for images in ' . $absFile);
					$this->findImages($absFile);
				} else if (is_file($absFile)){
					
					$this->processImage($absFile);
				}
			} 
		}
		
		/**
		 * Processes found images
		 */
		private function processImage($imgFile){
			if (!$this->endsWith($imgFile, '.jpg'))
				return;
				
			error_log('Processing ' . $imgFile);

			$procImgFile = $this->_destDir . substr($imgFile, strlen($this->_srcDir));
			$procImgFile = substr($procImgFile, 0, strpos($procImgFile, '.')).'.jpg';


			$this->createDir($procImgFile);
			
			$img = new \Imagick($imgFile);
			$img->setImageCompression(Imagick::COMPRESSION_JPEG);
			$img->setImageFormat('jpeg');
			$img->setImageCompressionquality(80);
			$img->resizeimage($this->_width, 0, imagick::FILTER_LANCZOS, 1);
			//$img->cropImage($this->_width, $this->_height, intval(($img->getImageWidth() - $this->_width)/2), 0);
			$img->writeimage($procImgFile);
			$img->destroy();
			
			error_log('Writing processed image to  ' . $procImgFile);			
		}
		
		private function createDir($absFile){
			$dir = dirname($absFile);
			//Make the destination directory if it doesn't exist
			if (!is_dir($dir))
			{
				error_log('Creating directory: ' . $dir);
				mkdir($dir, 0755, true);
			}			
		}
		
		function endsWith($haystack, $needle)
		{
		    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
		}
	}
	
	//Kick off the preprocessor
	$preprocessor = new pmb_ImagePreprocessor();
	$preprocessor->run();
?>