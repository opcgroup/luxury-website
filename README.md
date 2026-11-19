# Luxury Website v1.3.3 — WordPress Theme

**A customizable real estate WordPress theme**, with one-click visual presets, a visual Gutenberg page builder, block-level motion presets, built-in on-page SEO and public GitHub Releases updates.

Original design system informed by Utopia New Chandigarh, OPC Group, and Ecocity New Chandigarh. This theme is not a clone and contains no copied property photos, logos or copyright-protected website assets.

## System Requirements

WordPress **6.2+**, PHP **7.4+** (PHP 8.1+ recommended), HTTPS. Use a staging site and back up first.

## Install or upgrade

- Fresh: **Appearance → Themes → Add New → Upload Theme**, select `luxury-website-v1.3.1.zip`, Install, Activate.
- Existing v1.0.0, v1.1.0 or v1.2.0: Back up the site first, upload v1.3.0 via the same path, then **Replace current with uploaded**. Theme settings, pages, posts and custom post meta are stored in your WordPress database and are not intentionally reset during upgrade.
- WordPress website options: **Appearance → Luxury Website** (Header Builder, Design & Motion, Homepage, Contact, SEO Settings, GitHub Updates).

## Feature summary

### 1. Switch the site's appearance in one click

Choose from three original palettes/layout treatments:

- **Utopia — Editorial Luxury**: charcoal, champagne gold, split hero, elegant typography.
- **OPC — Premium Corporate**: navy, rich accent, property-focused cards and filters.
- **Ecocity — Green Estate**: forest green, organic corners and light estate colours.

Presets update theme-controlled CSS settings while keeping project data, menus and images. Third-party Elementor content with hardcoded styling is not forcibly rewritten.

### 2. Header Designer

Drag, move and remove logo, navigation, contact phone/email, CTA, WhatsApp, search, social links, site tagline, toggle and spacer across top/middle/bottom desktop rows and a separate mobile header. Change sticky/transparent options, colours, logo height, padding, gaps, sizes and menu spacing without editing code.

### 3. Build pages without code

**Pages → Add New → Block Editor (+) → search `Luxury`**.

Specialized blocks: **Luxury Hero, Luxury Section, Feature Card, Statistic, Testimonial, Property Grid, FAQ, Call to Action**. Combine them with core Gutenberg Columns, Gallery, Cover, Image, Paragraph, Buttons and Videos. A ready-to-use **Luxury Landing Page** editor pattern is included.

Every compatible block exposes **Luxury Animation & Hover** in its Block settings with 12 entrance choices, 6 hover effects, 4 looping effects, delay, duration, repeat-on-scroll and mobile disable. Animations use native browser capabilities and respect the visitor's reduced-motion preference. Preview motion on the front-end.

For custom Gutenberg homepages, **Settings → Reading → Your homepage displays → A static page**. A selected homepage containing `luxury/*` blocks is displayed using its custom content. For non-Luxury Gutenberg homepages, enable **Use WordPress Page Content as Homepage** in theme options.

### 4. Built-in SEO

At **Appearance → Luxury Website → SEO Settings**, edit homepage SEO Title, Meta Description, Related Keywords and Social Share Image. There are also project archive SEO fields.

At each **Page / Post / Project editor** open the **Luxury SEO** right-hand sidebar, or use the **Luxury SEO** meta box in classic editor. Fields include SEO Title, Meta Description, Focus Keyword, Related Keywords, Canonical URL, Noindex, Nofollow and Social Share Image.

Also supports category, tag and project-type term metadata from their edit screens. The theme can output SEO title, description, robots, canonical, Open Graph, Twitter card and basic schema JSON-LD. WordPress native XML sitemap is used; the theme does not create a second sitemap.

**Google does not use meta keywords for ranking.** Related and focus keyword fields primarily help editors. Legacy meta keywords output is optional and OFF by default. No ranking or indexing guarantee is made.

If common SEO plugins such as Yoast, Rank Math, AIOSEO or SEOPress are active, Luxury Website suppresses its own SEO tags to avoid duplication. Use one SEO source at a time.

### 5. GitHub Updates (public repo)

1. Create a **public GitHub repository** for the theme source.
2. Push the source files, including `.github/workflows/release.yml`, into the repository root.
3. **Appearance → Luxury Website → GitHub Updates** → set `OWNER/REPO` → Save.
4. When you publish new code, change both `style.css` Version and `LW_VERSION` in `functions.php`, commit, and push a version tag (e.g. `v1.2.0`).
5. Included GitHub Actions workflow publishes a **GitHub Release** with a ZIP asset like `luxury-website-v1.2.0.zip`, packaged with exactly one `luxury-website/` top-level folder.
6. WordPress **Dashboard → Updates** checks GitHub for new Releases; optionally switch on WordPress theme auto-updates once you have reliable backups.

