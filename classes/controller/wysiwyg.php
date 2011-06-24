<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_WYSIWYG extends Controller {

	public function action_static($file)
	{
		// Find the file extension
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		// Remove the extension from the filename
		$file = substr($file, 0, - (strlen($ext) + 1));

		if ($file = Kohana::find_file('vendor', $file, $ext))
		{
			// Check if the browser sent an "if-none-match: <etag>" header, and tell if the file hasn't changed
			$this->response->check_cache(sha1($this->request->uri()).filemtime($file), $this->request);

			// Send the file content as the response
			$this->response->body(file_get_contents($file));

			// Set the proper headers to allow caching
			$this->response->headers('content-type',  File::mime_by_ext($ext));
			$this->response->headers('last-modified', date('r', filemtime($file)));
		}
		else
		{
			// Return a 404 status
			$this->response->status(404);
		}
	}

	public function action_js($file)
	{
		$files = array
		(
			Kohana::find_file('vendor/tiny_mce', 'jquery.tinymce', 'js'),
			Kohana::find_file('vendor/codemirror/lib', 'codemirror', 'js'),
			Kohana::find_file('vendor/codemirror/lib', 'overlay', 'js'),
			Kohana::find_file('vendor/codemirror/mode/xml', 'xml', 'js'),
			Kohana::find_file('media/wysiwyg', 'initEditors', 'js'),
		);

		$optional_content = array
		(
			'textAreaClass' => 'rte',
			'lang'          => array(__('Rich text'), __('Source code'))
		);

		$this->_content($files, 'js', 'editor='.json_encode($optional_content).';');
	}

	public function action_css($file)
	{
		$files = array
		(
			Kohana::find_file('media/wysiwyg', 'wysiwyg', 'css'),
			Kohana::find_file('vendor/codemirror/lib', 'codemirror', 'css'),
			Kohana::find_file('vendor/codemirror/mode/xml', 'xml', 'css')
		);

		$this->_content($files, 'css');
	}

	protected function _content(array $files, $extension, $optional_content = NULL)
	{
		$content = '';

		foreach ($files as $file)
		{
			$content .= file_get_contents($file);
		}

		$this->response->body($optional_content.$content);
		$this->response->headers('content-type',  File::mime_by_ext($extension));
	}

} // End Controller_TinyMCE