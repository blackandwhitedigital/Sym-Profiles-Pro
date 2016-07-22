<?php
if( !class_exists( 'SpeakerSupport' ) ) :

	class SpeakerSupport {

		function verifyNonce( ){
            global $Speaker;
            $nonce      = @$_REQUEST['speaker_nonce'];
            $nonceText  = $Speaker->nonceText();
            if( !wp_verify_nonce( $nonce, $nonceText ) ) return false;
            return true;
        }

        function nonceText(){
        	return "speaker_nonce";
        }

        function socialLink(){
            return array(
                    'facebook' => __('Facebook', SPEAKER_SLUG),
                    'twitter'   => __('Twitter', SPEAKER_SLUG),
                    'linkedin' =>  __('LinkedIn', SPEAKER_SLUG),
                    'youtube' =>  __('Youtube', SPEAKER_SLUG),
                    'vimeo' =>  __('Vimeo', SPEAKER_SLUG),
                    'google-plus' =>  __('Google+', SPEAKER_SLUG)
                );
        }

	}
endif;
