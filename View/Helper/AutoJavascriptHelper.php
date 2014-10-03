<?php
App::uses('AppHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');

/**
 * Automatic JavaScript Helper
 *
 * @copyright   Copyright 2014-2014, Victor San Martín (http://victorsanmartin.com)
 * @package     AutoJavascript
 * @subpackage  AutoJavascript.View.Helper
 * @author      Victor San Martín (http://victorsanmartin.com)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class AutoJavascriptHelper extends AppHelper {

/**
 * Default settings
 *
 * @var array
 */
	public $settings = array(
		'path' => 'autoload',
		'controller' => true,
		'action' => false
	);

/**
 * Helpers requiered
 *
 * @var array
 */
	public $helpers = array('Html');

/**
 * Before Render callback
 *
 * @return void
 */
	public function beforeRender($file) {
		if (Configure::check('AutoJavascript.active') && Configure::read('AutoJavascript.active') == false) {
			return true;
		}

		if (!empty($this->settings['path'])) {
			$this->settings['path'] .= DS;
		}

		if ($this->settings['controller']) {
			$files = array($this->settings['path'] . $this->request->controller . '.js');
		}
		if ($this->settings['action']) {
			$files[] = $this->settings['path'] . $this->request->controller . DS . $this->request->action . '.js';
		}

		foreach ($files as $file) {
			$this->_include($file);
		}
	}

/**
 * Include file
 *
 * @param string $file file with path
 * @return void
 */
	protected function _include($file) {
		$includeFile = str_replace(DS, '/', $file);
		$this->Html->script($includeFile, array('inline' => false));
	}
}
