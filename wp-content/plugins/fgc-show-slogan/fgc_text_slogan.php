<?php
/*
Plugin Name: FGC Show Slogan
Plugin URI: https://fgc.com/
Description: show slogan bottom content
Version: 1.0
Author: Dang Quyen
Author URI: https://dangquyen.com
License: GPLv2 or later
Text Domain: dangquyen

*/
define('FGC_SLOGAN_DIR_PATH',plugin_dir_path(__FILE__) );
define('FGC_SLOGAN_DIR_URL',plugin_dir_url(__FILE__) );
class Fgc_Slogan{
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function execute(){
        //add js vs css to admin panel
        //add_action('admin_enqueue_scripts', array( $this, 'admin_style'));
        // Add event manager menu to admin panel
        add_action('admin_menu', array($this,'add_menu_sale_products'));
        register_activation_hook( __FILE__, array($this,'fgc_slogan_create_db'));
        // Add filer
        add_action( 'brian_action_hook',  array($this,'update_slogan' ));


    }
    // Add menu events manager  to the admin panel
    public function add_menu_sale_products(){

        add_menu_page('Slogan bottom of page',//title on the top address bar
            'Slogan in page',//title menu to show
            'manage_options',//The capability required , don't change
            'slogan-in-page',//menu slug
            array($this,'show_slogan_page'),//callback funcion
            'dashicons-format-aside',// icon
            3//position
        );
        add_action( 'admin_init', array($this,'register_mysettings' ));

    }
    public function show_slogan_page(){
        ?>
        <div class="wrap">
            <h2>Cài đặt slogan</h2>
            <?php if( isset($_GET['settings-updated']) ) { ?>
                <div id="message" class="updated">
                    <p><strong><?php _e('Settings saved.') ?></strong></p>
                </div>
            <?php } ?>
            <form method="post" action="options.php">
                <?php settings_fields( 'mfpd-slogan-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Slogan cần hiển thị:</th>
                        <td><textarea rows="4" cols="50" name="mfpd_slogan_option_name" readonly><?php echo get_option('mfpd_slogan_option_name'); ?></textarea></td>
                    </tr>
                </table>
                <?php submit_button('Cập nhật'); ?>
            </form>
        </div>
        <?php

    }

    public function update_slogan( $content ) {
//        $curent_slogan = get_option('mfpd_slogan_option_name','Slogan đang chờ nhập...');
//        $content = $content.'<strong>'.$curent_slogan.'</strong>';
//        return $content;
        $curent_slogan = get_option('mfpd_slogan_option_name','Slogan đang chờ nhập...');
        echo '<strong>'.$curent_slogan.'</strong>';
    }

    public function register_mysettings() {
        register_setting( 'mfpd-slogan-settings-group', 'mfpd_slogan_option_name' );
    }

}//end class
$new_slogan = new Fgc_Slogan();
$new_slogan->execute();