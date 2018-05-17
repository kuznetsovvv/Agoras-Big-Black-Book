<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AgorasBBB
 */

?>

	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="triangle" class="symbol">&#xF0D9;</div>
    <div class="widthlimit" id="tocbooklimit"><div class="bottomwidthlimit">
            <?php
$parents = get_categories( array(
    'hierarchical'     => true,
    'orderby'          => 'term_id',
    'order'            => 'ASC',
    'parent'           => 0,
    'hide_empty'       => 0
) );
$bn = 0;            
foreach($parents as $book){
    if($book->term_taxonomy_id != 1){//http://agorasbigblackbook.com/wp-content/uploads/2017/03/transparentSpinner.gif
    $bn++;
    ?>
        <div class="Book book<?php echo $book->term_taxonomy_id?>">        <!--THE BOOK BUTTON-->
        <script type="text/javascript">jQuery( document ).ready(function() {
            jQuery("#toclimit").append('<div class="tocbooks" id="toc<?php echo $book->term_taxonomy_id?>"></div>')
            });     
        </script>
    <?php
    echo '<h3><a href="'.get_category_link( $book->cat_ID ).'">Book '.$bn.'<br/>'.$book->name."</a></h3>";//" - #".$book->term_taxonomy_id."</h3>";
    ?>
            </div>        
    <?php
    }
}
        ?>
        <div class="clearfix">--</div>
        <?php
        
        foreach($parents as $book){
    if($book->term_taxonomy_id != 1){
        ?>
        <div class="tocCol toccol<?php echo $book->term_taxonomy_id?>"></div>
        <?php
    }}
        if(is_front_page()){
            $defaultbook=3;
        }elseif(is_author()||is_404()||is_search()){
            $defaultbook=0;
        }else{
            $catn = get_the_category();
            $defaultbook=($catn[0]->parent !=0)? $catn[0]->parent :$catn[0]->term_taxonomy_id;
        }
        
    ?><div class="clearfix">--</div></div></div>
        <small id="copyrightStatement"> Compiled by Mark Morgan Ford &amp; Rocky Vega <br> Agora's Big Black Book ©2015 by Agora Inc. <br> agorasbigblackbook.com ©2017 by The Agora</small>

