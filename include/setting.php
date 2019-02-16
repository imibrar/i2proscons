<?php

function i2_pros_and_cons_options_default($theme = "default") {

    $options = array(
        'use_theme' => 'default',
        'use_border' => 0,
        'border_color' => '#d4d4d4',
        'border_size' => 1,
        'use_border_shadow' => 0,
        'heading_center' => 0,
        'heading_font_size' => '',
        'heading_color' => '#ffffff',
        'text_underline' => 0,
        'pros_heading_background' => '#00bf08',
        'cons_heading_background' => '#bf000a',
        'body_font_size' => '',
        'body_color' => '',
        'pros_background' => '',
        'cons_background' => '',
        'use_icons' => 1,
        'icon_top' => 8,
        'pros_icon' => 'icon icon-thumbs-o-up',
        'cons_icon' => 'icon icon-thumbs-o-down',
        'pros_icon_color' => '#00bf08',
        'cons_icon_color' => '#bf000a'
      );
       $options['use_theme'] = $theme; 


       switch ($theme) {
            case 'shadow':
                $options['use_border_shadow'] = 1; 
                break;
            case 'bordered':
                $options['use_border'] = 1; 
                break;
            case 'background':
                $options['pros_background'] = '#e9f5e9'; 
                $options['cons_background'] = '#f9dcdd'; 
                break;
            case 'underline':
                $options['heading_center'] = 1; 
                $options['use_border'] = 1; 
                $options['text_underline'] = 1; 
                break;            
    }
        
    return $options;

  }


