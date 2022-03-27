<?php

/* --------------------------------------------------------------------------
 * Get theme options
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_option' ) ):
	function zante_get_option( $option ) {

		global $zante_settings;

		if ( empty( $zante_settings ) ) {
			$zante_settings = get_option( 'zante_settings' );
		}

		if ( isset( $zante_settings[$option] ) ) {
			return is_array( $zante_settings[$option] ) && isset( $zante_settings[$option]['url'] ) ? $zante_settings[$option]['url'] : $zante_settings[$option];
		} else {
			return false;
		}

	}
endif;

/* --------------------------------------------------------------------------
 * Define content width
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !isset( $content_width ) ) {

	$GLOBALS['content_width'] = apply_filters( 'zante_content_width', 870 );
}

/* --------------------------------------------------------------------------
 * Translate options
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_translate_options' ) ):
	function zante_get_translate_options() {
		global $zante_translate;
		get_template_part( 'core/translate' );
		$translate = apply_filters( 'zante_modify_translate_options', $zante_translate );
		return $translate;
	}
endif;

/* --------------------------------------------------------------------------
 * Translate
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_tr' ) ):
	function zante_tr( $string_key ) {
		if ( ( $translated_string = zante_get_option( 'tr_'.$string_key ) ) && zante_get_option( 'translation_type' ) == 'builtin' ) {

			if ( $translated_string == '-1' ) {
				return '';
			}
			return wp_kses_post( $translated_string );
		} else {
			$translate = zante_get_translate_options();
			return wp_kses_post( $translate[$string_key]['text'] );
		}
	}
endif;

/* --------------------------------------------------------------------------
 * Generate dynamic CSS
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_generate_css' ) ):
	function zante_generate_css() {
		ob_start();
		get_template_part( 'assets/css/dynamic-css' );

		// Dynamic CSS (Theme Options)
		$dynamic_css = ob_get_contents();
		ob_end_clean();

		// Custom CSS (Additional CSS)
		$additional_css = zante_get_option( 'additional_css' );
		return zante_compress_css_code( $dynamic_css.' '.$additional_css );
	}
endif;

/* --------------------------------------------------------------------------
 * Compress dynamic CSS
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_compress_css_code' ) ) :
	function zante_compress_css_code( $code ) {

		// Remove Comments
		$code = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code );

		// Remove tabs, spaces, newlines, etc.
		$code = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $code );

		return $code;
	}
endif;

/*-----------------------------------------------------------------------------------
* Outputs additional JavaScript code from theme options
* @since  1.0.0
* @modified 1.3.4
-----------------------------------------------------------------------------------*/
add_action( 'wp_footer', 'zante_wp_footer', 10 );

if ( !function_exists( 'zante_wp_footer' ) ):
	function zante_wp_footer() {

		//Additional JS
		$additional_js = trim( preg_replace( '/\s+/', ' ', zante_get_option( 'additional_js' ) ) );
		if ( !empty( $additional_js ) ) {
			echo '<script type="text/javascript">
				/* <![CDATA[ */

				(function($){

					'.$additional_js.'

				})(jQuery);


				/* ]]> */
				</script>';
		}

	}
endif;

