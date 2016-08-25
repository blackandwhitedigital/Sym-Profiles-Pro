 <?php

if(!class_exists('OneSpeakerShortcode')):

	/**
	* Shorcode for Specific Speaker
	*/
	class OneSpeakerShortcode
	{
		function __construct()
		{			
			add_shortcode( 'speakerinfo', array( $this, 'speakerpost_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array($this, 'fancybox_speaker') );
			add_action('wp_ajax_speakerinfo',  array($this,'speakerinfo'));
            add_action('wp_ajax_nopriv_speakerinfo',  array($this,'speakerinfo'));
		}

		function speakerpost_shortcode($atts , $content = ""){

			$col_A = array(1,2,3,4,6);

			global $Speaker;
			$atts = shortcode_atts( array(
					'speaker' => 'Panda',
					'col' => 3, 
		            'orderby'   => 'organisation',
					'order'	=> 'DESC',
					'layout'	=> 1,
					'pagination' => off,
				), $atts, 'speakerinfo' );
			$pagination = $atts['pagination'] == 'on' ? true : false;

			if(!in_array($atts['col'], $col_A)){
				$atts['col'] = 3;
			}
			if(!in_array($atts['layout'], array(1,2,3,'isotope'))){
				$atts['layout'] = 1;
			}

			$paged = get_query_var('paged') ? get_query_var('paged') :1 ; 

			$html = null;
			//$searchSchools = new WP_Query( $finalArgs );
			global $wpdb;
    		$mypostids = $wpdb->get_col("SELECT ID from $wpdb->posts where post_title LIKE '". $atts['speaker']."%' ");

    		$eventids = $wpdb->get_results("SELECT post_id from $wpdb->postmeta where meta_key = 'speakerevent_ID'");
    		$eventinfo = array();
    		var_dump($eventinfo);
    		foreach ($eventids as $key => $value) {
    		$val=$value->post_id;
    		$eventinfo[] = $val;
    		
    		}
    		if ($mypostids){
			$args = array(
					'post__in'=> $mypostids,
					'post_type' => 'speaker',
					'post_status'=> 'publish',
					
				);
			}else{
				$args = array(
					'post__in'=> $eventinfo,
					'post_type' => 'speaker',
					'post_status'=> 'publish',
					
				);
			}
		
			$speakerQuery = new WP_Query( $args );

			   if ( $speakerQuery->have_posts() ) {
			   		$html .= '<div class="container-fluid tlp-team">';
				    if($atts['layout'] == 'isotope') {
					    
					    $html .= '<div class="tlp-team-isotope">';
				    }
				    if($atts['layout'] != 'isotope') {
					    $html .= '<div class="row layout' . $atts['layout'] . '">';
				    }
				    if (!empty($_POST['id'])){
				   		$sid=$_POST['id'];
				    }else{
				   		$sid= 0;
				    }
				   
				    while ($speakerQuery->have_posts()) : $speakerQuery->the_post();
				    		
				    		$ID = get_the_ID();
				      		$title = get_the_title();
				      		$pLink = get_permalink();
				      		$short_bio = get_post_meta( get_the_ID(), 'short_bio', true );
				      		$designation = get_post_meta( get_the_ID(), 'designation', true );
				      		$organisation = get_post_meta( get_the_ID(), 'organisation', true );
				      		$speaker_event = get_post_meta( get_the_ID(), 'Speaker_event', true );
				      		$speakerevent_link = get_post_meta( get_the_ID(), 'speakerevent_link', true );
				      		$logo = get_post_meta( get_the_ID(), 'meta-image', true );

				      		if (has_post_thumbnail()){
				      			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $Speaker->options['feature_img_size']);
				      			$imgSrc = $image[0];
				      		}else{
								$imgSrc = $Speaker->assetsUrl .'images/demo.jpg';
				      		}

                            $grid=12/$atts['col'];
                            if($atts['col']==2){
						          $image_area="tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-6 tlp-col-xs-12 ";
						          $content_area="tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-6 tlp-col-xs-12 ";
						          $logoarea="";
						      }elseif($atts['col']==3){
						          $image_area="tlp-col-lg-3 tlp-col-md-4 tlp-col-sm-6 tlp-col-xs-12 ";
						          $content_area="tlp-col-lg-9 tlp-col-md-9 tlp-col-sm-6 tlp-col-xs-12 ";
						          $logoarea="tlp-col-lg-12 tlp-col-md-12 tlp-col-sm-12 tlp-col-xs-12";
						      }
							elseif($atts['col']==4){
						          $image_area
						          ="tlp-col-lg-12 tlp-col-md-12 tlp-col-sm-12 tlp-col-xs-12 ";
						          $content_area="tlp-col-lg-12 tlp-col-md-12 tlp-col-sm-12 tlp-col-xs-12 ";
						          $logoarea="";
						      }else{
						          $image_area="tlp-col-lg-3 tlp-col-md-4 tlp-col-sm-6 tlp-col-xs-12 ";
						          $content_area="tlp-col-lg-9 tlp-col-md-9 tlp-col-sm-6 tlp-col-xs-12 ";
						          $logoarea="";
						      }

				      		$sLink = unserialize(get_post_meta( get_the_ID(), 'social' , true));

							if($atts['layout'] != 'isotope') {
								$html .= "<div class='tlp-col-lg-{$grid} tlp-col-md-{$grid} tlp-col-sm-6 tlp-col-xs-12 tlp-equal-height'>";
							}
							switch ($atts['layout']) {
								case 1:
									$html .= $this->layoutOne($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link, $short_bio, $sLink);
								break;

								case 2:
									$html .= $this->layoutTwo($ID,$title, $pLink, $imgSrc, $designation, $organisation,$speaker_event,$speakerevent_link,$logo,$short_bio, $sLink,$image_area,$content_area);
								break;

								case 3:
									$html .= $this->layoutThree($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link,$logo ,$short_bio, $sLink,$image_area,$content_area);
								break;

								case 'isotope':
									$html .= $this->layoutIsotope($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link,$grid);
								break;

								default:
									# code...
								break;
							}
							if($atts['layout'] != 'isotope') {
								$html .= '</div>'; //end col

							}

				    endwhile;
					if($atts['layout'] != 'isotope') {
						$html .= '</div>'; // End row
					}
				    wp_reset_postdata();
				    // end row
				    if($atts['layout'] == 'isotope') {
					   $html .= '</div>'; // end speaker-isotope
				    }
				    $html .= '</div>'; // end container
				    }else{
				   	  	$html .= "<p>".__('No speaker found',SPEAKER_SLUG)."</p>";
				    }
			 
			return $html;

		}

		function layoutOne($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link, $short_bio, $sLink){
			global $Speaker;

			$settings = get_option($Speaker->options['settings']);
			
			$html = null;

			$html .= '<div class="single-team-area"><a onclick="div_show('.$ID.')" id="speakerinfo">';
			  	$html .='<div class="imageborder"><img class="img-responsive" src="'.$imgSrc.'" alt="'.$title.'"/></div></a>';
			  		$html .= '<div class="tlp-content">';
					if($settings['link_detail_page'] == 'no') {
						$html .= '<h3 class="name text-color heading-color">'. $title . '</h3>';
					}else{
						
					$html .= '<div class="body"><div class= "block"><h3 class="name text-color heading-color"><a title="' . $title . '"  class="modal-popup" href="'. $pLink.'">' . $title . '</a></h3></div></div>';
					}
					if($designation){
						$html .= '<div class="designation setting-org">'.$designation.'</div>';
					}
					if($organisation){
						$html .= '<div class="organisation setting-org">'.$organisation.'</div>';
					}
					if($speaker_event){
						$html .= '<div class="designation setting-org"><a href="' . $speakerevent_link . '" class ="text-color">'.$speaker_event.'</a></div>';
					}
				
	                $html .= '</div></div>';
	                 	$html .= '<div class="short-bio text-color">';
	    				if($short_bio){
						   	$shortexcerpt = wp_trim_words( $short_bio, $num_words = 20, $more = '<button  class="readmore_text text-color" onclick="fadeintext('.$ID.')">&nbsp...read more</button>' );
						   	$html .= '<p class="setting_desc" id="shortdesc'.$ID.'">' . $shortexcerpt . '</p>';
						   	
						   	}
						   	$html .= '<p class="setting_desc desc" id="fulldesc'.$ID.'"><a class="readmore_text" onclick="fadeouttext('.$ID.')">' . $short_bio . '</a></p>';
					$html .= '</div>';
        			$html .= '<div class="tpl-social">';
        			if($sLink){
        				foreach ($sLink as $id => $link) {
        						$html .= "<a href='{$sLink[$id]}' title='$id' target='_blank'><i class='fa fa-$id'></i></a>";
        				}
        			}
        		$html .= '</div>';
        	$html .= '</a></div>';

        	
                /*Pop-up window start*/
          
                $html .= '<div id="textm" class="popup">';
                $html .= '<div id="popupContact">';
                $html .= '<div class="popup-content">';
                $html .= '<button onclick ="div_hide()" class="">X</button>';
                $html .= '<div class="tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-12 tlp-col-xs-12"><div class="pop-speaker" id="speakerimg" ></div></div>';
                $html .= '<div class="tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-12 tlp-col-xs-12">';
                $html .= "<h3 class='widget-heading popup-desc'><span id='namepopup'>";
                $html .= "</span><br><span id='desigpopup'></span>,";
                $html .= " <span id='orgpopup'></span>";
                $html .= "</h3>";
                $html .= '<div id="biopopup"></div>';
                $html .= '<div id="urlpopup"></div><div></div>';
                 $html .= '</div>';
                $html .= '</form>';
                $html .= '</div></div>';
                $html .= '</div>';

                /* Pop-up Window end*/
			return $html;
			die();
		}

		function layoutTwo($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link,$short_bio,$logo, $sLink,$image_area,$content_area){
			global $Speaker;
			$settings = get_option($Speaker->options['settings']);

			$html = null;
				$html .='<div class="single-team-area round-img"><a onclick="div_show('.$ID.')" id="speakerinfo">';
					$html .='<div class="'. $image_area.'">';
						$html .='<div class="imagebordertwo"><img class="imagebordertwo" src="'.$imgSrc.'" alt="'.$title.'"/></div>';
					$html .= '</div>';

					$html .='<div class="'. $content_area.'">';
					$html .='<span class="leftcontenttwo">';
					if($settings['link_detail_page'] == 'no') {
						$html .= '<h3 class="tlp-title heading-color">'.$title.'</h3>';
					}else{
                        $html .= '<h3 class="tlp-title heading-color"><a title="'.$title.'" href="'.$pLink.'">'.$title.'</a></h3>';
					}
					$html .='<div class="designation setting-org">'.$designation.'</div>';
					$html .='<div class="organisation setting-org">'.$organisation.'</div>';
						if($speaker_event){
							$html .= '<div class="designation text-color"><a href="' . $speakerevent_link . '" class ="text-color">'.$speaker_event.'</a></div>';
						}
					$html .='</span><span class="rightcontenttwo">';
					if($logo){
		                $html .= '<img src= '.$logo.' />';
		            }
		            $html .='</span>';
					$html .='<div class="short-bio text-color">';
						if($short_bio){
						   
						   	$shortexcerpt = wp_trim_words( $short_bio, $num_words = 20, $more = '<button  class="readmore_text readtext" onclick="fadeintext('.$ID.')">&nbsp...read more</button>' );
						   	$html .= '<p class="setting_desc" id="shortdesc'.$ID.'">' . $shortexcerpt . '</p>';
						   	
						   	}
						   	$html .= '<p class="setting_desc desc" id="fulldesc'.$ID.'"><a class="readmore_text" onclick="fadeouttext('.$ID.')">' . $short_bio . '</a></p>';
						
					$html .= '</div>';

				$html .= '</div>';
			$html .= '</div>';

			/*Pop-up window start*/
          
                $html .= '<div id="textm" class="popup">';
                $html .= '<div id="popupContact">';
                $html .= '<div class="popup-content">';
                $html .= '<button onclick ="div_hide()" class="">X</button>';
                $html .= '<div class="tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-12 tlp-col-xs-12"><div class="pop-speaker" id="speakerimg" ></div></div>';
                $html .= '<div class="tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-12 tlp-col-xs-12">';
                $html .= "<h3 class='widget-heading popup-desc'><span id='namepopup'>";
                $html .= "</span><br><span id='desigpopup'></span>,";
                $html .= " <span id='orgpopup'></span>";
                $html .= "</h3>";
                $html .= '<div id="biopopup"></div>';
                $html .= '<div id="urlpopup"></div><div></div>';
                 $html .= '</div>';
                $html .= '</form>';
                $html .= '</div></div>';
                $html .= '</div>';


                /* Pop-up Window end*/

			return $html;
		}

		function layoutThree($ID,$title, $pLink, $imgSrc, $designation,  $organisation,$speaker_event,$speakerevent_link,$logo,$short_bio,  $sLink,$image_area,$content_area){
			global $Speaker;
			$settings = get_option($Speaker->options['settings']);

			$html = null;
				$html .='<div class="single-team-area "><a onclick="div_show('.$ID.')" id="speakerinfo">';
					$html .='<div class="'. $image_area.'">';
						$html .='<div class="imageborder"><img class="img-lay2 " src="'.$imgSrc.'" alt="'.$title.'"/></div>';
					$html .= '</div>';

					$html .='<div class="'. $content_area.'">';
					$html .='<span class="leftcontenttwo">';
					if($settings['link_detail_page'] == 'no') {
						$html .= '<h3 class="tlp-title heading-color">'.$title.'</h3>';
					}else{
                        $html .= '<h3 class="tlp-title heading-color"><a title="'.$title.'" href="'.$pLink.'">'.$title.'</a></h3>';
					}
					$html .='<div class="designation setting-org">'.$designation.'</div>';
					$html .='<div class="organisation setting-org">'.$organisation.'</div>';
						if($speaker_event){
							$html .= '<div class="designation text-color"><a href="' . $speakerevent_link . '" class ="text-color">'.$speaker_event.'</a></div>';
						}
					$html .='</span><span class="rightcontenttwo">';
					if($logo){
		                $html .= '<img src= '.$logo.' />';
		            }
		            $html .='</span>';
					$html .='<div class="short-bio text-color">';
						if($short_bio){
						   
						   	$shortexcerpt = wp_trim_words( $short_bio, $num_words = 20, $more = '<button  class="readmore_text readtext" onclick="fadeintext('.$ID.')">&nbsp...read more</button>' );
						   	$html .= '<p class="setting_desc" id="shortdesc'.$ID.'">' . $shortexcerpt . '</p>';
						   	
						   	}
						   	$html .= '<p class="setting_desc desc" id="fulldesc'.$ID.'"><a class="readmore_text" onclick="fadeouttext('.$ID.')">' . $short_bio . '</a></p>';
						
					$html .= '</div>';

				$html .= '</div>';
			$html .= '</div>';
			/*Pop-up window start*/
          
                 $html .= '<div id="textm" class="popup">';
                $html .= '<div id="popupContact">';
                $html .= '<div class="popup-content">';
                $html .= '<button onclick ="div_hide()" class="">X</button>';
                $html .= '<div class="tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-12 tlp-col-xs-12"><div class="pop-speaker" id="speakerimg" ></div></div>';
                $html .= '<div class="tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-12 tlp-col-xs-12">';
                $html .= "<h3 class='widget-heading popup-desc'><span id='namepopup'>";
                $html .= "</span><br><span id='desigpopup'></span>,";
                $html .= " <span id='orgpopup'></span>";
                $html .= "</h3>";
                $html .= '<div id="biopopup"></div>';
                $html .= '<div id="urlpopup"></div><div></div>';
                 $html .= '</div>';
                $html .= '</form>';
                $html .= '</div></div>';
                $html .= '</div>';

                /* Pop-up Window end*/

			return $html;
		}

		function layoutIsotope($ID,$title, $pLink, $imgSrc, $designation,$organisation,$speaker_event,$speakerevent_link,$grid){
			global $Speaker;
			$settings = get_option($Speaker->options['settings']);
			$html = null;
			$html .= "<div class='team-member tlp-col-lg-{$grid} tlp-col-md-{$grid} tlp-col-sm-6 tlp-col-xs-12 tlp-equal-height '>";
				$html .= '<div class="single-team-area"><a onclick="div_show('.$ID.')" id="speakerinfo">';
			  		$html .='<div class="imageborder"><img class="img-responsive" src="'.$imgSrc.'" alt="'.$title.'"/></div>';
			  		$html .= '<div class="tlp-content">';
						if($settings['link_detail_page'] == 'no') {
							$html .= '<h3 class="name heading-color">'. $title . '</h3>';
						}else{
							$html .= '<h3 class="name heading-color"><a title="' . $title . '" href="' . $pLink . '">' . $title . '</a></h3>';
						}
						if($designation){
							$html .= '<div class="designation setting-org">'.$designation.'</div>';
						}

	                $html .= '</div>';
				$html .= '</div>';
        	$html .= '</div>';

        	/*Pop-up window start*/
          
                 $html .= '<div id="textm" class="popup">';
                $html .= '<div id="popupContact">';
                $html .= '<div class="popup-content">';
                $html .= '<button onclick ="div_hide()" class="">X</button>';
                $html .= '<div class="tlp-col-lg-5 tlp-col-md-5 tlp-col-sm-12 tlp-col-xs-12"><div class="pop-speaker" id="speakerimg" ></div></div>';
                $html .= '<div class="tlp-col-lg-7 tlp-col-md-7 tlp-col-sm-12 tlp-col-xs-12">';
                $html .= "<h3 class='widget-heading popup-desc'><span id='namepopup'>";
                $html .= "</span><br><span id='desigpopup'></span>,";
                $html .= " <span id='orgpopup'></span>";
                $html .= "</h3>";
                $html .= '<div id="biopopup"></div>';
                $html .= '<div id="urlpopup"></div><div></div>';
                 $html .= '</div>';
                $html .= '</form>';
                $html .= '</div></div>';
                $html .= '</div>';


            /* Pop-up Window end*/
			return $html;
		}

		function speakerinfo(){ 
			global $Speaker;
			$id= $_POST['id'];
			$post_info = get_post($id ); 
			$titles = $post_info->post_title;
		    $organisations = get_post_meta( $id, 'organisation', true );
			$designations = get_post_meta( $id, 'designation', true );
			$short_bios = get_post_meta( $id, 'short_bio', true );
			$logos = get_post_meta( $id, 'meta-image', true );
			if (has_post_thumbnail($id)){
      			$images = wp_get_attachment_image_src( get_post_thumbnail_id($id));
      			$imgSrcc = $images[0];
      		}else{
				$imgSrcc = $Speaker->assetsUrl .'images/demo.jpg';
      		}
      		$speakerinfo= $titles."**".$imgSrcc."**".$organisations."**".$designations."**".$short_bios."**".$logos;
      		echo $speakerinfo;

      		die();

		}

		function fancybox_speaker(){
			global $Speaker;
			wp_enqueue_style( 'Speakerstyle', $Speaker->assetsUrl . 'css/Speakerstyle.css' );
			wp_enqueue_script( 'fancyboxSpeakerajaxjs', ' http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js
            	' );
            wp_enqueue_script( 'fancyboxSpeakerjs', 'http://code.jquery.com/jquery-1.11.1.min.js' );
            wp_enqueue_script( 'speaker-fancybox-js', 'http://www.jqueryscript.net/demo/Basic-Animated-Modal-Popup-Plugin-with-jQuery-stepframemodal/jquery.stepframemodal.js');
            	
            wp_enqueue_script( 'ajax_testing', $Speaker->assetsUrl . 'js/fancyboxinfo.js', array('jquery'), '2.2.2', true);
            wp_localize_script( 'ajax_testing', 'the_ajax_scripts', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );  

            wp_enqueue_script( 'fadein_desc', $Speaker->assetsUrl . 'js/fadein_desc.js', array('jquery'), '2.2.2', true);

            wp_enqueue_script( 'fadein_descinfo', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js' );  
		}

		
	}

endif;
