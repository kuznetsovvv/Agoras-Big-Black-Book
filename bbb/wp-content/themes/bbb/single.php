<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AgorasBBB
 */

get_header();     
$post = get_post();
$cat = get_the_category();
$isQuiz = false;
    
    //SETUP FOR ADMIN CHECK
	$user = wp_get_current_user();
	$allowed_roles = array('administrator');
if( array_intersect($allowed_roles, $user->roles ) ) {  
    //ADMIN ONLY CODE HERE
    if( $_GET["qs"] == 100 ) { 
        saveQuiz($post->ID);
    }
    if (strpos(strtolower($post->post_title), 'quiz') !== false) {
        $isQuiz = true;
    }
    //
}
?><span class="previousEntryArrow bigPrev"></span><span class="nextEntryArrow bigNext"></span>
    <div class="widthlimit">
        <?php                                                                                                
                $book = get_the_category_by_ID($cat[0]->parent);                //Generate an elegant navigation path
                $booklink = get_category_link( $cat[0]->parent ); 
                $chapter = preg_replace('/(\\d+)(\\.)/is', '', $cat[0]->name);
                echo('<p id="path"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'."Agora's Big Black Book</a> &gt; <a href=".'"'.$booklink.'">'.$book.'</a> &gt; <a href="'.$booklink.'/'.$cat[0]->slug.'">'.$chapter .'</a> &gt; <a href="'.$_SERVER['REQUEST_URI'].'">'.$post->post_title."</a></p>");
        ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main"><!--  &#xF02F;  is a print button-->
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
                <?php echo('<h2 id="posttitle" class="singleTitle">'.$post->post_title.'</h2>'); 
                    $leDate = get_the_date();
                    if($isQuiz == false){
                ?>
                    <div id="author-bio">
                        <h3 class="inactivebioButton">By <?php coauthors_posts_links(); ?> on <?php echo $leDate; ?></h3>
                        <hr/>
                    </div> 
            <?php
                    }else{
                        ?><div id="author-bio">
                        <hr/>
                    </div> 
                    <h3 id="quizScoreBox"></h3>
                    <form id="quizform" action='#'>
                    <?php
                    }
                    $allthecontent = $post->post_content;                   //This intermediary step will allow us to edit the post content serverside for quizzes.
                    if($isQuiz == true){
                        $ulpos = stripos($allthecontent, "<ul>");           //find the first ul
                        if(($ulpos < 3)&&($ulpos !== false)){               //if the first ul is the first element, we'll need to replace it
                            $allthecontent = substr_replace($allthecontent, "", $ulpos, 5);
                            $allthecontent = substr_replace($allthecontent, "", strripos($allthecontent, "</ul>"), -5);
                            $appendols = true;
                        }
                        $numqs = substr_count($allthecontent, "<ol>");      //count the number of ols
                        $openpos = stripos($allthecontent, "<ol>", 0)+4;
                        $lastpos = stripos($allthecontent, "</ol>", $openpos);
                        $tempstr = "";
                        $outstr = substr($allthecontent, 0, $openpos-5);
                        
                        for($i = 0; $i < $numqs; $i++){                     //iterate the ols
                            $tempstr = substr($allthecontent, $openpos, $lastpos-$openpos);
                            $tempstr = str_ireplace("<li><strong>", "<p class='correct'><input type='radio' name='q$i'><label class='ans'>",$tempstr);   
                            $tempstr = str_ireplace("</strong></li>", "</label></p><div class='clearfix'>--</div>",$tempstr);                            
                            $tempstr = str_ireplace("<li>", "<p><input type='radio' name='q$i'><label class='ans'>",$tempstr);   // style='float: left;'><span style='float: left;'>
                            $tempstr = str_ireplace("</li>", "</label></p><div class='clearfix'>--</div>",$tempstr);  
                            $openpos = stripos($allthecontent, "<ol>", $lastpos-5)+4;
                            $outstr = $outstr.$tempstr.str_replace("<li","<li style='margin-top:26px;'",substr($allthecontent, $lastpos+5, $openpos-$lastpos-10));
                            
                            $lastpos = stripos($allthecontent, "</ol>", $openpos);
                        }
                        $allthecontent = $outstr;
                        if($appendols == true){
                            $allthecontent = "<ol>".$allthecontent."</ol>";
                        }
                        
                    }
                    
                echo apply_filters( 'the_content', $allthecontent ); 

                
                    if($isQuiz == true){
                    ?> </form><div id="quizsubbutwrapper"><a id="quizsubmitbutton" onclick="javascript:submitQuiz();">Submit Answers</a></div>
                    <style>
                        #quizsubbutwrapper{
                            width:100%;
                            text-align: center;
                        }
                        #quizsubmitbutton{
                            text-align: center;
                            display:inline-block;
                            margin: 0 auto; 
                            padding:2px 5px;
                            border: 2px solid #fe7030;
                            background-color:#fe7030; 
                            font-size: 22px; 
                            color: #ffffff;
                        }
                        #quizsubmitbutton:hover{
                            border: 2px solid #fede30;
                            background-color:#fe7030; 
                            color: #fede30;
                            cursor: pointer;
                        }
                        .quizAnswer{
                            display:none;
                            padding:0 10%;
                            border-radius: 5px;
                            border: 1px solid #66AAFF;
                            background-color: #AADDFF;
                        }
                        input[type=radio]{
                            float: left;
                            padding: 0 26px 0 0 !important;
                            margin: 6px 0 0 6px !important;
                            vertical-align: middle;
                            display: block;
                        }
                        label.ans{
                            margin-left: 30px;
                            display: block;
                        }
                        ol>li>p{
                            margin: 4px 0 4px 6px;
                            border-radius: 5px;
                        }
                    </style>
                    <?php
                    }

            ?>
                </div>
            </main><!-- #main -->
            <div style="width:100%; font-size: 15px; line-height: 1.5;"><span style="float:left;"><span class="previousEntryArrow"></span><span class="previousEntryLink"></span></span>    <span style="float:right;"><span class="nextEntryLink"></span><span class="nextEntryArrow"></span></span><div class="clearfix">--</div></div>
        </div><!-- #primary -->
    </div> 
<?php
get_sidebar();
get_footer();

function saveQuiz($thisID){
    $meta = get_user_meta( get_current_user_id()); 
    $allQuizzes = unserialize($meta["quizzes"]);
    $allQuizzes[$thisID] = $_POST["score"];
    var_dump($allQuizzes);
    echo $thisID;
    update_user_meta( get_current_user_id(), "quizzes", $allQuizzes);
}