<?php

if(!class_exists('SpeakerTemplate')):

    /**
     *
     */
    class SpeakerTemplate
    {

        function __construct()
        {
            add_filter( 'template_include', array( $this, 'template_loader' ) );
        }

        public static function template_loader( $template ) {
            // $file = array('single-team.php');
            $find = array();
            $file = null;
            global $Speaker;
            if ( is_single() && get_post_type() == $Speaker->post_type ) {

                $file 	= 'single-team.php';
                $find[] = $file;
                $find[] = $Speaker->templatePath . $file;

            }

            if ( @$file ) {

                $template = locate_template( array_unique( $find ) );
                if ( ! $template ) {
                    $template = $Speaker->templatePath  . $file;
                }
            }

            return $template;
        }

    }

endif;
