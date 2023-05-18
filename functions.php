<?php

add_action('elementor/theme/register_locations', 'theme_prefix_register_elementor_locations');
function theme_prefix_register_elementor_locations($elementor_theme_manager)
{
	$elementor_theme_manager->register_all_core_location();
}


define('SH_THEME_URL', trailingslashit(get_template_directory_uri()));
define('SH_THEME_DIR', trailingslashit(get_template_directory()));
define('SH_THEME_ASSETS' , trailingslashit(SH_THEME_DIR . 'assets'));
define('SH_THEME_INC' , trailingslashit( SH_THEME_DIR . 'inc' ));
define('SH_CORE_VERSION', '1.0.0');

$mainFiles = glob(SH_THEME_INC . 'classes/*');

foreach($mainFiles as $file){
	require_once($file);
}

add_filter( 'use_block_editor_for_post', '__return_false' );
add_theme_support( 'menus' );
// var_dump(getallheaders());


//اضافه کردن یک باکس جدید در بخش ادمین مدیریت منوها
add_action( 'admin_head-nav-menus.php', function() {
    add_meta_box( 'plugin-slug-menu-metabox', "Wordpress Login/Logout", 'wpdocs_plugin_slug_render_menu_metabox', 'nav-menus', 'side', 'default', array( /*custom params*/ ) );
} );

function wpdocs_plugin_slug_render_menu_metabox( $object, $args )
{
  global $nav_menu_selected_id;
  // Create an array of objects that imitate Post objects
  $my_items = array(
    (object) array(
        'ID' => 1,
        'object_id' => 1,
        'type_label' => 'Login',
        'title' => 'Login',
        'url' => wp_login_url(),
        'type' => 'custom',
        'object' => 'plugin-slug-slug',
        'db_id' => 0,
        'menu_item_parent' => 0,
        'post_parent' => 0,
        'target' => '',
        'attr_title' => '',
        'description' => '',
        'classes' => array(),
        'xfn' => '',
    ),
    (object) array(
        'ID' => 1,
        'object_id' => 1,
        'type_label' => 'Logout',
        'title' => 'Logout',
        'url' => wp_logout_url(),
        'type' => 'custom',
        'object' => 'plugin-slug-slug',
        'db_id' => 0,
        'menu_item_parent' => 0,
        'post_parent' => 0,
        'target' => '',
        'attr_title' => '',
        'description' => '',
        'classes' => array(),
        'xfn' => '',
    ),
  );

  $db_fields = false;
  // If your links will be hierarchical, adjust the $db_fields array below
  if ( false ) { 
    $db_fields = array( 'parent' => 'parent', 'id' => 'post_parent' ); 
  }

  $walker = new Walker_Nav_Menu_Checklist( $db_fields );
  $removed_args = array( 'action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce', );
  ?>
  <div id="plugin-slug-div">
    <div id="tabs-panel-plugin-slug-all" class="tabs-panel tabs-panel-active">
    <ul id="plugin-slug-checklist-pop" class="categorychecklist form-no-clear" >
      <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $my_items ), 0, (object) array( 'walker' => $walker ) ); ?>
    </ul>
    <p class="button-controls">
      <span class="add-to-menu">
        <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-plugin-slug-menu-item" id="submit-plugin-slug-div" />
        <span class="spinner"></span>
      </span>
    </p>
  </div>
  <?php
}
