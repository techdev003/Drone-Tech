<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  
add_action("wp_enqueue_scripts", "wp_child_theme");
function wp_child_theme() 
{
    if((esc_attr(get_option("wp_child_theme_setting")) != "Yes")) 
    {
		wp_enqueue_style("parent-stylesheet", get_template_directory_uri()."/style.css");
    }

	wp_enqueue_style("child-stylesheet", get_stylesheet_uri());
// 	wp_enqueue_script("child-scripts", get_stylesheet_directory_uri() . "/js/view.js", array("jquery"), "6.1.1", true);
// 	wp_enqueue_script("child-custom-scripts", get_stylesheet_directory_uri() . "/js/custom.js", array("jquery"), "", true);
}
 function enqueue_child_theme_styles() {
    // Enqueue the parent theme's stylesheet first
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Enqueue your child theme's custom CSS file from the "assets" folder
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
// Register a custom sidebar widget area for single posts
function custom_single_post_sidebar() {
    register_sidebar(array(
        'name' => 'Single Post Sidebar',
        'id' => 'custom-single-post-sidebar',
        'description' => 'Widgets added here will appear in the sidebar on single post pages.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'custom_single_post_sidebar');
function enqueue_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');
