<?php
/**
 * Title: Footer
 * Slug: therisklabs/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package therisklabs
 */

/**
 * List block markup for a set of links.
 *
 * @param array $links List of array( label, path ).
 * @return string Block markup with escaped values.
 */
$therisklabs_list = static function ( $links ) {
	$out = '<!-- wp:list {"className":"trl-footer__list"} --><ul class="wp-block-list trl-footer__list">';
	foreach ( $links as $link ) {
		$out .= sprintf(
			'<!-- wp:list-item --><li><a href="%1$s">%2$s</a></li><!-- /wp:list-item -->',
			esc_url( home_url( $link[1] ) ),
			esc_html( $link[0] )
		);
	}
	return $out . '</ul><!-- /wp:list -->';
};

$therisklabs_heading = static function ( $label, $path ) {
	return sprintf(
		'<!-- wp:heading {"level":2,"className":"trl-footer__heading"} --><h2 class="wp-block-heading trl-footer__heading"><a href="%1$s">%2$s</a></h2><!-- /wp:heading -->',
		esc_url( home_url( $path ) ),
		esc_html( $label )
	);
};
?>
<!-- wp:group {"tagName":"footer","align":"full","className":"trl-footer","backgroundColor":"contrast","textColor":"contrast-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"},"margin":{"top":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"layout":{"type":"constrained"}} -->
<footer class="wp-block-group alignfull trl-footer has-contrast-2-color has-contrast-background-color has-text-color has-background has-link-color" style="margin-top:0;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)">
<!-- wp:columns {"align":"wide","className":"trl-footer__columns","style":{"spacing":{"blockGap":{"top":"2.5rem","left":"2.5rem"}}}} -->
<div class="wp-block-columns alignwide trl-footer__columns">
<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%">
<?php
// Block markup assembled from escaped values; see therisklabs_logo_block().
echo therisklabs_logo_block( 'reversed', 180 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>

<!-- wp:paragraph {"className":"trl-footer__tagline"} -->
<p class="trl-footer__tagline"><?php echo esc_html__( 'Assess · Assure · Advance', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html__( 'Cyber and AI assurance for regulated business.', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html__( 'Abu Dhabi · Dubai · Riyadh · Doha', 'therisklabs' ); ?><br><a href="mailto:hello@therisklabs.com">hello@therisklabs.com</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<?php foreach ( therisklabs_practices() as $therisklabs_practice ) : ?>
<!-- wp:column -->
<div class="wp-block-column">
	<?php
	$therisklabs_links = array();
	foreach ( $therisklabs_practice['items'] as $therisklabs_item ) {
		$therisklabs_links[] = array( $therisklabs_item[0], $therisklabs_item[1] );
	}
	// Both helpers escape every value they output.
	echo $therisklabs_heading( $therisklabs_practice['label'], $therisklabs_practice['path'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $therisklabs_list( $therisklabs_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
</div>
<!-- /wp:column -->
<?php endforeach; ?>

<!-- wp:column -->
<div class="wp-block-column">
	<?php
	echo $therisklabs_heading( __( 'Firm', 'therisklabs' ), '/about-us/' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $therisklabs_list( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		array(
			array( __( 'Who we are', 'therisklabs' ), '/about-us/' ),
			array( __( 'Industries', 'therisklabs' ), '/industries/' ),
			array( __( 'Insights', 'therisklabs' ), '/insights/' ),
			array( __( 'Contact', 'therisklabs' ), '/contact/' ),
		)
	);
	?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","className":"trl-footer__legal","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"padding":{"top":"1.5rem"}},"border":{"top":{"color":"var:preset|color|navy-raised","width":"1px"}}},"fontSize":"x-small","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide trl-footer__legal has-x-small-font-size" style="border-top-color:var(--wp--preset--color--navy-raised);border-top-width:1px;margin-top:var(--wp--preset--spacing--50);padding-top:1.5rem">
<!-- wp:paragraph -->
<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html__( 'The Risk Labs. All rights reserved.', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>"><?php echo esc_html__( 'Privacy Notice', 'therisklabs' ); ?></a> · <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php echo esc_html__( 'Terms of Use', 'therisklabs' ); ?></a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</footer>
<!-- /wp:group -->