A repo has **not** been connected or uploaded by the theme ZIP itself. This version supports public release assets only, not private repositories. Read `docs/SEO-AND-UPDATES.md` for details.

### 6. Property Project Module

Add new properties via **Properties → Add Property / Project**. Enter location, configuration, area, price, status, developer, RERA, brochure and maps; set featured images and Project Types. Use the `Luxury Property Grid` block or `[luxury_projects count="6" type="residential"]` shortcode. Lead form shortcode: `[luxury_contact_form]`.

### 7. Leads and contact

The native enquiry form verifies a nonce, sanitizes input and sends notification by `wp_mail`. It does not store personal leads in WP. Configure a verified SMTP provider and confirm live delivery. WhatsApp and CTA links are customizable.

## Production limitations and safeguards

- PHP + JS files were syntax checked during packaging, **but this build was not installed and browser-tested on your WordPress site**. Test on staging before enabling for customers.
- Do not claim real estate projects, pricing, RERA approvals or amenities are verified until you check official sources and replace theme placeholder content.
- Custom page builders and Elementor widgets with independent CSS may not respond to preset styling or Luxury block animation panels.
- SEO plugin conflicts are minimized by suppression, but validate generated `<head>` metadata when migrating from existing SEO plugins.
- GitHub access depends on public GitHub API reachability, repository URL, current WordPress update checks and correctly formatted release ZIPs.
- Theme-level Projects post type is portable only if registered elsewhere before switching to a different theme. Posts remain in the database if theme is deactivated.

License: GPL-2.0-or-later. Copyright 2026 Luxury Website Studio. Bundled SVG illustrations are original.

---

## v1.2.0: Real Estate Portal Upgrade (19 November 2026)

The theme is specifically designed for **real estate websites**, including individual project landing pages and multi-project listing portals. This release extends the earlier one-click theme presets, Header Builder, Gutenberg drag-and-drop page builder, no-code animations, built-in SEO and public GitHub Releases updater.

### Real estate directory and filtering

- **Properties → Add Property / Project:** create listings for flats, high-rise apartments, villas, independent floors, plots, commercial spaces or townships.
- **Properties → Property Types:** define your types such as Apartments, Plots, Villas, Independent Floors and Commercial.
- **Properties → Cities / Localities:** define locations like New Chandigarh, Mohali, Zirakpur, Kharar or Chandigarh. Names are only examples; no sample project claims are imported.
- `/projects/`: responsive searchable directory with filters for keyword, property type, city/locality, New Launch/Resale/Rental and numeric min/max budget.
- For reliable **budget filtering**, enter the **Numeric price in INR** field for every property you want matched. Prices entered only in the display text field cannot be numerically filtered. Filters run server-side and support pagination.
- Homepage has a compact property search panel beneath the hero.
- Add a search anywhere with `[luxury_property_search]` or compact mode `[luxury_property_search compact="yes"]`.

### Property details

Each property supports its own cover photo, additional WordPress Media Library gallery, status, listing category, BHK, size, parking, furnishing, bathrooms, developer, possession, RERA number, amenities, brochure, floor-plan URL, map URL and walkthrough video URL. The public property detail page shows a property summary sidebar and **project-specific enquiry form**, plus a prefilled WhatsApp enquiry link (configure WhatsApp number first).

The enquiry handler emails you a verified property title and URL with the lead data. Enquiries are not saved in a CRM/database. SMTP delivery testing is required on your hosting.

Shortcodes:

```
[luxury_projects count="6"]
[luxury_projects count="6" type="apartments"]
[luxury_projects count="6" featured="yes"]
[luxury_property_search]
[luxury_property_search compact="yes"]
[luxury_contact_form]
```

### Upgrade notes

Upgrade v1.1.0 → **v1.2.0** with the normal WordPress Replace Current Theme option (after backup), or via a correctly configured GitHub release. Theme folder/slug remains `luxury-website`, so existing options and property content are retained. The former Projects menu is now called **Properties**, and a new **Cities / Localities** taxonomy is available. Existing projects still work; new optional fields will initially be blank.

