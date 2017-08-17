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

    public function execute(){
        //add js vs css to admin panel
        //add_action('admin_enqueue_scripts', array( $this, 'admin_style'));
        // Add event manager menu to admin panel
        add_action('admin_menu', array($this,'add_menu_sale_products'));
        register_activation_hook( __FILE__, array($this,'fgc_sale_product_create_db'));
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
        add_action( 'admin_init', array($this,'register_mysettings' ));

    }
    public function show_custom_product_page() {
        ?>
        <div class="wrap">
            <h2>Cài đặt số lượng sản phẩm giảm giá</h2>
            <?php if( isset($_GET['settings-updated']) ) { ?>
                <div id="message" class="updated">
                    <p><strong><?php _e('Settings saved.') ?></strong></p>
                </div>
            <?php } ?>
            <form method="post" action="options.php">
                <?php settings_fields( 'mfpd-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Số lượng sản phẩm hiển thị:</th>
                        <td><input type="number" name="mfpd_option_name" value="<?php echo get_option('mfpd_option_name'); ?>" readonly/></td>
                    </tr>
                </table>
                <?php submit_button('Cập nhật'); ?>
            </form>
        </div>
    <?php
    }

    //function to register options
    public function register_mysettings() {
        register_setting( 'mfpd-settings-group', 'mfpd_option_name' );
    }
    public function tp_product_categories_args( $args ) {
        $limit = get_option('mfpd_option_name',10);
        $args = array(
            'limit' => $limit,
            'columns' => 4,
            'title' => __( 'Sản phẩm giảm giá', 'storefront' )
        );

        return $args;

    }





}//end class
$new_sale_products = new Fgc_Product_Sale();
$new_sale_products->execute();