<p>$options = [</p>
<p>    'cost' => 12,</p>
<p>    'salt' => "saltsaltysaltsaltysalt"</p>
<p>];</p>
<p>password_hash("passwordpassword", PASSWORD_DEFAULT, $options);</p>
<?php $options = [
    'cost' => 12,
    'salt' => "saltsaltysaltsaltysalt"
];
echo password_hash("passwordpassword", PASSWORD_DEFAULT, $options);?>
<hr>
<p>$options2 = [</p>
<p>    'cost' => 12,</p>
<p>//did not specify salt this time around</p>
<p>];</p>
<p> for($i=0; $i&lt;10; $i++){</p>
<p>password_hash("passwordpassword", PASSWORD_DEFAULT, $options2);</p>
<p>}//we'll run this a few times to see the different hashes</p>
<?php $options2 = [
    'cost' => 12,
];
for( $i=0; $i<10; $i++){
    echo "<p>".password_hash("passwordpassword", PASSWORD_DEFAULT, $options2)."</p>";
}