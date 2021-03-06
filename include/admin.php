<?php

function eg_setting_section_callback_function( $arg ) {
    // echo section intro text here
    echo '<p>id: ' . $arg['id'] . '</p>';             // id: eg_setting_section
    echo '<p>title: ' . $arg['title'] . '</p>';       // title: Example settings section in reading
    echo '<p>callback: ' . $arg['callback'] . '</p>'; // callback: eg_setting_section_callback_function
}