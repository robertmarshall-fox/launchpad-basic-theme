<?php

//Set Transient
//-------------
//$name - string name for transient
//plus - amount to be added to transient
//  if $plus = 0, reset transient

function set_plugin_trans($name, $plus) {
    if ( false === ( $value = get_transient( $name ) ) ){ //if transient does not exist
        $trans = 0;    
    } else {
        $trans = get_transient( $name );
    }
        
    $plus = number_format_i18n($plus);
    if ( ! empty( $plus ) || $plus > 0){
        $trans = $trans + $plus;
        set_transient( $name, $trans );
    } else {
        set_transient( $name, '0' );
    }
}