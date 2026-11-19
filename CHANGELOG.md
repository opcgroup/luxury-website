## 1.3.3 — 2026-11-19
- Fixed footer Explore menu links being nearly invisible on dark footer backgrounds.
- Stacked the fallback footer navigation vertically when no footer menu is assigned.
- Scoped footer styles so header links, homepage and listing archive retain existing appearance.

## 1.3.2 — 2026-11-19
- Added no-code design controls for the `/projects/` property listing archive in Studio and Customizer.
- Customizable visible H1, intro and description, banner image/background, alignment, padding, search heading, filter and results count.
- Kept archive title as an H1 when banner is hidden.
- Kept homepage design, existing property posts and per-archive SEO fields untouched.

# Changelog

## 1.3.1 — 2026-11-19
- Register all 11 inner-page block patterns using the WordPress server-side Pattern API for more reliable Gutenberg visibility.
- Remove the editor-only JavaScript pattern registration dependency; keep full-page and section layouts editable as native blocks.
- Homepage design, per-page SEO options and existing content unchanged.

# Luxury Website Theme — Changelog

## 1.2.0 — 19 November 2026
- Expanded Real Estate Properties post type and location taxonomy.
- Public searchable property directory with keyword, type, city/locality, listing category and numeric INR budget filters.
- Rich property detail pages: gallery, amenities, floor plan, map, video link, RERA data and price.
- Individual property WhatsApp CTA and property-aware enquiry email.
- Homepage property search panel, property search shortcodes and featured listing shortcode filter.
- Retains the no-code Gutenberg builder, animations, SEO manager, header designer and GitHub updater from v1.1.0.

## 1.1.0
- Luxury Gutenberg blocks and per-block animation controls.
- Built-in on-page SEO and editor SEO fields.
- Public GitHub Releases updater and GitHub Actions packaging workflow.

## 1.0.0
- Initial theme with three presets, responsive customizable header and real-estate project cards.

## v1.3.0 — Inner Pages Designer (19 November 2026)

- Preserved the existing `front-page.php` homepage layout and the design presets.
- Redesigned inner-page rendering to support independently selected Narrow, Standard, Wide and Full Width canvases.
- Added a Luxury Landing template that suppresses the built-in title banner.
- Added an editor sidebar for each Page: width, show/hide title banner, solid/gradient/featured-image banner, subtitle.
- Added 11 real estate Gutenberg block patterns: complete About, Project, Location, Floor Plans, Amenities, Gallery, Contact, Services and FAQ pages, plus modular benefits and CTA sections.
- Added block styles for Groups, Columns, Images and Buttons.
- Scoped responsive Gutenberg inner-page styling to avoid changing homepage output.
- Kept previous custom blocks, SEO controls, property module, header builder and GitHub Releases updater.

## v1.3.0 — SEO refinements
- Improved default meta-description extraction from Gutenberg block-based page content.
- Fixed pagination canonical URL defaults for paginated property, location, category, tag and blog archives.
- Added navigation BreadcrumbList JSON-LD for singular pages, posts and property details when built-in SEO is enabled.
- Hardened JSON-LD serialization of editor-managed values.
- Documented heading hierarchy, duplicate SEO plugin behaviour, internal-linking, performance and safe permalink practices.
