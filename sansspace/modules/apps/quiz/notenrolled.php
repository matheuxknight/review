<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo "<h2 class='error' style='font-size:24px'>Oops, something went wrong. Follow these steps:<br><br>
1. Go back to the <a href='/my'>My Learning Site</a> page<br>
2. Click on your course<br>
3. Re-navigate to this quiz <b>OR</b> click on the hyperlink you tried before.</h2>";

