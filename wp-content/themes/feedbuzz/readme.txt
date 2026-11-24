=== FeedBuzz ===
Contributors: yineali
Requires at least: 6.6
Tested up to: 7.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A colorful, responsive news and magazine theme built with native WordPress features.

== Description ==
FeedBuzz is a classic WordPress news and magazine theme with an editorial latest-posts layout, full static-page support, article and archive templates, widget areas, four menu locations, block editor styles, and optional RTL styling.

The theme uses WordPress posts, pages, menus, widgets, the Media Library, the Customizer, and one prefixed option array. It does not require a companion plugin and does not include analytics, tracking, remote fonts, third-party scripts, direct external API requests, social sharing controls, or automatic redirects. The top utility bar displays the localized date on the left. On the right, optional nofollow social-profile shortcuts can be configured by the site owner.

== Installation ==
1. Open Appearance > Themes > Add New > Upload Theme.
2. Upload the FeedBuzz ZIP file and activate the theme.
3. Open Appearance > Customize to configure the FeedBuzz Header, FeedBuzz Social Links, FeedBuzz Homepage, and FeedBuzz Design sections.
4. Set the site logo and optional header image in their native WordPress Customizer controls.
5. Assign the Primary, Utility, and Footer menus under Appearance > Menus.
6. Configure the Primary Sidebar and footer columns under Appearance > Widgets. Configure the header banner under Appearance > Customize > Header Banner.
7. Select either latest posts or a static front page under Settings > Reading. FeedBuzz respects both choices.

== Frequently Asked Questions ==

= Does FeedBuzz require a page builder or plugin? =
No. The theme uses native WordPress APIs and content.

= Does the theme contact external services? =
The theme itself does not make direct external API requests or enqueue remote assets. Standard WordPress features and content added by the site owner, such as avatars, embeds, widgets, advertisements, and links, may contact services selected by WordPress or the site owner.

= How does the front page work? =
When Settings > Reading is set to “Your latest posts,” FeedBuzz uses the WordPress main query and the configured “Blog pages show at most” value. When a static page is selected, its content is preserved above the magazine post feed. If that page is empty, the feed begins immediately without a large title-only gap. A separately selected posts page continues to use the standard blog index template.

= How do I add links to the top information bar? =
Assign a menu to the Utility Menu location under Appearance > Menus. If no menu is assigned, the theme shows Home and only real About, Contact, Blog, and Privacy destinations that exist in WordPress; it never lists every page automatically. The right side can display Facebook, X, Instagram, and YouTube shortcuts. Their profile destinations can be changed under Appearance > Customize > FeedBuzz Social Links. Empty social URL fields are not displayed on the front end.

= How do I place an advertisement in the header? =
Open Appearance > Customize > Header Banner, select an advertisement image, and optionally enter its destination URL and alternative text. The image appears between the logo and compact search form. If no uploaded image is selected, the bundled default banner is used while the banner is enabled.

= Where are theme settings stored? =
All custom presentation settings are stored in one prefixed option array named feedbuzz_options. They are edited through the native WordPress Customizer under Appearance > Customize, while WordPress core identity, menu, widget, and header-image controls remain in their native interfaces.

== Privacy ==
FeedBuzz does not collect, store, transmit, or sell personal data and does not include tracking code or direct external API calls. Clicking a configured social-platform or advertisement link takes the visitor to an external website selected by the site owner. Standard WordPress features and content added by the site owner—such as avatars, embeds, widgets, menus, advertisements, and links—may have separate privacy implications controlled by WordPress or the site owner.

== Copyright ==
FeedBuzz WordPress Theme, Copyright (C) 2026 yineali.
FeedBuzz is distributed under the terms of the GNU General Public License v2 or later.

Unless a different GPL-compatible license is explicitly stated below, all original PHP, JavaScript, CSS, JSON, templates, documentation, interface artwork, logo artwork, banner artwork, screenshot artwork, and demo imagery bundled with FeedBuzz are Copyright (C) 2026 yineali and licensed under the GNU General Public License v2 or later.

Under GPLv2 or later, recipients may use, study, modify, and redistribute FeedBuzz and the original bundled visual assets under the terms of that license.

== Resources ==
* FeedBuzz theme code, templates, stylesheets, JavaScript, JSON, translation files, and documentation: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: bundled with FeedBuzz.
* assets/images/feedbuzz-logo.webp: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original FeedBuzz logo artwork supplied by the theme author and bundled with FeedBuzz.
* assets/images/header-banner-default.png: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original banner artwork supplied by the theme author and bundled with FeedBuzz.
* screenshot.png - complete theme screenshot, interface composition, and screenshot-only artwork: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original screenshot composition supplied by the theme author and bundled with FeedBuzz.
* Screenshot demo image - living/dining room interior scene, including the lead-story and repeated card crops: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Screenshot demo image - bedroom/storage interior scene, including the feature-card and repeated card crops: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Screenshot demo image - wooden dining-table/interior scene, including the feature-card and repeated card crops: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Screenshot demo image - shelving/bookcase interior thumbnail visible in the popular-post list: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Screenshot demo image - natural-material/wood product thumbnail visible in the popular-post list: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Screenshot demo image - desk/cable-management thumbnail scene visible in the popular-post list: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original demo imagery supplied by the theme author; embedded only in screenshot.png.
* Inline interface SVG icons in inc/template-tags.php and front-page.php: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original interface artwork supplied with FeedBuzz.
* Decorative CSS gradients, shapes, and fallback artwork in assets/css/main.css and assets/css/ui.css: Copyright (C) 2026 yineali. License: GPLv2 or later. Source: original artwork supplied with FeedBuzz.
* System font stack: no font files are bundled with FeedBuzz; fonts are supplied by the visitor's operating system and browser.

No third-party font files, stock-photo files, icon packages, JavaScript libraries, CDN files, or remote executable resources are bundled with FeedBuzz. The screenshot demo imagery listed above is part of the GPL-licensed screenshot artwork and is not loaded as front-end theme content.

== Changelog ==

= 1.0.2 =
* Fixed category-menu keyboard navigation so the open list closes when keyboard focus leaves the menu while preserving Escape and pointer behavior.
* Fixed primary navigation active-state handling so only the actual current top-level item is highlighted.
* Made the designed Recent Comments section available on the homepage when approved comments exist.
* Replaced the previous theme screenshot with the supplied 1200 × 900 screenshot.png and updated its GPL resource documentation.
* Cleaned the public readme changelog/upgrade-notice structure and synchronized public version metadata.

= 1.0.1 =
* Initial WordPress.org submission of FeedBuzz.

== Upgrade Notice ==

= 1.0.2 =
WordPress.org review update: keyboard navigation, active-menu state, homepage comments, screenshot, and licensing documentation were refined.

= 1.0.1 =
Initial WordPress.org submission.
