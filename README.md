Basic-Layer7-Protection-
========================

Basic PHP Page that stops Layer 7 Attacks to 

To Install simply do what the script says. 
"   ================= Setup ============================
   ------------------------------------------------------------
   Copy this file and folder to same as index.php.
   Add following line to your ndex.php
   "<?php" 
   include("l7.php");
"

A example of this install is this.


BEFORE:

<?php

echo rand() . "\n";

?>

(If you don't know what that script is, it basicaly just generates a random number and outputs it.)

AFTER INSTALL:

<?php

include("l7.php");

echo rand() . "\n";

?>

Once that is done you have successfully Installed the Layer 7 Protection script.



