<?php

use touiteur\touites\Touite;

require_once 'vendor/autoload.php';

$t = new Touite(1,"Voilà un touite",20230202,"moi");

echo '<ul>';
echo $t->aff_touite();
echo '</ul>';