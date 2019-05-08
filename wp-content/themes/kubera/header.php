<?php
/**
 * The template for displaying the header.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php kubera_body_schema();?> <?php body_class(); ?>>
	<?php
	/**
	 * kubera_before_header hook.
	 *
	 *
	 * @hooked kubera_do_skip_to_content_link - 2
	 * @hooked kubera_top_bar - 5
	 * @hooked kubera_add_navigation_before_header - 5
	 */
	do_action( 'kubera_before_header' );

	/**
	 * kubera_header hook.
	 *
	 *
	 * @hooked kubera_construct_header - 10
	 */
	do_action( 'kubera_header' );

	/**
	 * kubera_after_header hook.
	 *
	 *
	 * @hooked kubera_featured_page_header - 10
	 */
	do_action( 'kubera_after_header' );
	?>

	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">
			<?php
			/**
			 * kubera_inside_container hook.
			 *
			 */
			do_action( 'kubera_inside_container' );