/* --------------------------------------------------------------------------
 * Image Sizes
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_image_sizes' ) ):
	function zante_get_image_sizes() {

		$sizes = array(
			'zante_image_size_480_480' => array( 'title' => esc_html__('480 x 480', 'zante'), 'w' => 480, 'h' => 480, 'crop' => true),
			'zante_image_size_400_800' => array( 'title' => esc_html__('400 x 800', 'zante'), 'w' => 400, 'h' => 800, 'crop' => true),
			'zante_image_size_720_520' => array( 'title' => esc_html__('720 x 520', 'zante'), 'w' => 720, 'h' => 520, 'crop' => true),
			'zante_image_size_1170_650' => array( 'title' => esc_html__('1170 x 650', 'zante'), 'w' => 1170, 'h' => 650, 'crop' => true),
			'zante_image_size_1920_800' => array( 'title' => esc_html__('1920 x 800', 'zante'), 'w' => 1920, 'h' => 800, 'crop' => true),
		);

		$disable_img_sizes = zante_get_option( 'disable_img_sizes' );
		if(!empty( $disable_img_sizes )){
			$disable_img_sizes = array_keys( array_filter( $disable_img_sizes ) );
		}
		if(!empty($disable_img_sizes) ){
			foreach($disable_img_sizes as $size_id ){
				unset( $sizes[$size_id]);
			}
		}
		$sizes = apply_filters( 'zante_modify_image_sizes', $sizes );
		return $sizes;
	}
endif;

/* --------------------------------------------------------------------------
 * Get branding
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_branding' ) ):
	function zante_get_branding() {

		$logo = zante_get_option( 'logo' );
		$logo_light = zante_get_option( 'logo_light' );
		$trasnparent_page_header = get_post_meta( get_the_ID(), 'zante_mtb_page_header_transparent', true );

		if ( empty($logo_light) || ( $trasnparent_page_header == false )  ) {

			$logo_light = $logo;

		}

		$logo_height = zante_get_option( 'logo_height' );

		if (empty($logo)) {

			$output = '
			<a class="navbar-brand text" href="'.home_url('/').'">
				'.get_bloginfo().'
			</a>';


		} else {

		$output = '
		<a class="navbar-brand light" href="'.home_url('/').'">
			<img src="'.$logo_light.'" height="'.$logo_height.'" style="height: '.$logo_height.'px" alt="'.get_bloginfo( 'name' ).'">
		</a>
		<a class="navbar-brand dark nodisplay" href="'.home_url('/').'">
			<img src="'.$logo.'" height="'.$logo_height.'" style="height: '.$logo_height.'px" alt="'.get_bloginfo( 'name' ).'">
		</a> ';

		}

		echo wp_kses_post($output);

	}

endif;

/* --------------------------------------------------------------------------
 * Append menu text to main mobile menu
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if(!function_exists('zante_append_text_mobile_menu')):

    add_filter('wp_nav_menu_items','mobile_menu_text', 10, 2);

    function mobile_menu_text( $nav, $args ) {

      if ( $args->theme_location == 'zante_main_menu' ) {

        $newmenuitem = '<li class="mobile_menu_title" style="display:none;">'. zante_tr('mobile_menu_text') .'</li>';
        $nav = $newmenuitem.$nav;

         }

        return $nav;

    }

endif;

/* --------------------------------------------------------------------------
 * @ Get blog pages
 * @ since  1.0.0
 * @ modified 1.3.4
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'is_not_normal_page' ) ):
function is_not_normal_page () {
    return ( is_archive() || is_author() || is_category() || is_tag() || is_search() );
}
endif;

/* --------------------------------------------------------------------------
 * @ Get Header Class
 * @ since  1.0.0
 ---------------------------------------------------------------------------*/
 if ( !function_exists( 'zante_header_state' ) ):
 	function zante_header_state() {

		$page_transparent_header = get_post_meta(get_the_ID(), 'zante_mtb_page_header_transparent', true);
		$page_semi_transparent_header = get_post_meta(get_the_ID(), 'zante_mtb_page_header_semi_transparent', true);
		$page_fixed_header = get_post_meta(get_the_ID(), 'zante_mtb_page_header_sticky', true);

		// If is blog page
		if ( is_home() ) {
			$page_transparent_header = get_post_meta( get_option( 'page_for_posts' ), 'zante_mtb_page_header_transparent', true);
			$page_semi_transparent_header = get_post_meta( get_option( 'page_for_posts' ), 'zante_mtb_page_header_semi_transparent', true);
			$page_fixed_header = get_post_meta( get_option( 'page_for_posts' ), 'zante_mtb_page_header_sticky', true);
		}

		// If page is not normal page
		if ( is_not_normal_page() ) {
			$page_fixed_header = zante_get_option('header_sticky');
			$page_transparent_header = zante_get_option('header_transparent');
		}

		$header_class = '';

		if ( $page_fixed_header == true ) {
			$header_class .= 'fixed ';
		}
		if ( $page_transparent_header == true ) {
			$header_class .= 'transparent ';
		}
		if ( $page_semi_transparent_header == true ) {
			$header_class .= 'semi-transparent ';
		}

		echo esc_attr( $header_class );

}

endif;

/* --------------------------------------------------------------------------
 * @ Get Page Title
 * @ since  1.0.0
 ---------------------------------------------------------------------------*/
 if ( !function_exists( 'zante_page_title' ) ):

 	function zante_page_title() {

		$page_title = get_post_meta(get_the_ID(), 'zante_mtb_page_title', true);

		if ( is_not_normal_page() ) {
			$blog_post_page = get_option( 'page_for_posts' );
			$page_title = get_post_meta($blog_post_page, 'zante_mtb_page_title', true);
		}

		if ( $page_title == true || $page_title == '' && class_exists( 'Redux' ) ) {

			return true;

		} elseif ( is_search() ) {

			return true;
		} else {

			return false;
		}

	}

