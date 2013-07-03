<?php
/***** My fonctions.php ******/


// Loading Isotope only on the Page Template
function my_isotope()
{
if (is_page_template( 'archive-nos_offres.php' )  && !is_admin() ) {
wp_enqueue_script( 'isotope', '/wp-content/themes/lepressing/lib/isotope/jquery.isotope.min.js', true ); // Enqueue it!
wp_enqueue_script( 'parameters','/wp-content/themes/lepressing/lib/isotope/isotope-parameters.js', true ); // Enqueue it!
}
}
add_action('wp_head', 'my_isotope');

/* #Include the the options, widgets and functions
================================================== */
/* require_once ('functions/theme-functions.php'); */
/* require_once ('lib/theme-customs.php'); */


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
add_filter('manage_edit-nos_offres_columns', 'add_new_nos_offres_columns');
add_action('manage_posts_custom_column', 'manage_nos_offres_columns', 10, 2);

function add_new_nos_offres_columns($gallery_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';		
		$new_columns['pthumb'] = _x('Thumbnail', 'column name');
		$new_columns['title'] = _x('Titre', 'column name');
		$new_columns['prod_cat'] = _x('Catégories', 'column name');
		$new_columns['author'] = __('Auteur');
		$new_columns['date'] = _x('Publié', 'column name');
		return $new_columns;
	}
// Add column informations to admin_init function
	// Add to admin_init function
			function manage_nos_offres_columns($column_name, $id) {		
				global $post;

				switch( $column_name ) {
					case "pthumb":
							global $wpdb, $post;
							if(has_post_thumbnail()){
								echo '<div class="">dsdsds
											<img src="'.thumb_url().'"  width="85" height="60"/>
											</div>';
							} else{
								$mc_attachments = new mcstudiosAttach();
						    $args   = array(
						        'instance'  => 'attachments',
						        'details'   => true
						    );
						    $mc_attachments = $mc_attachments->get_attachments( $args );
								echo '<div class="">dsdsds
											<img src="??'.$mc_attachments['attachments'][0]['src']['thumbnail']['url'].'"  width="85" height="70"/>
											</div>';
							}
				} // end switch
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
		require_once 'lib/metabox/init.php';

}

?>