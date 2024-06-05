<?php
$algos = hash_algos();
echo '<ul>';
foreach ($algos as $algo ){
    echo '<li>'.$algo.'</li>';
}
echo '</ul>';

