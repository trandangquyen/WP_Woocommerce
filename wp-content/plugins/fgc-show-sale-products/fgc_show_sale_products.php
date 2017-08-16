<?php
/*
Plugin Name: FGC Show Sale Products
Plugin URI: https://fgc.com/
Description: show products on the front page
Version: 1.0
Author: Dang Quyen
Author URI: https://dangquyen.com
License: GPLv2 or later
Text Domain: dangquyen

*/
define('FGC_SALE_DIR_PATH',plugin_dir_path(__FILE__) );
define('FGC_SALE_DIR_URL',plugin_dir_url(__FILE__) );
class Fgc_Product_Sale{
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }
    // Create Table event post
    public function fgc_sale_product_create_db() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'sale_products';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          products_number tinyint(4) UNSIGNED NOT NULL,
          columns tinyint(4) UNSIGNED NOT NULL,
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
        register_activation_hook( __FILE__, array($this,'fgc_sale_product_create_db'));

        // Add submenu
        //add_action('admin_menu', array($this,'add_submenu_events_manager'));
        // Remove event menu title
        //add_action('admin_menu', array($this,'remove_event_menu_title'));
        add_filter( 'storefront_on_sale_products_args',  array($this,'tp_product_categories_args' ));


    }
    // Add menu events manager  to the admin panel
    public function add_menu_sale_products(){

        add_menu_page('Sản phẩm giảm giá',//title on the top address bar
            'Sản phẩm giảm giá',//title menu to show
            'manage_options',//The capability required , don't change
            'manageProductOption',//menu slug
            array($this,'show_custom_product_page'),//callback funcion
            'dashicons-format-aside',// icon
            2//position
        );

    }
    public function show_custom_product_page(){
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM wp_sale_products" );
        $limit = $myrows[0]->products_number;
        $column = $myrows[0]->columns;
        ?>
        <form action="" method="post">
            <br>
            Nhập số lượng sản phẩm hiển thị (>0 và <10): <br>
            <input type="number" name="quantity" value="<?php echo $limit ?>">
            <br><br>
            Số cột (>0 và <5): <br>
            <input type="number" name="column" value="<?php echo $column ?>">
            <br><br>
            <input type="submit" value="submit" name="salepr_submit">
        </form>

        <?php

    }
    public function add_submenu_events_manager(){
        add_submenu_page(
            'manageProductOption',//parent slug
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

    public function tp_product_categories_args( $args ) {
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM wp_sale_products" );
        $limit = $myrows[0]->products_number;
        $column = $myrows[0]->columns;
        $args = array(
            'limit' => $limit,
            'columns' => $column,
            'title' => __( 'Sản phẩm giảm giá', 'storefront' )
        );

        return $args;

    }
    public function update_sale_products(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'sale_products';
        $quantity = $_POST['quantity'];
        $columns = $_POST['column'];
        if($quantity <= 0 || $quantity >10)

        {
            //$quantity = 0;

            echo '<div class="notice notice-warning" style="width: 84.3%; float: right"><p>Số sản phẩm nhập vào không hợp lệ (phải > 0 và < 10 sản phẩm)</p></div>';
            return;
        }
        if($columns <= 0 || $columns >5)
        {
            echo '<div class="notice notice-warning"  style="width: 84.3%; float: right"><p>Số cột không hợp lệ (phải > 0 và < 5)</p></div>';
            return;
        }
        $data = array(
            'products_number' => $quantity ,
            'columns' => $columns
        );
        $myrows = $wpdb->get_results( "SELECT id FROM wp_sale_products" );
        //var_dump($myrows); exit;
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
$new_sale_products = new Fgc_Product_Sale();
$new_sale_products->execute();
if(isset($_POST['salepr_submit']))
{
    $new_sale_products->update_sale_products();

}