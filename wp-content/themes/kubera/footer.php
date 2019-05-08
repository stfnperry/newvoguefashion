<?php
/**
 * The template for displaying the footer.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php
/**
 * kubera_before_footer hook.
 *
 */
do_action( 'kubera_before_footer' );
?>

<div <?php kubera_footer_class(); ?>>
	<?php
	/**
	 * kubera_before_footer_content hook.
	 *
	 */
	do_action( 'kubera_before_footer_content' );

	/**
	 * kubera_footer hook.
	 *
	 *
	 * @hooked kubera_construct_footer_widgets - 5
	 * @hooked kubera_construct_footer - 10
	 */
	do_action( 'kubera_footer' );

	/**
	 * kubera_after_footer_content hook.
	 *
	 */
	do_action( 'kubera_after_footer_content' );
	?>
</div><!-- .site-footer -->

<?php
/**
 * kubera_after_footer hook.
 *
 */
do_action( 'kubera_after_footer' );

wp_footer();
?>

</body>
</html>
