<?php
if( !class_exists( 'SpeakerfrontEnd' ) ) :

	class SpeakerfrontEnd {

        function __construct(){
            add_action( 'wp_enqueue_scripts', array($this, 'speaker_front_end') );
            add_action( 'wp_head', array($this, 'custom_css') );
        }

        function custom_css(){

            $html = null;
            global $Speaker;
            $settings = get_option($Speaker->options['settings']);
            $fiw = (isset($settings['feature_imgw']) ? ($settings['feature_imgw'] ? $settings['feature_imgw'] : 'auto' ) : 'auto');
            $fih = (isset($settings['feature_imgh']) ? ($settings['feature_imgh'] ? $settings['feature_imgh'] : 'auto' ) : 'auto');
            $ib = (isset($settings['imgborder']) ? ($settings['imgborder'] ? $settings['imgborder'] : 'none' ) : 'none');
            $pc = (isset($settings['primary_color']) ? ($settings['primary_color'] ? $settings['primary_color'] : '#0367bf' ) : '#0367bf');
            /* title setting layout1*/
            $hc = (isset($settings['heading_color']) ? ($settings['heading_color'] ? $settings['heading_color'] : '#000' ) : '#000');
            $hs = (isset($settings['heading_size']) ? ($settings['heading_size'] ? $settings['heading_size'] : '15px' ) : '15px');
            $ha = (isset($settings['heading_align']) ? ($settings['heading_align'] ? $settings['heading_align'] : 'none' ) : 'none');
            $hd = (isset($settings['heading_display']) ? ($settings['heading_display'] ? $settings['heading_display'] : 'show' ) : 'show');
            if ($hd =='hide'){
                $hdis = 'none';
            }
            $fb = (isset($settings['full_biolink']) ? ($settings['full_biolink'] ? $settings['full_biolink'] : '#333333' ) : '#333333');
            $fw = (isset($settings['textstylehead']) ? ($settings['textstylehead'] ? $settings['textstylehead'] : 'normal' ) : 'normal');
            $fs = (isset($settings['textstyleorg']) ? ($settings['textstyleorg'] ? $settings['textstyleorg'] : 'normal' ) : 'normal');
            $textd = (isset($settings['textstyledesc']) ? ($settings['textstyledesc'] ? $settings['textstyledesc'] : 'normal' ) : 'normal');
            /* designation setting layout1*/
            $dc = (isset($settings['desg_color']) ? ($settings['desg_color'] ? $settings['desg_color'] : '#333' ) : '#333');
            $ds = (isset($settings['desg_size']) ? ($settings['desg_size'] ? $settings['desg_size'] : '15px' ) : '15px');
            $da = (isset($settings['desg_align']) ? ($settings['desg_align'] ? $settings['desg_align'] : 'none' ) : 'none');
            $ddd = (isset($settings['desg_display']) ? ($settings['desg_display'] ? $settings['desg_display'] : 'show' ) : 'show');
            if ($ddd =='hide'){
                $ddis = 'none';
            }
            /* organisation setting layout1*/
            $oc = (isset($settings['org_color']) ? ($settings['org_color'] ? $settings['org_color'] : '#333' ) : '#333');
            $os = (isset($settings['org_size']) ? ($settings['org_size'] ? $settings['org_size'] : '15px' ) : '15px');
            $oa = (isset($settings['org_align']) ? ($settings['org_align'] ? $settings['org_align'] : 'none' ) : 'none');
            $od = (isset($settings['org_display']) ? ($settings['org_display'] ? $settings['org_display'] : 'show' ) : 'show');
            if ($od =='hide' && $od =='Hide'){
                $odis = 'none';
            }
             /* description setting layout1*/
            $tc = (isset($settings['text_color']) ? ($settings['text_color'] ? $settings['text_color'] : '#000' ) : '#000');
            $ts = (isset($settings['text_size']) ? ($settings['text_size'] ? $settings['text_size'] : '15px' ) : '15px');
            $ta = (isset($settings['text_align']) ? ($settings['text_align'] ? $settings['text_align'] : 'none' ) : 'none');
            $td = (isset($settings['text_display']) ? ($settings['text_display'] ? $settings['text_display'] : 'show' ) : 'show');
            if ($td =='hide' && $td =='Hide'){
                $tdis = 'none';
            }

            $br = (isset($settings['border_radius']) ? ($settings['border_radius'] ? $settings['border_radius'] : '0%' ) : '0%');
            $gm = (isset($settings['grid']) ? ($settings['grid'] ? $settings['grid'] : '15px' ) : '15px');
        
            
            
            $html .= "<style type='text/css'>";
            $html .= '  .tpl-socialicon li a.fa ,.tlp-team .short-desc, .tlp-team .tlp-team-isotope .tlp-content, .tlp-team .button-group .selected, .tlp-team .layout1 .tlp-content, .tlp-team .tpl-social a, .tlp-team .tpl-social li a.fa {';
                $html .= 'background: '.$pc;
            $html .= '}';
            /* title setting layout1*/
            $html .='.heading-color,.heading-color a,.tlp-team .layout1 .single-team-area h3 a{';
            $html .= 'color: '.$hc.'!important;';
            $html .= 'font-size: '.$hs.'!important;';
            $html .= 'text-align: '.$ha.'!important;';
            $html .= 'display: '.$hdis.'!important';
            $html .= 'font-weight: '.$fw.'!important;';
            $html .= 'font-style: '.$fw.'!important;';
            $html .= 'text-decoration: '.$fw.'!important';
            $html .= '}';
            /* title setting layout1 */
            /* designation setting layout1*/
            $html .='.setting-desg{';
            $html .= 'color: '.$dc.'!important;';
            $html .= 'font-size: '.$ds.'!important;';
            $html .= 'text-align: '.$da.'!important;';
            $html .= 'display: '.$ddis.'!important;';
            $html .= 'font-weight: '.$fd.'!important;';
            $html .= 'font-style: '.$fd.'!important;';
            $html .= 'text-decoration: '.$fd.'!important';
            $html .= '}';
            /* designation setting layout1 */
            /* organisation setting layout1*/
            $html .='.setting-org{';
            $html .= 'color: '.$oc.'!important;';
            $html .= 'font-size: '.$os.'!important;';
            $html .= 'text-align: '.$oa.'!important;';
            $html .= 'display: '.$odis.'!important';
            $html .= 'font-weight: '.$fs.'!important;';
            $html .= 'font-style: '.$fs.'!important;';
            $html .= 'text-decoration: '.$fs.'!important';
            $html .= '}';
            /* organisation setting layout1 */
            /* description setting layout1*/
            $html .='.setting_desc{';
            $html .= 'color: '.$tc.'!important;';
            $html .= 'font-size: '.$ts.'!important;';
            $html .= 'text-align: '.$ta.'!important;';
            $html .= 'display: '.$tdis.'!important';
            $html .= 'font-weight: '.$textd.'!important;';
            $html .= 'font-style: '.$textd.'!important;';
            $html .= 'text-decoration: '.$textd.'!important';
            $html .= '}';
            /* description setting layout1 */
            $html .= '.full_biolink{';
            $html .= 'background-color:'.$fb.'';
            $html .= '}';
            $html .='.img-responsive {';
            $html .= 'border-radius: '.$br.'!important;';
            $html .= 'width: '.$fiw.'px!important;';
            $html .= 'height: '.$fih.'px!important';
            $html .= '}';
            $html .='.img-lay2 {';
            $html .= 'width: '.$fiw.'px!important;';
            $html .= 'height: '.$fih.'px!important';
            $html .= '}';
            $html .='.imageborder {';
            $html .= 'border: '.$ib.'!important';
            $html .= '}';
            $html .='.imagebordertwo {';
            $html .= 'border: '.$ib.'!important;';
            $html .= 'border-radius: 50%!important;';
            $html .= '}';
            
            
            $html .='.tlp-col-xs-1, .tlp-col-sm-1, .tlp-col-md-1, .tlp-col-lg-1, .tlp-col-xs-2, .tlp-col-sm-2, .tlp-col-md-2, .tlp-col-lg-2, .tlp-col-xs-3, .tlp-col-sm-3, .tlp-col-md-3, .tlp-col-lg-3, .tlp-col-xs-4, .tlp-col-sm-4, .tlp-col-md-4, .tlp-col-lg-4, .tlp-col-xs-5, .tlp-col-sm-5, .tlp-col-md-5, .tlp-col-lg-5, .tlp-col-xs-6, .tlp-col-sm-6, .tlp-col-md-6, .tlp-col-lg-6, .tlp-col-xs-7, .tlp-col-sm-7, .tlp-col-md-7, .tlp-col-lg-7, .tlp-col-xs-8, .tlp-col-sm-8, .tlp-col-md-8, .tlp-col-lg-8, .tlp-col-xs-9, .tlp-col-sm-9, .tlp-col-md-9, .tlp-col-lg-9, .tlp-col-xs-10, .tlp-col-sm-10, .tlp-col-md-10, .tlp-col-lg-10, .tlp-col-xs-11, .tlp-col-sm-11, .tlp-col-md-11, .tlp-col-lg-11, .tlp-col-xs-12, .tlp-col-sm-12, .tlp-col-md-12, .tlp-col-lg-12 {';
            $html .= 'padding-left: '.$gm.'!important;';
            $html .= 'padding-right: '.$gm.'!important';
            $html .= '}';

            $html .= (isset($settings['custom_css']) ? ($settings['custom_css'] ? "{$settings['custom_css']}" : null) : null );

            $html .= "</style>";
             echo $html;
        }

	function speaker_front_end(){
            global $Speaker;
            wp_enqueue_style( 'speaker-fontawsome', $Speaker->assetsUrl .'css/font-awesome/css/font-awesome.min.css' );
            wp_enqueue_style( 'Speakerstyle', $Speaker->assetsUrl . 'css/Speakerstyle.css' );
            wp_enqueue_script( 'speaker-isotope-js', $Speaker->assetsUrl . 'js/isotope.pkgd.js', array('jquery'), '2.2.2', true);
            wp_enqueue_script( 'speaker-isotope-imageload-js', $Speaker->assetsUrl . 'js/imagesloaded.pkgd.min.js', array('jquery'), null, true);
            wp_enqueue_script( 'speaker-front-end', $Speaker->assetsUrl . 'js/front-end.js', null, null, true);
        }

	}
endif;