<div id="bbbtoc">
<div class="widthlimit" id="toclimit">
 <img src="https://agorasbigblackbook.com/transparentSpinner.gif" id="loading" style="display:none;" /><div id="toc"></div>   </div>
 
    <script type="text/javascript">  
    allowmenus = 0;
    mouseleft = 0;
    jQuery( document ).ready(function() { 
            console.log('%c© 2015 by Agora Inc.', 'color: #FF8800; font-size: 72px');
            console.log('%cThis material is protected under copyright law.', 'color: #DDBB00; font-size: 42px');
            jQuery('#wpadminbar, #wpadminbar *').mouseover( function(e) {
                e.stopPropagation();
            });
            jQuery('#blackbar, #blackbar *').mouseover( function(e) {
                e.stopPropagation();
            });
            jQuery('.site-branding, .site-branding *').mouseover( function(e) {
                e.stopPropagation();
            });
            jQuery('#greybar, #greybar *').mouseover( function(e) {
                e.stopPropagation();
            });
            jQuery('html').mouseover( function(e) {
                allowmenus = 1;
                mouseleft = 1;
            });
            jQuery('html').mouseleave( function(e) {
                closeOverlays();
            });
            jQuery('.Book').removeAttr('id');
            jQuery('.book<?php echo $defaultbook ?>').attr('id', 'ActiveBook')    
            //getBook(<?php //echo $defaultbook ?>, '#toc');                                      //MOD THIS TO SHOW ACTIVE
            getBooks();
            getChapters("toccol");
            var daate = new Date();
            var year = daate.getFullYear();
            var month = daate.getMonth();
            var day = daate.getDate();
            nextLinks();
            cdate = new Date(year + 1, month, day);
           <?php
            if(!is_front_page() && !is_page( array( 'log-in' ))){
                echo("initialfonts();");
            }?>
           if (jQuery(window).width() >= 480) {
                wideMenu("bigButtonArea", <?php echo(is_front_page()? 'false' : 'true') ?>);
            }
        
                setTimeout('readTextFile("//agorasbigblackbook.com/logo.txt", false)', 6000);
    });
               /* Anything that gets to the document
                   will hide the dropdown */
                jQuery("#content *").add("#content").click(function(event){
                    jQuery("#dropdowntwo").css('display', 'none');
                    jQuery("#dropdown").css('display', 'none');
                    jQuery(".ddbookc").css('display', 'none');
                    jQuery('.wideBook').removeAttr('id');
                });
                jQuery( ".search-field" ).focus(function() {
                    jQuery(".search-field").attr("placeholder", "");
                });
    function fontSettings(){
            jQuery(".fontSettings").css("display", "none");
            jQuery(".printButton").css("display", "none");
            jQuery(".settingsArea").css("display", "inline-block");//html('✕');
            jQuery(".size").removeClass('fontActive');
            setTimeout('initialfonts()', 50);
    }               
    function fontSettingsClose(){
            jQuery(".fontSettings").css("display", "inline-block");
            jQuery(".printButton").css("display", "inline-block");
            jQuery(".settingsArea").css("display", "none");//html('✕');
    }
    function fontPlus(){
        //var size = jQuery("main p").css("font-size");
        size = 22;// parseInt(size.substring(0, size.length - 2)) + 2;
        jQuery("main p").css("font-size", size+"px");
        jQuery("main li").css("font-size", parseInt(size)+"px");
        jQuery("#fontPlus").addClass('fontActive');
        jQuery("#fontMinus").removeClass('fontActive');
        jQuery("#fontDefault").removeClass('fontActive');
        document.cookie = ("size="+size+"; expires="+cdate+ "; path=/");
    }
    function fontMinus(){
        //var size = jQuery("main p").css("font-size");
        size = 15;// parseInt(size.substring(0, size.length - 2)) + 2;
        jQuery("main p").css("font-size", size+"px");
        jQuery("main li").css("font-size", parseInt(size)+"px");
        jQuery("#fontMinus").addClass('fontActive');
        jQuery("#fontPlus").removeClass('fontActive');
        jQuery("#fontDefault").removeClass('fontActive');
        document.cookie = ("size="+size+"; expires="+cdate+ "; path=/");
    }
    function fontDefault(){
        //var size = jQuery("main p").css("font-size");
        size = 18;// parseInt(size.substring(0, size.length - 2)) + 2;
        jQuery("main p").css("font-size", size+"px");
        jQuery("main li").css("font-size", parseInt(size)+"px");
        jQuery("#fontDefault").addClass('fontActive');
        jQuery("#fontMinus").removeClass('fontActive');
        jQuery("#fontPlus").removeClass('fontActive');
        document.cookie = ("size="+size+"; expires="+cdate+ "; path=/");
    }
    function fontSerif(){
        jQuery("#padarea *").css("font-family", "Georgia, serif");
        document.cookie = ("serif=1; expires="+cdate+ "; path=/");
        jQuery("#fontSans").removeClass('fontActive');
        jQuery("#fontSerif").addClass('fontActive');
    }
    function fontSans(){
        jQuery("#padarea *").css("font-family", "Verdana, sans-serif");
        document.cookie = ("serif=0; expires="+cdate+ "; path=/");
        jQuery("#fontSerif").removeClass('fontActive');
        jQuery("#fontSans").addClass('fontActive');
    }
    function fontLight(){
        jQuery("#padarea").css("background-color", "#ffffff");
        jQuery(".contentsEntry span").css("background-color", "#ffffff");
        jQuery(".contentsEntryAuthor span").css("background-color", "#ffffff");
        jQuery("#biomoredark").attr("id", "biomore");
        jQuery("html").css("background-color", "#f0f0f0");
        jQuery("html").css("background", "linear-gradient(to right, #e0e0e0 ,#f0f0f0,#f0f0f0,#f0f0f0,#f0f0f0,#e0e0e0)");
        jQuery("#padarea *").not("a").not("a *").css("color", "#404040");
        jQuery("#path").not("a").css("color", "#404040");
        document.cookie = ("light=1; expires="+cdate+ "; path=/");
        jQuery("#fontDark").removeClass('fontActive');
        jQuery("#fontLight").addClass('fontActive');
    }
    function fontDark(){
        jQuery("#padarea").css("background-color", "#262626");
        jQuery(".contentsEntry span").css("background-color", "#262626");
        jQuery(".contentsEntryAuthor span").css("background-color", "#262626");
        jQuery("#biomore").attr("id", "biomoredark");
        jQuery("html").css("background-color", "#464646");
        jQuery("html").css("background", "#464646");
        jQuery("#padarea *").not("a").not("a *").css("color", "#eee");
        jQuery("#path").not("a").css("color", "#eee");
        document.cookie = ("light=0; expires="+cdate+ "; path=/");
        jQuery("#fontLight").removeClass('fontActive');
        jQuery("#fontDark").addClass('fontActive');
    }
    function initialfonts(){
        size = getCookie("size");
        //console.log("size = "+size);
        if(size != ""){
            if(size == 15){
                fontMinus();
            }else if(size == 22){
                fontPlus();
            }else{
                fontDefault();
            }
        }else{
                fontDefault();
        }
        light=getCookie("light");
        //console.log("light = "+light);
        if(light != ""){
            if(light == 1){
                fontLight();
            }else{
                fontDark();
            }
        }else{
            fontLight();
        }
        serif=getCookie("serif");
        //console.log("serif = "+serif);
        if(serif == 1){
            fontSerif();
        }else{
            fontSans();
        }
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    function printDiv(divName) {
         var originalContents = document.body.innerHTML;
         light=getCookie("light");
         fontLight();
         var printContents = document.getElementById(divName).innerHTML + "<small>" + document.getElementById("copyrightStatement").innerHTML + "</small>";
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
         if(light != ""){
            if(light == 1){
                fontLight();
            }else{
                fontDark();
            }
         }else{
            fontLight();
         }
    }
    function wideMenu(target, home){
        if (typeof home === "undefined" || home === null) { 
            home = true; 
        }
        jQuery("#brandingMenuButton").attr('style','display:none'); 
        //console.log('wideMenu("'+target+'",'+home+')');
        if(home === true){
            jQuery('.'+target).html( '<div class="wideBook"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Home</a></div>');
        }
        if(jQuery('#toc'+books[0]).is(':empty')){
            setTimeout('wideMenu("'+target+'",'+home+')', 150);
        }else{
            bookstwo = {3:"New Employees",4:"Writing & Copywriting",5:"Sales & Marketing",6:"Publisher's Manual"};
            for (var i = 0, len = books.length; i < len; i++) { 
                var initbutton = ".ddbook"+books[i];
                var outbutton = "widebook"+books[i];
                var booklink = booklinks[i];
                if(jQuery('.'+target).html().length > 1){
                    jQuery('.'+target).append('<span style="width:1%; overflow: visible; margin: 0; padding: 0; display: inline-block; text-align:center;">|</span>');
                }
                var $newButton = jQuery(initbutton).clone().toggleClass('ddBook wideBook').toggleClass( outbutton).attr('onmouseover',"javascript: popddtwo('"+books[i]+"', '#chapcol', '#contcol');").attr('onclick','window.location.assign("'+booklink+'")').html(bookstwo[books[i]]).appendTo(jQuery('.'+target));
                
                
            }
            jQuery('.'+target).css("display", "block");
    <?php if(!is_front_page()){?>
            //jQuery(".wideBook.ddbook<?php echo $defaultbook ?>").attr('id', 'ActiveWideBook');
            
    <?php } ?>
        } 
                   
    }
    function highlightThis(){
        if(<?php echo(is_single()? 'true' : 'false') ?>){
            jQuery("[href]").each(function() {
                if (this.href == "<?php echo get_post_permalink() ?>") {
                    //console.log(this);
                    //console.log(jQuery(this).css("display"));
                    if(jQuery(this).is(":visible")){// && (jQuery(this).style("display") == block))
                        jQuery(this).attr("style", "font-weight:bold; color:#fe7030;");
                    }
                }
            });
        }
    }   
    </script> 
    <?php if(!is_front_page()){?>
    <style>
        .bigButtonArea .wideBook.widebook<?php echo $defaultbook ?>{
            border-bottom: 6px solid #fe7030;
            margin-bottom: 0;
        }
    </style>
    <?php } ?>


    <div class="clearfix">--</div>        <script type="text/javascript">
        var books = [3,4,5,6];
        var booklinks = ["<?php echo get_category_link( 3 ) ?>","<?php echo get_category_link( 4 ) ?>","<?php echo get_category_link( 5 ) ?>","<?php echo get_category_link( 6 ) ?>"];
        function getBooks(){
            for (var i = 0, len = books.length; i < len; i++) { 
                booknum = books[i];
                jQuery('#toc'+booknum).load('<?php echo esc_url( home_url( '/' ) )?>?j='+booknum);
            }
        }
        function getChapters(targetPrefix){
            for (var i = 0, len = books.length; i < len; i++) {
                booknum = books[i];
                if(jQuery('#toc'+booknum).is(':empty')){
                    setTimeout('getChapters("'+targetPrefix+'")', 150);
                    return;
                }
            }
            for (var i = 0, len = books.length; i < len; i++) {
                booknum = books[i];
                //console.log(booknum);
                jQuery('#toc'+booknum+' .Chapter p').each( function(){
                    jQuery(this).clone().appendTo(jQuery('.'+targetPrefix+booknum));
                });
            }
            
        }
        function getBook(booknum, targetID){
            if(jQuery('#toc'+booknum).is(':empty')){
                jQuery('#loading').insertAfter(targetID);
                jQuery('#loading').attr('style','display:block');
                jQuery(targetID).attr('style','display:none');
                jQuery('#toc'+booknum).load('<?php echo esc_url( home_url( '/' ) )?>?j='+booknum, function(){
                    jQuery(targetID).html(jQuery('#toc'+booknum).html());
                    jQuery('#loading').attr('style','display:none');
                    jQuery(targetID).attr('style','display:block');
                    highlightThis();
                });
            }else{
                jQuery(targetID).html(jQuery('#toc'+booknum).html());
                jQuery('#loading').attr('style','display:none');
                jQuery(targetID).attr('style','display:block');
                highlightThis();
            }
        }
        function popddtwo(booknum, colID, targetID){
            if(allowmenus < 1){
                setTimeout(function(){ allowmenus++;if(mouseleft ==0){popddtwo(booknum, colID, targetID);}  }, 400);
                return;
            }
            if(jQuery('#dropdown').is(':visible')){
               dropdownmenu();
            } 
            if(booknum == 0){
                jQuery('.wideBook').removeAttr('id'); jQuery('#dropdowntwo').slideUp(180);//css('display','none');
                return;
            }
            if(jQuery('#ActiveWideBook').length > 0 &&jQuery('#ActiveWideBook').attr('class').slice(-1)==booknum){
                return;
            }
            if(!(jQuery('#dropdowntwo').is(':visible')&&jQuery('#ActiveWideBook').attr('class').slice(-1)==booknum)){
                jQuery('.wideBook').removeAttr('id');  
                jQuery('.widebook'+booknum).attr('id', 'ActiveWideBook'); 
                //popddtwo('"+books[i]+"', '#chapcol', '#contcol');
                if(<?php echo(is_front_page()? 'true' : 'false') ?>){ 
                    jQuery("#dropdowntwo").css('top', jQuery("#blackbar").height()+jQuery("#blackbar").position().top);   
                }else{
                    jQuery("#dropdowntwo").css('top', parseInt(jQuery("#greybar").height())+parseInt(jQuery("#greybar").offset().top));   
                }
            }else{ 
                jQuery('.wideBook').removeAttr('id'); jQuery('#dropdowntwo').slideUp(180);//css('display','none');
                return;
            }
            jQuery(targetID).html("");
            if(jQuery('#toc'+booknum).is(':empty')){
                jQuery('#loading').insertAfter(colID);
                jQuery('#loading').attr('style','display:block');
                jQuery(targetID).parent().attr('style','display:none');
                jQuery('#toc'+booknum).load('<?php echo esc_url( home_url( '/' ) )?>?j='+booknum, function(){
                    jQuery(colID).html('<p style=font-weight:bold>Chapters</p>');
                    jQuery('#toc'+booknum+' p').each(function(){
                        jQuery(colID).append(jQuery(this).clone().attr("onmouseover", 'javascript: getarts("'+jQuery(this).attr('class')+'","'+targetID+'"); jQuery("#chapcol p").removeAttr("id");  jQuery(this).attr("id", "ActiveColChap");').html(jQuery(this).text()));
                    });
                    jQuery('#loading').attr('style','display:none');
                    jQuery('#dropdowntwo').slideDown(250);//css('display','block');
                    jQuery("#closeOverlay").css("display","block");
                    highlightThis();
                });
            }else{
                jQuery(colID).html('<p style=font-weight:bold>Chapters</p>');
                jQuery('#toc'+booknum+' p').each(function(){
                        jQuery(colID).append(jQuery(this).clone().attr("onmouseover", 'javascript: getarts("'+jQuery(this).attr('class')+'","'+targetID+'"); jQuery("#chapcol p").removeAttr("id");  jQuery(this).attr("id", "ActiveColChap");').html(jQuery(this).text()));
                });
                jQuery('#loading').attr('style','display:none');
                jQuery('#dropdowntwo').slideDown(250);//css('display','block');
                jQuery("#closeOverlay").css("display","block");
                highlightThis();
            }
        }
        function getMenu(booknum, colID, targetID){
            jQuery('#ddbookcol .ddBook').removeAttr('id');
            jQuery("#triangle").css('display', "none");
            if(jQuery('.'+colID+'c').is(":visible")){
                jQuery('.'+colID+'c').slideUp(180);//.attr('style','display:none');
                jQuery(targetID).attr('style','display:none');
                jQuery("#triangle").css('display', "none");
                return;
            }
            jQuery('#ddbookcol .'+colID).attr('id', 'ActiveddBook');
            jQuery(targetID).html("");
            jQuery(".ddbookc").slideUp(280);//.attr('style','display:none');
            if(!(jQuery('.'+colID+'c').length)){
                jQuery('<div class="ddBook ddbookc '+colID+'c" > a </div>').insertAfter( '#ddbookcol .'+colID );
                jQuery('.'+colID+'c').slideDown(240);
            }else{
                jQuery('.'+colID+'c').slideDown(240);//attr('style','display:block');
            }
            colID = colID+'c';
            if(jQuery('#toc'+booknum).is(':empty')){                
                jQuery('#loading').insertAfter(colID);
                jQuery('#loading').attr('style','display:block');
                jQuery(targetID).parent().attr('style','display:none');
                jQuery('#toc'+booknum).load('<?php echo esc_url( home_url( '/' ) )?>?j='+booknum, function(){
                    jQuery('.'+colID).html("");
                    jQuery('#toc'+booknum+' p').each(function(){
                         jQuery('.'+colID).append(jQuery(this).clone().attr("onclick", 'javascript: getarts("'+jQuery(this).attr('class')+'","'+targetID+'"); moveTri(jQuery(this).position().top); jQuery("#ddbookcol .'+colID+' p").removeAttr("id");  jQuery(this).attr("id", "ActiveColChap");').html(jQuery(this).text()));
                    });
                    jQuery('#loading').attr('style','display:none');
                    jQuery(targetID).parent().attr('style','display:block');
                    highlightThis();
                });
            }else{
                jQuery('.'+colID).html("");
                jQuery('#toc'+booknum+' p').each(function(){
                        jQuery('.'+colID).append(jQuery(this).clone().attr("onclick", 'javascript: moveTri(jQuery(this).position().top); getarts("'+jQuery(this).attr('class')+'","'+targetID+'");  jQuery("#ddbookcol .'+colID+' p").removeAttr("id");  jQuery(this).attr("id", "ActiveColChap");').html(jQuery(this).text()));
                });
                jQuery('#loading').attr('style','display:none');
                jQuery(targetID).parent().attr('style','display:block');
                highlightThis();
            }
            if(<?php echo(is_front_page()? 'true' : 'false') ?>){ 
                jQuery("#dropdown").css('top', jQuery("#blackbar").height()+jQuery("#blackbar").position().top);   
            }else{
                jQuery("#dropdown").css('top', jQuery(".site-branding").height()+jQuery(".site-branding").position().top);   
            }
        }
        function getarts(chapnum, targetID){
                if(jQuery(window).width()< 800){
                    window.location.assign(jQuery('p.'+chapnum+' a').attr('href'));
                    return;
                }
                jQuery(targetID).html("");
                //console.log(jQuery(targetID).html());
                jQuery(targetID).append("<p>"+jQuery('p.'+chapnum+':last()').text()+"</p>");
                //jQuery('p.'+chapnum+':eq(1)').text().appendTo(jQuery(targetID));
                //jQuery(targetID).append("<hr />");
                jQuery('ul.'+chapnum+':first').clone().appendTo(jQuery(targetID));
                //console.log(jQuery(targetID).html());
                jQuery('#loading').attr('style','display:none');
                jQuery(targetID).attr('style','display:block');
                highlightThis();
        }
        function moveTri(posy){
            jQuery("#triangle").css('top', posy+jQuery("#dropdown").position().top);
            jQuery("#triangle").css('display', "block");
        }
        function nextEntryLink(target, text){
            if (typeof text === "undefined" || text === null) { 
                text = true; 
            }
            <?php
                $page_object = get_queried_object();                    //These variables are also used in the previous entry function
                $page_id     = get_queried_object_id();
            ?>
            nextType = " Next Idea ";
            nextlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().next().html();       //Next entry within chapter
            if(!nextlink){                                                                                                   //if no next entry
                nextlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().parent().parent().next().html(); //get next chapter heading
                nextType = " Next Chapter ";
                if(!nextlink){                                                                                                 //check if previous line worked
                    nextlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().parent().parent().parent().parent().next().html(); //next book
                    nextType = " Next Book ";
                }
            }
            nexthref= nextlink.match('(?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*)');                      //get url
            if(nexthref){
                nexthref = decodeHtml(nexthref[0]);                                                                         
            }else{
                nexthref = "https://agorasbigblackbook.com";
                nextType = " Go Home ";
            }
            previewtext = nextType;
            if(!text){
                nextType = '<span class="symbol">&#xF054;</span>';
            }
            //console.log('<a href="'+nexthref+'" title="'+nextType+'">'+nextType+'</a>');                                           //use url
            jQuery(target).html('<a href="'+nexthref+'" title="'+previewtext+'">'+nextType+'</a>');
        }
        function previousEntryLink(target, text){
            if (typeof text === "undefined" || text === null) { 
                text = true; 
            }
            prevType = " Previous Idea ";
            prevlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().prev().html();       //Previous entry within chapter
            if(!prevlink){                                                                                                   //if no previous entry
                prevlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().parent().parent().prev().html(); //get previous chapter heading
                prevType = " Previous Chapter ";
                if(!prevlink){                                                                                                 //check if previous line worked
                    prevlink = jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').last().parent().parent().parent().parent().parent().prev().html(); //previous book
                    prevType = " Previous Book ";
                }
            }
            prevhref= prevlink.match('(?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*)');                      //get url
            if(prevhref){
                prevhref = decodeHtml(prevhref[0]);                                                                         
            }else{
                prevhref = "https://agorasbigblackbook.com";
                prevType = " Go Home ";
            }
            previewtext = prevType;
            if(!text){
                prevType = '<span class="symbol">&#xF053;</span>';
            }
            //console.log('<a href="'+prevhref+'" title="'+prevType+'">'+prevType+'</a>');                                           //use url
            jQuery(target).html('<a href="'+prevhref+'" title="'+previewtext+'">'+prevType+'</a>');
        }
        function nextLinks(){
            <?php echo(is_single()? '' : 'return; ') ?>
            if(!jQuery('a[href$="<?php echo get_post_permalink($page_id) ?>"]').length){
                //console.log("i retried");
                setTimeout(nextLinks, 123);
                return;
            }else{
                    //console.log("i success?");
                    nextEntryLink(".nextEntryLink", true);
                    nextEntryLink(".nextEntryArrow", false);
                    previousEntryLink(".previousEntryLink", true);
                    previousEntryLink(".previousEntryArrow", false);
            }
        }
        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.textContent;
        }                             
        function dropdownmenu() {
            if(jQuery('#dropdowntwo').is(':visible')){
               popddtwo(0);
            }   
            if(jQuery("#dropdown").css('display') == 'none'){
                jQuery("#dropdown").slideDown(250);//attr('style','display:block');
                jQuery("#closeOverlay").css("display","block");
                if(<?php echo(is_front_page()? 'true' : 'false') ?>){ 
                    jQuery("#dropdown").css('top', jQuery("#blackbar").height()+jQuery("#blackbar").position().top);   
                }else{
                    jQuery("#dropdown").css('top', jQuery(".site-branding").height()+jQuery(".site-branding").position().top);   
                }
                jQuery('.ddBook').removeAttr('id');
                //jQuery('#ddbookcol .ddbook<?php //echo $defaultbook;?>').attr('id', 'ActiveddBook')
                //highlightThis();
            }else{           
                jQuery("#dropdown").slideUp(180);//attr('style','display:none');
                jQuery("#closeOverlay").css("display","none");
                jQuery('#dropdownchapters').attr('style','display:none');
                jQuery(".ddbookc").css('display', 'none');
                jQuery("#triangle").css('display', 'none');
            }
        }
        function closeOverlays(){
            jQuery("#closeOverlay").css("display","none");
            if(jQuery('#dropdowntwo').is(':visible')){
               popddtwo(0);
            }   
            if(jQuery('#dropdown').is(':visible')){
               dropdownmenu();
            } 
        }
        function searchmenu() {
            jQuery("#searcharea input").attr("onblur","searchmenu()");
            if(jQuery("#searcharea").css('display') == 'none'){
                jQuery("#searcharea").attr('style','display:block; left:'+jQuery('#searchbutton').position().left+'px'); 
                jQuery("#searcharea .search-field").focus();          
                jQuery("#searchbutton").attr('style','display:none');  
                jQuery("#headMid").css('visibility', 'hidden');
            }else{           
                jQuery("#searcharea").attr('style','display:none');
                jQuery("#searchbutton").attr('style','display:block'); 
                jQuery("#headMid").css('visibility', 'visible');
            }
        }  
    
        function readTextFile(file, echo){
        if (typeof echo === "undefined" || echo === null) { 
            echo = true; 
        }
            var rawFile = new XMLHttpRequest();
            rawFile.open("GET", file, false);
            rawFile.onreadystatechange = function ()
            {
                if(rawFile.readyState === 4)
                {
                    if(rawFile.status === 200 || rawFile.status == 0)
                    {
                        var allText = rawFile.responseText;
                        if(echo){
                            textLines = allText.replace(/\r\n/g,"\n").split('\n') ;
                            jQuery('.page-content > p').first().text(textLines[Math.floor((Math.random() * textLines.length))]);
                        }else{
                            console.log(allText);
                        }
                    }
                }
            }
            rawFile.send(null);
        }
        function submitQuiz(){
            var score = 0;
            var totalquestions = jQuery(".correct").length;
            allInputNames = [];
            light=getCookie("light");
            //console.log("light = "+light);
            if(light != ""){
                if(light == 1){
                    lightfonts=true;
                }else{
                    lightfonts=false;
                }
            }
            if(lightfonts == true){
                jQuery("input:checked").parent().css("background-color","#ff7777");
            }else{
                jQuery("input:checked").parent().css("background-color","#990000");
            }
            jQuery(".correct>input").each(function(){
               if (jQuery(this).is(':checked')){
                    if(lightfonts == true){
                        jQuery(this).parent().css("background-color","#77ff77");
                    }else{
                        jQuery(this).parent().css("background-color","#009900");
                    }
                   score++;
               }else{
                    if(lightfonts == true){
                        jQuery(this).parent().css("background-color","#ccff77");
                    }else{
                        jQuery(this).parent().css("background-color","#559900");
                    }
                   //jQuery(this).parent().css("background-color","#ccff77");                   
               }
            });
            //score = Math.round(score * 100 / totalquestions);
            jQuery("#quizScoreBox").text("Your score: "+Math.round(score * 100 / totalquestions)+"%");
            score = score+"/"+totalquestions;
            jQuery(".quizAnswer").show();
            jQuery.post("<?php echo $_SERVER['REQUEST_URI']?>?qs=100", {score}, function( results ) {
                // results contains whatever that request returned
                //console.log(results);
                console.log(" ");
            });
            jQuery('html, body').animate({
                scrollTop: jQuery("#posttitle").offset().top
            }, 800);
            //jQuery.scrollTo(".quizAnswer");
        }
        
    </script>
    <nav id="site-navigation" class="main-navigation" role="navigation"></nav><!-- #site-navigation --></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
