<?php
add_action('admin_menu', 'wbelnt_menu_page');
function wbelnt_menu_page(){
	global $submenu;
	add_menu_page(
		'News Ticker for Elementor',
		'News Ticker for Elementor',
		'manage_options',
		'wbel-news-ticker',
		'wbel_nt_callback',
		'dashicons-image-flip-horizontal',
		'59'
	);

	add_submenu_page(
		'wbel-news-ticker',
		'Custom CSS',
		'Custom CSS',
		'manage_options',
		'wbel-nt-custom-css',
		'wbel_nt_css_callback' 
	);

	add_submenu_page(
		'wbel-news-ticker',
		'Custom JS',
		'Custom JS',
		'manage_options',
		'wbel-nt-custom-js',
		'wbel_nt_js_callback' 
	);

	$link_text = '<span class="wbelnt-up-pro-link" style="font-weight: bold; color: #FCB214">Upgrade To Pro</span>';
			
	$submenu["wbel-news-ticker"][4] = array( $link_text, 'manage_options' , 'https://web-lodge.com/product/news-ticker-for-elementor/' );
	
	return $submenu;
}

function wbel_nt_callback(){}
function wbel_nt_css_callback(){
	 // The default message that will appear
    $custom_css_default = __( '/*
Welcome to the Custom CSS editor!

Please add all your custom CSS here and avoid modifying the core plugin files. Don\'t use <style> tag
*/');
	    $custom_css = get_option( 'wbelnt_custom_css', $custom_css_default );
?>
	    <div class="wrap">
	        <div id="icon-themes" class="icon32"></div>
	        <h2><?php _e( 'Custom CSS' ); ?></h2>
	        <?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Custom CSS updated.' ) . '</strong></p></div>'; ?>
	 
	        <form id="custom_css_form" method="post" action="options.php" style="margin-top: 15px;">
	 
	            <?php settings_fields( 'wbelnt_custom_css' ); ?>
	 
	            <div id="custom_css_container">
	                <div name="wbelnt_custom_css" id="wbelnt_custom_css" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div>
	            </div>
	 
	            <textarea id="custom_css_textarea" name="wbelnt_custom_css" style="display: none;"><?php echo $custom_css; ?></textarea>
	            <p><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
	        </form>
	    </div>
<?php
}

function wbel_nt_js_callback(){
	// The default message that will appear
    $custom_js_default = __( '/*
Welcome to the Custom JS editor!

Please add all your custom JS here and avoid modifying the core plugin files. Don\'t use <script> tag
*/');
	    $custom_css = get_option( 'wbelnt_custom_js', $custom_js_default );
?>
	    <div class="wrap">
	        <div id="icon-themes" class="icon32"></div>
	        <h2><?php _e( 'Custom JS' ); ?></h2>
	        <?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Custom JS updated.' ) . '</strong></p></div>'; ?>
	 
	        <form id="custom_js_form" method="post" action="#" onsubmit="return false;" style="margin-top: 15px;">
	 
	            <?php settings_fields( 'wbelnt_custom_js' ); ?>
	 
	            <div id="custom_css_container">
	                <div name="wbelnt_custom_js" id="wbelnt_custom_js" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div>
	            </div>
	 
	            <textarea id="custom_js_textarea" name="wbelnt_custom_js" style="display: none;"><?php echo $custom_css; ?></textarea>
	            <p><input type="submit" class="button-primary disabled" value="<?php _e( 'Save Changes' ) ?>" /><a href="https://web-lodge.com/product/news-ticker-for-elementor/" target="_blank" class="button" style="background: #FCB214; color: #fff;font-weight: 700; margin-left: 10px">Upgrade to Pro</a></p>
	        </form>
	    </div>
<?php
}

add_action( 'admin_enqueue_scripts', 'wbelnt_custom_css_js_scripts' );
function wbelnt_custom_css_js_scripts( $hook ) {

	wp_enqueue_script( 'wbelnt_admin_js', WB_NT_URL . 'admin/assets/js/admin.js', array( 'jquery' ), '1.0.0', true );

    if ( ('news-ticker-for-elementor_page_wbel-nt-custom-css' == $hook) || ('news-ticker-for-elementor_page_wbel-nt-custom-js' == $hook) ) {
        wp_enqueue_script( 'ace_code_highlighter_js', WB_NT_URL . 'assets/ace/js/ace.js', '', '1.0.0', true );
        wp_enqueue_script( 'ace_mode_css', WB_NT_URL . 'assets/ace/js/mode-css.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
        wp_enqueue_script( 'ace_mode_js', WB_NT_URL . 'assets/ace/js/mode-javascript.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
        wp_enqueue_script( 'custom_css_js', WB_NT_URL . 'assets/ace/ace-include.js', array( 'jquery', 'ace_code_highlighter_js' ), '1.0.0', true );
    }
}

add_action( 'admin_init', 'wbelnt_register_custom_css_setting' ); 
function wbelnt_register_custom_css_setting() {
    register_setting( 'wbelnt_custom_css', 'wbelnt_custom_css',  'wbelnt_custom_css_validation');
}

function wbelnt_custom_css_validation( $input ) {
    if ( ! empty( $input['wbelnt_custom_css'] ) )
        $input['wbelnt_custom_css'] = trim( $input['wbelnt_custom_css'] );
    return $input;
}


