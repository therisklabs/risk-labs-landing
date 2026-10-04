<?php
/**
 * Plugin Name: TRL Content Migration
 * Description: One-time fixes for The Risk Labs content: corrects service links, maps old colours to the brand palette, rewords unverifiable credential claims, and files articles under "Our Perspective". Preview first, apply once, restore if needed. Deactivate and delete when done.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: The Risk Labs
 * License: GPL-2.0-or-later
 * Text Domain: trl-content-migration
 *
 * @package trl-content-migration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plans, applies and restores the content changes.
 */
final class TRL_Content_Migration {

	const BACKUP_META = '_trl_premigration_content';
	const NONCE       = 'trl_content_migration';
	const PAGE_SLUG   = 'trl-content-migration';

	/**
	 * Post types and statuses in scope.
	 */
	const POST_TYPES    = array( 'page', 'post' );
	const POST_STATUSES = array( 'publish', 'draft', 'pending', 'private', 'future' );

	/**
	 * Articles to file under "Our Perspective" so the Insights menu link is not empty.
	 */
	const PERSPECTIVE_POSTS = array(
		'iso-42001-vs-eu-ai-act',
		'cbuae-information-security-regulation-first-time-filers',
		'agentic-ai-red-teaming',
	);

	/**
	 * Content rules, applied in order. Each rule:
	 *  - id:      stable key shown in the report.
	 *  - label:   what the rule does, in plain words.
	 *  - type:    'text' (exact, case-sensitive) or 'regex'.
	 *  - search / replace.
	 *
	 * @return array[]
	 */
	public static function rules() {
		$rules = array();

		// 1. Service links: header, footer and pages point one level too high.
		$practices = array(
			'trust-assurance'  => array( 'controls-assurance', 'independent-audit', 'external-certification' ),
			'risk-compliance'  => array( 'risk-management', 'regulatory-compliance', 'third-party-risk-management', 'business-resilience' ),
			'enable-transform' => array( 'process-transformation', 'ai-enablement', 'data-analytics' ),
		);
		foreach ( $practices as $parent => $children ) {
			$rules[] = array(
				'id'      => 'link-' . $parent,
				'label'   => sprintf( 'Fix links to %s services', $parent ),
				'type'    => 'regex',
				'search'  => '#href="/services/(' . implode( '|', $children ) . ')/?"#',
				'replace' => 'href="/services/' . $parent . '/$1/"',
			);
		}

		// 2. Colours: old palette to brand palette. Specific accent borders first.
		$colours = array(
			array( 'border-bottom: 2px solid #0a4bff', 'border-bottom: 2px solid #E5482C', 'Accent rule lines to Signal Orange' ),
			array( '#0a4bff', '#0F1B2D', 'Off-brand blue to Lab Navy' ),
			array( '#0a0f1c', '#0F1B2D', 'Old navy to Lab Navy' ),
			array( '#6b7280', '#3A4556', 'Low-contrast grey to Slate' ),
			array( '#e5e5e5', '#E2E5EA', 'Old border grey to Line' ),
		);
		foreach ( $colours as $i => $c ) {
			$rules[] = array(
				'id'      => 'colour-' . ( $i + 1 ),
				'label'   => $c[2],
				'type'    => 'regex',
				'search'  => '#' . preg_quote( $c[0], '#' ) . '(?![0-9a-fA-F])#i',
				'replace' => $c[1],
			);
		}

		// 3. Claims: remove firm-level accreditations not held, and unprovable acceptance claims.
		$text = array(
			array( 'claim-home-lead', 'Every engagement is run by a certified lead (CISA, CISSP, PCI QSA, ISO LA, SWIFT CSP). No pyramid staffing.', 'Every engagement is led by a senior, certified practitioner (CISA, CISSP, ISO 27001 Lead Auditor). No pyramid staffing.' ),
			array( 'claim-home-evidence-title', 'Regulator-grade evidence', 'Regulator-ready evidence' ),
			array( 'claim-home-evidence', 'Our audit reports have been accepted by central banks, telecom regulators, and payment schemes across the GCC.', 'Our reports are built to the evidence standard that central banks, telecom regulators, and payment schemes across the GCC expect.' ),
			array( 'claim-about-lead', 'If you are paying for a QSA, a lead auditor, or a vCISO, that is who shows up', 'If you are paying for a lead auditor, a senior assessor, or a vCISO, that is who shows up' ),
			array( 'claim-about-evidence', 'Our reports have been accepted by regulators, acquirers, and central banks across the GCC.', 'Our reports are written to the evidence standard that regulators, acquirers, and central banks across the GCC expect.' ),
			array( 'claim-about-frameworks', 'SWIFT CSP. NESA. SAMA.', 'SWIFT CSP. UAE IA. SAMA.' ),
			array( 'claim-audit-credentials', 'CISA · ISO 27001 Lead Auditor · ISO 42001 Lead Implementer · PCI QSA · SWIFT CSP Assessor.', 'CISA · ISO 27001 Lead Auditor · ISO 42001 Lead Implementer.' ),
			array( 'claim-cert-scope', 'End-to-end certification programs for ISO, PCI DSS, SOC 2, SWIFT CSP, and emerging standards — from gap assessment to successful external audit.', 'End-to-end certification readiness for ISO, PCI DSS, SOC 2, SWIFT CSP, and emerging standards — from gap assessment through to the external audit, which is performed by an accredited certification body, QSA, or licensed CPA firm.' ),
			array( 'claim-cert-pci', 'PCI DSS v4.0.1 (QSA-led)', 'PCI DSS v4.0.1 (readiness and QSA audit support)' ),
			array( 'claim-fs-services', 'PCI QSA assessments, SWIFT CSP independent assessments, ISO 27001 certification programs,', 'PCI DSS readiness and QSA audit support, SWIFT CSP independent assessments, ISO 27001 certification readiness,' ),
			array( 'nesa-gov-intro', 'operates under NESA IAS, sector-specific regulators', 'operates under the UAE Information Assurance (IA) Regulation (formerly NESA IAS), sector-specific regulators' ),
			array( 'nesa-gov-item', 'NESA Information Assurance Standards (IAS)', 'UAE Information Assurance Regulation (formerly NESA IAS)' ),
			array( 'nesa-gov-services', 'NESA IAS gap assessments and certification,', 'UAE IA Regulation gap assessments and compliance programmes,' ),
			array( 'nesa-industries', 'NESA IAS · DESC ISR', 'UAE IA · DESC ISR' ),
			array( 'nesa-reg-intro', 'CBUAE, SAMA, NESA, DESC,', 'CBUAE, SAMA, UAE IA, DESC,' ),
			array( 'nesa-reg-item', 'NESA IAS, DESC ISR, Abu Dhabi Information Security Standards', 'UAE IA Regulation (formerly NESA IAS), DESC ISR, Abu Dhabi Information Security Standards' ),
		);
		foreach ( $text as $t ) {
			$rules[] = array(
				'id'      => $t[0],
				'label'   => 'Reword: ' . wp_trim_words( $t[1], 8, '…' ),
				'type'    => 'text',
				'search'  => $t[1],
				'replace' => $t[2],
			);
		}

		// 4. Credentials list: firm-level PCI and SWIFT accreditations removed from "Who we are".
		foreach ( array( 'PCI QSA — Qualified Security Assessor', 'SWIFT CSP Assessor', 'PCI SSLCA — Secure Software Lifecycle Assessor' ) as $i => $item ) {
			$rules[] = array(
				'id'      => 'credential-' . ( $i + 1 ),
				'label'   => 'Remove credential list item: ' . $item,
				'type'    => 'regex',
				'search'  => '#<!-- wp:list-item -->\s*<li>' . preg_quote( $item, '#' ) . '</li>\s*<!-- /wp:list-item -->\s*#u',
				'replace' => '',
			);
		}

		return $rules;
	}

