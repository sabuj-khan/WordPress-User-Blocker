<?php
/*
 * Plugin Name:       User Role Blocker
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       User Role Blocker
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mohammad Sabuj Khan
 * Author URI:        https://sabuj.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       urb
 * Domain Path:       /languages
 */


 function urb_load_text_domain(){
    load_plugin_textdomain( 'urb', false, dirname( __FILE__ ) . '/languages' );
 }
add_action('plugins_loaded', 'urb_load_text_domain');


function urb_add_new_role(){
    add_role('urb_user_blocked', __('Blocked', 'urb'), array('blocked'=>true));

    add_rewrite_rule('blocked/?$', 'index.php?blocked=1', 'top');  

}
add_action('init', 'urb_add_new_role');


function url_query_vars(){
    $query_vars[] = 'blocked';
    return $query_vars;
}
add_filter('query_vars', 'url_query_vars');



add_action('init', function(){
    if(is_admin() && current_user_can('blocked')){
        wp_redirect(get_home_url().'/blocked');
        die();
    }
});


function url_template_redirect(){
    $is_blocked = intval(get_query_var('blocked'));

    if($is_blocked){
        
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Blocked</title>
        </head>
        <body>
         <h2>   <?php echo __('You are blocked', 'url'); ?> </h2>
        </body>
        </html>



        <?php
        die();
    }

}
add_action('template_redirect', 'url_template_redirect');







