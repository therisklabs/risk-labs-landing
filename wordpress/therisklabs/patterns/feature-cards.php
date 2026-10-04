<?php
/**
 * Title: Three feature cards
 * Slug: therisklabs/feature-cards
 * Categories: therisklabs, featured
 * Description: Section heading with three bordered cards, each with a title, text and link.
 *
 * @package therisklabs
 */

$therisklabs_card = static function ( $title, $text ) {
	return sprintf(
		'<!-- wp:column {"className":"trl-card"} --><div class="wp-block-column trl-card"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="wp-block-heading has-large-font-size">%1$s</h3><!-- /wp:heading --><!-- wp:paragraph {"textColor":"slate","fontSize":"small"} --><p class="has-slate-color has-text-color has-small-font-size">%2$s</p><!-- /wp:paragraph --></div><!-- /wp:column -->',
		esc_html( $title ),
		esc_html( $text )
	);
};
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"className":"trl-eyebrow trl-eyebrow--accent"} -->
<p class="trl-eyebrow trl-eyebrow--accent"><?php echo esc_html__( 'Why clients choose us', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Section headline.', 'therisklabs' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"},"margin":{"top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--40)">
<?php
// The helper escapes both values.
echo $therisklabs_card( __( 'Senior-led', 'therisklabs' ), __( 'Every engagement is led by a senior, certified practitioner.', 'therisklabs' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $therisklabs_card( __( 'Evidence-first', 'therisklabs' ), __( 'Every finding traces to a control, a test, or a document.', 'therisklabs' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $therisklabs_card( __( 'Built for the GCC', 'therisklabs' ), __( 'We work in the standards your regulator reads.', 'therisklabs' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
