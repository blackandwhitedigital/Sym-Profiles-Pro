<?php

require ('Wp_License_Manager_Client.php');
class Speaker extends Wp_License_Manager_Client
{
    public $options;
   

	function __construct(){

        $this->options = array(
            'settings' => 'speaker_settings',
            'version'  => '0.1',
            'feature_img_size' => 'speaker-thumb',
            'installed_version' => 'speaker_installed_version'
        );

        
                
        $this->post_type = 'speaker';
        $settings = get_option($this->options['settings']);
        $this->post_type_slug = isset($settings['slug']) ? ($settings['slug'] ? sanitize_title_with_dashes($settings['slug']) : 'speaker' ) : 'speaker';
        $this->incPath       = dirname( __FILE__ );
        $this->functionsPath    = $this->incPath . '/functions/';
        $this->classesPath		= $this->incPath . '/classes/';
        $this->widgetsPath		= $this->incPath . '/widgets/';
        $this->viewsPath		= $this->incPath . '/views/';
        $this->templatePath     = $this->incPath . '/template/';

        $this->assetsUrl        = SPEAKER_PLUGIN_URL  . '/assets/';
        $options = get_option('speaker-license-settings' );
        $seturl = new Wp_License_Manager_Client();
        $seturl->call_api('info',array(
                    
                    'email' => $options['email'],
                    'license_key' => $options['license_key'],
                    'request' => 'activation',
                    'product_id' => 'Symposium Speaker Profiles Pro',
                    'instance' => uniqid(),
                    'platform' => home_url(),          
                    'software_version' => '0.1'
                ),$this->classesPath );

        $this->defaultSettings = array(
            'primary_color' => '#0367bf',
            'feature_img' => array(
                'width' => 400,
                'height'=> 400
            ),
            'slug' => 'speaker',
            'link_detail_page' => 'yes',
            'custom_css' => null
        );

       
        register_activation_hook(SPEAKER_PLUGIN_ACTIVE_FILE_NAME, array($this, 'activate'));
      
        //register_activation_hook(SPEAKER_PLUGIN_ACTIVE_FILE_NAME, array($this, 'initval'));
        //register_activation_hook(SPEAKER_PLUGIN_ACTIVE_FILE_NAME, array($this,'cyb_activation'));
        register_deactivation_hook(SPEAKER_PLUGIN_ACTIVE_FILE_NAME, array($this, 'deactivate'));
        //add_action('activated_plugin',array($this,'save_error'));
        /* $license_manager = new Wp_License_Manager_Client(); */


	}

    /*public function cyb_activation()
    {
        // Don't forget to exit() because wp_redirect doesn't exit automatically
        wp_redirect( admin_url( 'edit.php?post_type=speaker&page=gettingstarted' ) ) ;
        flush_rewrite_rules();
        $this->insertDefaultData();

    }*/

    /*public function activate() {

        flush_rewrite_rules();
        $this->insertDefaultData();

    }
    */
    public function initval($product_id,$product_name,$text_domain,$api_url){
      parent::__construct($product_id,$product_name,$text_domain,$api_url);  
    }

    /*public function activate() {
        flush_rewrite_rules();
        $this->insertDefaultData();
    }*/

    public function deactivate() {
        flush_rewrite_rules();
    }


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


    function loadWidget($dir){
        if (!file_exists($dir)) return;
        foreach (scandir($dir) as $item) {
            if( preg_match( "/.php$/i" , $item ) ) {
                require_once( $dir . $item );
                $class = str_replace( ".php", "", $item );

                if (method_exists($class, 'register_widget')) {
                    $caller = new $class;
                    $caller->register_widget();
                }
                else {
                    register_widget($class);
                }
            }
        }
    }


	 function render( $viewName, $args = array()){
        global $Speaker;

        $viewPath = $Speaker->viewsPath . $viewName . '.php';
        if( !file_exists( $viewPath ) ) return;

        if( $args ) extract($args);
        $pageReturn = include $viewPath;
        if( $pageReturn AND $pageReturn <> 1 )
            return $pageReturn;
        if( @$html ) return $html;
    }


	/**
     * Dynamicaly call any  method from models class
     * by pluginFramework instance
     */
    function __call( $name, $args ){
        if( !is_array($this->objects) ) return;
        //unset($this->objects[3]);
        foreach($this->objects as $object){
            if(method_exists($object, $name)){
                 
                $count = count($args);
                if($count == 0)
                    return $object->$name();
                elseif($count == 1)
                    return $object->$name($args[0]);
                elseif($count == 2)
                    return $object->$name($args[0], $args[1]);
                elseif($count == 3)
                    return $object->$name($args[0], $args[1], $args[2]);
                elseif($count == 4)
                    return $object->$name($args[0], $args[1], $args[2], $args[3]);
                elseif($count == 5)
                    return $object->$name($args[0], $args[1], $args[2], $args[3], $args[4]);
                elseif($count == 6)
                    return $object->$name($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
                elseif($count == 7)
                    return $object->$name($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);

            }
        }
    }

    private function insertDefaultData()
    {
        global $Speaker;
        update_option($Speaker->options['installed_version'],$Speaker->options['version']);
        if(!get_option($Speaker->options['settings'])){
            update_option( $Speaker->options['settings'], $Speaker->defaultSettings);
        }
    }

}

// change post title 
global $Speaker;
if( !is_object( $Speaker ) ) $Speaker = new Speaker;

 
function wpb_change_title_text( $title ){
     $screen = get_current_screen();
     if  ( 'speaker' == $screen->post_type ) {
          $title = 'Speaker Name';
     }
     return $title;
}

  

add_filter( 'enter_title_here', 'wpb_change_title_text' );

// visual composer compatibility

add_action( 'vc_before_init', 'visualcomposer_compatibility' );

function visualcomposer_compatibility() {
    global $Speaker;
    vc_map( array(
        "name" => __( "Speaker" ),
        "base" => "speaker",
        "class" => "",
        "category" => __( "Content"),
        "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => __( "Shortcode" ),
            "param_name" => "value",
            "value" => '[speaker col="2" speaker="4" orderby="speaker" order="ASC" layout="1"]',
            "description" => __( "Shortcode for Speaker Plugin")
         )
      )
   ) );
}

function shortcode_button_script() 
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "code_shortcode", 
                    "Speaker", 
                    callback
                );

                function callback()
                {
                    var selected_text = getSel();
                    QTags.insertContent('[speaker col="4" speaker="4" orderby="speaker" order="ASC" layout="1"]');
                }
            </script>
        <?php
    }

}


/*$newtest->__construct();*/
add_action("admin_print_footer_scripts", "shortcode_button_script");
