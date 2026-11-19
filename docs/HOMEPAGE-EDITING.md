## 1.3.6 Customizer instant preview

In Appearance > Customize > Luxury Website — Design Studio, hero text, homepage headings, descriptions, colors, most numeric sizing controls and expandable FAQs update immediately in the preview iframe. There is **no need to Publish or reload just to preview**. Publish only after you are satisfied with the draft changes. Structural settings such as show/hide sections and project counts use WordPress automatic preview refresh (not a full-site publish).

Appearance > Luxury Website > Homepage is a separate dashboard settings form, not a visual editor. Use **Save Website Settings** there. After deploying an update, force-refresh browser cached scripts once (Ctrl+F5) if the Customizer still uses old JavaScript.

# Homepage editing (Luxury Website 1.3.4)

The Customizer includes individual Homepage sections for search and statistics, About, Projects, Features, Gallery, Location & Map, FAQ Questions & Answers (six entries), Call To Action, Articles, and Contact Form Intro.

Open **Appearance > Customize > Luxury Website — Design Studio > Homepage – FAQ Questions & Answers** to edit the FAQ in a live preview. Use the other Homepage subsections to edit their content, and select Publish to save.

Alternative: **Appearance > Luxury Website > Homepage** has the same editable content in grouped fields. Save Website Settings there. Do not enable **Use WordPress Page Content as Homepage** unless you want to replace the theme homepage with the WordPress page editor.

For GitHub Releases: update source to v1.3.4, push to `opcgroup/luxury-website` main and release tag v1.3.4 with the provided ZIP as an asset. It must contain a single top-level `luxury-website/` directory. WordPress Settings > Appearance > Luxury Website > GitHub Updates must point to that repository. A new release is required; the current ZIP does not publish itself. Always back up before installation.

Note: Changes to visible heading text do not by themselves modify custom SEO title and description. Review those separately in Luxury Website > SEO Settings. Existing site options and property data are preserved by the upgrade.
