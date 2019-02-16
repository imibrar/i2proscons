<?php
/**
 * Plugin Name: i2 Pro & Cons
 * Plugin URI: https://github.com/imibrar/i2proscons/
 * Description: The plugin will allow you to show pro & cons in beautiful style.
 * Author: Ibrar Hussain
 * Author URI: https://github.com/imibrar
 * Version: 0.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

include_once('include/setting.php');
include_once('include/custom-style.php');


if(!function_exists('i2_pros_cons_block_assets')) {
    function i2_pros_cons_block_assets() { // phpcs:ignore
        // Styles.
        wp_enqueue_style(
            'i2-pros-cons-block-style-css', // Handle.
            plugins_url( 'dist/blocks.editor.build.css',  __FILE__ ), // Block style CSS.
            array( 'wp-editor' ) // Dependency to include the CSS after it.
          //  ,filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
        );
        wp_enqueue_style('i2-pros-and-cons-custom-fonts-icons-style', plugins_url('/dist/fonts/styles.css', __FILE__));
      }
    }
    
    // Hook: Frontend assets.
    add_action( 'enqueue_block_assets', 'i2_pros_cons_block_assets' );
    
    
    if(!function_exists('i2_pros_cons_setup')) {
        function i2_pros_cons_setup()
        {
    
            wp_enqueue_script(
                'i2_pro_cons_script', // Handle.
                plugins_url( '/dist/blocks.build.js',  __FILE__  ),
                array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
                true // Enqueue the script in the footer.
            );
            $options = get_option( 'i2_pros_and_cons', i2_pros_and_cons_options_default());
            $i2_pros_cons_icons = array(
                'useIcon' => $options['use_icons'],
                'pros' => $options['pros_icon'],
                'cons' => $options['cons_icon']
            );
            wp_localize_script( 'i2_pro_cons_script', 'i2_pro_cons_icons', $i2_pros_cons_icons);


            wp_enqueue_style('i2_pro_cons_editor_style', plugins_url('/dist/blocks.editor.build.css', __FILE__));
        }
    }
    
    add_action( 'enqueue_block_editor_assets', 'i2_pros_cons_setup' );
    
    function i2_pros_cons( $atts , $content = null){
        $options = get_option( 'i2_pros_and_cons', i2_pros_and_cons_options_default());
        // echo '<pre>'; 
        //  print_r($atts); 
        //  echo '</pre>';

             
/*
    [pros_icon] => icon icon-thumbs-up
    [cons_icon] => icon icon-thumbs-down use_icons
*/
    $icon =  isset( $atts['type'] ) && $atts['type'] == 'cons' ? $options['cons_icon'] : $options['pros_icon'];  
    $useIcon = $options['use_icons'] == 1? "has-icon" : "no-icon";  
    $data = substr($content, 6, strlen($content) -6);
    $lines = explode("\n", $data);
    $list = "<ul class='{$useIcon}'>";
     foreach ($lines as $key => $value) {
         $trimed = rtrim($value, "<br />");
         $trimed = rtrim($trimed, "<br >");
         $trimed = rtrim($trimed, "<br>");
         if(strlen($trimed) > 0){
         $list .= "<li>" . ($options['use_icons'] == 1 ? "<i class='{$icon}'></i>" : "") . $trimed . "</li>";
         }
     }
      return	$list . '</ul>';
    }
    add_shortcode( 'i2proscons', 'i2_pros_cons' );

    function i2_pros_cons_sc($params, $content = null) {        
        return '<div class="i2-pros-cons-wrapper">' . do_shortcode( $content) . '</div>';    
    }
    add_shortcode('i2pc','i2_pros_cons_sc');

    function i2_pros_sc($params, $content = null) {    
        return 	"<div class='i2-pros'> <h3 class='i2-pros-title'> ". __('Pros') . "</h3>
        <div class='section'>" 
        .  do_shortcode("[i2proscons type='pros']<data>{$content}</data>[/i2proscons]") . 
        "</div> </div>";    
    }
    add_shortcode('i2pros','i2_pros_sc');

    function i2_cons_sc($params, $content = null) {    
        return 	"<div class='i2-cons'> <h3 class='i2-cons-title'> ". __('Cons') . "</h3>
        <div class='section'>" 
        .  do_shortcode("[i2proscons type='pros']<data>{$content}</data>[/i2proscons]") . 
        "</div> </div>";    
    }
    add_shortcode('i2cons','i2_cons_sc');