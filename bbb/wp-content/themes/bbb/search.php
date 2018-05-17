<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
                <header class="page-header">
				    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'bbb' ), '<span>"<em>' . get_search_query() . '</em>"</span>' ); ?></h1>
                </header><!-- .page-header -->
                <br>
		<?php
                checkAuthor(get_search_query());
		if ( have_posts() ) : ?>

			
			<?php
                
                
                
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

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

function checkAuthor($input){
    $input = strtoupper($input);
    // no shortest distance found, yet
    $shortest = -1;
    $shortests = -1;
    $users = get_users(array(
        'role__not_in' => array( 'role' => 'Administrator' ) ,
        'meta_key'     => '',
        'fields'       => array('ID' , 'display_name')
     ));
    //save all usernames
    $words = $users;
    $bestusers = []; 
    $foundIDs = [];
    // loop through words to find the closest
    foreach ($words as $word) {  
        //Break up into bits of name
        $subnames = explode(" ", $word->display_name); 
        foreach ($subnames as $subname) {
            if(!ctype_alnum($subname)){
                continue;
            }        
            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein(trim($input), trim(strtoupper($subname)), 6, 10, 6);
            //echo $subname." - levenshtein distance: ".$lev;
            // if a next shortest word has not yet been found
            if ($lev <= $shortests || $shortests < 0) {
                if($lev < $shortests){
                    unset($bestusers);
                    unset($foundIDs);
                }
                if(!in_array($word->ID, $foundIDs)){
                    $bestusers[] = $word;
                    $foundIDs[] = $word->ID;
                }
                $shortests = $lev;               
            }
            //echo "<br>";
        }
        // calculate the distance between the input word,
        // and the current word
        $lev = levenshtein(trim($input), trim(strtoupper($word->display_name)), 6, 10, 6);
        // check for an exact match
        if ($lev == 0) {
            // closest word is this one (exact match)
            $closest = $word->display_name;
            $aurl = get_author_posts_url( $word->ID );
            $shortest = 0;
            // break out of the loop; we've found an exact match
            break; 
        }
        // if this distance is less than the next found shortest
        // distance, OR if a next shortest word has not yet been found
        if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $closest  = $word->display_name;
            $aurl = get_author_posts_url( $word->ID );
            $shortest = $lev;
        }
    }
    ?><p><?php
    $threshold = 2.5 * (strlen($input)+1);
    if($shortest < $shortests){
        if ($shortest == -1 || $shortest > $threshold) {
            return;
        }elseif($shortest == 0){
            echo "<script type='text/javascript'>window.location.href = '$aurl'</script>";
        }else{
            echo "<a href='$aurl'>$closest - Biography and Entries</a><br>";
            echo "<script type='text/javascript'>jQuery( document ).ready(function() {jQuery('.no-results').css('display','none');});</script>";        
        }
    }else{
        if ($shortests == -1 || $shortests > $threshold) {
            return;
        }else{
            if($shortests == 0 and count($bestusers) == 1){
                echo "<script type='text/javascript'>window.location.href = '".get_author_posts_url( $bestusers[0]->ID )."'</script>";
            }else{   
                foreach ($bestusers as $best){
                    echo '<a href="'.get_author_posts_url( $best->ID ).'">'.$best->display_name." - Biography and Entries</a><br>";
                    echo "<script type='text/javascript'>jQuery( document ).ready(function() {jQuery('.no-results').css('display','none');});</script>";  
                }    
            }
        }
    }
        ?></p><?php
}