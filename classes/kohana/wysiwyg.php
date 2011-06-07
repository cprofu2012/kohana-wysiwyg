<?php defined('SYSPATH') or die('No direct access allowed.');

class Kohana_WYSIWYG {

	/**
	 * @var array
	 */
	protected $_config;

	/**
	 *
	 *
	 * @return string
	 */
	public static function js()
	{
		return Route::get('wysiwyg')
			->uri(array('action' => 'js', 'file' => 'wysiwyg.js'));
	}

	/**
	 *
	 * @return string
	 */
	public static function css()
	{
		return Route::get('wysiwyg')
			->uri(array('action' => 'css', 'file' => 'wysiwyg.css'));
	}

} // End Kohana_WYSIWYG