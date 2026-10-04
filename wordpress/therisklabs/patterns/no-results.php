<?php
/**
 * Title: No results
 * Slug: therisklabs/no-results
 * Inserter: no
 *
 * @package therisklabs
 */

?>
<!-- wp:group {"className":"trl-card","style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"color":"var:preset|color|line","width":"1px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group trl-card has-border-color" style="border-color:var(--wp--preset--color--line);border-width:1px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
<!-- wp:heading {"level":2,"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html__( 'Nothing published here yet.', 'therisklabs' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"slate"} -->
<p class="has-slate-color has-text-color"><?php echo esc_html__( 'New articles and client stories are on the way. For references or a briefing on a specific regulation, contact us.', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'Contact us', 'therisklabs' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
