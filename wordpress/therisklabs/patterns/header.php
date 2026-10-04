<?php
/**
 * Title: Header
 * Slug: therisklabs/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * @package therisklabs
 */

$therisklabs_services = '';
foreach ( therisklabs_practices() as $therisklabs_practice ) {
	$therisklabs_links = '';
	foreach ( $therisklabs_practice['items'] as $therisklabs_item ) {
		$therisklabs_links .= therisklabs_nav_link( $therisklabs_item[0], $therisklabs_item[1], $therisklabs_item[2] );
	}
	$therisklabs_services .= therisklabs_nav_submenu( $therisklabs_practice['label'], $therisklabs_practice['path'], $therisklabs_links );
}

$therisklabs_industry_links = '';
foreach ( therisklabs_industries() as $therisklabs_industry ) {
	$therisklabs_industry_links .= therisklabs_nav_link( $therisklabs_industry[0], $therisklabs_industry[1] );
}
$therisklabs_industry_links .= therisklabs_nav_link( __( 'All industries', 'therisklabs' ), '/industries/' );
?>
<!-- wp:group {"tagName":"header","align":"full","className":"trl-header","backgroundColor":"contrast","textColor":"base","style":{"spacing":{"padding":{"top":"0","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"layout":{"type":"constrained"}} -->
<header class="wp-block-group alignfull trl-header has-base-color has-contrast-background-color has-text-color has-background has-link-color" style="padding-top:0;padding-bottom:0">
<!-- wp:group {"align":"wide","className":"trl-header__inner","style":{"spacing":{"padding":{"top":"1.125rem","bottom":"1.125rem"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide trl-header__inner" style="padding-top:1.125rem;padding-bottom:1.125rem">
<?php
// Block markup assembled from escaped values; see therisklabs_logo_block().
echo therisklabs_logo_block( 'reversed', 190 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>

<!-- wp:navigation {"overlayBackgroundColor":"contrast","overlayTextColor":"base","className":"trl-nav","ariaLabel":"<?php echo esc_attr__( 'Main', 'therisklabs' ); ?>","layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"0"}}} -->
<?php
// Block markup assembled from escaped values and wp_json_encode(); see therisklabs_nav_link().
echo therisklabs_nav_link( __( 'Who we are', 'therisklabs' ), '/about-us/' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo therisklabs_nav_submenu( __( 'What we do', 'therisklabs' ), '/services/', $therisklabs_services, 'trl-mega' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo therisklabs_nav_submenu( __( 'Industries', 'therisklabs' ), '/industries/', $therisklabs_industry_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo therisklabs_nav_link( __( 'Insights', 'therisklabs' ), '/insights/' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo therisklabs_nav_link( __( 'Contact us', 'therisklabs' ), '/contact/', '', 'trl-nav-cta' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>
<!-- /wp:navigation -->
</div>
<!-- /wp:group -->
</header>
<!-- /wp:group -->
