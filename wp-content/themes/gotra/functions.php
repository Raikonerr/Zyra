<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Overwrite parent theme background defaults and registers support for WordPress features.
add_action( 'after_setup_theme', 'lalita_background_setup' );
function lalita_background_setup() {
	add_theme_support( "custom-background",
		array(
			'default-color' 		 => '222222',
			'default-image'          => get_stylesheet_directory_uri().'/img/gotra-bg.gif',
			'default-repeat'         => 'repeat',
			'default-position-x'     => 'left',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-attachment'     => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		)
	);
}

// Overwrite theme URL
function lalita_theme_uri_link() {
	return 'https://wpkoi.com/gotra-wpkoi-wordpress-theme/';
}

// Overwrite parent theme's blog header function
add_action( 'lalita_after_header', 'lalita_blog_header_image', 11 );
function lalita_blog_header_image() {

	if ( ( is_front_page() && is_home() ) || ( is_home() ) ) { 
		$blog_header_image 			=  lalita_get_setting( 'blog_header_image' ); 
		$blog_header_title 			=  lalita_get_setting( 'blog_header_title' ); 
		$blog_header_text 			=  lalita_get_setting( 'blog_header_text' ); 
		$blog_header_button_text 	=  lalita_get_setting( 'blog_header_button_text' ); 
		$blog_header_button_url 	=  lalita_get_setting( 'blog_header_button_url' ); 
		if ( $blog_header_image != '' ) { ?>
		<div class="page-header-image grid-parent page-header-blog" style="background-image: url('<?php echo esc_url($blog_header_image); ?>') !important;">
        	<div class="page-header-noiseoverlay"></div>
        	<div class="page-header-blog-inner">
                <div class="page-header-blog-content-h grid-container">
                    <div class="page-header-blog-content">
                    <?php if ( $blog_header_title != '' ) { ?>
                        <div class="page-header-blog-text">
                            <?php if ( $blog_header_title != '' ) { ?>
                            <h2><?php echo wp_kses_post( $blog_header_title ); ?></h2>
                            <div class="clearfix"></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="page-header-blog-content page-header-blog-content-b">
                	<?php if ( $blog_header_text != '' ) { ?>
                	<div class="page-header-blog-text">
						<?php if ( $blog_header_title != '' ) { ?>
                        <p><?php echo wp_kses_post( $blog_header_text ); ?></p>
                        <div class="clearfix"></div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="page-header-blog-button">
                        <?php if ( $blog_header_button_text != '' ) { ?>
                        <a class="read-more button" href="<?php echo esc_url( $blog_header_button_url ); ?>"><?php echo esc_html( $blog_header_button_text ); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
		</div>
		<?php
		}
	}
}

// Extra cutomizer functions
if ( ! function_exists( 'gotra_customize_register' ) ) {
	add_action( 'customize_register', 'gotra_customize_register' );
	function gotra_customize_register( $wp_customize ) {
				
		// Add Gotra customizer section
		$wp_customize->add_section(
			'gotra_layout_effects',
			array(
				'title' => __( 'Gotra Effects', 'gotra' ),
				'priority' => 24,
			)
		);
		
		// Blog image noise
		$wp_customize->add_setting(
			'gotra_settings[img_effect]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'gotra_settings[img_effect]',
			array(
				'type' => 'select',
				'label' => __( 'Blog image noise', 'gotra' ),
				'choices' => array(
					'enable' => __( 'Enable', 'gotra' ),
					'disable' => __( 'Disable', 'gotra' )
				),
				'settings' => 'gotra_settings[img_effect]',
				'section' => 'gotra_layout_effects',
				'priority' => 10
			)
		);
		
		// Site title underline
		$wp_customize->add_setting(
			'gotra_settings[title_underline]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'gotra_settings[title_underline]',
			array(
				'type' => 'select',
				'label' => __( 'Site title underline', 'gotra' ),
				'choices' => array(
					'enable' => __( 'Enable', 'gotra' ),
					'disable' => __( 'Disable', 'gotra' )
				),
				'settings' => 'gotra_settings[title_underline]',
				'section' => 'gotra_layout_effects',
				'priority' => 20
			)
		);
		
		// Magic mouse
		$wp_customize->add_setting(
			'gotra_settings[magic_cursor]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'gotra_settings[magic_cursor]',
			array(
				'type' => 'select',
				'label' => __( 'Magic mouse', 'gotra' ),
				'choices' => array(
					'enable' => __( 'Enable', 'gotra' ),
					'disable' => __( 'Disable', 'gotra' )
				),
				'settings' => 'gotra_settings[magic_cursor]',
				'section' => 'gotra_layout_effects',
				'priority' => 30
			)
		);
		
		// Gotra effect colors
		$wp_customize->add_setting(
			'gotra_settings[gotra_color_1]', array(
				'default' => '#ffffff',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gotra_settings[gotra_color_1]',
				array(
					'label' => __( 'Mouse color', 'gotra' ),
					'section' => 'gotra_layout_effects',
					'settings' => 'gotra_settings[gotra_color_1]',
					'priority' => 35
				)
			)
		);
		
		$wp_customize->add_setting(
			'gotra_settings[gotra_color_2]', array(
				'default' => '#888888',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gotra_settings[gotra_color_2]',
				array(
					'label' => __( 'Mouse color 2', 'gotra' ),
					'section' => 'gotra_layout_effects',
					'settings' => 'gotra_settings[gotra_color_2]',
					'priority' => 36
				)
			)
		);
		
		// Gotra button
		$wp_customize->add_setting(
			'gotra_settings[gotra_button]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'gotra_settings[gotra_button]',
			array(
				'type' => 'select',
				'label' => __( 'Gotra button', 'gotra' ),
				'choices' => array(
					'enable' => __( 'Enable', 'gotra' ),
					'disable' => __( 'Disable', 'gotra' )
				),
				'settings' => 'gotra_settings[gotra_button]',
				'section' => 'gotra_layout_effects',
				'priority' => 40
			)
		);
		
		$wp_customize->add_setting(
			'gotra_settings[gotra_color_3]', array(
				'default' => '#eeeeee',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gotra_settings[gotra_color_3]',
				array(
					'label' => __( 'Button color 1', 'gotra' ),
					'section' => 'gotra_layout_effects',
					'settings' => 'gotra_settings[gotra_color_3]',
					'priority' => 45
				)
			)
		);
		
		$wp_customize->add_setting(
			'gotra_settings[gotra_color_4]', array(
				'default' => '#111111',
				'type' => 'option',
				'sanitize_callback' => 'gotra_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gotra_settings[gotra_color_4]',
				array(
					'label' => __( 'Button color 2', 'gotra' ),
					'section' => 'gotra_layout_effects',
					'settings' => 'gotra_settings[gotra_color_4]',
					'priority' => 46
				)
			)
		);
	}
}

//Sanitize choices.
if ( ! function_exists( 'gotra_sanitize_choices' ) ) {
	function gotra_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug
		$input = sanitize_key( $input );

		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it;
		// otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

// Sanitize colors. Allow blank value.
if ( ! function_exists( 'gotra_sanitize_hex_color' ) ) {
	function gotra_sanitize_hex_color( $color ) {
	    if ( '' === $color ) {
	        return '';
		}

	    // 3 or 6 hex digits, or the empty string.
	    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
	        return $color;
		}

	    return '';
	}
}

// Gotra effects colors css
if ( ! function_exists( 'gotra_effect_colors_css' ) ) {
	function gotra_effect_colors_css() {
		// Get Customizer settings
		$gotra_settings = get_option( 'gotra_settings' );
		
		$gotra_color_1  	 = '#ffffff';
		$gotra_color_2  	 = '#888888';
		$gotra_color_3  	 = '#eeeeee';
		$gotra_color_4  	 = '#111111';
		if ( isset( $gotra_settings['gotra_color_1'] ) ) {
			$gotra_color_1 = $gotra_settings['gotra_color_1'];
		}
		if ( isset( $gotra_settings['gotra_color_2'] ) ) {
			$gotra_color_2 = $gotra_settings['gotra_color_2'];
		}
		if ( isset( $gotra_settings['gotra_color_3'] ) ) {
			$gotra_color_3 = $gotra_settings['gotra_color_3'];
		}
		if ( isset( $gotra_settings['gotra_color_4'] ) ) {
			$gotra_color_4 = $gotra_settings['gotra_color_4'];
		}
		
		$lalita_settings = wp_parse_args(
			get_option( 'lalita_settings', array() ),
			lalita_get_color_defaults()
		);
		
		$gotra_extracolors = 'body #magicMouseCursor{background-color: ' . esc_attr( $gotra_color_1 ) . ';}body #magicPointer{background: ' . esc_attr( $gotra_color_2 ) . ';} .gotra-button .button,.gotra-button .button:visited,.gotra-button button:not(.menu-toggle),
html .gotra-button input[type="button"],.gotra-button input[type="reset"],.gotra-button input[type="submit"],.woocommerce.gotra-button a.button, .woocommerce.gotra-button button.button.alt {color: ' . esc_attr( $gotra_color_3 ) . ';}.gotra-button .button:hover,.gotra-button .button:visited:hover,.gotra-button button:not(.menu-toggle):hover,
html .gotra-button input[type="button"]:hover,.gotra-button input[type="reset"]:hover,.gotra-button input[type="submit"]:hover,.woocommerce.gotra-button a.button:hover, .woocommerce.gotra-button button.button.alt:hover {color: ' . esc_attr( $gotra_color_4 ) . ';border-color: ' . esc_attr( $gotra_color_3 ) . ';background-color: ' . esc_attr( $gotra_color_3 ) . '}';
		
		return $gotra_extracolors;
	}
}

// The dynamic styles of the parent theme added inline to the parent stylesheet.
// For the customizer functions it is better to enqueue after the child theme stylesheet.
if ( ! function_exists( 'gotra_remove_parent_dynamic_css' ) ) {
	add_action( 'init', 'gotra_remove_parent_dynamic_css' );
	function gotra_remove_parent_dynamic_css() {
		remove_action( 'wp_enqueue_scripts', 'lalita_enqueue_dynamic_css', 50 );
	}
}

// Enqueue this CSS after the child stylesheet, not after the parent stylesheet.
if ( ! function_exists( 'gotra_enqueue_parent_dynamic_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'gotra_enqueue_parent_dynamic_css', 50 );
	function gotra_enqueue_parent_dynamic_css() {
		$css = lalita_base_css() . lalita_font_css() . lalita_advanced_css() . lalita_spacing_css() . lalita_no_cache_dynamic_css() .gotra_effect_colors_css();

		// escaped secure before in parent theme
		wp_add_inline_style( 'lalita-child', $css );
	}
}

//Adds custom classes to the array of body classes.
if ( ! function_exists( 'gotra_body_classes' ) ) {
	add_filter( 'body_class', 'gotra_body_classes' );
	function gotra_body_classes( $classes ) {
		// Get Customizer settings
		$gotra_settings = get_option( 'gotra_settings' );
		
		$img_effect 	  = 'enable';
		$gotra_button  	  = 'enable';
		$title_underline  = 'enable';
		$magic_cursor     = 'enable';
		
		if ( isset( $gotra_settings['img_effect'] ) ) {
			$img_effect = $gotra_settings['img_effect'];
		}
		
		if ( isset( $gotra_settings['gotra_button'] ) ) {
			$gotra_button = $gotra_settings['gotra_button'];
		}
		
		if ( isset( $gotra_settings['title_underline'] ) ) {
			$title_underline = $gotra_settings['title_underline'];
		}
		
		if ( isset( $gotra_settings['magic_cursor'] ) ) {
			$magic_cursor = $gotra_settings['magic_cursor'];
		}
		
		// Blog image noise
		if ( $img_effect != 'disable' ) {
			$classes[] = 'gotra-img-effect';
		}
		
		// Gotra button
		if ( $gotra_button != 'disable' ) {
			$classes[] = 'gotra-button';
		}
		
		// Site title underline
		if ( $title_underline != 'disable' ) {
			$classes[] = 'gotra-title-underline';
		}
		
		// Magic mouse
		if ( $magic_cursor != 'disable' ) {
			$classes[] = 'gotra-magic-cursor';
		}
		
		return $classes;
	}
}

// Magic mouse
if ( ! function_exists( 'gotra_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'gotra_scripts' );
	/**
	 * Enqueue scripts and styles
	 */
	function gotra_scripts() {

		$dir_uri = get_stylesheet_directory_uri();
		// Get Customizer settings
		$gotra_settings = get_option( 'gotra_settings' );
		$magic_cursor  = 'enable';
		if ( isset( $gotra_settings['magic_cursor'] ) ) {
			$magic_cursor = $gotra_settings['magic_cursor'];
		}
		
		if ( $magic_cursor != 'disable' ) {
			wp_enqueue_style( 'gotra-magic-mouse', esc_url( $dir_uri ) . "/css/magic-mouse.min.css", false, LALITA_VERSION, 'all' );
			wp_enqueue_script( 'gotra-magic-mouse', esc_url( $dir_uri ) . "/js/magic-mouse.min.js", array( 'jquery'), LALITA_VERSION, true );
		}
	}
}

// Overwrite parent theme function for post images
add_action( 'lalita_after_entry_header', 'lalita_post_image' );
/**
 * Prints the Post Image to post excerpts
 */
function lalita_post_image() {
	// If there's no featured image, return.
	if ( ! has_post_thumbnail() ) {
		return;
	}
	
	$gotra_settings = get_option( 'gotra_settings' );
		
	$img_effect  = 'enable';
	if ( isset( $gotra_settings['img_effect'] ) ) {
		$img_effect = $gotra_settings['img_effect'];
	}

	// If we're not on any single post/page or the 404 template, we must be showing excerpts.
	if ( ! is_singular() && ! is_404() ) {
		echo '<div class="post-image"><a href="' . esc_url( get_permalink() ) . '">';
		if ( $img_effect != 'disable' ) {
			echo '<div class="gotra-img-effect-holder">';
		}
		echo get_the_post_thumbnail(
			get_the_ID(),
			apply_filters( 'lalita_pageheader_default_size', 'full' ),
			array(
				'itemprop' => 'image',
			)
		);
		if ( $img_effect != 'disable' ) {
			echo '<div class="gotra-img-effect-layer"></div></div>';
		}
		echo '</a>
			</div>';
	}
}