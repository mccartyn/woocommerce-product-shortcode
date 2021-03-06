<?php
/*
Plugin Name: 	Woocommerce Product Shortcode
Plugin URI: 	http://www.mrjoshfisher.com/plugins
Description: 	A shortcode for displaying woocommerce product info
Author: 		Josh Fisher
Version 		1.0
Author URI: 	http://www.mrjoshfisher.com
License:		GPL2

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

function wcshort_styles() {
    wp_enqueue_style('wcshortstyles', plugins_url('/assets/css/wcshortstyle.css', __FILE__));
}

function wcshort_scripts() {
	wp_enqueue_script('wcshortscripts', plugins_url('/assets/js/min/wcshortcustom-min.js', __FILE__));
}

add_action('wp_enqueue_scripts', 'wcshort_styles');
add_action('wp_enqueue_scripts', 'wcshort_scripts');

add_shortcode( 'wcproductinfo', 'wcproductinfo_function' );

	function wcproductinfo_function($atts) {
		$a = shortcode_atts( array(
	        'product' => '',
	    ), $atts );
		
		$product_ID = $a['product']; //Product ID
		$pro = new WC_Product($product_ID);
		
		$ret = '';
		
		// Title
		$ret .= "<p class='ptitle'>" . $pro->get_title() . "</p>";
		$ret .= "<br>";
		
		// Image in Link
		$ret .= "<a  href=' " .$pro->get_permalink() . " '>" . $pro->get_image('full') .  "</a>";
		$ret .= "<br>";
		
		// Regular Price
		$ret .= "<b>Regular Price: </b>".$pro->get_regular_price();     
	    $ret .= "<br>";
	    
	    // Sale Price
	    $ret .= "<b>Sale Price: </b>".$pro->get_sale_price();     
	    $ret .= "<br>";
	    
	    // If product is on sale strikeout regular price css
	    if($pro->is_on_sale()){
		   $ret .= "<h3><strike>£" .$pro->get_regular_price() . "</strike> - <b>£" .$pro->get_sale_price() . "</b></h3>";
		}
	    $ret .= "<br>";
		
		// Get Product Link
		$ret .= "<b>Link: </b> <a href=' " .$pro->get_permalink() . " '>". $pro->get_title() ."</a>";
	    $ret .= "<br>";
	    
		// Get Total Stock
	    $ret .= "<b>Availability Stock: </b>".$pro->get_total_stock();  
	    $ret .= "<br>";
	    
	    // If Product Is In Stock Then show In Stock
	    if($pro->is_in_stock()){
		    $ret .= "<b>In Stock</b>";
	    } else {
		    $ret .= "<b>Out Of Stock</b>";
	    }
	    $ret .= "<br>";
		
		
		
		// Product SKU
		$ret .= "<b>SKU: </b>" . $pro->get_sku();
		$ret .= "<br>";
		
		// Product Weight
		$ret .= "<b>Weight: </b>" . $pro->get_weight();
		$ret .= "<br>";
		
		// Product Height
		$ret .= "<b>Height: </b>" . $pro->get_height();
		$ret .= "<br>";
		
		// Product Width
		$ret .= "<b>Width: </b>" . $pro->get_width();
		$ret .= "<br>";
		
		// Product Length
		$ret .= "<b>Length: </b>" . $pro->get_length();
		$ret .= "<br>";
		
		// Product Dimensions
		$ret .= "<b>Dimensions: </b>" . $pro->get_dimensions();
		$ret .= "<br>";
		
		//Product Long Desciption
		$ret .= "<b>Long Description: </b>" . $pro->post->post_content;
		$ret .= "<br>";
		
		// Product Short Desctipion
		$ret .= "<b>Short Description: </b>" . $pro->post->post_excerpt;
		$ret .= "<br>";
		
		// Product Tags
		$ret .= "<b>Tags: </b>" . $pro->get_tags();
		
		// Product Add To Cart Button
		$ret .='
		<form class="cart" method="post" enctype="multipart/form-data">
		<input type="hidden" name="add-to-cart" value="' . esc_attr($pro->id) . '"><button type="submit">' .  $pro->single_add_to_cart_text() . '</button></form>';
		
		return $ret;

}

// WOOCOMMERCE PRODUCT SLIDER SHORTCODE

add_shortcode( 'wcslider', 'wcproductslider' );

function wcproductslider($atts) {
	$a = shortcode_atts( array(
        //'product' => '98',
        'products' => '',
    ), $atts );

	$sliproducts = explode(",", $a['products']);
	
	$ret = '';
	$ret .= "<div class='slider-wrapper'>";
	$ret .= "<div class='slider multiple-items'>";
	
	foreach ($sliproducts as $productkey) {
		//$ret .= $productkey;
		$product_ID = $productkey; //Product ID
		$pro = new WC_Product($product_ID);
		
		$ret .= "
				<div>
				<a  href=' " .$pro->get_permalink() . " '>"
				. $pro->get_image() .  "</a>
				<p class='ptitle'>" . $pro->get_title() . "</p>
				<p class='pprice'>£" . $pro->get_regular_price() . "</p>
				<p class='plink'><a href=' " .$pro->get_permalink() . " '>View Product</a></p>
				</div>
			
				";
	}
	
	$ret .= "</div>";
	$ret .= "</div>";

	/*$ret .= '<script type="text/javascript">
        jQuery(function ($){
	        $(document).ready(function(){
		        $(".multiple-items").slick({
				  slidesToShow:3,slidesToScroll: 1,autoplay:false,arrows:true,dots:false,autoplaySpeed: 2000,
			   });
		   });
	   });
    </script>';*/
	
    return $ret;

}

