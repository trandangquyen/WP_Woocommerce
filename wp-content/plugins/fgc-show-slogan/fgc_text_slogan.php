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
    // Create Table event post
    public function fgc_slogan_create_db() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'slogan_products';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          text_slogan text COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY  (id)
          
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    public function execute(){
        //add js vs css to admin panel
        //add_action('admin_enqueue_scripts', array( $this, 'admin_style'));
        // Add event manager menu to admin panel
        add_action('admin_menu', array($this,'add_menu_sale_products'));
        register_activation_hook( __FILE__, array($this,'fgc_slogan_create_db'));

        // Add submenu
        //add_action('admin_menu', array($this,'add_submenu_events_manager'));
        // Remove event menu title
        //add_action('admin_menu', array($this,'remove_event_menu_title'));
        add_filter( 'the_content',  array($this,'tp_product_categories_args' ));


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

    }
    public function show_slogan_page(){
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM wp_slogan_products" );
        $curent_slogan = $myrows[0]->text_slogan;
        ?>
        <form action="" method="post">
            Nhập vào slogan muốn hiển thị:<br><br>

            <textarea name="slogan" id="text-slogan" cols="50" rows="5"><?php echo $curent_slogan ?></textarea>
            <br><br>
            <input type="submit" value="submit" name="slogan_submit">
        </form>

        <?php

    }
    public function add_submenu_events_manager(){
        add_submenu_page(
            'slogan-in-page',//parent slug
            'Cấu hình hiển thị',//title on the top address bar
            'Cấu hình hiển thị',//title menu to show
            'manage_options',//don't change
            'event.all-events-list',//menu slug
            array($this,'show_custom_form')//callback function
        );
    }

    public function show_custom_form(){
        echo 'This content do not show in the admin panelllll';
    }

    public function tp_product_categories_args( $content ) {
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM wp_slogan_products" );
        $curent_slogan = $myrows[0]->text_slogan;
        $content = $content.'<strong>'.$curent_slogan.'</strong>';

        return $content;

    }
    public function update_slogan(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'slogan_products';
        $slogan = $_POST['slogan'];
        //var_dump($slogan); exit;
        $data = array(
            'text_slogan' => $slogan
        );
        $myrows = $wpdb->get_results( "SELECT id FROM wp_slogan_products" );

        if(empty($myrows))
        {
            $wpdb->insert($table_name, $data, $format = null);
            echo '<div class="notice notice-warning"  style="width: 84.3%; float: right"><p>Cập nhật thành công!</p></div>';
        }
        else{
            $where = array('id'=>1);
            $sql_event_update = $wpdb->update($table_name, $data,$where, $format = null, $where_format = null);
            echo '<div class="notice notice-warning"  style="width: 84.3%; float: right"><p>Cập nhật thành công!</p></div>';
        }

        if($sql_event_update)
            return true;
        else
            return false;
    }





}//end class
$new_slogan = new Fgc_Slogan();
$new_slogan->execute();
if(isset($_POST['slogan_submit']))
{
    $new_slogan->update_slogan();

}