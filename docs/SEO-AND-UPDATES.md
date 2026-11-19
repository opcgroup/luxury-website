# SEO + No-Code Page Builder + GitHub Releases

## GitHub releases with no custom update server

1. Create a **public** GitHub repo (example `YOURNAME/luxury-website`).
2. Upload/push the theme source files **at the repository root** (`style.css`, `functions.php`, `inc/`, `assets/`, `.github/workflows/release.yml`, etc.).
3. In WordPress go to **Appearance → Luxury Website → GitHub Updates**, set `YOURNAME/luxury-website` and Save.
4. In GitHub, open repository **Settings → Actions → General → Workflow permissions** and enable Read and write permissions if your org requires it.
5. Publish a new version by editing the `Version:` in `style.css` and `LW_VERSION` in `functions.php` to e.g. `1.2.0`, commit changes, then push the `v1.2.0` tag.
6. GitHub Actions automatically packages `luxury-website-v1.2.0.zip` (containing `luxury-website/`) and attaches it to a new public GitHub Release. If Actions are disabled, upload this ZIP manually to a release with the matching tag.
7. Check **WordPress Dashboard → Updates**. WordPress will show the new theme version when its update check runs. To permit unattended installation, enable auto-updates for the theme in **Appearance → Themes → Theme Details**.

**Important:** Pushing an ordinary commit without creating a newer GitHub Release will not publish a WordPress update. Public GitHub Releases only; private repositories would require an authenticated, secure updater beyond this theme. A live repo is not connected in the ZIP. Back up before all updates; never store API tokens in theme options.

## SEO configuration

- Site-wide: **Appearance → Luxury Website → SEO Settings**: built-in SEO toggle, homepage title, description, related keywords, social image.
- Per page: edit any **Page**, **Post**, or **Project** → open **Luxury SEO** (magnifying glass icon) on editor sidebar. Classic editor has **Luxury SEO** meta box.
- Fields: SEO Title, Meta Description, Focus Keyword, Related Keywords, Canonical URL, Noindex, Nofollow, Social Share Image.
- Preview and checklist: helps with title/description lengths and phrase placement; **not** an official search-engine score.
- Metadata: `<title>`, meta description, WordPress canonical, Open Graph, Twitter card and basic JSON-LD. WordPress core includes XML sitemap at `/wp-sitemap.xml` unless disabled elsewhere.
- The focus/related keyword fields are editorial aids. Google does not use the `meta keywords` tag for ranking. Emitting it is optional and OFF by default.
- If Yoast SEO, Rank Math, All in One SEO, or SEOPress is active, the theme suppresses its SEO metadata output to avoid duplicate/conflicting tags. Use your SEO plugin as the single source of truth.
- Verify SEO with live HTML `view-source` and Google Search Console. Metadata does not guarantee rankings, rich snippets or indexing.

## Building pages without coding

1. **Pages → Add New** (or edit an existing page).
2. In WordPress Block Editor click **+** and search `Luxury`.
3. Insert **Luxury Hero**, **Luxury Section**, **Feature Card**, **Statistic**, **Testimonial**, **Property Grid**, **FAQ**, **Call to Action**. Use native WordPress **Columns**, **Group**, **Cover**, **Image**, **Gallery**, **Buttons**, **Video** blocks inside Luxury Sections for more variety.
4. Select an editable block and find the **Luxury Animation & Hover** panel in block settings. Choose entrance, hover, delay, duration, looping, repeat and mobile behaviour — no CSS coding.
5. To use a custom page as the homepage, choose it under **Settings → Reading → A static page**. Pages containing Luxury blocks are rendered as a custom homepage automatically. Or enable **Use WordPress Page Content as Homepage** in Luxury Website Studio.

Animations use a browser observer and respect reduced-motion accessibility preferences. Effects on blocks supplied by third-party page builders (e.g. Elementor widgets) are managed by those plugins and may not inherit these settings. Gutenberg blocks that explicitly disable custom classes cannot receive the theme's block-level motion panel.

## v1.3 inner-page SEO guardrails

- **One descriptive H1 per page.** The 9 complete Luxury Inner Pages patterns include an H1 in the first hero. The automatic WordPress page-title banner is hidden for pages with full-width pattern heroes to prevent duplicate H1 headings. If you hide the banner on a blank/custom page, add your own H1.
- **Use the right heading order.** Subsections should use H2, with H3 for details (e.g., BHK specifications and location). Do not replace headings with only styled text.
- **Distinct, useful metadata.** Set SEO Title and Meta Description in the Luxury SEO sidebar; default descriptions are generated from page text when no custom description is supplied. Do not copy the same description across every project page.
- **Readable slugs and internal links.** Keep established permalinks unchanged during a design-only upgrade. Link from project overview pages to legitimate Floor Plans, Amenities, Location and Contact pages using ordinary links.
- **Canonical pagination.** Paginated project/type/location/category archives keep their own page-specific canonical URLs (page 2 does not automatically canonicalize to page 1). Explicit canonical overrides remain the site owner's responsibility.
- **Structured data.** Basic WebPage/BlogPosting and navigation BreadcrumbList JSON-LD are generated when the built-in SEO module is active. Do not invent star ratings, precise prices, RERA numbers, possession dates or amenity data for schema.
- **Images and speed.** Upload descriptive image alt text, well-compressed WebP/AVIF assets where available, and use lazy loading for noncritical imagery. Preview mobile CLS/LCP in PageSpeed Insights; animation should not obstruct meaningful text or prevent crawlable content.
- **Avoid duplicate SEO output.** If Yoast, Rank Math, AIOSEO or SEOPress is active, built-in SEO output is suppressed. Do not run multiple SEO generators at once.
- **No SEO promise.** Metadata and schema improve technical clarity but cannot ensure indexing, rich results, or Google ranking positions. Verify published site HTML and Google Search Console coverage after the update.
