<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AgorasBBB
 */
if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
if (!is_user_logged_in()) {
    if(!is_page( array( 'log-in' ))){
        header("Location: https://" . $_SERVER["HTTP_HOST"] . '/log-in/');
        die('<h1>Please <a href="https://'. $_SERVER["HTTP_HOST"] .'/log-in/">log in</a> to continue</h1>');
    }
}
?><!DOCTYPE html>
<html <?php
language_attributes();
?>>
<head>
<link rel="icon" href="https://agorasbigblackbook.com/favicon2.png" type="image/png">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<meta charset="<?php
bloginfo('charset');
?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php
wp_head();
//echo "is front page: ".(is_front_page()? 'true' : 'false')."<br/>";
//echo "is home: ".(is_home()? 'true' : 'false')."<br/>";
if(is_page( array( 'log-in', 'account' ))){ ?>
    <link rel="stylesheet" href="<?php
    echo get_stylesheet_directory_uri();
?>/login.css?v=<?php
    echo +filemtime(get_stylesheet_directory() . "/login.css");?>">
<?php 
}
if (is_front_page()) {
?>
				<link rel="stylesheet" href="<?php
    echo get_stylesheet_directory_uri();
?>/homepage.css?v=<?php
    echo +filemtime(get_stylesheet_directory() . "/homepage.css");
?>">		<?php
} else {
?>
                <link rel="stylesheet" href="<?php
    echo get_stylesheet_directory_uri();
?>/bbb.css?v=<?php
    echo +filemtime(get_stylesheet_directory() . "/bbb.css");
?>">
    <?php
}

if (!(isset($_COOKIE["js"]) && password_verify(date(wd) . $_SERVER['REMOTE_ADDR'] . "Agora Was Here", $_COOKIE["js"]))) {
?>
   
    <script type="text/javascript">
        jQuery(document).ready(function(){
           jQuery.get("//"+window.location.hostname+"/jsValid.php", function ( datas ){
               window.location.reload(1);
           });
         });      
    </script>
<?php
    die();
} else {
?>    
                    

    <link rel="stylesheet" href="<?php
    echo get_stylesheet_directory_uri();
?>/toc.css?v=<?php
    echo +filemtime(get_stylesheet_directory() . "/toc.css");
?>">
    <!--THIS CODE RUNS WHEN JS VALIDATES -->
    <script type="text/javascript">//document.addEventListener('contextmenu', event => event.preventDefault());</script>
<?php
}
?>    
</head>

<body <?php
body_class();
?>>
<div id="page" class="site">
    <div id="closeOverlay" onmouseover="javascript: closeOverlays();"></div>
	<a class="skip-link screen-reader-text" href="#padarea"><?php
esc_html_e('Skip to content', 'bbb');
?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
                <?php if (is_front_page()) {?>
            <div id="blackbar">
    <div id="headLeft">
            <div id="dropdownbutton" onclick="dropdownmenu()"> <span class="symbol">&#xF0C9;</span><span class="smallhidetext"> Contents </span></div>
            <div id="homebutton" onclick="window.location.assign('<?php echo esc_url( home_url( '/' ) ); ?>');"> <span class="symbol">&#xF015;</span></div>
            <div id="searchbutton" onclick="searchmenu()"> <span class="symbol">&#xF002;</span><span class="smallhidetext">   Search</span> </div>
            <div id="searcharea" style="display:none" ><?php
            get_search_form();
            ?></div>
        </div>
        <div id="headRight">
            <div id="logout" onclick="window.location.replace('<?php echo wp_logout_url(  ); ?>');">
                <span class="smallhidetext">Log Out</span> <span class="symbol">&#xF08B;</span></div>
            <div id="changepass" onclick="window.location.assign('<?php echo home_url("/account/"); ?>');">
                <span class="smallhidetext">Account</span> <span class="symbol">&#xF21D;</span></div>
        </div>        
        <div id="headMid"><div class="bigButtonArea"></div></div>
            </div>
            
    <div id="dropdowntwo" style="display:none;"><div id="ddtwocenter">
        <div id="chapcol"></div><div id="contcol"></div><div class="clearfix">--</div>
    </div></div>
    <?php } 
error_reporting(E_ALL);
if (is_front_page() || is_home()):
?>
            <div class="widthlimit">
                <div class="floater">
                    <a class="site-title" style="width:100%; " href="<?php
    echo esc_url(home_url('/'));
