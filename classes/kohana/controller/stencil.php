<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stencil Layout Module for Kohana
 *
 * @package		Stencil Layout Module
 * @author		David Goodson
 * @website		daveg.me.uk
 * @copyright	(c) 2010-2011 David Goodson
 * @license		http://creativecommons.org/licenses/by-sa/3.0/
 * @version		0.1.4
 */

abstract class Kohana_Controller_Stencil extends Controller_Template
{
	public $template;
	public $styles;
	public $scripts;

	private function init()
	{
		$this->template = Kohana::config('stencil.template_dir') .'/'. Kohana::config('stencil.default_template');
		
		$this->auto_render = Kohana::config('stencil.auto_render');
		
		$this->styles = array();
		$this->scripts = array();
	}
	
	public function before()
	{
		$this->init();
		
		parent::before();
			
		if($this->auto_render)
		{
			$this->template->title 		= $this->__title(NULL);
			$this->template->content 	= $this->__content(NULL);
			
			$this->template->styles 	= $this->__styles( Kohana::config('stencil.default_styles'));
			$this->template->scripts	= $this->__scripts( Kohana::config('stencil.default_scripts'));
		}
	}
	
	public function after()
	{
		if($this->auto_render)
		{		
			$this->template->title = $this->__title($this->template->title);
			$this->template->content = $this->__content($this->template->content);
			
			$this->template->styles = array_merge( $this->template->styles, $this->__styles($this->styles) );
			$this->template->scripts = array_merge( $this->template->scripts, $this->__scripts($this->scripts) );
		}
		
		parent::after();
	}
	
	/*
	 * Generate Title according to config and input
	 *
	 */
	
	private function __title($title)
	{
		if( !empty($title) && $title != Kohana::config('stencil.site_name'))
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
	 * Generate View for Content according to input
	 *
	 */
	private function __content($content)
	{
		if( !empty($content))
		{
			if(get_class($content) != 'View')
				$content = View::factory($content);
		}
		else
		{
				$content = View::factory($this->request->controller() . '/' . $this->request->action());
		}
		
		return $content;
	}
	
	/*
	 * Append Styles Dir to styles array
	 *
	 */
	private function __styles($styles)
	{
		$append = Kohana::config('stencil.styles_dir').'/';
		
		return $this->__array_value_append($styles, $append);
	}
	
	/*
	 * Append Script Dir to scripts array
	 *
	 */
	private function __scripts($scripts)
	{
		$append = Kohana::config('stencil.scripts_dir').'/';
		
		return $this->__array_value_append($scripts, $append);
	}
	
	/*
	* Append string to values in an array
	*
	*/
	private function __array_value_append($arr, $append)
	{
		foreach($arr as &$v)
			$v = $append.$v;
		
		return $arr;
	}
}
