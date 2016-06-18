<?php
/*
Plugin Name: 	Woocommerce Product Shortcode
Plugin URI: 	http://www.lemonapps.co.uk/plugins
Description: 	A shortcode for displaying woocommerce product info
Author: 		Lemon Apps
Version 		1.0
Author URI: 	http://www.lemonapps.co.uk/
License:		GPL2

Copyright 2016 Lemon Plugin

Woocommerce Product Shortcode is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Woocommerce Product Shortcode is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Woocommerce Product Shortcode. If not, see {URI to Plugin License}.
*/

add_shortcode( 'wcproductinfo', 'wcproductinfo_function' );

	function wcproductinfo_function($atts) {
		$a = shortcode_atts( array(
	        'product' => '',
	    ), $atts );
		
		$product_ID = $a['product']; //Product ID
		$pro = new WC_Product($product_ID);
		
		$ret = '';
		
		$ret .= "<p class='ptitle'>" . $pro->get_title() . "</p>";
		$ret .= "<br>";
		
		$ret .= "<a  href=' " .$pro->get_permalink() . " '>" . $pro->get_image('full') .  "</a>";
		$ret .= "<br>";
		
		$ret .= "<b>Regular Price: </b>".$pro->get_regular_price();     
	    $ret .= "<br>";
	    
	    $ret .= "<b>Sale Price: </b>".$pro->get_sale_price();     
	    $ret .= "<br>";
	    
	    if($pro->is_on_sale()){
		   $ret .= "<h3><strike>£" .$pro->get_regular_price() . "</strike> - <b>£" .$pro->get_sale_price() . "</b></h3>";
		}
	    $ret .= "<br>";
	   
		$ret .= "<b>Link: </b> <a href=' " .$pro->get_permalink() . " '>". $pro->get_title() ."</a>";
	    $ret .= "<br>";
	    
	   
	    $ret .= "<b>Availability Stock: </b>".$pro->get_total_stock();  
	    $ret .= "<br>";
	    
	    
	    if($pro->is_in_stock()){
		    $ret .= "<b>In Stock</b>";
	    } else {
		    $ret .= "<b>Out Of Stock</b>";
	    }
	    $ret .= "<br>";
		
		
		
		
		$ret .= "<b>SKU: </b>" . $pro->get_sku();
		$ret .= "<br>";
		
		$ret .= "<b>Weight: </b>" . $pro->get_weight();
		$ret .= "<br>";
		
		$ret .= "<b>Height: </b>" . $pro->get_height();
		$ret .= "<br>";
		
		$ret .= "<b>Width: </b>" . $pro->get_width();
		$ret .= "<br>";
		
		$ret .= "<b>Length: </b>" . $pro->get_length();
		$ret .= "<br>";
		
		$ret .= "<b>Dimensions: </b>" . $pro->get_dimensions();
		$ret .= "<br>";
		
		$ret .= "<b>Long Description: </b>" . $pro->post->post_content;
		$ret .= "<br>";
		
		$ret .= "<b>Short Description: </b>" . $pro->post->post_excerpt;
		$ret .= "<br>";
		
		$ret .= "<b>Tags: </b>" . $pro->get_tags();
		
		$ret .='
		<form class="cart" method="post" enctype="multipart/form-data">
		<input type="hidden" name="add-to-cart" value="' . esc_attr($pro->id) . '"><button type="submit">' .  $pro->single_add_to_cart_text() . '</button></form>';
		
		return $ret;

}

