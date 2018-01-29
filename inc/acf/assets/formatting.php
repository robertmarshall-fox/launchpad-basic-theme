<?php

/**
 * This page changes any default formatting set by ACF
 **/

/*
 * This function removes P tags when outputting an image
 */

function filter_ptags_on_images_acf($content) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('acf_the_content', 'filter_ptags_on_images_acf');