	/**
	 * Apply all rules to one string.
	 *
	 * @param string $content Post content.
	 * @param array  $counts  Per-rule match counts, updated by reference.
	 * @return string
	 */
	public static function transform( $content, array &$counts ) {
		foreach ( self::rules() as $rule ) {
			$n = 0;
			if ( 'regex' === $rule['type'] ) {
				$result = preg_replace( $rule['search'], $rule['replace'], $content, -1, $n );
				if ( null === $result ) {
					continue; // Regex error: leave content unchanged for this rule.
				}
				$content = $result;
			} else {
				$content = str_replace( $rule['search'], $rule['replace'], $content, $n );
			}
			if ( $n ) {
				$counts[ $rule['id'] ] = ( isset( $counts[ $rule['id'] ] ) ? $counts[ $rule['id'] ] : 0 ) + $n;
			}
		}
		return $content;
	}

	/**
	 * Posts in scope.
	 *
	 * @return WP_Post[]
	 */
	private static function posts() {
		return get_posts(
			array(
				'post_type'        => self::POST_TYPES,
				'post_status'      => self::POST_STATUSES,
				'posts_per_page'   => -1,
				'orderby'          => 'ID',
				'order'            => 'ASC',
				'suppress_filters' => true,
			)
		);
	}

	/**
	 * Dry run: what would change, without writing anything.
	 *
	 * @return array{posts: array, totals: array, categories: array}
	 */
	public static function plan() {
		$report = array(
			'posts'      => array(),
			'totals'     => array(),
			'categories' => array(),
		);

		foreach ( self::posts() as $post ) {
			$counts  = array();
			$updated = self::transform( $post->post_content, $counts );
			if ( $updated !== $post->post_content ) {
				$report['posts'][] = array(
					'id'     => $post->ID,
					'title'  => $post->post_title,
					'counts' => $counts,
				);
				foreach ( $counts as $id => $n ) {
					$report['totals'][ $id ] = ( isset( $report['totals'][ $id ] ) ? $report['totals'][ $id ] : 0 ) + $n;
				}
			}
		}

		$term = get_term_by( 'slug', 'our-perspective', 'category' );
		foreach ( self::PERSPECTIVE_POSTS as $slug ) {
			$post = get_page_by_path( $slug, OBJECT, 'post' );
			if ( ! $post ) {
				$report['categories'][] = array( $slug, 'post not found' );
			} elseif ( ! $term ) {
				$report['categories'][] = array( $slug, 'category "our-perspective" not found' );
			} elseif ( has_term( $term->term_id, 'category', $post ) ) {
				$report['categories'][] = array( $slug, 'already in Our Perspective' );
			} else {
				$report['categories'][] = array( $slug, 'will be added to Our Perspective' );
			}
		}

		return $report;
	}

