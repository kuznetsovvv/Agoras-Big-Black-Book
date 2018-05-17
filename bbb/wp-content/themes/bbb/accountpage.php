<?php
/**
 * Template Name: Account Page
 *
 * This is the template that is used for the login page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AEresources
 */

get_header();
?>
    <div class="widthlimit">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div id="padarea">
                    <h1 class="entry-title" style="color: rgb(64, 64, 64); font-family: Verdana, sans-serif;">Account</h1>
                    <?php
                    if(current_user_can('administrator')){                                                                  //ADMIN ONLY WRAPPER FOR DEV
                    $meta = get_user_meta( get_current_user_id()); 
                    ?>
                    <p>Your Bookmarks</p>
                    <ul>
                        <li>Coming soon</li>
                        <li>filler user metadata below</li>
                        <li>
                    <?php
                        var_dump($meta["nickname"]); 
                    ?>
                        </li>
                    </ul>
                    <hr/>
                    <p>Your Quizzes</p>
                    <ul>
                    <?php
                        $quizResults = $meta["quizzes"]; 
                        foreach( $quizResults as $key => $quiz ){
                            $quizData = unserialize($quiz);
                            $pos = 1;
                            echo "<li>";
                            foreach( $quizData as $key => $datapoint){
                                if($pos == 0){
                                    echo "<ol>";
                                }
                                if ($pos) {
                                        echo "<strong><a href='".get_permalink($key)."'>".get_the_title($key)."</a></strong>";
                                        echo " - score: ".$datapoint;
                                }else{
                                        echo "<li><small>".$key." - ".$datapoint."</small></li>";
                                }
                                $pos = $pos - 1;
                            }
                            if($pos < 0){
                                echo "</ol>";
                            }
                            echo "</li>";
                        }
                    ?>
                    </ul>
                    <hr/>
                    <?php
                    }                                                                                                       //END ADMIN ONLY WRAPPER FOR DEV
                    ?>
                    <p>You may update your password using the form below.</p>
                    <?php
                    if(!empty($_GET['action'])){
                        if( $_GET["action"] == "set" && (!($_POST["newWPPass"] === null)) && (!($_POST["newWPPass2"] === null)) && (!($_POST["vnonce"] === null)) ){
                            newPassword($_POST["newWPPass"], $_POST["newWPPass2"], $_POST["vnonce"]);
                        }
                    }
                    $nonce = password_hash(date(wd).$_SERVER['REMOTE_ADDR']."nonce".get_current_user_id(), PASSWORD_DEFAULT); 
                    ?>
                    <form id="setpassword" method="POST" action="?action=set">
                        <p>New Password: <br><input type="password" id="newWPPass" name="newWPPass" value="" required></p>
                        <p>Confirm New Password: <br><input type="password" id="newWPPass2" name="newWPPass2" value="" required></p>
                        <input type="hidden" id="vnonce" name="vnonce" value="<?php echo $nonce; ?>">  
                        <input type="submit" value="Set New Password">
                    </form>
                </div><!-- #padarea -->
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- #widthlimit -->
<?php
function newPassword($newPW, $newPW2, $nonce){
    if (!is_user_logged_in()){            // if obvious hacking attempt: try to crash their browser, try to send them to fbi.gov, yell at them, and end the process.
        ?><script type="text/javascript">
            var total = "";
            for(var i = 0; i<99999;i++){
                total = total +i.toString();
                history.pushState(0, 0, total);
            }
        </script><?php //Browser-crashing script
        header("Refresh: 12;url=https://fbi.gov"); //try to send them to the FBI's site if their browser hasn't crashed within 3 seconds
        echo "<h1>Go away.</h1>"; //yell at them
        die("<p>You should never even see this message as a user. Why are you trying to change someone's password if you're not signed in? There's a password reset portal on the login screen.</p>");// yell at them some more, stop loading page
    }
    if($newPW != $newPW2){
        echo "<h1>Passwords do not match. Password not changed!</h1>";
        return;
    }
    if(current_user_can('administrator')){
        echo "<h1>Access Denied, change the password through the WordPress account settings in the backend.</h1>";
        return;        
    }
    if(password_verify(date(wd) . $_SERVER['REMOTE_ADDR'] ."nonce".get_current_user_id(), $nonce)){
        wp_set_password($newPW, get_current_user_id());
        echo"<h1>Password Change Sucessful</h1>";
        return;
    }else{
        echo "<h1>Sorry, an error occured while setting your password. Please Try Again!</h1>";
        return;
    }
}
get_sidebar();
get_footer();
