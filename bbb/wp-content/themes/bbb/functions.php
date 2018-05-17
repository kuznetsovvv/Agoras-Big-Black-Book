<?php
/**
 * AgorasBBB functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AgorasBBB
 */

if ( ! function_exists( 'bbb_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bbb_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on AgorasBBB, use a find and replace
	 * to change 'bbb' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bbb', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'bbb' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bbb_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'bbb_setup' );

// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
    global $post;
	//return ' <a class="moretag" href="'. get_permalink($post->ID) . '">Read more...</a>';
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter( 'wp_mail_from', 'wpse_new_mail_from' );     
function wpse_new_mail_from( $old ) {
    return 'help@agorasbigblackbook.com'; // Edit it with your email address
}

add_filter('wp_mail_from_name', 'wpse_new_mail_from_name');
function wpse_new_mail_from_name( $old ) {
    return "Agora's Big Black Book"; // Edit it with your/company name
}
//redirect users to my login page
add_filter('login_url', 'your_login_url', 10, 2 );
//a few possibilities of login form actions  'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login' 
add_action('login_form_login', 'your_login_page');
add_action('login_form_register', 'your_register_page');
add_action('login_form_logout', 'your_login_page');
add_action('wp_login', 'your_login_redirect', 10, 2);
//add_action('lost_password', 'your_reset_page');                                             //UNCOMMENT THIS ONE ITS FOR DEBUG
// assuming that your new front end login url is "/login", use these:
function your_login_url($login_url, $redirect) {
    return home_url('/log-in/');
}
function your_login_page() {
    wp_redirect(home_url('/log-in/'), 302);
}
function your_register_page() {
    wp_redirect(home_url('/log-in/?action=register'), 302);
}
function your_reset_page() {
    wp_redirect(home_url('/log-in/?action=lostpassword'), 302);
}
//catch login redirects, pass along errors
add_filter('login_redirect', 'my_login_redirect', 10, 3);
function my_login_redirect($redirect_to, $requested_redirect_to, $user) {
    if (is_wp_error($user)) {
        //Login failed, find out why...
        $error_types = array_keys($user->errors);
        //Error type seems to be empty if none of the fields are filled out
        $error_type = 'both_empty';
        //Otherwise just get the first error (as far as I know there
        //will only ever be one)
        if (is_array($error_types) && !empty($error_types)) {
            $error_type = $error_types[0];
        }
        wp_redirect( home_url('/log-in/') . "?errr=" . $error_type ."&failed=1"); 
        exit;
    } else {
        //Login OK - redirect to another page?
        if  (current_user_can('activate_plugins')) {
            wp_redirect('/wp-admin/index.php', 302);
        }else{
            wp_redirect(home_url(''), 302);
        }
    }
}
// if admin send them to the dashboard, otherwise leave them on the frontend
function your_login_redirect($user_login, $user) {
    if  (current_user_can('activate_plugins')) {
        wp_redirect('/wp-admin/index.php', 302);
    }else{
        wp_redirect(home_url(''), 302);
    }
}

//Pass reset errors
add_action('lostpassword_post', 'validate_reset', 99, 3);
function validate_reset(){
    if(isset($_POST['user_login']) && !empty($_POST['user_login'])){
        $email_address = $_POST['user_login'];
        if(filter_var( $email_address, FILTER_VALIDATE_EMAIL )){
            if(!email_exists( $email_address )){
                wp_redirect( 'log-in/?errr=email_dne' );
                exit;
            }
        }else{
                $username = $_POST['user_login'];
                if ( !username_exists( $username ) ){
                wp_redirect( 'log-in/?errr=email_dne' );
                    exit;
                }
            } 

    }else{
        wp_redirect( 'log-in/?errr=form_empty' );
        exit;   
    }
}
//clean up html emails going out
add_filter( 'wp_mail', 'my_wp_mail_filter' );
function my_wp_mail_filter( $args ) {
	
	$new_wp_mail = array(
		'to'          => $args['to'],
		'subject'     => $args['subject'],
		'message'     => $args['message'],
		'headers'     => $args['headers'],
		'attachments' => $args['attachments'],
	);
	if((strpos($new_wp_mail['message'], '</table>') !== false) && (strpos($new_wp_mail['headers'], 'text/html') === false)){//check for '<table style="' and 'Content-type: text/html'...
        $new_wp_mail['headers'] = "Content-type: text/html".$new_wp_mail['headers'];
    }
	return $new_wp_mail;
}
//clean up password reset message
add_filter('retrieve_password_message','custom_retrieve_password_message',10,2);
function custom_retrieve_password_message($message, $key){
    $userstartpos = strpos($message, "&login=") + 7;
    $userendpos = strrpos($message, ">");
    $userloginforreset = substr($message, $userstartpos, $userendpos - $userstartpos);
    return '<html><table style="background:#cccccc; background-color:#cccccc;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer" style="font-family: Arial, Helvetica, sans-serif;">
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailHeader">
                                    <tr>
                                        <td align="center" valign="top"><br>&nbsp;<br>&nbsp;<br></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="background: #000000; background-color: #000000; color:#ffffff; font-family: Goudy Old Style, Garamond, Big Caslon, Times New Roman, serif;">
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailHeader">
                                    <tr>
                                        <td align="center" valign="top"><h1 style="font-family: Goudy Old Style, Garamond, Big Caslon, Times New Roman, serif;">'."Agora's Big Black Book".'</h1></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="background: #ffffff; background-color: #ffffff">
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailBody">
                                    <tr style="width: 420px;">
                                        <td align="center" valign="top">
                                        <h2 style="font-family: Arial, Helvetica, sans-serif;">Reset Your Password.</h2>
                                        <p style="font-family: Arial, Helvetica, sans-serif;">Click the link below<br>to set your new password.</p>
                                        <a width="422" href="'.network_site_url("log-in/?action=reset&key=$key&login=". $userloginforreset, 'login').'" bgcolor="#fe7030" width="420" style=" width: 420px; background:#fe7030; background-color:#fe7030; text-decoration:none; color:#ffffff; font-size: 20px; border: none;"><span bgcolor="#fe7030" style="background:#fe7030; background-color:#fe7030; padding: 0; margin: 0; font-family: Arial, Helvetica, sans-serif; text-decoration:none; display: block; width: 420px;"> &nbsp; Click to Reset Your Password &nbsp; </span></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <p>'."<small style='font-family: Arial, Helvetica, sans-serif;'>If you received this email by mistake, simply delete it. Nothing further will happen if you don't click the link above.".'</small></p>
                                            <p><small style="font-family: Arial, Helvetica, sans-serif;">For any questions, please contact <a href="mailto:help@agorasbigblackbook.com">help@agorasbigblackbook.com</a></small></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailHeader">
                                    <tr>
                                        <td align="center" valign="top"><br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table></html>
        ';
}//*/
// Returns only posts for Searches
function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}
add_filter('pre_get_posts','SearchFilter');

// only allow user registration in wordpress from specific domain, we'll modify this to whitelist only.
function wpcs_disable_email_domain ( $errors, $sanitized_user_login, $user_email ) {
    if((strlen($sanitized_user_login)<1)&&(strlen($user_email)<6)){
        $errors->add( 'both_fields_empty', __( 'You must input username and email to register', 'my_domain' ) );
    }    
    list( $email_user, $email_domain ) = explode( '@', $user_email );
    $allowedDomains = openlist("domains");
    if ( !in_array(strtoupper($email_domain), $allowedDomains ) ) {//if(!in_array($_SERVER['REMOTE_ADDR'], $allowed)){
        $emailWhitelist = openlist("emails");
        if ( !in_array( strtoupper($user_email), $emailWhitelist ) ) {
            $errors->add( 'not_whitelisted', __( 'Email and domain not found in whitelist, please contact us directly to receive an account.', 'my_domain' ) );
        }
    }
    if (is_wp_error($errors)) {
        //Login failed, find out why...
        $error_types = array_keys($errors->errors);
        //Error type seems to be empty if none of the fields are filled out
        $error_type = "";
        //Otherwise just get the first error (as far as I know there
        //will only ever be one)
        if (is_array($error_types) && !empty($error_types)) {
            $error_type =  $error_type."/n".$error_types[count($error_types) -1];
        }
        wp_redirect( home_url('/log-in/') . "?action=register&errr=" . str_replace(" ", "_",$error_type)."&failed=1" ); 
        return $errors;   
    }
    return $errors;
}
add_filter( 'registration_errors', 'wpcs_disable_email_domain', 10, 3 );
//Function to get lists for above operations
function openlist($name){
    if (($handle = fopen(ABSPATH."/htnoaccess/".$name.".csv", "r")) !== FALSE) {
        $outArray = [];
        while (($data = fgetcsv($handle, 420000, ",")) !== FALSE) {
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
                array_push($outArray, strtoupper($data[$c]));
            }
        }
        fclose($handle);
        return($outArray);
    }
    return false;
}
//PASS NEW PASSWORD ERRORS
function new_pass_errs ( $errors, $user ) {
    if (is_wp_error($errors)) {
        //Login failed, find out why...
        $error_types = array_keys($errors->errors);
        //Error type seems to be empty if none of the fields are filled out
        $error_type = "";
        //Otherwise just get the first error (as far as I know there
        //will only ever be one)
        if (is_array($error_types) && !empty($error_types)) {
            $error_type =  $error_type."/n".$error_types[count($error_types) -1];
        }
        if (!empty($error_type) && strlen($errortype) > 1) {
            wp_redirect( home_url('/log-in/') . "?action=reset&errr=" . str_replace(" ", "_",$error_type)."&failed=1" ); 
        }else{
            wp_redirect( home_url('/log-in/') . "?action=login&success=1&did=reset" ); 
        }
        return $errors;   
    }
    wp_redirect( home_url('/404/') ); 
    return $errors;
}
add_filter( 'validate_password_reset', 'new_pass_errs', 10, 3 );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bbb_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bbb_content_width', 640 );
}
add_action( 'after_setup_theme', 'bbb_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bbb_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bbb' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bbb' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    //My Widget Areas begin below
    register_sidebar(array(
    'name' => 'Most Popular Ideas',
    'before_widget' => '<div class = "widgetPopular>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );
    register_sidebar(array(
    'name' => 'The Big Black Book',
    'before_widget' => '<div class = "widgetNav">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );

}
add_action( 'widgets_init', 'bbb_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bbb_scripts() {
	wp_enqueue_style( 'bbb-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bbb-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'bbb-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bbb_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