endif;

/* --------------------------------------------------------------------------
 * Generate Google fonts links
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_generate_fonts_link' ) ):
	function zante_generate_fonts_link() {

		$fonts = array();
		$fonts[] = zante_get_option( 'main_font' );
		$fonts[] = zante_get_option( 'h_font' );
		$fonts[] = zante_get_option( 'nav_font' );
		$unique = array(); //do not add same font links
		$native = zante_get_native_fonts();
		$protocol = is_ssl() ? 'https://' : 'http://';
		$link = array();

		foreach ( $fonts as $font ) {
			if ( !in_array( $font['font-family'], $native ) ) {
				$temp = array();
				if ( isset( $font['font-style'] ) ) {
					$temp['font-style'] = $font['font-style'];
				}
				if ( isset( $font['subsets'] ) ) {
					$temp['subsets'] = $font['subsets'];
				}
				if ( isset( $font['font-weight'] ) ) {
					$temp['font-weight'] = $font['font-weight'];
				}
				$unique[$font['font-family']][] = $temp;
			}
		}

		$subsets = array( 'latin' ); // latin as default

		foreach ( $unique as $family => $items ) {

			$link[$family] = $family;

			// Fonts weight to load
			$weight = array( '400', '500', '600', '700', '800', '900' );

			foreach ( $items as $item ) {

				//Check weight and style
				if ( isset( $item['font-weight'] ) && !empty( $item['font-weight'] ) ) {
					$temp = $item['font-weight'];
					if ( isset( $item['font-style'] ) && empty( $item['font-style'] ) ) {
						$temp .= $item['font-style'];
					}

					if ( !in_array( $temp, $weight ) ) {
						$weight[] = $temp;
					}
				}

				//Check subsets
				if ( isset( $item['subsets'] ) && !empty( $item['subsets'] ) ) {
					if ( !in_array( $item['subsets'], $subsets ) ) {
						$subsets[] = $item['subsets'];
					}
				}
			}

			$link[$family] .= ':'.implode( ",", $weight );
		}

		if ( !empty( $link ) ) {

			$query_args = array(
				'family' => urlencode( implode( '|', $link ) ),
				'subset' => urlencode( implode( ',', $subsets ) )
			);

			$fonts_url = add_query_arg( $query_args, $protocol.'fonts.googleapis.com/css' );

			return esc_url_raw( $fonts_url );
		}

		return '';

	}
endif;


/* --------------------------------------------------------------------------
 * Get native fonts
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_native_fonts' ) ):
	function zante_get_native_fonts() {

		$fonts = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma,Geneva, sans-serif",
			"'Times New Roman', Times,serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);

		return $fonts;
	}
endif;

/* --------------------------------------------------------------------------
 * Get font option
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_font_option' ) ):
	function zante_get_font_option( $option = false ) {

		$font = zante_get_option( $option );
		$native_fonts = zante_get_native_fonts();
		if ( !in_array( $font['font-family'], $native_fonts ) ) {
			$font['font-family'] = "'".$font['font-family']."'";
		}

		return $font;
	}
endif;


/* --------------------------------------------------------------------------
 * WP_Bootstrap_Navwalker
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( ! class_exists( 'WP_Bootstrap_Navwalker' ) ) {

	class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul role=\"menu\" class=\"dropdown-menu\" >\n";
		}

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			if ( 0 === strcasecmp( $item->attr_title, 'divider' ) && 1 === $depth ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} elseif ( 0 === strcasecmp( $item->title, 'divider' ) && 1 === $depth ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} elseif ( 0 === strcasecmp( $item->attr_title, 'dropdown-header' ) && 1 === $depth ) {
				$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
			} elseif ( 0 === strcasecmp( $item->attr_title, 'disabled' ) ) {
				$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
			} else {
				$class_names = $value = '';
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
				if ( $args->has_children ) {
					$class_names .= ' dropdown'; }
				if ( in_array( 'current-menu-item', $classes, true ) ) {
					$class_names .= ' active'; }
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
				$output .= $indent . '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $value . $class_names . '>';
				$atts = array();

				$atts['target'] = ! empty( $item->target )	? $item->target	: '';
				$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
				// If item has_children add atts to a.
				if ( $args->has_children && 0 === $depth ) {
					$atts['href']   		= '#';
					$atts['data-toggle']	= 'dropdown';
					$atts['class']			= 'dropdown-toggle';
					$atts['aria-haspopup']	= 'true';
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				}
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				$item_output = $args->before;

				if ( ! empty( $item->attr_title ) ) :
								$pos = strpos( esc_attr( $item->attr_title ), 'glyphicon' );
					if ( false !== $pos ) :
						$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>&nbsp;';
								else :
									$item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></i>&nbsp;';
											endif;
				else :
					$item_output .= '<a' . $attributes . '>';
				endif;
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="arrow mobile-dropdown-toggle"></span></a>' : '</a>';
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return; }
			$id_field = $this->db_fields['id'];
			// Display this element.
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		public static function fallback( $args ) {
			if ( current_user_can( 'edit_theme_options' ) ) {

				/* Get Arguments. */
				$container = $args['container'];
				$container_id = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class = $args['menu_class'];
				$menu_id = $args['menu_id'];

				if ( $container ) {
					echo '<' . esc_attr( $container );
					if ( $container_id ) {
						echo ' id="' . esc_attr( $container_id ) . '"';
					}
					if ( $container_class ) {
						echo ' class="' . sanitize_html_class( $container_class ) . '"'; }
					echo '>';
				}
				echo '<ul';
				if ( $menu_id ) {
					echo ' id="' . esc_attr( $menu_id ) . '"'; }
				if ( $menu_class ) {
					echo ' class="' . esc_attr( $menu_class ) . '"'; }
				echo '>';
				echo '<li><a href="' .esc_url( admin_url( 'nav-menus.php' ) ). '">' . esc_html__( 'Add a menu', 'zante' ) . '</a></li>';
				echo '</ul>';
				if ( $container ) {
					echo '</' . esc_attr( $container ) . '>'; }
			}
		}
	}
}


