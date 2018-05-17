<?php
/*
Plugin Name: BBB grid Widget
Plugin URI: http://www.agoraeconomics.com
Description: A plugin that adds a widget to display a grid of images with associated links
Version: 1.0
Author: Vladimir Kuznetsov - Agora Global Projects
Author URI: http://www.agoraeconomics.com
License: Some Rights Reserved. Contact Agora Global Projects for more information.
*/


class agp_bbbgrid_plugin extends WP_Widget {

	// constructor
	function agp_bbbgrid_plugin() {
		 parent::WP_Widget(false, $name = __('BBB grid Widget Plugin', 'agp_bbbgrid_plugin') );
	}

// widget form creation
function form($instance) {

// Check values
     $bbbgridcount = '10';
     $perLineCount = '5';
     $smolPerLineCount = '2';

?>    
    <input class="widefat" id="<?php echo $this->get_field_id('bbbgridcount'); ?>" name="<?php echo $this->get_field_name('bbbgridcount'); ?>" type="hidden" value="<?php echo ($bbbgridcount); ?>" />  
    <input class="widefat" id="<?php echo $this->get_field_id('perLineCount'); ?>" name="<?php echo $this->get_field_name('perLineCount'); ?>" type="hidden" value="<?php echo ($perLineCount); ?>" /> 
<?php
   for($i=1; $i<= $bbbgridcount; $i++){
        $imgvarname = 'bbbgridimage'.$i;
        $linkvarname = 'bbbgridlink'.$i;
        $titlevarname = 'bbbgridtitle'.$i;
       
        if ( isset( $instance[ $linkvarname ] ) ) {
            $$linkvarname = $instance[ $linkvarname ];
        }
        else {
            $$linkvarname = "";
        }
        if ( isset( $instance[ $imgvarname ] ) ) {
            $$imgvarname = $instance[ $imgvarname ];
        }
        else {
            $$imgvarname = "";
        }
        if ( isset( $instance[ $titlevarname ] ) ) {
            $$titlevarname = $instance[ $titlevarname ];
        }
        else {
            $$titlevarname = "";
        }

       
       ?>
     <p>
    <br /><strong>Box #<?php echo $i ?></strong><br />
    <label for="<?php echo $this->get_field_id($imgvarname); ?>"><?php _e('image url:', 'agp_bbbgrid_plugin'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id($imgvarname); ?>" name="<?php echo $this->get_field_name($imgvarname); ?>" type="url" value="<?php echo ($$imgvarname); ?>" />  
    <label for="<?php echo $this->get_field_id($linkvarname); ?>"><?php _e('link:', 'agp_bbbgrid_plugin'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id($linkvarname); ?>" name="<?php echo $this->get_field_name($linkvarname); ?>" type="url" value="<?php echo ($$linkvarname); ?>" />   
    <label for="<?php echo $this->get_field_id($titlevarname); ?>"><?php _e('title:', 'agp_bbbgrid_plugin'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id($titlevarname); ?>" name="<?php echo $this->get_field_name($titlevarname); ?>" type="text" value="<?php echo ($$titlevarname); ?>" />  
</p>
<?php
   } 
        
	}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['bbbgridcount'] = trim($new_instance['bbbgridcount']);  
      $instance['perLineCount'] = trim($new_instance['perLineCount']);  
    
       for($i=1; $i<= $instance['bbbgridcount']; $i++){
            $imgvarname = 'bbbgridimage'.$i;
            $linkvarname = 'bbbgridlink'.$i;
            $titlevarname = 'bbbgridtitle'.$i;
            $instance[$imgvarname] = str_replace("http://", "https://", trim($new_instance[$imgvarname]));  
            $instance[$linkvarname] = str_replace("http://", "https://", trim($new_instance[$linkvarname])); 
            $instance[$titlevarname] = trim($new_instance[$titlevarname]); 
       }
     return $instance;
}

// display widget
function widget($args, $instance) {
       extract( $args );

       // these are the widget options
       $title = "BBB grid";
       $bbbgridcount = $instance['bbbgridcount'];
       $perLineCount = 5;
    //echo '<script type="text/javascript">console.log("'.$perLineCount.'");</script>';
            ?>
    <style>
        .bbbgridbox{
            float:left;
            margin: 5px <?php echo(10/$perLineCount) ?>%;
            padding: 0;
            width: 46%;
            text-align:center;
        }
        .bbbgridtitle{
            line-height: 1.25 !important;
        }
        .bbbgridimg{
            margin:0;
            padding:0;
            width: 100%;
            max-width:120px;
            height: auto;
            box-shadow: 5px 5px 12px #888888;
            filter: grayscale(100%);
        }
        .bbbgridbox:hover .bbbgridimg{
            filter:none !important;
        }
        .bbbgridbox a, .bbbgridbox a:visited{
            color: #000000;
            text-decoration:none;
        }        
        .bbbgridbox a:active, .bbbgridbox:hover a{
            color: #fe7030;
            text-shadow: 1px 0px #fe7030;
        }
        .smolclearfix {
            display:none;
            visibility: hidden;
            height: 0;
            /*
            display: block;
            clear: both;
            */
        }
        .smolclearfix {
            display:block;
            visibility: hidden;
            height: 0;
            clear: both;
        }        
        .bbbgridclearfix{
            visibility: hidden;
            height: 0;
            display:none;
            clear: none;
        }
@media screen and (min-width: 480px){
    .smolclearfix {
        display:none;
        clear: none;
    }      
    .bbbgridclearfix{
        display:block;
        clear: both;
    }
    .bbbgridbox{
        width: <?php echo(80/$perLineCount) ?>%;
    }
}
    </style>
<div class="widthlimit">
<?php
           for($i=1; $i<= $bbbgridcount; $i++){
                $imgvarname = 'bbbgridimage'.$i;
                $linkvarname = 'bbbgridlink'.$i;
                $titlevarname = 'bbbgridtitle'.$i;
                $$imgvarname = trim($instance[$imgvarname]); 
                $$linkvarname = trim($instance[$linkvarname]); 
                $$titlevarname = trim($instance[$titlevarname]); 
                ?>
        <div class="bbbgridbox">
            <a href="<?php echo $$linkvarname;?>">
                <img class="bbbgridimg" src="<?php echo $$imgvarname;?>" alt="<?php echo $i;?>" />
                <p class="bbbgridtitle"><?php echo $$titlevarname;?></p>
            </a>
        </div>
<?php echo $smolPerLineCount;
               echo ($i % $perLineCount == 0 ? '<div class="bbbgridclearfix">--</div>' : ""); 
 echo ($i % 2 == 0 ? '<div class="smolclearfix">--</div>' : ""); ?>
            <?php
            }
    ?>
</div>
<?php
    }
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("agp_bbbgrid_plugin");'));



?>