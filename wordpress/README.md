# The Risk Labs: WordPress theme and content fixes

This folder holds the WordPress work for the site at `therisklabc-ypsnm.wpcomstaging.com`. The React site in the rest of this repository is separate and is not changed by anything here.

| Folder | What it is |
|---|---|
| `therisklabs/` | Custom block theme. Replaces Twenty Twenty-Five. |
| `trl-content-migration/` | One-time plugin that fixes links, colours, claims and categories in the existing pages. |
| `docs/site-review.md` | Review findings and what each part of this work fixes. |
| `build.sh` | Builds the two upload zips into `dist/`. |

## What the theme does

- **Brand:** Lab Navy `#0F1B2D`, Signal Orange `#E5482C` (accents only, never body text), white. Space Grotesk for headings and Inter for body text, both self-hosted (no Google Fonts call).
- **Header:** supplied reversed logo, plus a mega menu built on the core Navigation block. Menu items can be edited in the Site Editor, and the menu is keyboard- and screen-reader-accessible. On phones it becomes a full-screen menu.
- **Footer:** logo, the tagline "Assess · Assure · Advance", all service links, the legal links and the current year.
- **Templates:** full-width page (used by your existing pages), standard page, article, article list and categories, search, and a 404 page.
- **Patterns** (in the editor's inserter under "The Risk Labs"): page hero, three feature cards, call-to-action band.
- **Existing pages:** stronger navy overlay on hero photos for readable text, and headings scaled down on phones.

## Before you start

1. **Plan:** uploading a theme or plugin on WordPress.com requires the **Business plan or higher**.
2. **Backup:** in WordPress.com, go to **Jetpack → Backup** and confirm there is a backup from today. Do **not** rely on the `.zip` backup sent for this review: it replaced every `%` with a placeholder string, and restoring from it would break the site.
3. **Build the zips:** run `bash wordpress/build.sh`, or use the zips supplied with this work.

## Deploy steps (about 20 minutes)

### Step 1: Install the theme (do not activate yet)
1. **Appearance → Themes → Add New Theme → Upload Theme**, then choose `therisklabs.zip` and click **Install Now**.
2. Click **Live Preview**. Check the home page, a service page, the Insights page and the mobile view (resize the window).

### Step 2: Run the content fixes
1. **Plugins → Add New Plugin → Upload Plugin**, choose `trl-content-migration.zip`, then **Install Now** and **Activate**.
2. Go to **Tools → TRL Content Migration**. The page lists every page that will change and each rule's match count. Nothing is saved yet.
3. Every rule should show a number. A dash means the text was not found, usually because a page was edited after this plugin was written. Check those pages manually.
4. Click **Apply changes**.
5. Open the home page, **Who we are** and **External Certification**, and check the wording.
6. If anything looks wrong, click **Restore** on the same screen. Every changed page also keeps a normal WordPress revision.

### Step 3: Activate the theme
1. **Appearance → Themes → The Risk Labs → Activate.**
2. Click through the menu: every service link should open its page without a redirect.

### Step 4: Clean up
1. Deactivate and delete **TRL Content Migration**.
2. Delete the unused **BusinessDeal** and **Assembler** themes. Keep Twenty Twenty-Five as a fallback.
3. Complete the settings checklist below.

## Settings checklist (manual, about 10 minutes)

| Setting | Where | Change to |
|---|---|---|
| Search visibility of the **staging** site | Settings → Reading | Tick "Discourage search engines" until this is the live domain |
| Comments | Settings → Discussion | Untick "Allow people to submit comments on new posts" |
| Admin email | Settings → General | A company mailbox, not Gmail |
| Two-step login | WordPress.com account → Security | On, for every admin |
| Site icon | Site Editor → Settings (or Appearance → Customize → Site Identity) | Upload `TRL_app_icon` / `app-icon-512.png` from the logo kit |
| Cookie consent | Jetpack → Settings | Turn on the cookie banner, or turn off Google Analytics, before go-live |
| Drafts and trash | Pages → Drafts / Trash | Delete the old drafts: About, What we do, Who we are, Our team, Our Perspective, GRC & Compliance, AI Security & Assurance, Cyber Risk Advisory, Technical Assurance, Hello World |

## Rollback

- **Theme:** activate Twenty Twenty-Five again. Your earlier header and footer are still saved for that theme.
- **Content:** Tools → TRL Content Migration → **Restore**, or restore a single page from its revisions.
- **Everything:** Jetpack → Backup → restore to the point before Step 1.

## Notes for maintainers and reviewers

- Menu and footer links are defined once, in `therisklabs_practices()` and `therisklabs_industries()` in `functions.php`.
- Header and footer are PHP patterns, so links use `home_url()` and the year stays current. If someone edits the header or footer in the Site Editor, WordPress saves a copy in the database and the PHP version stops being used. To return to the theme version, use **Site Editor → Patterns → Template parts → Header → Reset**.
- The content migration uses `wp_update_post( wp_slash( … ) )`, so the escaped characters in block JSON (for example `&`) survive the save. It refuses to run for users without `unfiltered_html`; otherwise WordPress would strip the `<style>` blocks on the Insights page.
- WP-CLI: `wp trl-migrate plan|apply|restore`.
- **Tested locally** on WordPress 6.7 (PHP 8.3, SQLite) with the real page content from the backup:
  - Apply → re-run (0 further changes) → restore (byte-identical original) → re-apply.
  - Block validation with `@wordpress/blocks` 15: the migration introduces no new invalid blocks.
  - Screenshots at 1440, 1024 and 390 px, with no horizontal scroll.
