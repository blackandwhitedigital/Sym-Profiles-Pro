<?php
get_header( );

while ( have_posts() ) : the_post();
	global $post;
?>
<div class="container-fluid tlp-single-container">
	<div class="row">
		<article id="post-<?php the_ID(); ?>" <?php post_class('tlp-member-article'); ?>>
		<div class="container-fluid tlp-team">
			<div class="tlp-col-lg-2 tlp-col-md-2 tlp-col-sm-2 tlp-col-xs-12 profile-cover ">
			<div class="profile-pic"><div class="imageborder">
				<?php
				if(has_post_thumbnail()){
					echo get_the_post_thumbnail( get_the_ID(), 'large' );
				}else{
	               	$img = $Speaker->assetsUrl .'images/demo.jpg';
	                echo "<img src='".$img."'>";
	            }
				?>
			</div></div>
			</div>
			<div class="tlp-col-lg-8 tlp-col-md-8 tlp-col-sm-8 tlp-col-xs-12">
				
				<?php
					$sLink = unserialize(get_post_meta( get_the_ID(), 'social' , true));
					$organisation = get_post_meta( get_the_ID(), 'organisation', true );
					$organisationlogo = get_post_meta( get_the_ID(), 'organisationlogo', true );
					$designation = get_post_meta( get_the_ID(), 'designation', true );
					$short_bio = get_post_meta( get_the_ID(), 'short_bio', true );
					$url = get_post_meta( get_the_ID(), 'web_url', true );
					$speaker_event = get_post_meta( get_the_ID(), 'Speaker_event', true );
					$logo = get_post_meta( get_the_ID(), 'meta-image', true );
					$speakerevent_link = get_post_meta( get_the_ID(), 'speakerevent_link', true );
					$title = $post->post_title;
					$posttype = $post->post_type;
					$permalink = get_permalink($post_id);

					$html = null;

					$html .="<div class='tlp-single-details tlp-team'>";
					$html .= '<ul class="contact-info">';
					?>

						<?php
			            $html .="<h3 class='widget-heading'><span class='title_name heading-color'>".get_the_title();
						if($designation){
			            	$html .="</span><span class='title_des setting-org'>$designation</span>";
			            }
			            if($organisation){
			                $html .="<span class='title_org setting-org'>$organisation</span>";
			            }
			            $html .= "</h3>";
			            if($speaker_event){
			            $html .= "<div class=''><a href='". $speakerevent_link . "''>$speaker_event</a></div>";
			             }
			            $html .= '<div class="tlp-member-detail">'. apply_filters('the_content',get_the_content()) .'</div>';
			            $html .= '<div class="short-bio">';
			           
			            $html .= '<div class="tpl-social socialicon">';
						if ($sLink) {
							foreach ($sLink as $id => $link) {
								$html .= "<a href='{$sLink[$id]}' title='$id' target='_blank'><i class='fa fa-$id'></i></a>";
							}
						}
						$html .= '</div>';
			        	$html .= "</div>";
		            $html .= "</ul></div>";
			$html .= "</div>";
            $html .= '<div class="tlp-col-lg-2 tlp-col-md-2 tlp-col-sm-2 tlp-col-xs-12 logo">';
            if($logo){
                $html .= '<img src= '.$logo.' />';
            }
            $html .= "</div>";
			echo $html;
			
			?>

		</article>


<?php endwhile;

get_footer();
