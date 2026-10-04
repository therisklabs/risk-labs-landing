<?php
/**
 * The Risk Labs theme functions.
 *
 * @package therisklabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THERISKLABS_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function therisklabs_setup() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
	add_theme_support( 'responsive-embeds' );

	// Block themes get core pattern suggestions by default; this site uses its own patterns.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'therisklabs_setup' );

/**
 * Front-end stylesheet for components theme.json cannot express
 * (mega menu, header, cards, focus states).
 */
function therisklabs_enqueue_assets() {
	wp_enqueue_style(
		'therisklabs',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		THERISKLABS_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'therisklabs_enqueue_assets' );

/**
 * Preload the two variable fonts used above the fold.
 */
function therisklabs_preload_fonts() {
	$fonts = array(
		'assets/fonts/space-grotesk-latin-wght-normal.woff2',
		'assets/fonts/inter-latin-wght-normal.woff2',
	);
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( $font ) )
		);
	}
}
add_action( 'wp_head', 'therisklabs_preload_fonts', 1 );

/**
 * Brand favicons when no Site Icon is set in Site Editor > Settings.
 */
function therisklabs_favicons() {
	if ( has_site_icon() ) {
		return;
	}
	printf(
		'<link rel="icon" href="%1$s" type="image/svg+xml">' . "\n" .
		'<link rel="icon" href="%2$s" sizes="32x32" type="image/png">' . "\n" .
		'<link rel="apple-touch-icon" href="%3$s">' . "\n",
		esc_url( get_theme_file_uri( 'assets/images/TRL_icon_colour_small.svg' ) ),
		esc_url( get_theme_file_uri( 'assets/images/favicon-32.png' ) ),
		esc_url( get_theme_file_uri( 'assets/images/app-icon-180.png' ) )
	);
}
add_action( 'wp_head', 'therisklabs_favicons', 2 );

/**
 * Drop the emoji detection script and styles: an extra request and inline
 * script on every page, not needed for this site.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Pattern category for the theme's own section patterns.
 */
function therisklabs_pattern_categories() {
	register_block_pattern_category(
		'therisklabs',
		array( 'label' => __( 'The Risk Labs', 'therisklabs' ) )
	);
}
add_action( 'init', 'therisklabs_pattern_categories' );

/**
 * Site map shared by the header mega menu and the footer, so links are
 * defined once. Paths match the live page hierarchy.
 *
 * @return array
 */
function therisklabs_practices() {
	return array(
		array(
			'label' => __( 'Trust & Assurance', 'therisklabs' ),
			'path'  => '/services/trust-assurance/',
			'items' => array(
				array( __( 'Controls Assurance', 'therisklabs' ), '/services/trust-assurance/controls-assurance/', __( 'Design and testing of business, technology and digital control frameworks.', 'therisklabs' ) ),
				array( __( 'Independent Audit', 'therisklabs' ), '/services/trust-assurance/independent-audit/', __( 'Objective evaluation of governance, risk and control for effectiveness and maturity.', 'therisklabs' ) ),
				array( __( 'External Certification', 'therisklabs' ), '/services/trust-assurance/external-certification/', __( 'Readiness for ISO, SOC 2, PCI DSS and NIST certification and attestation.', 'therisklabs' ) ),
			),
		),
		array(
			'label' => __( 'Risk & Compliance', 'therisklabs' ),
			'path'  => '/services/risk-compliance/',
			'items' => array(
				array( __( 'Risk Management', 'therisklabs' ), '/services/risk-compliance/risk-management/', __( 'Enterprise, technology, cyber and privacy risk assessment and treatment.', 'therisklabs' ) ),
				array( __( 'Regulatory Compliance', 'therisklabs' ), '/services/risk-compliance/regulatory-compliance/', __( 'Programmes aligned to local and global regulation and industry standards.', 'therisklabs' ) ),
				array( __( 'Third-Party Risk Management', 'therisklabs' ), '/services/risk-compliance/third-party-risk-management/', __( 'Vendor due diligence, onboarding, monitoring and remediation.', 'therisklabs' ) ),
				array( __( 'Business Resilience', 'therisklabs' ), '/services/risk-compliance/business-resilience/', __( 'Business continuity, disaster recovery and operational resilience.', 'therisklabs' ) ),
			),
		),
		array(
			'label' => __( 'Enable & Transform', 'therisklabs' ),
			'path'  => '/services/enable-transform/',
			'items' => array(
				array( __( 'Process Transformation', 'therisklabs' ), '/services/enable-transform/process-transformation/', __( 'Security and compliance processes redesigned for efficiency and scale.', 'therisklabs' ) ),
				array( __( 'AI Enablement', 'therisklabs' ), '/services/enable-transform/ai-enablement/', __( 'AI governance, security and assurance: ISO 42001, EU AI Act, AI red teaming.', 'therisklabs' ) ),
				array( __( 'Data & Analytics', 'therisklabs' ), '/services/enable-transform/data-analytics/', __( 'Risk telemetry, control effectiveness measurement and continuous audit.', 'therisklabs' ) ),
			),
		),
	);
}

