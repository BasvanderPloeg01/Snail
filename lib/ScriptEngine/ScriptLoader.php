<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

class ScriptLoader {
	/**
	 * Class ScriptLoader
	 */
	public function __construct() {
		$this->load_scripts();
	}

	/**
	 * Loads in every script in Config::config
     */
	private function load_scripts() {
		if (Config::$config['SCRIPT']['EVERY_TIME_EXECUTION'] != 'NONE') {
			$dirname = Config::$config['SCRIPT']['EVERY_TIME_EXECUTION'];

			/**
			 * @var String
			 */
			$dir = './scripts/';
			
			if (is_array($dirname)) {
				foreach ($dirname as $name) {
					if ($name != "NONE") {
						if (!is_dir($dir . $name)) {
							Debug::exitdump('Script directory not found', __LINE__, "lib/ScriptEngine/ScriptLoader");
						}

						$files = array_diff(scandir($dir . $name), ['..', '.']);

						foreach ($files as $file) {
							/**
							 * @var String
							 */
							$myfile = file_get_contents($dir . $name . '/' . $file);
							
							if (strpos($file, 'Model')) {
								$this->makeModel($myfile, $file);
							} else if (strpos($file, 'Controller')) {
								$this->makeController($myfile, $file);
							} else {
								$this->makeView($myfile, $file);
							}
						}
					}
				}
			} else {
				if ($dirname != "NONE") {
					if (!is_dir($dir . $dirname)) {
						Debug::exitdump('Script directory not found', __LINE__, "lib/ScriptEngine/ScriptLoader");
					}

					$files = array_diff(scandir($dir . $dirname), ['..', '.']);

					foreach ($files as $file) {
						/**
						 * @var String
						 */
						$myfile = file_get_contents($dir . $dirname . '/' . $file);
						
						if (strpos($file, 'Model')) {
							$this->makeModel($myfile, $file);
						} else if (strpos($file, 'Controller')) {
							$this->makeController($myfile, $file);
						} else {
							$this->makeView($myfile, $file);
						}
					}
				}
			}
		}
		
		if (Config::$config['SCRIPT']['ONE_TIME_EXECUTION'] != 'NONE') {
			/**
			 * @var String
			 */
			$settingsContent = './app/Config.php';

			/**
			 * @var String / Array
			 */
			$dirname = Config::$config['SCRIPT']['ONE_TIME_EXECUTION'];

			/**
			 * @var String
			 */
			$dir = './scripts';
			
			if (is_array($dirname)) {
				foreach ($dirname as $name) {
					if ($name != "NONE") {
						if (!is_dir($dir . '/' . $name)) {
							Debug::exitdump('Script directory not found', __LINE__, "lib/ScriptEngine/ScriptLoader");
						}

						$files = array_diff(scandir($dir . '/' . $name), ['..', '.']);

						foreach ($files as $file) {
							/**
							 * @var String
							 */
							$myfile = file_get_contents($dir . '/' . $name . '/' . $file);
							
							if (strpos($file, 'Model')) {
								$this->makeModel($myfile, $file);
							} else if (strpos($file, 'Controller')) {
								$this->makeController($myfile, $file);
							} else {
								$this->makeView($myfile, $file);
							}
						}
					}
				}
			} else {
				if ($dirname != "NONE") {
					if (!is_dir($dir . '/' . $dirname)) {
						Debug::exitdump('Script directory not found', __LINE__, "lib/ScriptEngine/ScriptLoader");
					}

					$files = array_diff(scandir($dir . '/' . $dirname), ['..', '.']);

					foreach ($files as $file) {
						/**
						 * @var String
						 */
						$myfile = file_get_contents($dir . '/' . $dirname . '/' . $file);
						
						if (strpos($file, 'Model')) {
							$this->makeModel($myfile, $file);
						} else if (strpos($file, 'Controller')) {
							$this->makeController($myfile, $file);
						} else {
							$this->makeView($myfile, $file);
						}
					}
				}
			}
			
			if (is_array($dirname)) {
				foreach ($dirname as $script) {
					$newSettingsContent = str_replace($script, 'NONE', file_get_contents($settingsContent));
					file_put_contents($settingsContent, $newSettingsContent);
				}
			} else {
				$newSettingsContent = str_replace($dirname, 'NONE', file_get_contents($settingsContent));
				file_put_contents($settingsContent, $newSettingsContent);
			}
		}
	}

	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates Model
     */
	private function makeModel($fileContents, $name) {
		if (!file_exists('models/' . $name)) {
			$model = fopen('./models/' . $name, 'w');
			
			fwrite($model, $fileContents);
		}
	}

	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates Controller
     */
	private function makeController($fileContents, $name) {
		if (!file_exists('controllers/' . $name)) {
			$view = fopen('./controllers/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}

	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates View
     */
	private function makeView($fileContents, $name) {
		if (!file_exists('views/' . $name)) {
			$view = fopen('./views/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}
}