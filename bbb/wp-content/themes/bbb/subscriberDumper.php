<?php
/**
 * Template Name: Subscriber Dumper
 *
 * This is used to get a master list of Subscribers by affiliate
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
            'role'         => 'subscriber'
         ); 
        $allusers = get_users( $args );
    $domains = [];
    $otherSubAccts =[];
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
            /*
            $args = array(
    'post_type' => 'post',
    'posts_per_page' => 1000,
    'post_status' => 'publish',
    'author_name' => $auvtor->user_login
);
$author_query = new WP_Query( $args );//*/
            
list( $email_user, $email_domain ) = explode( '@', $auvtor->user_login );
            $email_domain = strtolower($email_domain);
            if(empty($email_domain)){
                array_push($otherSubAccts, $auvtor->user_login );
                continue;
            }
            if(array_key_exists($email_domain, $domains)){
                $domains[$email_domain]++;
            }else{
                $domains[$email_domain] = 1;
            }
 

                ?>

                                <!--
                                <h1 style="font-weight: normal;" id="ee"><?php //echo the_author_meta('display_name', $aid) ?></h1>
                                <div class="clearfix">--</div> -->
                                   
                                <?php
               } ?>
                <ul>
                <?php
                arsort($domains);
                foreach($domains as $domain => $addresses){
                    echo "<li>We have ".$addresses." subscribers from ".$domain.".</li>";
                }    
                ?>
                </ul>
                <div class="clearfix">--</div>
                <?php
                
            echo "<br>The following users have no domain name associated with their subscriber accounts:<ol>";
            foreach($otherSubAccts as $usrname){
                echo("<li>".$usrname."</li>");
            }
            echo "</ol>";
                ?>
                
            </div>
		</main><!-- #main -->
            <div style="visibility:hidden; font-size: 15px; line-height: 1.5;">--</div>
        </div>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
