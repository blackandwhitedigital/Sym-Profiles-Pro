<?php
if (!class_exists('Speakerorganisation')) {

    class Speakerorganisation {


        function __construct() {
            add_action('add_meta_boxes', array($this, 'prfx_custom_meta'));
            add_action( 'edit_form_after_title', array($this, 'speaker_after_title') );
            add_action( 'admin_enqueue_scripts', array($this, 'prfx_image_enqueue'));
            add_action('save_post', array($this, 'save_speakerorganisation_meta_data'), 10, 3);
        }
        function speaker_after_title($post){
            global $Speaker;

            if( $Speaker->post_type !== $post->post_type) {
                return;
            }
        }

        function prfx_custom_meta() {
            add_meta_box(
                    'speaker_metas',
                    __('Organization Logo', SPEAKER_SLUG ),
                    array($this,'speaker_metas'),
                    'speaker',
                    'side'
                );
        }
  
        function speaker_metas($post){
                global $Speaker;
                wp_nonce_field( $Speaker->nonceText(), 'speaker_nonce' );
                $meta = get_post_meta( $post->ID );
            ?>
            <div class="tlp-field-holder">
                    <div class="tplp-label orglable">
                        <label for="organisation_logo"><?php _e('Organisation logo', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field orgfield">
                        <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
                        <input type="button" id="meta-image-button" class="button orgbutton" value="<?php _e( 'Upload an Image', 'prfx-textdomain' )?>" />

                        <span class="desc"></span>
                    </div>
                </div>
                <?php
            }

        function save_speakerorganisation_meta_data($post_id, $post, $update) {

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

            global $Speaker;

            if ( !wp_verify_nonce( @$_REQUEST['speaker_nonce'], $Speaker->nonceText() ) )return;


            if ( 'speaker' != $post->post_type ) return;

            if( isset( $_POST[ 'meta-image' ] ) ) {
                update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] );
            }

        }
         // Registers and enqueues the required javascript.
        function prfx_image_enqueue() {
            
            global $Speaker;
                wp_enqueue_media();
                wp_enqueue_script( 'box_image', $Speaker->assetsUrl. 'js/meta-box-image.js', array( 'jquery' ) );
                wp_localize_script( 'box_image', 'meta_image',
                    array(
                        'title' => __( 'Upload an Image', 'prfx-textdomain' ),
                        'button' => __( 'Use this image', 'prfx-textdomain' ),
                    )
                );
                wp_enqueue_script( 'box_image' );
            
        }
}
}