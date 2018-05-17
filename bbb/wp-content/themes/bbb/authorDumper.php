<?php
/**
 * Template Name: Author Dumper
 *
 * This is used to get a master list of Articles by Author
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AEresources
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
        $args = array(
            'role'         => 'contributor'
         ); 
        $allusers = get_users( $args );
        foreach($allusers as $auvtor) {                                                                          //AUTHOR LOOP     
            //$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $aid =  $auvtor->ID;//$author->ID;   
        /*        $args = array(
                    'include'       =>  get_post_taxonomies( 'author' ),
                    'author'        =>  $aid,
                );          //*/
          /*  $args = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'author',
                        'field' => 'slug',
                        'terms' => $auvtor->user_login
                    )
                ),
            );
            $current_user_posts = get_posts( $args ); 
                var_dump($current_user_posts);//*/
            
            $args = array(
    'post_type' => 'post',
    'posts_per_page' => 1000,
    'post_status' => 'publish',
    'author_name' => $auvtor->user_login
);
$author_query = new WP_Query( $args );
 

                ?>


                                <h1 style="font-weight: normal;" id="ee"><?php echo the_author_meta('display_name', $aid) ?></h1>
                                <div class="clearfix">--</div>
                                <ol>

                        <?php
                    if ( $author_query->have_posts() ) :
                        while ( $author_query->have_posts() ) : $author_query->the_post();

                        // Do your presentation
                            echo "<li>".get_the_title()."</li>";
                        endwhile;
                    endif;
                       // echo "<ol>";
                        /* Start the Loop */
            //echo count_user_posts($aid);//count($current_user_posts);
                        //foreach ( $current_user_posts as $post ){ 
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                                    //echo'<li><a href="'.get_post_permalink($post->ID).'">'.$post->post_title.'</a></li>';
                                   ?><!--<br />--><?php
                            //get_template_part( 'template-parts/content', get_post_format() );

                       //}


                      // echo "</ol>";
                                ?>
                </ol>            
                                <?php
               } ?>
                
            </div>
		</main><!-- #main -->
            <div style="visibility:hidden; font-size: 15px; line-height: 1.5;">--</div>
        </div>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
