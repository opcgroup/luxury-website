<?php
/** Luxury Website - public GitHub Release updater for WordPress 6.2+. */
if ( ! defined('ABSPATH') ) { exit; }

/** Validate owner/repository format. No private tokens or hidden secrets. */
function lw_github_repository() {
    $repo = trim( (string) lw_opt('github_repo', '') );
    return preg_match('/\A[a-zA-Z0-9_.-]+\/[a-zA-Z0-9_.-]+\z/D', $repo) ? $repo : '';
}

function lw_github_release() {
    $repo = lw_github_repository();
    if ( ! $repo ) { return false; }
    $cache_key = 'lw_gh_' . substr(md5($repo),0,18);
    $cached = get_site_transient($cache_key);
    if ( false !== $cached ) { return $cached === 'none' ? false : $cached; }
    $request = wp_remote_get('https://api.github.com/repos/' . $repo . '/releases/latest', array(
        'timeout'=>8, 'redirection'=>2, 'sslverify'=>true,
        'headers'=>array('Accept'=>'application/vnd.github+json', 'X-GitHub-Api-Version'=>'2022-11-28', 'User-Agent'=>'LuxuryWebsiteTheme/' . LW_VERSION),
    ));
    if (is_wp_error($request) || wp_remote_retrieve_response_code($request) !== 200) {
        set_site_transient($cache_key, 'none', 30 * MINUTE_IN_SECONDS);
        return false;
    }
    $data = json_decode(wp_remote_retrieve_body($request), true);
    if ( ! is_array($data) || empty($data['tag_name']) || !empty($data['draft']) || !empty($data['prerelease']) ) { return false; }
    $version = ltrim(sanitize_text_field($data['tag_name']), 'vV');
    if (!preg_match('/\A\d+\.\d+\.\d+(?:[-.][a-z0-9.]+)?\z/i', $version)) { return false; }
    $package = '';
    // Require an uploaded release asset, not GitHub's generated source archive.
    // The asset ZIP must contain one top-level folder called luxury-website.
    foreach ((array)($data['assets'] ?? array()) as $asset) {
        $name = $asset['name'] ?? '';
        $url = $asset['browser_download_url'] ?? '';
        if (preg_match('/\Aluxury-website(?:-v?\d[^\/]*)?\.zip\z/i', $name)
            && stripos($url, 'https://github.com/' . $repo . '/releases/download/') === 0) {
            $package = esc_url_raw($url); break;
        }
    }
    if (!$package) { return false; }
    $release = array('version'=>$version,'package'=>$package,'url'=>'https://github.com/' . $repo . '/releases/latest');
    set_site_transient($cache_key,$release,6 * HOUR_IN_SECONDS);
    return $release;
}

// Update URI is github.com, which keeps this third-party theme separate from WordPress.org updates.
add_filter('update_themes_github.com', function($update, $theme_data, $stylesheet, $locales) {
    if ($stylesheet !== 'luxury-website') { return $update; }
    $release = lw_github_release();
    if (!$release || version_compare($release['version'], LW_VERSION, '<=')) { return false; }
    return array('theme'=>'luxury-website', 'version'=>$release['version'], 'url'=>$release['url'],
        'package'=>$release['package'], 'requires'=>'6.2', 'requires_php'=>'7.4');
}, 10, 4);

// On repository change, refresh the cached update response on the next normal WordPress check.
add_action('update_option_lw_options', function($old,$new) {
    $before = is_array($old) ? ($old['github_repo'] ?? '') : '';
    $after = is_array($new) ? ($new['github_repo'] ?? '') : '';
    if ($before !== $after) {
        if ($before) delete_site_transient('lw_gh_' . substr(md5($before),0,18));
        if ($after) delete_site_transient('lw_gh_' . substr(md5($after),0,18));
        delete_site_transient('update_themes');
    }
}, 10, 2);