class i2ProsAndConsSettingsPage
{
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'i2_pros_and_cons_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'i2_pros_and_cons_page_init' ) );
        add_action( 'admin_enqueue_scripts',array( $this, 'i2_pros_and_cons_add_color_picker') );
        $this->options = get_option( 'i2_pros_and_cons', i2_pros_and_cons_options_default());
    }


    public function i2_pros_and_cons_add_color_picker() {
     
        if( is_admin() ) {             
            wp_enqueue_style( 'wp-color-picker' );  
            wp_enqueue_style('i2-pros-and-cons-fa-icons-style', plugins_url('../dist/fa-icons/css/fontawesome-iconpicker.css', __FILE__));
            wp_enqueue_style('i2-pros-and-cons-custom-fonts-icons-style', plugins_url('../dist/fonts/styles.css', __FILE__));
            
            wp_enqueue_script( 'i2-pros-and-cons-custom-js', plugins_url( '../dist/js/scripts.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  );
            wp_enqueue_script( 'i2-pros-and-cons-fa-icons-js', plugins_url( '../dist/fa-icons/js/fontawesome-iconpicker.js', __FILE__ ), array( 'jquery'), '', true  );
        }
    }

    /**
     * Add options page
     */
    public function i2_pros_and_cons_add_plugin_page()
    {
        add_menu_page(
            __('i2 Pros & Cons Setting', 'i2-pros-and-cons'),
            __('i2 Pros & Cons', 'i2-pros-and-cons'),
                'manage_options',
                'i2_pros_and_cons',
                array( $this, 'i2_pros_and_cons_settings_page' ),
                'dashicons-feedback',
                83
            );
    }

    /**
     * Options page callback
     */
    public function i2_pros_and_cons_settings_page()
    {
        // Set class property
     //  $this->options = get_option( 'i2_pros_and_cons', $this->i2_pros_and_cons_options_default());
        // echo '<pre>'; 
        // print_r($this->options);
        // print_r($this->i2_pros_and_cons_options_default());
        // echo '</pre>';
        ?>
        <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <?php settings_errors(); ?>
            <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'global'; ?>    
            <h2 class="nav-tab-wrapper">            
    <a href="?page=i2_pros_and_cons&tab=global" class="nav-tab <?php echo $active_tab == 'global' ? 'nav-tab-active' : ''; ?>"><?php _e('Global','i2-pros-cons') ?></a>
    <a href="?page=i2_pros_and_cons&tab=heading" class="nav-tab <?php echo $active_tab == 'heading' ? 'nav-tab-active' : ''; ?>"><?php _e('Heading','i2-pros-cons') ?></a>
    <a href="?page=i2_pros_and_cons&tab=section" class="nav-tab <?php echo $active_tab == 'section' ? 'nav-tab-active' : ''; ?>"><?php _e('Section','i2-pros-cons') ?></a>
    <a href="?page=i2_pros_and_cons&tab=icons" class="nav-tab <?php echo $active_tab == 'icons' ? 'nav-tab-active' : ''; ?>"><?php _e('Icons','i2-pros-cons') ?></a>
        </h2>
            <form method="post" action="options.php" autocomplete="off">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'i2_pros_and_cons' );

          // output setting sections based on tab selections
           if( $active_tab == 'global' ) {
                    do_settings_sections( 'i2_pros_and_cons_default' );
            } else if( $active_tab == 'heading' ){
                do_settings_sections( 'i2_pros_and_cons_heading' );
            } else if( $active_tab == 'section' ){
                do_settings_sections( 'i2_pros_and_cons_body' );
            }else{
                do_settings_sections( 'i2_pros_and_cons_icons' );
            }

                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function i2_pros_and_cons_page_init()
    {        
      $var =  register_setting(
            'i2_pros_and_cons', // Option group
            'i2_pros_and_cons', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'i2_pros_and_cons_section_default', // ID
            'Global Settings', // Title
            array( $this, 'section_info' ), // Callback
            'i2_pros_and_cons_default' // Page
        );       


        add_settings_section(
            'i2_pros_and_cons_section_heading', // ID
            'Headding Setting', // Title
            array( $this, 'section_info' ), // Callback
            'i2_pros_and_cons_heading' // Page
        );  
     
        add_settings_section(
            'i2_pros_and_cons_section_body', // ID
            'Section Setting', // Title
            array( $this, 'section_info' ), // Callback
            'i2_pros_and_cons_body' // Page
        );  
        add_settings_section(
            'i2_pros_and_cons_section_icons', // ID
            'Icons Setting', // Title
            array( $this, 'section_info' ), // Callback
            'i2_pros_and_cons_icons' // Page
        ); 

       // global fields 

       add_settings_field(
        'use_theme', 
        __('Theme', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_select_field' ), 
        'i2_pros_and_cons_default', 
        'i2_pros_and_cons_section_default',
        [ 'id' => 'use_theme']
             ); 

       add_settings_field(
        'use_border', 
        __('User Border', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_checkbox_field' ), 
        'i2_pros_and_cons_default', 
        'i2_pros_and_cons_section_default',
        [ 'id' => 'use_border']
             );  

             add_settings_field(
                'border_size', 
                __('Border Size', 'i2-pros-and-cons'), 
                array( $this, 'i2_pros_and_cons_callback_text_field' ), 
                'i2_pros_and_cons_default', 
                'i2_pros_and_cons_section_default',
                [ 'id' => 'border_size', 'size' => 4, 'helptext' => 'px', 'type' => 'number' ]
            );  
        add_settings_field(
            'border_color', 
            __('Border Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_default', 
            'i2_pros_and_cons_section_default',
            [ 'id' => 'border_color', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );               
             add_settings_field(
                'use_border_shadow', 
                __('Separate with Border Shadow', 'i2-pros-and-cons'), 
                array( $this, 'i2_pros_and_cons_callback_checkbox_field' ), 
                'i2_pros_and_cons_default', 
                'i2_pros_and_cons_section_default',
                [ 'id' => 'use_border_shadow']
                     );               
    // end global fields

       // heading fields 
       add_settings_field(
        'heading_center', 
        __('Align Heading Text in center', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_checkbox_field' ), 
        'i2_pros_and_cons_heading', 
        'i2_pros_and_cons_section_heading',
        [ 'id' => 'heading_center']
    );  
        add_settings_field(
                'heading_font_size', 
                __('Font Size', 'i2-pros-and-cons'), 
                array( $this, 'i2_pros_and_cons_callback_text_field' ), 
                'i2_pros_and_cons_heading', 
                'i2_pros_and_cons_section_heading',
                [ 'id' => 'heading_font_size', 'size' => 4, 'helptext' => 'px', 'type' => 'number' ]
            );  
        add_settings_field(
            'heading_color', 
            __('Text Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_heading', 
            'i2_pros_and_cons_section_heading',
            [ 'id' => 'heading_color', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  
        add_settings_field(
            'pros_heading_background', 
            __('Pros Background Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_heading', 
            'i2_pros_and_cons_section_heading',
            [ 'id' => 'pros_heading_background', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  
        add_settings_field(
            'cons_heading_background', 
            __('Cons Background Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_heading', 
            'i2_pros_and_cons_section_heading',
            [ 'id' => 'cons_heading_background', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  

       // end heading fields

     // body fields  
        add_settings_field(
                'body_font_size', 
                __('Font Size', 'i2-pros-and-cons'), 
                array( $this, 'i2_pros_and_cons_callback_text_field' ), 
                'i2_pros_and_cons_body', 
                'i2_pros_and_cons_section_body',
                [ 'id' => 'body_font_size', 'size' => 4, 'helptext' => 'px', 'type' => 'number' ]
            );  
        add_settings_field(
            'body_color', 
            __('Text Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_body', 
            'i2_pros_and_cons_section_body',
            [ 'id' => 'body_color', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  
        add_settings_field(
            'pros_background', 
            __('Pros Background Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_body', 
            'i2_pros_and_cons_section_body',
            [ 'id' => 'pros_background', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  
        add_settings_field(
            'cons_background', 
            __('Cons Background Color', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_text_field' ), 
            'i2_pros_and_cons_body', 
            'i2_pros_and_cons_section_body',
            [ 'id' => 'cons_background', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
        );  
        add_settings_field(
            'text_underline', 
            __('Text Underline', 'i2-pros-and-cons'), 
            array( $this, 'i2_pros_and_cons_callback_checkbox_field' ), 
            'i2_pros_and_cons_body', 
            'i2_pros_and_cons_section_body',
            [ 'id' => 'text_underline']
                 );  

       // end body fields
     // icons fields 
     add_settings_field(
        'use_icons', 
        __('Use Icons', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_checkbox_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'use_icons']
             );  
     add_settings_field(
        'icon_top', 
        __('Icons Start Position', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_text_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'icon_top', 'size' => 4, 'helptext' => 'px (from top to bottom)', 'type' => 'number' ]
    );  

    add_settings_field(
        'pros_icon', 
        __('Pros Icon', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_font_icon_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'pros_icon', 'myclass' => 'i2-pros-cons-icons', 'type' => 'text' ]
    ); 
    add_settings_field(
        'pros_icon_color', 
        __('Pros Icon Color', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_text_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'pros_icon_color', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
    );  
    add_settings_field(
        'cons_icon', 
        __('Cons Icon', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_font_icon_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'cons_icon', 'myclass' => 'i2-pros-cons-icons', 'type' => 'text' ]
    ); 
    add_settings_field(
        'cons_icon_color', 
        __('Cons Icon Color', 'i2-pros-and-cons'), 
        array( $this, 'i2_pros_and_cons_callback_text_field' ), 
        'i2_pros_and_cons_icons', 
        'i2_pros_and_cons_section_icons',
        [ 'id' => 'cons_icon_color', 'myclass' => 'i2-pros-cons-color-picker', 'type' => 'text' ]
    );  

     //end icons fields
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $selectedTheme =   isset( $input['use_theme'] ) ? $input['use_theme'] :  $this->options['use_theme'];
        if($selectedTheme != $this->options['use_theme']){
          return i2_pros_and_cons_options_default($selectedTheme);
        }
        $new_input = array_merge($this->options, array_filter($input));

        $new_input['use_theme'] = 'custom';
        if( isset($input['use_theme'])){
          $new_input['use_border'] = isset( $input['use_border'] ) ?   $input['use_border']  : 0;
          $new_input['use_border_shadow'] = isset( $input['use_border_shadow'] ) ?   $input['use_border_shadow']  : 0;
        }
        if( isset($input['cons_icon_color'])){
            $new_input['use_icons'] = isset( $input['use_icons'] ) ?   $input['use_icons']  : 0;
          }
         if(isset($input['body_font_size'])){
            $new_input['body_font_size'] =   $input['body_font_size'];
         }
         if(isset($input['heading_font_size'])){
            $new_input['heading_font_size'] =   $input['heading_font_size'];
            $new_input['heading_center'] = isset( $input['heading_center'] ) ?   $input['heading_center']  : 0;
         }
         if(isset($input['body_color'])){
            $new_input['text_underline'] =   isset( $input['text_underline'] ) ?   $input['text_underline']  : 0;
         }

        // echo '<pre>'; 
        //  print_r($input); 
        //  print_r($new_input); 
        //  echo '</pre>';
        //  exit();         

            return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Print the Section info
     */
    public function section_info()
    {
        print 'Choose your settings below:';
    }


   //callback: text field
    function i2_pros_and_cons_callback_text_field( $args ) {

        $id    = isset( $args['id'] )    ? $args['id']    : '';
        $class = isset( $args['myclass'] ) ? $args['myclass'] : '';       
        $size = isset( $args['size'] ) ? $args['size'] : '40';       
        $helptext = isset( $args['helptext'] ) ? $args['helptext'] : ''; 
        $type = isset( $args['type'] ) ? $args['type'] : 'text'; 
        $value = isset( $this->options[$id] ) ? sanitize_text_field( $this->options[$id] ) : '';

        echo '<input id="i2_pros_and_cons_'. $id .'" name="i2_pros_and_cons['. $id .']" class="'. $class .'" type="'. $type .'" size="'. $size.'" value="'. $value .'" /> ' . $helptext;        
    }
    function i2_pros_and_cons_callback_font_icon_field( $args ) {

        $id    = isset( $args['id'] )    ? $args['id']    : '';
        $class = isset( $args['myclass'] ) ? $args['myclass'] : '';       
        $size = isset( $args['size'] ) ? $args['size'] : '40';       
        $helptext = isset( $args['helptext'] ) ? $args['helptext'] : ''; 
        $value = isset( $this->options[$id] ) ? sanitize_text_field( $this->options[$id] ) : '';
        echo '<div class="form-group"><div class="input-group">';
        echo '<input data-placement="bottomLeft" id="i2_pros_and_cons_'. $id .'" name="i2_pros_and_cons['. $id .']" class="'. $class .'" type="text" size="'. $size.'" value="'. $value .'" /> ' . $helptext;        
        echo ' <span class="input-group-addon"></span></div></div>';
    }
    // callback: checkbox field
        function i2_pros_and_cons_callback_checkbox_field( $args ) {

            $id    = isset( $args['id'] )    ? $args['id']    : '';            
            $checked = isset( $this->options[$id] ) ? checked( $this->options[$id] , 1, false ) : '';
            
            echo '<input id="i2_pros_and_cons_'. $id .'" name="i2_pros_and_cons['. $id .']" type="checkbox" value="1"'. $checked .'/>';
            
        }

// callback: select field
function i2_pros_and_cons_callback_select_field( $args ) {
	
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	
	$selected_option = isset( $this->options[$id] ) ? sanitize_text_field( $this->options[$id] ) : 'default';
	
	$select_options = $this->i2_pros_and_cons_theme_select();
	
	echo '<select id="i2_pros_and_cons_'. $id .'" name="i2_pros_and_cons['. $id .']">';
	
	foreach ( $select_options as $value => $option ) {
		
		$selected = selected( $selected_option === $value, true, false );
		
		echo '<option value="'. $value .'"'. $selected .'>'. $option .'</option>';
		
	}
	
	echo '</select>';
	
}

        function i2_pros_and_cons_theme_select() {
	
            return array(
                
                'default'   => esc_html__('Default',   'i2-pros-and-cons'),
                'shadow'      => esc_html__('Shadow',      'i2-pros-and-cons'),
                'background'     => esc_html__('Background',     'i2-pros-and-cons'),
                'bordered'      => esc_html__('Bordered',      'i2-pros-and-cons'),
                'underline'      => esc_html__('Underline',      'i2-pros-and-cons'),
                'custom'   => esc_html__('Custom',   'i2-pros-and-cons')                
            );
            
        }


}

if( is_admin() )
    $i2_pros_and_cons_setting_page = new i2ProsAndConsSettingsPage();