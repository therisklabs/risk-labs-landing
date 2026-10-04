<?php
/**
 * Title: Page hero (navy)
 * Slug: therisklabs/page-hero
 * Categories: therisklabs, banner
 * Description: Navy hero with eyebrow, headline, lead text and two buttons. No photo, so text contrast is always safe.
 *
 * @package therisklabs
 */

?>
<!-- wp:group {"align":"full","className":"trl-band trl-bracket","backgroundColor":"contrast","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull trl-band trl-bracket has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:paragraph {"className":"trl-eyebrow"} -->
<p class="trl-eyebrow"><?php echo esc_html__( 'Practice area', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php echo esc_html__( 'A clear, specific headline.', 'therisklabs' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"contrast-2","fontSize":"large"} -->
<p class="has-contrast-2-color has-text-color has-large-font-size"><?php echo esc_html__( 'One or two sentences on the outcome the client gets.', 'therisklabs' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"contrast"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-contrast-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'Start a conversation', 'therisklabs' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","textColor":"base"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-base-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php echo esc_html__( 'See what we do', 'therisklabs' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