After updating, go to **Settings → Permalinks → Save Changes** if `/projects/` or location taxonomy URLs give 404 errors. The GitHub updater is included but is **not live** until you create a public GitHub repository, set its `OWNER/REPO` in theme options, and publish matching versioned Releases.

**Production caution:** PHP/JS syntax and ZIP packaging can be validated offline, but a real WordPress installation, plugin interoperability, SMTP, CDN, caching and browser/device testing must be completed on a staging site before a production rollout. Real project prices, amenities and RERA details must be verified and published by the site owner.

---

## v1.3.0 — Inner Pages Visual Builder (19 November 2026)

**What changed:** Inner pages no longer have to use the original generic narrow page layout. The homepage (`front-page.php`) was **not redesigned**.

### Create an attractive About / Location / Floor Plans / Contact / Projects page

1. **WordPress Dashboard → Pages → Add New** (or edit an existing page).
2. Open the right settings sidebar and expand **Luxury Page Design**. Choose **Full Width** to place full-width sections; set **Top Title Banner → Hide** when using one of the ready-made page templates with its own hero heading. You can also choose Standard/Wide/Narrow and a solid/gradient/featured-image title banner.
3. Click **+ Block Inserter → Patterns → Luxury Inner Pages**. Pick a full-page design: **About Us, Single Project Landing, Location & Connectivity, Floor Plans & Prices, Amenities & Specifications, Photo Gallery, Contact & Enquiry, Real Estate Services, FAQ & Buyer Information**. Two drop-in sections are available: 3 Property Benefits and Enquiry Call to Action.
4. Use **List View** (three horizontal lines in the upper editor toolbar) to drag, move, duplicate or delete sections. Click a text area to edit wording. Replace photo placeholders with WordPress Image, Cover or Gallery blocks. Use the **Styles** tab on Group, Image, Columns and Button blocks for custom looks.
5. Select a block, expand **Luxury Animation & Hover** to choose fade/slide/zoom, scroll effect timing, hover motion and mobile settings.
6. Preview desktop/tablet/mobile in the editor, then **Publish**.

### Alternate page templates

In the Page's **Template** selector, choose **Luxury Full Width** or **Luxury Landing (No Title Banner)**. These are real PHP page templates located under `/templates/`; page-specific sidebar settings are preferred for finer control.

### Important

- These are ready-made **editable Gutenberg compositions**, not an Elementor clone. No paid Elementor is required. Existing Elementor content remains supported with its own styling rules.
- All project figures, prices, distances, amenities and compliance claims are editable placeholders, **not verified project facts**.
- An existing page is not automatically overwritten by a pattern: the editor inserts patterns where you choose; back up before editing an established page.
- Pages using fixed styles from page-builder plugins may need edits in that plugin’s editor.
- Test on a staging WordPress installation before upgrading a live site. PHP/JS syntax checks and static packaging checks do not replace real browser testing.


## v1.3.1: Pattern visibility fix

All 11 **Luxury Inner Pages** patterns are now registered with the WordPress server-side Pattern API on `init` instead of relying on a block editor JavaScript registration script. This fixes a possible source of missing categories. It cannot make patterns appear if another theme is active.

1. **Appearance → Themes**: confirm **Luxury Website 1.3.1** is Active.
2. **Pages → Add New → + → Patterns → Luxury Inner Pages** (or search **About Us**).
3. Full pages are editable templates; adjust the correct text and replace placeholder imagery. Existing pages and homepage are not overwritten.
4. If the category is still absent, hard-refresh the editor and check Site Health for PHP/JavaScript errors.

No live-site WordPress installation or visual tests have been performed. Backup and test on staging first.

## 8. Projects page design controls (v1.3.2)

The automatically-generated `/projects/` property archive is **not** an editable WordPress Page. To edit its design without code:

- **Appearance → Luxury Website → Projects Listing** (new Studio tab); OR
- **Appearance → Customize → Luxury Website — Design Studio → Projects Listing Page**.

Settings: main heading (visible H1), banner description, small intro, optional background image/colour, banner padding/alignment, search section headings, filter visibility and results count. The normal homepage and property entries remain separate. Existing projects, URLs and archive SEO settings are retained.

For Google title/meta description: **Appearance → Luxury Website → SEO Settings → Projects Archive SEO Title / Description**. These are separate from the visible banner H1.

## Footer Explore fix (v1.3.3)
The footer's `Explore` links now use light text on the dark background with a gold hover/focus state. The default fallback links (Home / Projects / Contact) are stacked vertically rather than horizontally. To choose different footer links: Appearance → Menus → create a menu → assign to Footer Menu.
