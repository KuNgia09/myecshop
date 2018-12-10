<?php
$a='&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;这是商品详细&lt;/p&gt;';
$a=html_entity_decode($a);
// $a=htmlentities($a);
echo $a; 
?>