	/**
	 * Apply the changes. Original content is kept in post meta and as a revision.
	 *
	 * @return array|WP_Error Plan that was applied, or an error.
	 */
	public static function apply() {
		// Saving without unfiltered_html would strip the <style> blocks some pages rely on.
		if ( ! current_user_can( 'unfiltered_html' ) && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			return new WP_Error( 'trl_no_unfiltered_html', 'Your account cannot save unfiltered HTML, so WordPress would strip parts of the pages. Run this as a site administrator.' );
		}
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			kses_remove_filters();
		}

		$plan = self::plan();

		foreach ( $plan['posts'] as $row ) {
			$post   = get_post( $row['id'] );
			$counts = array();
			$new    = self::transform( $post->post_content, $counts );

			if ( '' === get_post_meta( $post->ID, self::BACKUP_META, true ) ) {
				// add_post_meta() unslashes its input; slash so block JSON escapes survive.
				add_post_meta( $post->ID, self::BACKUP_META, wp_slash( $post->post_content ), true );
			}

			$result = wp_update_post(
				wp_slash(
					array(
						'ID'           => $post->ID,
						'post_content' => $new,
					)
				),
				true
			);
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}

		$term = get_term_by( 'slug', 'our-perspective', 'category' );
		if ( $term ) {
			foreach ( self::PERSPECTIVE_POSTS as $slug ) {
				$post = get_page_by_path( $slug, OBJECT, 'post' );
				if ( $post ) {
					wp_set_post_terms( $post->ID, array( (int) $term->term_id ), 'category', true );
				}
			}
		}

