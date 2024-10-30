<?php
/*
Plugin Name: Css-selectors
Description: It adds CSS selectors in the HTML where there are not.
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Domain Path: /languages/
Text Domain: css-sel
Version: 0.0.3
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

if( !class_exists( 'DOMDocument' ) || !function_exists( 'libxml_use_internal_errors' ) ){
  //Without the DOMDocument module the plugin can't work. Let's warn the user and then return
  add_action( 'admin_notices','eos_cs_admin_notice' );
  return;
}

function eos_cs_admin_notice(){
  ?>
  <div class="notice notice-error" style="padding:10px"><?php esc_html_e( 'The module DOMDocument is not installed on this server. The plugin CSS Selectors can not work','css-sel' ); ?></div>
  <?php
}

add_filter( 'the_content','eos_cs_add_selectors' );
//Add CSS selectors where there aren't
function eos_cs_add_selectors( $content ){
  $dom = new DOMDocument();
  libxml_use_internal_errors( true );
  $dom->loadHTML( '<html><head></head><body>'.do_shortcode( $content ) ).'</body></html>';
  $elements = $dom->getElementsByTagName( '*' );
  $n = 0;$e = 0;
  foreach( $elements as $element ){
    $class_name = $element->getAttribute( 'class' );
    if( !$class_name || '' === $class_name ){
      $tag_name = $element->tagName;
      if( in_array( $tag_name,array( 'html','head','body' ) ) ) continue;
      $innerTEXT = $element->textContent;
      if( $innerTEXT && '' !== $innerTEXT ){
        $new_class = 'css-sel-'.esc_attr( $tag_name ).'-'.substr( md5( $innerTEXT ),0,6 );
      }
      else{
        foreach( array( 'width','srcset','src','href','value' ) as $attr_name ){
          if( $element->hasAttribute( $attr_name ) ){
            $attr_value = $element->getAttribute( $attr_name );
            if( $attr_value && '' !== $attr_value ){
              $k = $attr_value;
              break;
            }
          }
          else{
            $k = $e;
          }
        }
        $new_class = 'css-sel-'.esc_attr( $tag_name ).'-'.substr( md5( $k ),0,6 );
        ++$e;
      }
      $element->setAttribute( 'class',$new_class );
    }
    ++$n;
  }
  $content = $dom->saveHTML();
  $content = str_replace( '<html><head></head><body>','',$content );
  $content = str_replace( '</body></html>','',$content );
  return $content;
}
