<?php
/***** My fonctions.php ******/





// Loading Isotope only on the Page Template

/*
wp_enqueue_script( 'isotope', '/wp-content/themes/lepressing/lib-lp/isotope/jquery.isotope.min.js', true ); // Enqueue it!
wp_enqueue_script( 'parameters','/wp-content/themes/lepressing/lib-lp/isotope/isotope-parameters.js', true ); // Enqueue it!
*/

function my_isotope() {
  if ( is_page_template ( 'archive-nos_offres.php' ) )  {
    /** Call landing-page-template-one enqueue */
    wp_enqueue_script( 'isotope', '/wp-content/themes/lepressing/lib-lp/isotope/jquery.isotope.min.js', true ); // Enqueue it!
    wp_enqueue_script( 'parameters','/wp-content/themes/lepressing/lib-lp/isotope/isotope-parameters.js', true ); // Enqueue it!
  } else {
    /** Call regular enqueue */
    wp_enqueue_script( 'parametres','/wp-content/themes/lepressing/js/config.js', true );
    wp_enqueue_script( 'isotope', '/wp-content/themes/lepressing/lib-lp/isotope/jquery.isotope.min.js', true );
    wp_enqueue_script( 'parameters','/wp-content/themes/lepressing/lib-lp/isotope/isotope-parameters.js', true );
    wp_enqueue_script( 'jfade','/wp-content/themes/lepressing/lib-lp/fade-page/jquery.jfade.1.0.min.js', true );

  }
}
add_action( 'wp_footer', 'my_isotope' );

//load sur toute les pages
/*
function my_isotope()
{
wp_enqueue_script( 'isotope', '/wp-content/themes/lepressing/lib-lp/isotope/jquery.isotope.min.js', true ); // Enqueue it!
wp_enqueue_script( 'parameters','/wp-content/themes/lepressing/lib-lp/isotope/isotope-parameters.js', true ); // Enqueue it!
}
add_action('wp_head', 'my_isotope');
*/


/**********************************************************************  Creation des rubriques dans le back office ************************************/
// Custom rubrique
// mor info @ http://codex.wordpress.org/Function_Reference/register_post_type
// ajoute un onglet dans le BO de WP gestion d'une rubrique avec gabarit
/*
/* Creating a New Post Type for OFFRES MEDIATRANSPORTS *************************************/
add_action( 'init', 'rubrique_nos_offres_init', 0 );
function rubrique_nos_offres_init() {
  $labels = array(
    'name' => _x('Offres', 'post type general name'),
    'singular_name' => _x('Offres', 'post type singular name'),
    'add_new' => _x('Ajouter une offre', 'nos_offres'),
    'add_new_item' => __('Ajouter une offre'),
    'edit_item' => __('Editer'),
    'new_item' => __('Nouvelle offre'),
    'all_items' => __('Toutes les offres'),
    'view_item' => __('Voir'),
    'search_items' => __('Chercher'),
    'not_found' =>  __('Aucune offre trouvée'),
    'not_found_in_trash' => __('Pas dans la poubelle'), 
    'parent_item_colon' => '',
    'menu_name' => 'Nos offres'

  );
  $nos_offres_args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'can_export' => true,
    'menu_position' => 4,
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'has_archive' => true, 
    'hierarchical' => true,
    'capability_type' => 'post',
    'supports' => array('title',/* 'editor', */'author','thumbnail'),
		'rewrite' => array(
			'slug' => 'nos-offres','with_front' => false)
  ); 
  register_post_type('nos_offres',$nos_offres_args);

}
/*Add other Post type & Taxonomies above as needed *************************************/

//Taxonomies - Add other Taxonomies
add_action( 'init', 'create_my_taxonomies', 0 );
function create_my_taxonomies() {
	register_taxonomy( 'offers', array("nos_offres"), array( 'hierarchical' => true,  'label' => 'Catégories', "singular_label" => "Catégories", 'query_var' => true, "rewrite" => true));
}


// Add column informations to admin_init function
function add_new_nos_offres_columns($nos_offres_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';		
		$new_columns['thumb'] = _x('Thumbnail', 'column name');
		$new_columns['title'] = _x('Titre', 'column name');
		$new_columns['prod_cat'] = _x('Catégories', 'column name');
		$new_columns['author'] = __('Auteur');
		$new_columns['date'] = _x('Publié', 'column name');
		return $new_columns;
	}
add_filter('manage_edit-nos_offres_columns', 'add_new_nos_offres_columns');

// Affichage des données
add_action('manage_posts_custom_column', 'data_colonne');
function data_colonne($name) {
 global $post;
 switch ($name) {
case 'thumb':
 if(has_post_thumbnail($post->ID))
 {
 ?>
 <a href="<?php the_permalink(); ?>" target="_blank">
 <?php the_post_thumbnail(array(70,70));?>
 </a>
 <?php
 }
 else
 {
 _e('No Thumbnail','twentyeleven');
 }
 break;
 }
 }
 
