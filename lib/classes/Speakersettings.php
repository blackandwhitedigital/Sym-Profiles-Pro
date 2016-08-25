<?php

/**
*
*/
class Speakersettings
{

    function __construct()
    {
        add_action( 'init', array($this, 'speaker_pluginInit') );
        add_action( 'wp_ajax_speakerSettings', array($this, 'speakerSettings'));
        add_action( 'admin_menu' , array($this, 'speaker_menu_register'));
        add_filter( 'plugin_action_links_' . SPEAKER_PLUGIN_ACTIVE_FILE_NAME, array($this, 'speaker_marketing') );
    }

    function speaker_marketing($links){
        return $links;
    }

    /**
     *  Ajax response for settings update
     */
    
    function speakerSettings(){
        global $Speaker;
        $error = true;     
        if($Speaker->verifyNonce()){
            unset($_REQUEST['action']);
            unset($_REQUEST['speaker_nonce']);
            unset($_REQUEST['_wp_http_referer']);
            update_option( $Speaker->options['settings'], $_REQUEST);
            flush_rewrite_rules();
            $response = array(
                    'error'=> $error,
                    'msg' => __('Settings successfully updated',SPEAKER_SLUG)
                );
        }else{
            $response = array(
                    'error'=> true,
                    'msg' => __('Security Error!!',SPEAKER_SLUG)
                );
        }
        wp_send_json( $response );
        die();
    }

    /**
     *  Text domain + image size register
     */
    function speaker_pluginInit(){
        $this->load_plugin_textdomain();
        
        global $Speaker;
        $settings = get_option($Speaker->options['settings']);
        $width = isset($settings['feature_img']['width']) ? ($settings['feature_img']['width'] ? (int) $settings['feature_img']['width'] : 400) : 400;
        $height = isset($settings['feature_img']['height']) ? ($settings['feature_img']['height'] ? (int) $settings['feature_img']['height'] : 400) : 400;
        add_image_size( $Speaker->options['feature_img_size'], $width, $height, true );
       
    }


    /**
     *  speaker menu addition
     */
    function speaker_menu_register() {
        global $Speaker;
        $page = add_submenu_page( 'edit.php?post_type=speaker', __('Speaker Settings', SPEAKER_SLUG), __('Settings', SPEAKER_SLUG), 'administrator', 'Speaker_settings', array($this, 'Speaker_settings') );

        $about = add_submenu_page('edit.php?post_type=speaker', __('Getting Started', AGENDA_SLUG), __('Getting Started', AGENDA_SLUG), 'administrator', 'gettingstarted', array($this, 'gettingstarted'));

        add_action('admin_print_styles-' . $page, array( $this,'speaker_style'));
        add_action('admin_print_scripts-'. $page, array( $this,'speaker_script'));
        wp_enqueue_style( 'tpl_css_settings', $Speaker->assetsUrl . 'css/settings.css');
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'tpl_js_settings',  $Speaker->assetsUrl. 'js/settings.js', array('jquery','wp-color-picker'), '', true );
        $nonce = wp_create_nonce( $Speaker->nonceText() );
        /* var_dump($nonce);
        exit();*/
        wp_localize_script( 'tpl_js_settings', 'tpl_var', array('speaker_nonce' => $nonce) );

    }

    /**
     *  speaker Style addition
     */
    function speaker_style(){
        global $Speaker;
        wp_enqueue_style( 'tpl_css_settings', $Speaker->assetsUrl . 'css/settings.css');
    }

    /**
     *  speaker script addition
     */
    function speaker_script(){
        global $Speaker;
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'tpl_js_settings',  $Speaker->assetsUrl. 'js/settings.js', array('jquery','wp-color-picker'), '', true );
        $nonce = wp_create_nonce( $Speaker->nonceText() );
        wp_localize_script( 'tpl_js_settings', 'tpl_var', array('speaker_nonce' => $nonce) );
    }

    /**
     * Render donation page
     */
    function gettingstarted()
    {
        global $Speaker;
        $Speaker->render('about');
    }

    /**
     * Render team settings page
     */
    function Speaker_settings(){
        global $Speaker;
        $Speaker->render('settings');
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since 0.1.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain( SPEAKER_SLUG, FALSE,  SPEAKER_LANGUAGE_PATH );
    }

}
