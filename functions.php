<?php
function add_gtm_head(){
?>

<!-- Google Tag Manager -->
<!-- Replace GTM-XXXXXXX with your own --> 
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6L3M8H');</script>
<!-- Replace GTM-XXXXXXX with your own --> 
<!-- End Google Tag Manager -->

<?php
}
add_action( 'wp_head', 'add_gtm_head', 10 );

function add_gtm_body(){
?>

<!-- Google Tag Manager (noscript) -->
<!-- Replace GTM-XXXXXXX with your own --> 
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6L3M8H"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- Replace GTM-XXXXXXX with your own -->
<!-- End Google Tag Manager (noscript) -->

<?php
}
add_action( 'body_top', 'add_gtm_body' );

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/* - 
Hide all but Contributors' and Authors' own posts from all but Editors and Admins
*/

function query_set_only_author( $wp_query ) {
    global $current_user;
    if( is_admin() && !current_user_can('edit_others_posts') ) {
        $wp_query->set( 'author', $current_user->ID );
    }
}
add_action('pre_get_posts', 'query_set_only_author' );

/* - 
For wp-admin users, hide various menu items and meta boxes from all but Editors and Admins. Varies by view options and plugins in-use.
*/

function remove_menus(){
 if( ! current_user_can( 'manage_options' ) ) {
  // remove_menu_page( 'upload.php' );              //Media
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'edit.php?post_type=seoal_container' ); // AutoLinker
  }
}
add_action( 'admin_menu', 'remove_menus', 999 );

// REMOVE POST META BOXES
function remove_my_post_metaboxes() {
  if( ! current_user_can( 'manage_options' ) ) {
    remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
    remove_meta_box( 'postoptions','post','normal' ); // Post Options     Metabox
    remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments     Status Metabox
    remove_meta_box( 'commentsdiv','post','normal' ); // Comments Metabox
    remove_meta_box( 'postcustom','post','normal' ); // Custom Fields     Metabox
    remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
    remove_meta_box( 'revisionsdiv','post','normal' ); // Revisions   Metabox
    remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
    remove_meta_box( 'trackbacksdiv','post','normal' ); // Trackback Metabox
  }
}
add_action('admin_menu','remove_my_post_metaboxes');