/****************************************************** METABOX ******************************************************/

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id'         => 'offre',
		'title'      => 'Offres',
		'pages'      => array('nos_offres'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Test Text',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_text',
				'type' => 'text',
				'taxonomy' => 'imag_theme',
			),
			array(
				'name' => 'Test Text Small',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textsmall',
				'type' => 'text_small',
			),
			array(
				'name' => 'Test Text Medium',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textmedium',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Test Date Picker',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textdate',
				'type' => 'text_date',
			),
			array(
				'name' => 'Test Date Picker (UNIX timestamp)',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textdate_timestamp',
				'type' => 'text_date_timestamp',
			),
			array(
				'name' => 'Test Date/Time Picker Combo (UNIX timestamp)',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_datetime_timestamp',
				'type' => 'text_datetime_timestamp',
			),
			array(
	            'name' => 'Test Time',
	            'desc' => 'field description (optional)',
	            'id'   => $prefix . 'test_time',
	            'type' => 'text_time',
	        ),
			array(
				'name' => 'Test Money',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textmoney',
				'type' => 'text_money',
			),
			array(
	            'name' => 'Test Color Picker',
	            'desc' => 'field description (optional)',
	            'id'   => $prefix . 'test_colorpicker',
	            'type' => 'colorpicker',
				'std'  => '#ffffff'
	        ),
			array(
				'name' => 'Test Text Area',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textarea',
				'type' => 'textarea',
			),
			array(
				'name' => 'Test Text Area Small',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textareasmall',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Test Text Area Code',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textarea_code',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'Test Title Weeeee',
				'desc' => 'This is a title description',
				'id'   => $prefix . 'test_title',
				'type' => 'title',
			),
			array(
				'name'    => 'Test Select',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_select',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'    => 'Test Radio inline',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_radio_inline',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'    => 'Test Radio',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_radio',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'     => 'Test Taxonomy Radio',
				'desc'     => 'Description Goes Here',
				'id'       => $prefix . 'text_taxonomy_radio',
				'type'     => 'taxonomy_radio',
				'taxonomy' => '', // Taxonomy Slug
			),
			array(
				'name'     => 'Test Taxonomy Select',
				'desc'     => 'Description Goes Here',
				'id'       => $prefix . 'text_taxonomy_select',
				'type'     => 'taxonomy_select',
				'taxonomy' => '', // Taxonomy Slug
			),
			array(
				'name'		=> 'Test Taxonomy Multi Checkbox',
				'desc'		=> 'field description (optional)',
				'id'		=> $prefix . 'test_multitaxonomy',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> '', // Taxonomy Slug
			),
			array(
				'name' => 'Test Checkbox',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_checkbox',
				'type' => 'checkbox',
			),
			array(
				'name'    => 'Test Multi Checkbox',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_multicheckbox',
				'type'    => 'multicheck',
				'options' => array(
					'check1' => 'Check One',
					'check2' => 'Check Two',
					'check3' => 'Check Three',
				),
			),
			array(
				'name'    => 'Test wysiwyg',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_wysiwyg',
				'type'    => 'wysiwyg',
				'options' => array(	'textarea_rows' => 5, ),
			),
			array(
				'name' => 'Test Image',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'test_image',
				'type' => 'file',
			),
		),
	);

	// Add other metaboxes above as needed

	return $meta_boxes;
}
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'lib-lp/metabox/init.php';

}

/**
 * Création d'un shortcode simple
 */

add_shortcode("alerte", "alerte");
function alerte( $atts, $content = null ) {  
    return '<div class="alert-box alert">'.$content.'</div>';
}
add_shortcode("bouton", "bouton");
function bouton( $atts, $content = null ) {  
    return '<div class="large button expand">'.$content.'</div>';
}





/* AJOUTE DANS LE tinyMCE LE BTN */
//Step 1: Hook into WordPress
/*
add_action('init', 'add_button'); 
//Step 2: Create Our Initialization Function
function add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_plugin');  
     add_filter('mce_buttons', 'register_button');  
   }  
}  
//Step 3: Register Our Button(s)
function register_button($buttons) {  
   array_push($buttons, "quote");  
   return $buttons;  
} 
//Step 4: Register Our TinyMCE Plugin
function add_plugin($plugin_array) {  
   $plugin_array['quote'] = get_stylesheet_directory_uri('template_url').'/js/customcodes.js';  
   return $plugin_array;  
}
*/
//end Création d'un shortcode simple avec son bouton

/* AJOUTE UN DOPDOWN MENU DANS LE tinyMCE pour les shotcode */
add_action('media_buttons','add_sc_select',11);
function add_sc_select(){
    global $shortcode_tags;
     /* ------------------------------------- */
     /* enter names of shortcode to exclude bellow */
     /* ------------------------------------- */
    $exclude = array("wp_caption", "embed", "gallery", "caption");
    echo '&nbsp;<select id="sc_select"><option>Vos shortcodes personnalisés</option>';
    foreach ($shortcode_tags as $key => $val){
            if(!in_array($key,$exclude)){
            $shortcodes_list .= '<option value="['.$key.'][/'.$key.']">'.$key.'</option>';
            }
        }
     echo $shortcodes_list;
     echo '</select>';
}
add_action('admin_head', 'button_js');
function button_js() {
        echo '<script type="text/javascript">
        jQuery(document).ready(function(){
           jQuery("#sc_select").change(function() {
                          send_to_editor(jQuery("#sc_select :selected").val());
                          return false;
                });
        });
        </script>';
}

?>