/* Luxury Website: instant WordPress Customizer preview (no publish or reload needed). */
(function (api) {
  'use strict';
  if (!api || !api.bind) return;

  function all(selector) { return document.querySelectorAll(selector); }
  function text(selector, value) {
    all(selector).forEach(function (element) { element.textContent = String(value == null ? '' : value); });
  }
  // Preserve arrows/icons in CTA anchors instead of removing their child spans.
  function linkLabel(selector, value) {
    all(selector).forEach(function (anchor) {
      var node = Array.prototype.find.call(anchor.childNodes, function (child) { return child.nodeType === 3; });
      if (node) node.nodeValue = String(value == null ? '' : value) + ' ';
      else anchor.insertBefore(document.createTextNode(String(value == null ? '' : value) + ' '), anchor.firstChild);
    });
  }
  function attr(selector, name, value) {
    all(selector).forEach(function (element) { element.setAttribute(name, String(value == null ? '' : value)); });
  }
  function css(name, value) { document.documentElement.style.setProperty(name, String(value == null ? '' : value)); }
  function lengthVar(name, value, unit) {
    var number = Number(value);
    if (Number.isFinite(number)) css(name, number + (unit || 'px'));
  }
  function bind(key, update) {
    api('lw_options[' + key + ']', function (setting) { setting.bind(update); });
  }

  var textFields = {
    tagline: '.lw-site-header .lw-tagline',
    hero_kicker: '.lw-hero-content > .lw-eyebrow',
    hero_title: '.lw-hero-content h1',
    hero_description: '.lw-hero-content > p',
    home_search_kicker: '.lw-home-property-search .lw-eyebrow',
    about_kicker: '.lw-about-text > .lw-eyebrow',
    about_title: '.lw-about-text > h2',
    about_description: '.lw-about-text > p',
    about_image_badge_top: '.lw-image-accent > span',
    about_image_badge_bottom: '.lw-image-accent > strong',
    projects_kicker: '.lw-projects .lw-section-heading .lw-eyebrow',
    projects_title: '.lw-projects .lw-section-heading h2',
    projects_description: '.lw-projects .lw-section-heading p',
    features_kicker: '.lw-features .lw-center-heading .lw-eyebrow',
    features_title: '.lw-features .lw-center-heading h2',
    gallery_kicker: '.lw-gallery .lw-center-heading .lw-eyebrow',
    gallery_title: '.lw-gallery .lw-center-heading h2',
    location_kicker: '.lw-location-inner > div:first-child .lw-eyebrow',
    location_title: '.lw-location-inner > div:first-child h2',
    location_description: '.lw-location-inner > div:first-child > p:first-of-type',
    location_art_label: '.lw-location-art > span:last-child',
    faq_kicker: '.lw-faq-grid > div:first-child .lw-eyebrow',
    faq_title: '.lw-faq-grid > div:first-child h2',
    cta_kicker: '.lw-cta-inner .lw-eyebrow',
    cta_section_title: '.lw-cta-inner h2',
    cta_section_desc: '.lw-cta-inner p',
    blog_kicker: '.lw-articles .lw-section-heading .lw-eyebrow',
    blog_title: '.lw-articles .lw-section-heading h2',
    contact_kicker: '.lw-contact-intro > .lw-eyebrow',
    contact_title: '.lw-contact-intro > h2',
    contact_desc: '.lw-contact-intro > p:first-of-type',
    footer_about: '.lw-footer-grid > div:first-child > p:first-of-type',
    footer_disclaimer: '.lw-footer-disclaimer',
    archive_kicker: '.lw-archive-hero .lw-eyebrow',
    archive_title: '.lw-archive-hero h1, .lw-archive-inline-title',
    archive_description: '.lw-archive-hero p',
    archive_search_kicker: '.lw-property-directory-head .lw-eyebrow',
    archive_search_title: '.lw-property-directory-head h2'
  };
  Object.keys(textFields).forEach(function (key) {
    bind(key, function (value) { text(textFields[key], value); });
  });
  for (var i = 1; i <= 3; i++) {
    (function (index) {
      bind('stat_' + index + '_number', function (value) { text('.lw-stats-grid .lw-stat:nth-child(' + index + ') strong', value); });
      bind('stat_' + index + '_label', function (value) { text('.lw-stats-grid .lw-stat:nth-child(' + index + ') span', value); });
      bind('feature_' + index + '_title', function (value) { text('.lw-feature-grid .lw-feature:nth-child(' + index + ') h3', value); });
      bind('feature_' + index + '_body', function (value) { text('.lw-feature-grid .lw-feature:nth-child(' + index + ') p', value); });
    })(i);
  }
  var linkTextFields = {
    cta_text: '.lw-site-header .lw-button-small',
    hero_button: '.lw-hero-actions .lw-button:first-child',
    hero_secondary: '.lw-hero-actions .lw-button:nth-child(2)',
    about_button_text: '.lw-about-text .lw-text-link',
    projects_all_text: '.lw-projects .lw-section-heading .lw-text-link',
    location_map_label: '.lw-location-inner .lw-text-link',
    cta_button_text: '.lw-cta-inner .lw-button',
    blog_all_text: '.lw-articles .lw-section-heading .lw-text-link'
  };
  Object.keys(linkTextFields).forEach(function (key) {
    bind(key, function (value) { linkLabel(linkTextFields[key], value); });
  });
  var linkFields = {
    cta_url: '.lw-site-header .lw-button-small',
    hero_button_url: '.lw-hero-actions .lw-button:first-child',
    hero_secondary_url: '.lw-hero-actions .lw-button:nth-child(2)',
    about_button_url: '.lw-about-text .lw-text-link',
    location_map_url: '.lw-location-inner .lw-text-link',
    cta_button_url: '.lw-cta-inner .lw-button'
  };
  Object.keys(linkFields).forEach(function (key) {
    bind(key, function (value) { attr(linkFields[key], 'href', value || '#'); });
  });

  // Shared styling is expressed as CSS variables in the theme's existing stylesheet.
  var colorVars = {
    primary: '--lw-primary', accent: '--lw-accent', background: '--lw-background',
    surface: '--lw-surface', ink: '--lw-ink', muted: '--lw-muted',
    header_bg: '--lw-header-bg', header_color: '--lw-header-color',
    topbar_bg: '--lw-topbar-bg', topbar_color: '--lw-topbar-color'
  };
  Object.keys(colorVars).forEach(function (key) {
    bind(key, function (value) { if (/^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i.test(value || '')) css(colorVars[key], value); });
  });
  var numberVars = {
    container_width: '--lw-container', radius: '--lw-radius',
    section_gap: '--lw-section-gap', header_height: '--lw-header-height',
    header_gap: '--lw-header-gap', menu_gap: '--lw-menu-gap',
    menu_font_size: '--lw-menu-font', header_mobile_height: '--lw-mobile-height'
  };
  Object.keys(numberVars).forEach(function (key) {
    bind(key, function (value) { lengthVar(numberVars[key], value, 'px'); });
  });
  bind('font', function (value) {
    if (window.LWLivePreview && window.LWLivePreview.fonts && window.LWLivePreview.fonts[value]) {
      css('--lw-font', window.LWLivePreview.fonts[value]);
    }
  });
  bind('hero_height', function (value) {
    all('.lw-hero').forEach(function (hero) { if (Number.isFinite(Number(value))) hero.style.minHeight = Number(value) + 'px'; });
  });
  bind('hero_overlay', function (value) {
    all('.lw-hero').forEach(function (hero) { hero.style.setProperty('--lw-overlay', Math.min(95, Math.max(0, Number(value) || 0)) / 100); });
  });
  bind('hero_image', function (value) {
    all('.lw-hero').forEach(function (hero) {
      var fallback = window.LWLivePreview && window.LWLivePreview.defaultHero;
      hero.style.setProperty('--lw-hero-photo', 'url(' + JSON.stringify(value || fallback || '') + ')');
    });
  });
  bind('logo_height', function (value) {
    all('.lw-logo img').forEach(function (img) { if (Number.isFinite(Number(value))) img.style.maxHeight = Number(value) + 'px'; });
  });
  bind('header_padding', function (value) {
    all('.lw-header-main').forEach(function (header) {
      if (Number.isFinite(Number(value))) header.style.paddingBlock = Number(value) + 'px';
    });
  });
  bind('archive_bg_color', function (value) {
    all('.lw-archive-hero').forEach(function (banner) { banner.style.backgroundColor = value || ''; });
  });
  bind('archive_banner_padding', function (value) {
    all('.lw-archive-hero').forEach(function (banner) { if (Number.isFinite(Number(value))) banner.style.paddingBlock = Number(value) + 'px'; });
  });
  bind('archive_align', function (value) {
    all('.lw-archive-hero').forEach(function (banner) {
      banner.classList.toggle('lw-archive-align-center', value === 'center');
      banner.classList.toggle('lw-archive-align-left', value !== 'center');
    });
  });
  bind('office_address', function (value) {
    text('.lw-footer-grid > div:nth-child(3) > p:first-of-type', value);
    text('.lw-contact-intro > p strong + span', value);
  });
  bind('phone', function (value) {
    // Do not modify elements for which the phone is an optional structural presence.
    all('a.lw-header-contact[href^="tel:"], .lw-footer-grid > div:nth-child(3) a[href^="tel:"]').forEach(function (link) {
      link.setAttribute('href', 'tel:' + String(value || '').replace(/[^0-9+]/g, ''));
      var inner = link.querySelector('span'); if (inner) inner.textContent = value;
      else link.textContent = value;
    });
  });
  bind('email', function (value) {
    all('a.lw-header-contact[href^="mailto:"], .lw-footer-grid > div:nth-child(3) a[href^="mailto:"]').forEach(function (link) {
      link.setAttribute('href', 'mailto:' + String(value || ''));
      var inner = link.querySelector('span'); if (inner) inner.textContent = value;
      else link.textContent = value;
    });
  });

  function renderFAQs(value) {
    var target = document.querySelector('.lw-faq-items');
    if (!target) return; // If FAQ section is disabled, WordPress refresh transport restores it.
    var items;
    try { items = JSON.parse(value || '[]'); } catch (e) { return; }
    if (!Array.isArray(items)) return;
    // Remember which questions users have expanded while editing.
    var expanded = {};
    target.querySelectorAll('details[open]').forEach(function (detail) {
      var summary = detail.querySelector('summary');
      if (summary) expanded[summary.firstChild && summary.firstChild.nodeValue] = true;
    });
    var fragment = document.createDocumentFragment();
    items.slice(0, 250).forEach(function (item) {
      if (!item || !String(item.question || '').trim()) return;
      var details = document.createElement('details');
      details.className = 'lw-faq-item lw-reveal is-visible';
      var summary = document.createElement('summary');
      var question = String(item.question).trim();
      summary.appendChild(document.createTextNode(question));
      var plus = document.createElement('span'); plus.setAttribute('aria-hidden', 'true'); plus.textContent = '+';
      summary.appendChild(plus);
      var answer = document.createElement('p'); answer.textContent = String(item.answer || '');
      details.appendChild(summary); details.appendChild(answer);
      if (expanded[question]) details.open = true;
      fragment.appendChild(details);
    });
    target.replaceChildren(fragment);
  }
  bind('faq_items', renderFAQs);
})(window.wp && window.wp.customize);
