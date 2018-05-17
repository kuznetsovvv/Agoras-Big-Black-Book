<?php
/**
 * Template Name: Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AEresources
 */

if(isset($_GET['j'])){
    subcats($_GET['j']);
    ?><?php
    ob_end_flush();
    exit(0);
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <br />
        <h3 class="homepageSubhead">Important Ideas</h3>

        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Most Popular Ideas") ) : ?>
            <?php endif;?>

        <hr style="margin:auto; width: 50%;" />
            <script type="text/javascript">
                jQuery( ".search-field" ).blur(function() {
                    jQuery(".search-field").attr("placeholder", "🔍︎ Search the Book");
                });
            </script>
<?php
get_sidebar();
get_footer();

function subcats($category){
            $subCategories = get_categories( array(
            'hierarchical'     => true,
            'orderby'          => 'name',
            'order'            => 'ASC',
            'parent'           => $category,
            'hide_empty'       => 0
        ) );
        $linebreaker = 0;
        $rowcount = ceil(count($subCategories)/3);
        foreach( $subCategories as $cat){  //Iterate through chapters
            $linebreaker += 1;
            if($linebreaker % $rowcount == 1){
                ?><div class="chapCol"><?php
            }
                ?>
            <div class="Chapter">
                
                <?php
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => $cat->term_taxonomy_id,
	        'meta_key'		   => 'page',
            'orderby'          => 'meta_value_num',
            'order'            => 'ASC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true 
        );
        $posts_array = get_posts( $args ); 
            echo '<p class="chapter'.$cat->term_taxonomy_id.'"><a href="'.get_category_link($cat->term_taxonomy_id).'">'.preg_replace('/(\\d+)(\\.)/is', '', $cat->name)."</a></p>";//" - #".$cat->term_taxonomy_id."</p>";
            echo '<ul class="chapter'.$cat->term_taxonomy_id.'">';
            foreach($posts_array as $post){
                echo '<li><a href="'.get_post_permalink($post->ID).'">'.$post->post_title."</a></li>";//." - #".$post->ID."</li>";
            }
            echo "</ul>";
        ?>
                </div>
                
                <?php
            if($linebreaker % $rowcount == 0){
                ?></div><?php
            }
    }
    ?><div class="clearfix">--</div><?php
}