/**
 * Industry pages.
 *
 * @return array List of array( label, path ).
 */
function therisklabs_industries() {
	return array(
		array( __( 'Financial Services', 'therisklabs' ), '/industries/financial-services/' ),
		array( __( 'Government & Public Sector', 'therisklabs' ), '/industries/government/' ),
		array( __( 'Healthcare', 'therisklabs' ), '/industries/healthcare/' ),
		array( __( 'Gaming & Lottery', 'therisklabs' ), '/industries/gaming/' ),
	);
}

/**
 * Serialise a navigation link block.
 *
 * @param string $label       Link text.
 * @param string $path        Site-relative path.
 * @param string $description Optional description shown in the mega menu.
 * @param string $class_name  Optional extra class.
 * @return string Block markup.
 */
function therisklabs_nav_link( $label, $path, $description = '', $class_name = '' ) {
	$attrs = array(
		'label' => $label,
		'url'   => home_url( $path ),
		'kind'  => 'custom',
	);
	if ( $description ) {
		$attrs['description'] = $description;
	}
	if ( $class_name ) {
		$attrs['className'] = $class_name;
	}
	return '<!-- wp:navigation-link ' . wp_json_encode( $attrs ) . ' /-->' . "\n";
}

/**
 * Serialise a navigation submenu block around already-serialised children.
 *
 * @param string $label      Link text.
 * @param string $path       Site-relative path.
 * @param string $children   Inner block markup.
 * @param string $class_name Optional extra class.
 * @return string Block markup.
 */
function therisklabs_nav_submenu( $label, $path, $children, $class_name = '' ) {
	$attrs = array(
		'label' => $label,
		'url'   => home_url( $path ),
		'kind'  => 'custom',
	);
	if ( $class_name ) {
		$attrs['className'] = $class_name;
	}
	return '<!-- wp:navigation-submenu ' . wp_json_encode( $attrs ) . ' -->' . "\n" . $children . '<!-- /wp:navigation-submenu -->' . "\n";
}

/**
 * Logo as a core Image block, so it can be swapped in the Site Editor.
 *
 * @param string $variant 'reversed' (on navy) or 'colour' (on white).
 * @param int    $width   Rendered width in px; never below the 120px brand minimum.
 * @return string Block markup.
 */
function therisklabs_logo_block( $variant = 'reversed', $width = 190 ) {
	$file  = 'reversed' === $variant ? 'TRL_logo_horizontal_reversed.svg' : 'TRL_logo_horizontal_colour.svg';
	$width = max( 120, (int) $width );
	$attrs = array(
		'width'           => $width . 'px',
		'sizeSlug'        => 'full',
		'linkDestination' => 'custom',
		'className'       => 'trl-logo',
	);

	return '<!-- wp:image ' . wp_json_encode( $attrs ) . ' -->' . "\n" . sprintf(
		'<figure class="wp-block-image size-full is-resized trl-logo"><a href="%1$s"><img src="%2$s" alt="%3$s" style="width:%4$dpx"/></a></figure>',
		esc_url( home_url( '/' ) ),
		esc_url( get_theme_file_uri( 'assets/images/' . $file ) ),
		esc_attr__( 'The Risk Labs', 'therisklabs' ),
		$width
	) . "\n" . '<!-- /wp:image -->';
}