?>" rel="home">
                <img style="width:100%; height:auto; max-width:300px; margin:auto;" src="<?php
    echo esc_url(home_url('/'));
?>/Big-Black-Book_Cover_600pix.jpg"></a>
                </div>
                <div class="floater2">
				<?php
    get_search_form();
?>
                    <script type="text/javascript">
                    jQuery(".search-field").attr("placeholder", "🔍︎   Search the Book");
                    </script>    
                </div>
                <div class="clearfix">--</div>
            </div></div>
            
            
			<?php
else:
?>
            
            <!--HEADER IS GENERATED HERE-->
        <div id="headLeft">
            <div id="dropdownbutton" onclick="dropdownmenu()"> <span class="symbol">&#xF0C9;</span><span class="smallhidetext"> Contents </span></div>
            <div id="homebutton" onclick="window.location.assign('<?php echo esc_url( home_url( '/' ) ); ?>');"> <span class="symbol">&#xF015;</span></div>
            <div id="searchbutton" onclick="searchmenu()"> <span class="symbol">&#xF002;</span><span class="smallhidetext">   Search</span> </div>
            <div id="searcharea" style="display:none" ><?php
            get_search_form();
            ?></div>
        </div>
        <div id="headRight"><div id="logout" onclick="window.location.replace('<?php echo wp_logout_url(  ); ?>');"><span class="smallhidetext">Log Out</span> <span class="symbol">
&#xF08B;</span></div>
            <div id="changepass" onclick="window.location.assign('<?php echo home_url("/account/"); ?>');">
                <span class="smallhidetext">Account</span> <span class="symbol">&#xF21D;</span></div></div>        
        <div id="headMid"><div id="logotitle" onclick="window.location.assign('<?php echo esc_url( home_url( '/' ) ); ?>');">Agora's Big Black Book</div></div>
            <!--<<div id="brandingMenuButton">
                <div id="dropdownbutton" onclick="dropdownmenu()"> &equiv; </div>
            </div>-->
            <!--<div id="brandingimg">
                <a href="<?php
    //echo esc_url(home_url('/'));
?>" rel="home">
                <img src="<?php
    //echo esc_url(home_url('/'));
?>booklogo.png"></a>
                </div> -->
                <?php
    if (true) {
        $catn        = get_the_category();
        $defaultbook = ($catn[0]->parent != 0) ? $catn[0]->parent : $catn[0]->term_taxonomy_id;
    }
?>
                <div class="clearfix">--</div>
			<?php
endif;

$description = get_bloginfo('description', 'display');
if ($description || is_customize_preview()):
?>
			<?php
endif;
?>
		<!-- .site-branding -->
            
                <div class="clearfix">--</div>
	</header><!-- #masthead -->
                    <div id="dropdown" style="display:none;">
                    <div id="ddbookcol">
<?php
$parents = get_categories(array(
    'hierarchical' => true,
    'orderby' => 'term_id',
    'order' => 'ASC',
    'parent' => 0,
    'hide_empty' => 0
));
$bookcount = 0;
foreach ($parents as $book) {
    if ($book->term_taxonomy_id != 1) { //http://agorasbigblackbook.com/wp-content/uploads/2017/03/transparentSpinner.gif
?>
        <div class="ddBook ddbook<?php
        echo $book->term_taxonomy_id;
?>" onclick="getMenu('<?php
        echo $book->term_taxonomy_id;
?>', 'ddbook<?php
        echo $book->term_taxonomy_id;
?>', '#dropdownchapters');">                                                                         
            <!--THE BOOK BUTTON-->
    <?php
        $bookcount++;
        echo "<h3>Book " . $bookcount . "</h3>";
        echo "<h3>" . $book->name . "</h3>"; //" - #".$book->term_taxonomy_id."</h3>";
?>
            <p class="symbol" style="width: 1em; margin: 0 auto; line-height: 0.8;" >&#xF078;</p>
            </div>        
    <?php
    }
}
?>
</div><div id="dropdownchapters"></div><div class="clearfix">--</div></div>
    <?php if (!is_front_page()) {?>
    <div id="greybar"><div class="bigButtonArea"></div></div>
    <div id="dropdowntwo" style="display:none;"><div id="ddtwocenter">
        <div id="chapcol"></div><div id="contcol"></div><div class="clearfix">--</div>
    </div></div>
    <?php } ?>

	<div id="content" class="site-content" > <!--onselectstart='return false;' oncopy="return false" onpaste="return false" oncut="return false"-->