		update_option( 'trl_content_migration_applied', gmdate( 'c' ), false );
		return $plan;
	}

	/**
	 * Put back the content saved before the migration. Category additions are not undone.
	 *
	 * @return int|WP_Error Number of posts restored.
	 */
	public static function restore() {
		if ( ! current_user_can( 'unfiltered_html' ) && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			return new WP_Error( 'trl_no_unfiltered_html', 'Run restore as a site administrator.' );
		}
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			kses_remove_filters();
		}

		$ids = get_posts(
			array(
				'post_type'      => self::POST_TYPES,
				'post_status'    => self::POST_STATUSES,
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => self::BACKUP_META, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			)
		);

		$restored = 0;
		foreach ( $ids as $id ) {
			$original = get_post_meta( $id, self::BACKUP_META, true );
			$result   = wp_update_post(
				wp_slash(
					array(
						'ID'           => $id,
						'post_content' => $original,
					)
				),
				true
			);
			if ( is_wp_error( $result ) ) {
				return $result;
			}
			delete_post_meta( $id, self::BACKUP_META );
			++$restored;
		}

		delete_option( 'trl_content_migration_applied' );
		return $restored;
	}

	/* ------------------------------------------------------------------ */
	/* Admin screen: Tools > TRL Content Migration                         */
	/* ------------------------------------------------------------------ */

	/**
	 * Register hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_post_trl_migration', array( __CLASS__, 'handle_post' ) );
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::add_command( 'trl-migrate', 'TRL_Content_Migration_CLI' );
		}
	}

	/**
	 * Add the Tools page.
	 */
	public static function menu() {
		add_management_page( 'TRL Content Migration', 'TRL Content Migration', 'manage_options', self::PAGE_SLUG, array( __CLASS__, 'render' ) );
	}

	/**
	 * Handle Apply / Restore form posts.
	 */
	public static function handle_post() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to do this.', 'trl-content-migration' ), 403 );
		}
		check_admin_referer( self::NONCE );

		$action = isset( $_POST['trl_action'] ) ? sanitize_key( wp_unslash( $_POST['trl_action'] ) ) : '';
		if ( 'apply' === $action ) {
			$result  = self::apply();
			$message = is_wp_error( $result ) ? 'error:' . $result->get_error_message() : 'applied';
		} elseif ( 'restore' === $action ) {
			$result  = self::restore();
			$message = is_wp_error( $result ) ? 'error:' . $result->get_error_message() : 'restored:' . (int) $result;
		} else {
			$message = 'error:Unknown action.';
		}

		set_transient( 'trl_migration_notice_' . get_current_user_id(), $message, 60 );
		wp_safe_redirect( admin_url( 'tools.php?page=' . self::PAGE_SLUG ) );
		exit;
	}

	/**
	 * Render the Tools page.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$notice_key = 'trl_migration_notice_' . get_current_user_id();
		$notice     = get_transient( $notice_key );
		delete_transient( $notice_key );

		$plan    = self::plan();
		$rules   = self::rules();
		$applied = get_option( 'trl_content_migration_applied' );
		$backups = count(
			get_posts(
				array(
					'post_type'      => self::POST_TYPES,
					'post_status'    => self::POST_STATUSES,
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_key'       => self::BACKUP_META, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				)
			)
		);
		?>
		<div class="wrap">
			<h1>TRL Content Migration</h1>
			<?php if ( $notice ) : ?>
				<?php $is_error = 0 === strpos( $notice, 'error:' ); ?>
				<div class="notice <?php echo esc_attr( $is_error ? 'notice-error' : 'notice-success' ); ?>"><p>
					<?php
					if ( $is_error ) {
						echo esc_html( substr( $notice, 6 ) );
					} elseif ( 'applied' === $notice ) {
						esc_html_e( 'Changes applied. Check the pages, then deactivate and delete this plugin.', 'trl-content-migration' );
					} else {
						/* translators: %d: number of posts. */
						echo esc_html( sprintf( __( 'Restored %d posts to their pre-migration content.', 'trl-content-migration' ), (int) substr( $notice, 9 ) ) );
					}
					?>
				</p></div>
			<?php endif; ?>

			<p>This page shows what will change. Nothing is saved until you press <strong>Apply changes</strong>. Each changed page keeps its old version (as a revision and in a backup field), so you can restore it.</p>
			<?php if ( $applied ) : ?>
				<p><strong>Last applied:</strong> <?php echo esc_html( $applied ); ?> (UTC)</p>
			<?php endif; ?>

			<h2>Pages and posts that will change (<?php echo (int) count( $plan['posts'] ); ?>)</h2>
			<?php if ( ! $plan['posts'] ) : ?>
				<p>Nothing to change. The fixes are already in place.</p>
			<?php else : ?>
				<table class="widefat striped">
					<thead><tr><th>Page or post</th><th>Changes</th></tr></thead>
					<tbody>
					<?php foreach ( $plan['posts'] as $row ) : ?>
						<tr>
							<td><a href="<?php echo esc_url( get_edit_post_link( $row['id'] ) ); ?>"><?php echo esc_html( $row['title'] ); ?></a></td>
							<td><?php echo esc_html( implode( ', ', array_map( static function ( $id, $n ) { return $id . ' ×' . $n; }, array_keys( $row['counts'] ), $row['counts'] ) ) ); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

			<h2>Rules</h2>
			<table class="widefat striped">
				<thead><tr><th>Rule</th><th>What it does</th><th>Matches</th></tr></thead>
				<tbody>
				<?php foreach ( $rules as $rule ) : ?>
					<tr>
						<td><code><?php echo esc_html( $rule['id'] ); ?></code></td>
						<td><?php echo esc_html( $rule['label'] ); ?></td>
						<td><?php echo isset( $plan['totals'][ $rule['id'] ] ) ? (int) $plan['totals'][ $rule['id'] ] : '—'; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="description">A dash means the text was not found: either the fix is already applied, or the page wording has changed since this plugin was written.</p>

			<h2>Categories</h2>
			<ul>
				<?php foreach ( $plan['categories'] as $c ) : ?>
					<li><code><?php echo esc_html( $c[0] ); ?></code>: <?php echo esc_html( $c[1] ); ?></li>
				<?php endforeach; ?>
			</ul>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline-block;margin-right:1em">
				<?php wp_nonce_field( self::NONCE ); ?>
				<input type="hidden" name="action" value="trl_migration">
				<input type="hidden" name="trl_action" value="apply">
				<?php submit_button( 'Apply changes', 'primary', 'submit', false, $plan['posts'] ? array() : array( 'disabled' => 'disabled' ) ); ?>
			</form>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline-block" onsubmit="return confirm('Restore all changed pages to their content before the migration?');">
				<?php wp_nonce_field( self::NONCE ); ?>
				<input type="hidden" name="action" value="trl_migration">
				<input type="hidden" name="trl_action" value="restore">
				<?php submit_button( sprintf( 'Restore %d pages', $backups ), 'secondary', 'submit', false, $backups ? array() : array( 'disabled' => 'disabled' ) ); ?>
			</form>
		</div>
		<?php
	}
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	/**
	 * Run The Risk Labs content migration from WP-CLI.
	 */
	class TRL_Content_Migration_CLI {

		/**
		 * Show what would change.
		 *
		 * @subcommand plan
		 */
		public function plan() {
			$plan = TRL_Content_Migration::plan();
			foreach ( $plan['posts'] as $row ) {
				WP_CLI::log( sprintf( '#%d %s: %s', $row['id'], $row['title'], wp_json_encode( $row['counts'] ) ) );
			}
			foreach ( $plan['categories'] as $c ) {
				WP_CLI::log( $c[0] . ': ' . $c[1] );
			}
			WP_CLI::success( count( $plan['posts'] ) . ' posts would change.' );
		}

		/**
		 * Apply the changes.
		 *
		 * @subcommand apply
		 */
		public function apply() {
			$result = TRL_Content_Migration::apply();
			if ( is_wp_error( $result ) ) {
				WP_CLI::error( $result->get_error_message() );
			}
			WP_CLI::success( count( $result['posts'] ) . ' posts updated.' );
		}

		/**
		 * Restore pre-migration content.
		 *
		 * @subcommand restore
		 */
		public function restore() {
			$result = TRL_Content_Migration::restore();
			if ( is_wp_error( $result ) ) {
				WP_CLI::error( $result->get_error_message() );
			}
			WP_CLI::success( $result . ' posts restored.' );
		}
	}
}

TRL_Content_Migration::init();