/* --------------------------------------------------------------------------
 * Limit character
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_trim_chars' ) ):
	function zante_trim_chars( $string, $limit, $more = '...' ) {
		if ( !empty( $limit ) ) {
			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $string ), ' ' );
			preg_match_all( '/./u', $text, $chars );
			$chars = $chars[0];
			$count = count( $chars );
			if ( $count > $limit ) {
				$chars = array_slice( $chars, 0, $limit );
				for ( $i = ( $limit -1 ); $i >= 0; $i-- ) {
					if ( in_array( $chars[$i], array( '.', ' ', '-', '?', '!' ) ) ) {
						break;
					}
				}
				$chars =  array_slice( $chars, 0, $i );
				$string = implode( '', $chars );
				$string = rtrim( $string, ".,-?!" );
				$string.= $more;
			}
		}
		return $string;
	}
endif;


/* --------------------------------------------------------------------------
 * Post excerpt limit
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_excerpt' ) ):
	function zante_get_excerpt( $limit = 250 ) {
		$manual_excerpt = false;
		if ( has_excerpt() ) {
			$content =  get_the_excerpt();
			$manual_excerpt = true;
		} else {
			$text = get_the_content( '' );
			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}
		if ( !empty( $content ) ) {
			if ( !empty( $limit ) || !$manual_excerpt ) {
				$more = zante_get_option( 'more_string' );
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = zante_trim_chars( $content, $limit, $more );
			}
			return wp_kses_post( wpautop( $content ) );
		}
		return '';
	}
endif;

/* --------------------------------------------------------------------------
* Share social media
* @since  1.0.0
---------------------------------------------------------------------------*/
if ( ! function_exists( 'zante_social_share' ) ) {
 function zante_social_share() {
	 global $post;
	 $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
	 ?>
		 <div class="social_media">
			 <span><i class="fa fa-share-alt"></i><?php echo zante_tr('share_text'); ?></span>
			 <a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo zante_tr('share_facebook'); ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo zante_tr('share_facebook'); ?>"><i class="fa fa-facebook"></i></a>
			 <a class="twitter" href="https://twitter.com/share?url=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo zante_tr('share_twitter'); ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo zante_tr('share_twitter'); ?>"><i class="fa fa-twitter"></i></a>
			 <a class="pinterest" href="https://pinterest.com/pin/create/button/?url=<?php esc_url( the_permalink() ); ?>" onclick="share_popup(this.href,'<?php echo zante_tr('share_pinterest'); ?>','700','400'); return false;" data-toggle="tooltip" data-original-title="<?php echo zante_tr('share_pinterest'); ?>"><i class="fa fa-pinterest"></i></a>
		 </div>

	 <?php
 }
}

