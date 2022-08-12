<?php

/** 
 * Global function dump prints out formatted text 
 * @param string $text Text to be printed out
 */
function dump($args)
{
    {
        echo "<div style='background-color: black; color: white'>";
        echo '<pre>';
        var_dump($args);
        echo '</pre>';
        echo '</div>';
    } 
}