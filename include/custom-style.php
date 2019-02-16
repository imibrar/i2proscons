<?php
/*
    [use_theme] => default
    [use_border] => 0
    [use_border_shadow] => 0

    [heading_center] => 
    [heading_font_size] => 
    [heading_color] => #ffffff
    [pros_heading_background] => #00bf08
    [cons_heading_background] => #bf000a

    [body_font_size] => 
    [body_color] => 
    [pros_background] => 
    [cons_background] => 

    [use_icons] => 1
    [icon_top] => 8
    [pros_icon] => icon icon-check-1
    [cons_icon] => icon icon-ban-3
    [pros_icon_color] => #00bf08
    [cons_icon_color] => #bf000a
*/
$inlineStyle = "";
$options = get_option( 'i2_pros_and_cons', i2_pros_and_cons_options_default());

    $useBorder = $options['use_border'] != null ? $options['use_border'] : '';
    $borderColor = $options['border_color'] != null ? $options['border_color'] : '';
    $borderSize = $options['border_size'] != null ? $options['border_size'] : '';
    $useBorderShadow = $options['use_border_shadow'] != null ? $options['use_border_shadow'] : '';

    $headingCenter = $options['heading_center'] != null ? $options['heading_center'] : '';
    $headingFontSize = $options['heading_font_size'] != null ? $options['heading_font_size'] : '';
    $headingColor = $options['heading_color'] != null ? $options['heading_color'] : '';
    $prosHeadingBackground = $options['pros_heading_background'] != null ? $options['pros_heading_background'] : '';
    $consHeadingBackground = $options['cons_heading_background'] != null ? $options['cons_heading_background'] : '';

    $textUnderline = $options['text_underline'] != null ? $options['text_underline'] : '';
    $sectionFontSize = $options['body_font_size'] != null ? $options['body_font_size'] : '';
    $sectionColor = $options['body_color'] != null ? $options['body_color'] : '';
    $prosBackground = $options['pros_background'] != null ? $options['pros_background'] : '';
    $consBackground = $options['cons_background'] != null ? $options['cons_background'] : '';

    $useIcon = $options['use_icons'] != null ? $options['use_icons'] : '';
    $iconTop = $options['icon_top'] != null ? $options['icon_top'] : '';
    // $prosIcon = $options['pros_icon'] != null ? $options['pros_icon'] : '';
    // $consIcon = $options['cons_icon'] != null ? $options['cons_icon'] : '';
    $prosIconColor = $options['pros_icon_color'] != null ? $options['pros_icon_color'] : '';
    $consIconColor = $options['cons_icon_color'] != null ? $options['cons_icon_color'] : '';



    if($useBorder == 1){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons,.i2-pros-cons-wrapper .i2-pros{border: {$borderSize}px solid {$borderColor};}";
    }

    if($useBorderShadow == 1){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros::before, .i2-pros-cons-wrapper .i2-cons::before {content: '';position: absolute;width: 100%;bottom: 0px;z-index: -1;-webkit-box-shadow: -30px 6px 15px 1px rgba(212, 212, 212, 0.55);box-shadow: -30px 6px 15px 1px rgba(212, 212, 212, 0.55); }";
        $inlineStyle .= "  .i2-pros-cons-wrapper .i2-pros-title::before, .i2-pros-cons-wrapper .i2-cons-title::before {content: '';position: absolute;top: 40px;bottom: 0px;width: 1px;left: 0;z-index: -1;background-color: transparent; -webkit-box-shadow: -4px 3px 10px 0px #d4d4d4;box-shadow: -4px 3px 10px 0px #d4d4d4; }";
    }


    if($headingCenter == 1)
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons-title,.i2-pros-cons-wrapper .i2-pros-title{text-align: center!important;}";

    if($headingFontSize != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons-title,.i2-pros-cons-wrapper .i2-pros-title{font-size: {$headingFontSize}px!important;}";

    if($headingColor != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons-title,.i2-pros-cons-wrapper .i2-pros-title{color: {$headingColor}!important;}";

    if($prosHeadingBackground != '')
    $inlineStyle .=  ".i2-pros-cons-wrapper .i2-pros-title {background-color: {$prosHeadingBackground} !important;}";

    if($consHeadingBackground != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons-title{background-color: {$consHeadingBackground}!important;}";



    if($textUnderline == 1)
    $inlineStyle .= " .i2-pros-cons-wrapper .section ul li{text-decoration: underline!important;}";

    if($sectionFontSize != '')
    $inlineStyle .= " .i2-pros-cons-wrapper ul li {font-size: {$sectionFontSize}px!important; line-height : "  . $sectionFontSize * 1.3 . "px;}";

    if($sectionColor != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros,.i2-pros-cons-wrapper .i2-cons {color: {$sectionColor}!important;}";

    if ($prosBackground != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros{background-color: {$prosBackground}!important;}";

    if($consBackground != '')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons{background-color: {$consBackground}!important;}";
   



   if($prosIcon != '' && $prosIcon != '0')
   $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros li{background-image: url('{$imgUrl}y{$prosIcon}.png')!important;}";

    if($consIcon != '' && $consIcon != '0')
    $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons li{background-image: url('{$imgUrl}n{$consIcon}.png')!important;}";
    
    if($prosIcon == '0'){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros li{background-image: none!important; padding-left: 15px !important;}";  
    }
    if($consIcon == '0'){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons li{background-image: none!important;padding-left: 15px !important;}";  
    }

    if($iconTop != ''){
        $inlineStyle .= " .i2-pros-cons-wrapper .section ul li i{top: {$iconTop}px!important;}";  
    }
    if($prosIconColor != ''){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-pros  ul li i{color: {$prosIconColor}!important;}";  
    }
    if($consIconColor != ''){
        $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons ul li i{color: {$consIconColor}!important;}";  
    }
    
    // if($consIconTop != ''){
    //     $inlineStyle .= " .i2-pros-cons-wrapper .i2-cons li{background-position-y: none!important;padding-left: 15px !important;}";  
    // }


    // if($useBorder != '' && $useBorder == 'yes'){
    //     $inlineStyle .= ".i2-pros-cons-wrapper .i2-pros .section, .i2-pros-cons-wrapper .i2-cons .section {-webkit-box-shadow: -4px 3px 10px 0px rgba(212,212,212,1);-moz-box-shadow: -4px 3px 10px 0px rgba(212,212,212,1);box-shadow: -4px 3px 10px 0px rgba(212,212,212,1);}";
    //     add_action( 'enqueue_block_assets', 'i2_pros_cons_matchHeight_script' );
    // }


if(!function_exists('i2_pros_cons_custom_style')) {
    function i2_pros_cons_custom_style()
    {
        global $inlineStyle;
         wp_add_inline_style( 'i2-pros-cons-block-style-css', $inlineStyle );
     }
    } 

    if(!function_exists('i2_pros_cons_admin_custom_style')) {
        function i2_pros_cons_admin_custom_style()
        {
            global $inlineStyle;
             wp_add_inline_style( 'i2_pro_cons_editor_style', $inlineStyle );
         }
        } 

   add_action( 'wp_enqueue_scripts', 'i2_pros_cons_custom_style' );
   add_action( 'admin_enqueue_scripts', 'i2_pros_cons_admin_custom_style' );