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
       print_r($args);
        echo '</pre>';
        echo '</div>';
    } 
}