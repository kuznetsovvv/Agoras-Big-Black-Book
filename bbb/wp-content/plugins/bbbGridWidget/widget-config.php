<?php
/**
 * This file could be used to catch submitted form data. When using a non-configuration
 * view to save form data, remember to use some kind of identifying field in your form.
 */
 if((isset($_POST['gold'])) and isset($_POST['dow']) and is_admin()) {      
     $dwrite = $_POST['gold'].";".$_POST['dow'];

 }
?>
<p>We'll use this space as inputs for the Gold vs DOW costs!</p>
<p><?php echo $_POST['gold']; ?> This file is set up in: <tt><?php echo __FILE__ ?></tt></p>
<form action="#" method="post">
<p>$USD per Gold ounce </p>
<input type="text" name="gold" />
<p>$USD per DOW share</p>
<input type="text" name="dow" />
<input type="submit">
</form>