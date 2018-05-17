<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package AgorasBBB
 */

get_header(); ?>

	<div id="primary" class="content-area">
        <div class="widthlimit">
        <p id="path" style="visibility:hidden">--</p>
		<main id="main" class="site-main" role="main">                
                <div class="fontSettings" onclick="javascript:fontSettings();"><span style="font-size:24px">A</span><span style="font-size:18px">A</span></div>
                <div class="settingsArea" style="display:none">
                    <span class="fontlabel">Font Size:</span>
                    <span class="settingsGroup">
                        <span onclick="javascript:fontMinus()" class="size" id="fontMinus"> Small </span>
                        <span onclick="javascript:fontDefault()" class="size" id="fontDefault"> Medium </span>
                        <span onclick="javascript:fontPlus()" class="size" id="fontPlus"> Large </span>
                    </span>
                    <span class="fontlabel">Typography:</span>
                    <span class="settingsGroup">
                        <span onclick="javascript:fontSerif()" class="size" id="fontSerif"> Serif </span>
                        <span onclick="javascript:fontSans()" class="size" id="fontSans"> Sans </span>
                    </span>
                    <span class="fontlabel">Color:</span>   
                    <span class="settingsGroup">
                        <span onclick="javascript:fontLight()" class="size" id="fontLight"> Light </span>
                        <span onclick="javascript:fontDark()" class="size" id="fontDark"> Dark </span>
                    </span>
                    <span onclick="javascript:fontSettingsClose()" class="close">✕</span>
                </div>
            <div id="padarea">

			<section class="error-404 not-found">
				<header class="page-header">
					<h2 class="page-title"><a href="https://en.wikipedia.org/wiki/HTTP_404" target="_blank">404</a></h2>
				</header><!-- .page-header -->

				<div class="page-content">					
                    <p>That page was not found.</p>
                    <h1><a href="https://agorasbigblackbook.com">Click here to return home.</a></h1>
					<?php	
						// Only show the widget if site has multiple categories.
						
						/* translators: %1$s: smiley */

						the_widget( 'WP_Widget_Tag_Cloud' );
					?>
                    
                    <p>This error has been logged.</p>
                    <?php 
                    global $current_user;
                    if( $current_user->ID == 1){ ?>
                    <script type="text/javascript">
                        console.log("<?php echo $current_user->ID ?> a");
                        jQuery( document ).ready(function() {
                            setTimeout('readTextFile("//agorasbigblackbook.com/excuses.txt", true)', 100);
                            setInterval('readTextFile("//agorasbigblackbook.com/excuses.txt", true)', 15000);
                        });
                    </script>
                    <?php } ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

            </div>

		</main><!-- #main -->
            <div style="visibility:hidden; font-size: 15px; line-height: 1.5;">--</div>
        </div>
	</div><!-- #primary -->

<?php
get_footer();
