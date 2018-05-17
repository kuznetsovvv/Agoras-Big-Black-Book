<?php
/**
* A Simple Category Template
*/

get_header(); ?> 
 <div class="widthlimit">
        <div id="primary" class="content-area">
        <p id="path" style="visibility:hidden">--</p>
            <main id="main" class="site-main" role="main">
                <div class="fontSettings" onclick="javascript:fontSettings();"><span style="font-size:24px">A</span><span style="font-size:18px">A</span></div>
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
<!--<section id="primary" class="site-content">
<div id="content" role="main">-->

<?php 
// Check if there are any posts to display
if ( have_posts() ) : ?>

<header class="archive-header">
<?php
    $isParent = false;
   $thisCat = get_the_category();
                    
    if(get_the_category_by_ID( $thisCat[0]->parent ) == str_replace("&#8217;", "'",single_cat_title( '', false ))){
        $isParent = true;
    }
    ?>
<h1 class="archive-title"><?php
    if(!$isParent){
        echo get_cat_name($thisCat[0]->parent);
    }else{
        single_cat_title( '', true ); 
    }
    ?></h1>

<br>
<?php
// Display optional category description
 if ( category_description() ) : ?>
<div class="archive-meta"><?php echo category_description(); ?></div>
<?php endif; ?>
</header>

<?php
    $args = array( 'child_of' => $thisCat[0]->parent, 'hide_empty' => false );
    $categories = get_categories( $args );
    foreach($categories as $category) { 
        echo '<p id="chp'.$category->term_id.'">&#10148; Chapter ' . $category->name.' </p> ';
        //echo '<p> Description:'. $category->description . '</p>';
        if($category->count >0){
            //echo '<p> Contains '. $category->count . ' entries:</p>'; 
            $args = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'category'         => $category->term_taxonomy_id,
                'meta_key'		   => 'page',
                'orderby'          => 'meta_value_num',
                'order'            => 'ASC',
                'post_type'        => 'post',
                'post_status'      => 'publish',
                'suppress_filters' => true 
            );
            $posts_array = get_posts( $args ); 
            //var_dump($posts_array);
                //echo "<ul>";
                foreach($posts_array as $post){
                    //$author = get_the_author_meta( "display_name", $post->post_author );
                    //$authorlink = get_author_posts_url( $post->post_author );
                    ?> <div class="contentsEntry">
                    <!--<div class="elipses">.............................................................................................................................................</div>--><?php
                    echo '<a class="contentsEntryTitle" href="'.get_post_permalink($post->ID).'"><span>'.$post->post_title.'</span></a>  <br>';//<a href="'.$authorlink.'">'.$author.'</a></li>';//." - #".$post->ID."</li>";
                    $authorarr = get_coauthors($post->ID);
                    $authorcounter = 0;
                    ?><div class="contentsEntryAuthor"><span> by <?php
                    foreach($authorarr as $coauthor){
                        $authorcounter++;
                        ?><a href="<?php echo get_author_posts_url( $coauthor->ID ); ?>">
                        <?php echo $coauthor->display_name; ?>
                        </a>
                        <?php
                        if($authorcounter < count($authorarr)){
                            echo " and ";
                        }
                    }
                    ?></span></div>
                </div><br>
                    <div class="clearfix">--</div><?php
                }
                //echo "</ul>";
                echo "<hr>";
        }else{
            echo '<p>No contents yet</p><hr>';
        }
    }
/*}else{
            $args = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'category'         => $thisCat[0]->term_taxonomy_id,
                'meta_key'		   => 'page',
                'orderby'          => 'meta_value_num',
                'order'            => 'ASC',
                'post_type'        => 'post',
                'post_status'      => 'publish',
                'suppress_filters' => true 
            );
            $posts_array = get_posts( $args ); 
            //var_dump($posts_array);
    
                foreach($posts_array as $post){
                    $author = get_the_author_meta( "display_name", $post->post_author );
                    $authorlink = get_author_posts_url( $post->post_author );
                    echo '<h3><a href="'.get_post_permalink($post->ID).'">'.$post->post_title.'</a> by <a href="'.$authorlink.'">'.$author.'</a></h3><hr>';//." - #".$post->ID."</li>";
                }
// The Loop
    
 }//*/

else: ?>
<p>This chapter still needs content. Please press the back button on your browser.</p>

<?php 
        $thisCat = get_the_terms(get_queried_object_id(),"category");
                //var_dump(get_category_link( $thisCat[0]->parent ));
        ?>
                <script type="text/javascript">window.location = "<?php echo get_category_link( $thisCat[0]->parent ); ?>"</script>
          <?php      
        endif;  
    if(!$isParent){
                    ?>
                    <script type="text/javascript">
                        //console.log("comparison = <?php echo ($isParent ? 'true': 'false'); ?>");
                        jQuery(document).ready(function(){
                            jQuery('html, body').animate({
                                scrollTop: jQuery("#chp<?php echo $thisCat[0]->term_id; ?>").offset().top -50
                            }, 1000);
                        });
                        //console.log("<?php echo $thisCat[0]->parent ?>, <?php echo $thisCat[0]->term_id; ?>");
                        /*jQuery(window).load(function() {
                            jQuery('.contentsEntryTitle').each(function(){
                              //var html_org = jQuery(this).html();
                              //var html_calc = '<span>' + html_org + '</span>';
                              //jQuery(this).html(html_calc);
                              var width = jQuery(this).find('span:first').width()+1;
                              //jQuery(this).html(html_org);
                                console.log(jQuery(this).html()+ " width found: " + width);
                                //jQuery(this).width(width);
                            });
                        });//*/
                    </script>
                    <?php } ?>
                    <script type="text/javascript">
                        //console.log("comparison = <?php echo ($isParent ? 'true': 'false'); ?>");
                        window.onload = function(){
                            jQuery('.contentsEntry').each(function(index, element) {
                                //console.log('element at index ' + index);
                                //console.log('current element as dom object:' + element);
                                var heightA = jQuery('.contentsEntryAuthor > span', this).height();
                                var heightB = jQuery('.contentsEntryTitle > span', this).height();
                                //console.log('A '+heightA);
                                //console.log('B '+heightB);
                               /* if(heightA>heightB){
                                    //console.log('A > B');
                                    jQuery('.contentsEntryTitle > span', this).prepend("<br>");
                                    //jQuery(this).css('border', '1px solid blue');
                                }else if(heightB > heightA){
                                    //console.log('A < B');
                                    jQuery('.contentsEntryAuthor > span', this).prepend("<br>");
                                    //jQuery(this).css('border', '1px solid red');
                                }//*/
                            });
                        };

                    </script>
                </div>
            </main>
                <div style="visibility:hidden; font-size: 15px; line-height: 1.5;">--</div>
     </div>
</div>

<!--</div>
</section> -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>