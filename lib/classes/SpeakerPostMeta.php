<?php
if (!class_exists('SpeakerPostMeta')):

    /**
     *
     */
    class SpeakerPostMeta
    {

        function __construct() {
            add_action('add_meta_boxes', array($this, 'speaker_meta_boxs'));
            add_action('save_post', array($this, 'save_speaker_meta_data'), 10, 3);
            add_action( 'edit_form_after_title', array($this, 'speaker_after_title') );
            add_action( 'admin_enqueue_scripts', array($this, 'event_enqueue'));
        }
        
        function speaker_after_title($post){
            global $Speaker;

            if( $Speaker->post_type !== $post->post_type) {
                return;
            }
        }

        function speaker_meta_boxs() {
            add_meta_box(
                'speaker_meta',
                __('Speaker Info', SPEAKER_SLUG ),
                array($this,'speaker_meta'),
                'speaker',
                'normal',
                'high'
            );
            
        }

        function speaker_meta($post){
                global $Speaker;
                wp_nonce_field( $Speaker->nonceText(), 'speaker_nonce' );
                $meta = get_post_meta( $post->ID );
            ?>
            <div class="member-field-holder">

            <form action="" method="post" enctype="multipart/form-data">

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="short_bio"><?php _e('Short Bio:', SPEAKER_SLUG); ?></label>
                    </div>
                    <div class="tlp-field">
                        <textarea name="short_bio" rows="5" class="tlpfield" value=""><?php echo (@$meta['short_bio'][0] ? @$meta['short_bio'][0] : null) ?></textarea>
                        <span class="desc"><?php _e('Add some short bio', SPEAKER_SLUG); ?></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="organisation"><?php _e('Organisation', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="text" name="organisation" class="tlpfield" value="<?php echo (@$meta['organisation'][0] ? @$meta['organisation'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="web_url"><?php _e('Organisation Web URL', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="url" name="web_url" class="tlpfield" value="<?php echo (@$meta['web_url'][0] ? @$meta['web_url'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="designation"><?php _e('Role', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="text" name="designation" class="tlpfield" value="<?php echo (@$meta['designation'][0] ? @$meta['designation'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                
                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="email"><?php _e('Email', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="email" name="email" class="tlpfield" value="<?php echo (@$meta['email'][0] ? @$meta['email'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="url"><?php _e('Telephone', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="text" name="telephone" class="tlpfield" value="<?php echo (@$meta['telephone'][0] ? @$meta['telephone'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="location"><?php _e('Location', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                        <input type="text" name="location" class="tlpfield" value="<?php echo (@$meta['location'][0] ? @$meta['location'][0] : null) ?>">
                        <span class="desc"></span>
                    </div>
                </div>

                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="location"><?php _e('Event', SPEAKER_SLUG); ?>:</label>
                    </div>
                    <div class="tlp-field">
                    <?php 
                        $argss= query_posts( array( 'post_type' => 'agenda' ) );
                        $agenda= new WP_Query( $argss );
                        if ($agenda->have_posts()) :  
                        ?>
                            <select name="Event_name" id="Event_name">
                            <option value="0"><?php echo (@$meta['Speaker_event'][0] ? @$meta['Speaker_event'][0] : null) ?></option>
                                <?php  while (have_posts()) : the_post();  
                                $event_date = get_post_meta( get_the_ID(), 'event_date', true );
                                ?>
                                    <option value="<?php echo get_the_title(); 
                                        ?>**<?php  echo get_permalink();?>**<?php echo $event_date; ?>**<?php echo get_the_ID(); ?> ">
                                    <?php echo get_the_title(); 
                                    ?>
                                    </option>
                                <?php endwhile;  ?>
                            </select>
                        <?php //endif;
                        else: ?><input type="text" name="Event_name" class="tlpfield" value="<?php echo (@$meta['Event_name'][0] ? @$meta['Event_name'][0] : null) ?>">
                            
                        <?php  endif; ?>
                        <span class="desc"></span>
                    </div>
                </div>


            <!--  social links start-->

            <h2 class="hndle ui-sortable-handle"><?php _e('Social Links', SPEAKER_SLUG); ?></h2>     
            <?php
            $s = unserialize(get_post_meta( $post->ID, 'social' , true));
                foreach($Speaker->socialLink() as $id => $label){
                ?>
                <div class="tlp-field-holder">
                    <div class="tplp-label">
                        <label for="location"><?php echo $label; ?></label>
                    </div>
                    <div class="tlp-field">
                        <input type="url" name="social[<?php echo $id; ?>]" class="tlpfield" value="<?php echo (@$s[$id] ? @$s[$id] : null) ?>">
                    </div>
                </div>
            <?php } ?>
            </form>
            </div>
            <?php
        }

        /* social links end*/

        function save_speaker_meta_data($post_id, $post, $update) {

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

            global $Speaker;

            if ( !wp_verify_nonce( @$_REQUEST['speaker_nonce'], $Speaker->nonceText() ) )return;


            if ( 'speaker' != $post->post_type ) return;

            if ( isset( $_REQUEST['short_bio'] ) ) {
                update_post_meta( $post_id, 'short_bio', sanitize_text_field( $_REQUEST['short_bio'] ) );
            }

            if ( isset( $_REQUEST['email'] ) ) {
                update_post_meta( $post_id, 'email', sanitize_text_field( $_REQUEST['email'] ) );
            }

            if ( isset( $_REQUEST['organisation'] ) ) {
                update_post_meta( $post_id,'organisation', sanitize_text_field( $_REQUEST['organisation'] ) );
            }

            if ( isset( $_REQUEST['designation'] ) ) {
                update_post_meta( $post_id, 'designation', sanitize_text_field( $_REQUEST['designation'] ) );
            }

            if ( isset( $_REQUEST['web_url'] ) ) {
                update_post_meta( $post_id, 'web_url', sanitize_text_field( $_REQUEST['web_url'] ) );
            }

            if ( isset( $_REQUEST['telephone'] ) ) {
                update_post_meta( $post_id, 'telephone', sanitize_text_field( $_REQUEST['telephone'] ) );
            }

            if ( isset( $_REQUEST['location'] ) ) {
                update_post_meta( $post_id, 'location', sanitize_text_field( $_REQUEST['location'] ) );
            }

            if ( isset( $_REQUEST['Event_name'] ) ) {
                $str = $_REQUEST['Event_name'];
                $strr = $_REQUEST['Event_name'];
                $test=(explode('**',$str,-1));
                $plink=(explode('**',$str,-1));                
                $date=(explode('**',$str,3));
                $ID=(explode('**',$str,4));
                update_post_meta( $post_id, 'Speaker_event', sanitize_text_field( $test[0] ) );
                update_post_meta( $post_id, 'speakerevent_link', sanitize_text_field( $plink[1] ) );
                update_post_meta( $post_id, 'speakerevent_date', sanitize_text_field( $date[2] ) );
                update_post_meta( $post_id, 'speakerevent_ID', sanitize_text_field( $ID[3] ) );
            }

            if( isset($_REQUEST['social'])){
                $s = array_filter($_REQUEST['social']);
                update_post_meta( $post_id, 'social', serialize($s) );
            }

        }

        function speaker_script() {
            global $post_type,$Speaker;
            if($post_type == $Speaker->post_type){
                $Speaker->speaker_style();
                $Speaker->speaker_script();
            }
        }

        function event_enqueue(){
            //wp_enqueue_script( 'event_function', $Agenda->assetsUrl. 'js/events.js', array( 'jquery' ) );
        }
    }
    
endif;
    