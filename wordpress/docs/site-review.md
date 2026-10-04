# The Risk Labs website: review and remediation record

**Scope:** WordPress.com staging site `therisklabc-ypsnm.wpcomstaging.com`, backup taken 4 October 2026. The backup covers the installed themes, the database (35 pages and posts) and the uploads.
**Inputs:** site backup, Logo Usage Guide v1.0 (October 2026), logo kit (SVG and PNG).

## 1. Starting position

- The active theme is **Twenty Twenty-Five**. The supplied BusinessDeal theme was installed but inactive, and none of its settings were in use.
- The site's design was hand-written HTML and CSS inside the Header and Footer template parts, plus inline styles in each page.
- The site used the Geist font and a blue accent (`#0A4BFF`). Neither appears in the brand guide.

## 2. Findings and remediation

| # | Severity | Finding | Remediation | Status |
|---|---|---|---|---|
| 1 | High | Staging site is open to search engines (`blog_public=1`, launched, sitemaps on). | Settings → Reading → Discourage search engines. | Manual step (README checklist) |
| 2 | High | Credential and acceptance claims that could not be supported: firm-level PCI QSA, PCI SSLCA and "SWIFT CSP Assessor"; "reports accepted by central banks"; "QSA-led" PCI work; SOC 2 described as certification. | Reworded on 5 pages to readiness and support wording. Removed the three firm-level accreditations from the credentials list. | Fixed (migration plugin) |
| 3 | High | Insights menu linked to the "Our Perspective" and "Trust Stories" categories, which had 0 posts. | All 3 articles added to Our Perspective. New menu links to the Insights page. Empty categories show a branded "nothing yet" message with a contact link. | Fixed |
| 4 | Medium | 60 service links pointed to `/services/<service>` instead of `/services/<practice>/<service>`. WordPress redirected them (301), which costs a round trip on every click and weakens SEO. | Links rewritten in content. Header and footer generated from one site map. | Fixed |
| 5 | Medium | Header menu was hard-coded HTML with inline `onclick` handlers: not editable, no `aria-expanded`, and incompatible with a strict Content Security Policy. | Rebuilt on the core Navigation block: editable, keyboard-accessible, no inline scripts. | Fixed (theme) |
| 6 | Medium | Off-brand colours and fonts (Geist, `#0A4BFF`). Geist was loaded twice, once from Google Fonts (sending visitor IP addresses to Google). | Brand palette and self-hosted Space Grotesk and Inter in `theme.json`. 127 old colour values mapped to brand values. | Fixed |
| 7 | Medium | "NESA IAS" is the former name of the UAE Information Assurance Regulation. | Updated to "UAE IA Regulation (formerly NESA IAS)" on 4 pages. | Fixed. **Confirm the preferred naming with your regulatory lead.** |
| 8 | Medium | Hero (cover) blocks on 26 pages were written outside the editor. Their markup does not match what the editor produces, so opening these pages shows "This block contains unexpected or invalid content". | Not changed automatically. In the editor, choose **Attempt recovery** on each hero, or rebuild it with the "Page hero" pattern. | **Open: next phase** |
| 9 | Medium | Jetpack Google Analytics is on with no cookie consent. | Turn on a consent banner or turn off analytics. | Manual step |
| 10 | Low | 41 hero images load directly from Unsplash. | Navy overlay at 82% and greyscale make photos a brand-consistent texture and keep text contrast safe. Replacing them with owned imagery is recommended. | Partly fixed |
| 11 | Low | Admin email is a Gmail address. Comments are open by default. | Company mailbox with two-step login; comments off. | Manual step |
| 12 | Low | Clutter: 10 old drafts, 2 trashed pages, 188 revisions, a test form entry, unused BusinessDeal and Assembler themes. | Delete after go-live. | Manual step |

## 3. Corrections to the first review

- **The `%` placeholder** (`{6499a232…}`) is in the **backup file**, not the live site. The same string appears in content saved at different times, which points to the backup tool. Impact: never restore from that backup file. Use Jetpack Backup instead.
- **Service links** return a 301 redirect, not a 404 error. Severity lowered from High to Medium.
- **Alt text:** hero images are decorative backgrounds, so empty `alt=""` is correct under WCAG. This is not a defect.

## 4. Items for the firm to confirm

1. Team credentials still claimed on the site: CISA, CISSP, ISO 27001 Lead Auditor, ISO 42001 Lead Implementer, CEH. Each must be held by a current team member.
2. "Established 2020" and "selected US engagements through our affiliate network": keep only if you can evidence them.
3. "Engagements require clearance to work with classified systems" (Government page) states a requirement, not a claim that you hold clearance. Confirm this is the intended reading.
4. Brand guide CMYK and Pantone values are still marked "to be confirmed with printer". They are not needed for the website.
