<?php

if(!class_exists('SpeakerinitWidget')):

	/**
	* 
	*/
	class SpeakerinitWidget
	{
		
		function __construct()
		{
			add_action( 'widgets_init', array($this, 'initWidget'));
		}


		function initWidget(){
			global $Speaker;

			$Speaker->loadWidget( $Speaker->widgetsPath );
		}
	}


endif;