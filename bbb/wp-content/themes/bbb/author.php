<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AgorasBBB
 */

get_header(); ?>

	<div id="primary" class="content-area">
        <div class="widthlimit">
        <p id="path" style="visibility:hidden">--</p>
		<main id="main" class="site-main" role="main">                
            <div class="fontSettings" onclick="javascript:fontSettings();"><span style="font-size:24px">A</span><span style="font-size:18px">A</span></div>
                <div class="printButton" onclick="javascript:printDiv('padarea');"><span class="symbol" style="font-size:24px"> &#xF02F;</span></div>
                <div class="settingsArea" style="display:none">
                    <span onclick="javascript:fontSettingsClose()" class="close">✕</span>
                    <span class="noWrap">
                        <span class="fontlabel">Font Size</span>
                        <span class="settingsGroup">
                            <span onclick="javascript:fontMinus()" class="size" id="fontMinus"> Small </span>
                            <span onclick="javascript:fontDefault()" class="size" id="fontDefault">Medium </span>
                            <span onclick="javascript:fontPlus()" class="size" id="fontPlus"> Large </span>
                        </span>
                    </span>
                    <span class="noWrap">                    
                        <span class="fontlabel">Typography</span>
                        <span class="settingsGroup">
                            <span onclick="javascript:fontSerif()" class="size" id="fontSerif">Serif</span>
                            <span onclick="javascript:fontSans()" class="size" id="fontSans"> Sans </span>
                        </span>
                    </span>
                    <span class="noWrap">                    
                        <span class="fontlabel">Color</span>   
                        <span class="settingsGroup">
                            <span onclick="javascript:fontLight()" class="size" id="fontLight">Light </span>
                            <span onclick="javascript:fontDark()" class="size" id="fontDark"> Dark </span>
                        </span>
                    </span>
                </div>
            <div id="padarea">
		<?php
        $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $aid =  $author->ID;   
		if ( have_posts() ) : ?>

			<header class="page-header">
                <div id="author-profile">
                    <h1>About <?php the_author_meta('display_name', $aid) ?></h1>
                    <div id="author-avatar">
                    <?php                         
                        $image = get_avatar($aid, 200);
                        echo $image;
                    ?>
                    </div>
                    <div id="author-bio">
                        <p>
                        <?php 
                            //$Result = str_replace( "\n", '<br />', $Text ); 
                            $text = str_replace( "\n", '</p><p>',get_the_author_meta('description', $aid));		
                            echo $text;
                        ?>
                        </p>
                    </div>
                    <p id="biomore" ><a onclick="javascript: jQuery('#author-bio').attr('id','author-bio-active'); jQuery('#biomore').css('display','none'); jQuery('#biomoredark').css('display','none'); jQuery('#bioless').css('display','block');">Read more...</a></p>
                    <p id="bioless" ><a onclick="javascript: jQuery('#author-bio-active').attr('id','author-bio'); jQuery('#bioless').css('display','none'); jQuery('#biomore').css('display','block'); jQuery('#biomoredark').css('display','block');">Less...</a></p>
                    <hr>
                    <h1 style="font-weight: normal;" id="ee"><?php echo count_user_posts($aid)." Essay".(count_user_posts($aid)>1?"s ":" ")?>by <?php echo the_author_meta('display_name', $aid) ?>:</h1>
                    <div class="clearfix">--</div>
                </div>
				<?php
					//the_archive_title( '<h1 class="page-title">', '</h1>' );
					//the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
                        the_title('<h1><a href="'.get_post_permalink(get_the_ID()).'">','</a></h1>');
                        the_excerpt();
                        ?><br /><?php
				//get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
            </div>
		</main><!-- #main -->
            <div style="visibility:hidden; font-size: 15px; line-height: 1.5;">--</div>
        </div>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
