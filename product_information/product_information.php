<?php
/*
Plugin Name: Product Information
Description: This plugin is for displaying products in the front-end and manage add to cart functionality.
Version: 1.0
*/

// register product post type
add_action( 'init', 'register_products_post_type' );
function register_products_post_type() {
    register_post_type( 'products',
        array(
            'labels' => array(
                'name' => 'Products',
                'singular_name' => 'Product',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Product',
                'edit' => 'Edit',
                'edit_item' => 'Edit Product',
                'new_item' => 'New Product',
                'view' => 'View',
                'view_item' => 'View Product',
                'search_items' => 'Search Product',
                'not_found' => 'No Product found',
                'not_found_in_trash' => 'No Product found in Trash',
                'parent' => 'Parent Product'
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
}

// register product taxonomy
add_action( 'init', 'register_products_taxonomy' );
function register_products_taxonomy() {    
    $labels = array(
        'name' => __( 'Product Categories' , 'product_category' ),
        'singular_name' => __( 'Product Category', 'product_category' ),
        'search_items' => __( 'Search Product Category' , 'product_category' ),
        'all_items' => __( 'All Product Categories' , 'product_category' ),
        'edit_item' => __( 'Edit Product Category' , 'product_category' ),
        'update_item' => __( 'Update Product Category' , 'product_category' ),
        'add_new_item' => __( 'Add New Product Category' , 'product_category' ),
        'new_item_name' => __( 'New Product Category Name' , 'product_category' ),
        'menu_name' => __( 'Product Category' , 'product_category' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'product_category' ),
        'show_admin_column' => true,
        'show_in_rest' => true
    );
    register_taxonomy( 'product_category', 'products', $args);
}

// create shortcode for products page
add_action( 'init', 'products_shortcode' );
function products_shortcode() {
$args = array(
    'post_type' => 'products',
    'posts_per_pahe' => 6,
    'post_status' => 'publish'
);
$query = new WP_Query( $args );
if($query->have_posts()){
	while($query->have_posts()){
		$query->the_post(); ?>
		<div class="product-blc">
			<h4><?php the_title(); ?></h4>
		</div>	
	<?php } // end of while
	wp_reset_postdata();
} // end of while
add_shortcode( 'products', 'products_shortcode' );
}