<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Kohana_Controller_Stencil extends Controller_Template
{
	public $template;
	public $content;
	public $title;
	
	public function __construct(Kohana_Request $request)
	{
		parent::__construct($request);
		
		$this->template = Kohana::config('stencil.template_dir') . '/' . Kohana::config('stencil.default_template');
	}
	
	public function before()
	{
		parent::before();
		
		if($this->auto_render)
		{
			$this->template->title		= '';
			
			$this->template->content	= View::factory($this->request->controller . '/' . $this->request->action);
			
			$this->template->styles 	= array();
			$this->template->scripts	= array();
		}
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			//$styles = array(
			//	'media/css/screen.css' => 'screen, projection',
			//	'media/css/print.css' => 'print',
			//	'media/css/style.css' => 'screen',
			//);
	  
			//$scripts = array(
			//	'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js',
			//);
		
			$this->template->title = $this->__title($this->template->title);
			
			//$this->template->styles = array_merge( $this->template->styles, $styles );
			//$this->template->scripts = array_merge( $this->template->scripts, $scripts );
		}
		parent::after();
	}
	
	/*
	 * Generate Title according to config
	 *
	 */
	
	private function __title($title)
	{
		if( !empty($title))
		{
			if(Kohana::config('stencil.site_name_placement') == 'append')
			{
				$title .= Kohana::config('stencil.site_name_divider') . Kohana::config('stencil.site_name');
			}
			else
			{
				$title = Kohana::config('stencil.site_name') . Kohana::config('stencil.site_name_divider') . $title;
			}
		}
		else
		{
			$title = Kohana::config('stencil.site_name');
		}
		
		return $title;
	}
	
	/*
	 * Generate Content according to config
	 *
	 */
	private function __content($content)
	{
		if( !empty($content))
		{
			
		}
	
	}
}