/* --------------------------------------------------------------------------
 * Share PopUp
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'zante_share_popup', 79 );

if ( ! function_exists( 'zante_share_popup' ) ) {
function zante_share_popup(){
  ?>
  <script>
      function share_popup(url, title, w, h) {
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=no, menubar=no, resizable=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        if (window.focus) {
            newWindow.focus();
        }
    }
  </script>
  <?php
    }
}


/* --------------------------------------------------------------------------
 * Comments
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( ! function_exists( 'zante_custom_comments' ) ) {
function zante_custom_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class='comment-box'>
							<div class="comment-avatar">
									<?php
									$gravatar_alt = get_comment_author();
									echo get_avatar($comment,'80', '', $gravatar_alt); ?>
							</div>
                <div class="comment-header">
                    <?php
                    $author = get_comment_author();
                    $link = get_comment_author_url();
                    if(!empty($link))
                        $author = '<a rel="nofollow" href="'.$link.'" >'.$author.'</a>';
                    printf('<h4 class="author-name">%s</h4>', $author) ?>
                    <?php edit_comment_link(__(' <i class="fa fa-pencil" aria-hidden="true"></i>','zante'),'  ','') ?>

                     <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                 </div>
                <div class="comment-info">
                    <i class="fa fa-clock-o"></i>
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                        <span>
                            <?php printf( esc_html__('%1$s at %2$s','zante'), get_comment_date(),  get_comment_time()) ?>
                        </span>
                    </a>
                </div>
                <div class='comment-text'>
                <?php comment_text(); ?>
                <?php if ($comment->comment_approved == '0') : ?>
                <em class="info"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo zante_tr('comment_moderation') ?></em>
                <?php endif; ?>
                </div>
            </div>
    </div>
<?php
}
}

/* --------------------------------------------------------------------------
 * Rearrange comments form fields
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function zante_rearrange_comment_form_fields( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'zante_rearrange_comment_form_fields' );


/* --------------------------------------------------------------------------
 * Breadcrumb
 * @since  1.0.0
 * @modifieid 1.3.4
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_breadcrumb' ) ) {
    function zante_get_breadcrumb($options = array()) {

  // Check if is front/home page, return
  if ( is_front_page() ) {
    return;
  }

  // Define
  global $post;
  $custom_taxonomy  = ''; // If you have custom taxonomy place it here

  $defaults = array(
    'id'          =>  '',
    'classes'     =>  'breadcrumb',
    'home_title'  =>  __( 'Home', 'zante' )
  );

  // Start the breadcrumb with a link to your homepage
  echo '<ul id="'. esc_attr( $defaults['id'] ) .'" class="'. esc_attr( $defaults['classes'] ) .'">';

  // Creating home link
  echo '<li class="item"><a href="'. get_home_url() .'">'. esc_html( $defaults['home_title'] ) .'</a></li>';

  if ( is_single() ) {

    // Get posts type
    $post_type = get_post_type();

    // If post type is not post
    if( $post_type != 'post' ) {

      $post_type_object   = get_post_type_object( $post_type );
      $post_type_link     = get_post_type_archive_link( $post_type );

      echo '<li class="item item-cat"><a href="'. $post_type_link .'">'. $post_type_object->labels->name .'</a></li>';

    }

    // Get categories
    $category = get_the_category( $post->ID );

    // If category not empty
    if( !empty( $category ) ) {

      // Arrange category parent to child
      $category_values      = array_values( $category );
      $get_last_category    = end( $category_values );
      // $get_last_category    = $category[count($category) - 1];
      $get_parent_category  = rtrim( get_category_parents( $get_last_category->term_id, true, ',' ), ',' );
      $cat_parent           = explode( ',', $get_parent_category );

      // Store category in $display_category
      $display_category = '';
      foreach( $cat_parent as $p ) {
        $display_category .=  '<li class="item item-cat">'. $p .'</li>' . $sep;
      }

    }

    // If it's a custom post type within a custom taxonomy
    $taxonomy_exists = taxonomy_exists( $custom_taxonomy );

    if( empty( $get_last_category ) && !empty( $custom_taxonomy ) && $taxonomy_exists ) {

      $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
      $cat_id         = $taxonomy_terms[0]->term_id;
      $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
      $cat_name       = $taxonomy_terms[0]->name;

    }

    // Check if the post is in a category
    if( !empty( $get_last_category ) ) {

      echo $display_category;
      echo '<li class="item item-current">'. get_the_title() .'</li>';

    } else if( !empty( $cat_id ) ) {

      echo '<li class="item item-cat"><a href="'. $cat_link .'">'. $cat_name .'</a></li>' . $sep;
      echo '<li class="item-current item">'. get_the_title() .'</li>';

    } else {

      echo '<li class="item-current item">'. get_the_title() .'</li>';

    }

  } else if( is_archive() ) {

    if( is_tax() ) {
      // Get posts type
      $post_type = get_post_type();

      // If post type is not post
      if( $post_type != 'post' ) {

        $post_type_object   = get_post_type_object( $post_type );
        $post_type_link     = get_post_type_archive_link( $post_type );

        echo '<li class="item item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_link . '">' . $post_type_object->labels->name . '</a></li>' . $sep;

      }

      $custom_tax_name = get_queried_object()->name;
      echo '<li class="item item-current">'. $custom_tax_name .'</li>';

    } else if ( is_category() ) {

      $parent = get_queried_object()->category_parent;

      if ( $parent !== 0 ) {

        $parent_category = get_category( $parent );
        $category_link   = get_category_link( $parent );

        echo '<li class="item"><a href="'. esc_url( $category_link ) .'">'. $parent_category->name .'</a></li>' . $sep;

      }

      echo '<li class="item item-current">'. single_cat_title( '', false ) .'</li>';

    } else if ( is_tag() ) {

      // Get tag information
      $term_id        = get_query_var('tag_id');
      $taxonomy       = 'post_tag';
      $args           = 'include=' . $term_id;
      $terms          = get_terms( $taxonomy, $args );
      $get_term_name  = $terms[0]->name;

      // Display the tag name
      echo '<li class="item-current item">'. $get_term_name .'</li>';

    } else if ( is_author() ) {

      // Auhor archive

      // Get the author information
      global $author;
      $userdata = get_userdata( $author );

      // Display author name
      echo '<li class="item-current item">'. 'Author: '. $userdata->display_name . '</li>';

    } else {

      echo '<li class="item item-current">'. post_type_archive_title() .'</li>';

    }

  } else if ( is_page() ) {

    // Standard page
    if( $post->post_parent ) {

      // If child page, get parents
      $anc = get_post_ancestors( $post->ID );

      // Get parents in the right order
      $anc = array_reverse( $anc );

      // Parent page loop
      if ( !isset( $parents ) ) $parents = null;
      foreach ( $anc as $ancestor ) {

        $parents .= '<li class="item-parent item"><a href="'. get_permalink( $ancestor ) .'">'. get_the_title( $ancestor ) .'</a></li>';

      }

      // Display parent pages
      echo $parents;

      // Current page
      echo '<li class="item-current item">'. get_the_title() .'</li>';

    } else {

      // Just display current page if not parents
      echo '<li class="item-current item">'. get_the_title() .'</li>';

    }

  } else if ( is_home() ) {

    // Search results page
    echo '<li class="item-current item">'.__('Blog', 'zante').'</li>';

  } else if ( is_search() ) {

    // Search results page
    echo '<li class="item-current item">' .__('Search results for:', 'zante').' '. get_search_query().'</li>';

  } else if ( is_404() ) {

    // 404 page
    echo '<li class="item-current item">' .__('Error 404', 'zante'). '</li>';

  }

  // End breadcrumb
  echo '</ul>';


    }
}

/* --------------------------------------------------------------------------
 * Get JS options
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'zante_get_js_settings' ) ):
	function zante_get_js_settings() {
		$js_settings = array();

		// $js_settings['rtl_mode'] = zante_is_rtl() ? true : false;
		$js_settings['header_sticky'] = zante_get_option( 'header_sticky' ) ? true : false;
		$js_settings['smooth_scroll'] = zante_get_option( 'smooth_scroll' );

		return $js_settings;
	}
endif;

/* --------------------------------------------------------------------------
 * VC Set as theme
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
if( !function_exists('zante_vcSetAsTheme') ) {
	add_action('vc_before_init', 'zante_vcSetAsTheme');
	function zante_vcSetAsTheme()
	{
		vc_set_as_theme();
	}
}
