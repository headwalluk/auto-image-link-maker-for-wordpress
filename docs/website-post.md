# Automated image lightbox for WordPress

Auto Image Link Maker scans your pages for images and groups them into lightboxes. It's configurable via CSS selectors and includes developer-friendly hooks for per-page overrides.

Images inside HTML tables and other block editor content often aren't wrapped in links — they're just static. This plugin fixes that by wrapping plain images with anchor tags and opening them in a touch-friendly lightbox. Images in the same container (e.g a table or gallery block) are isolated into their own lightbox galleries.

## Client-side solution

The plugin runs a small JavaScript script on the front end that wraps unwrapped images in anchor links. The script checks each image to see if it already has a parent `<a>` tag using `element.closest('a')` — a clean, native DOM method. If there's no anchor, it wraps the image and links to the full-size source.

I considered using the WordPress WP HTML Tag Processor tool, but the client-side DOM method turned out to be much more robust, as we're always working with a validated DOM.

## Built-In lightbox

Wrapped images open in a smooth, touch-friendly lightbox powered by [GLightbox](https://biati-digital.github.io/glightbox/). No jQuery dependency, no external CDN — everything is bundled. Images in the same container (like a table or gallery block) form a swipeable lightbox gallery, so visitors can navigate through multiple images without closing the overlay.

![Automated lightbox plugin settings page](https://cdn.headwall-hosting.com/wp-content/uploads/2026/03/auto-lightbox-plugin-wordpress-settings.webp)

## Configurable & developer-friendly

You control which images are affected using CSS selectors (default: `#main img`), and which page types the plugin runs on (posts, pages, archives, etc.). There's also an exclude list for things like site logos and avatars.

For developers, the plugin provides `apply_filters()` hooks so you can override behaviour on a per-page basis. Want to disable the lightbox on specific pages, or add custom selectors for WooCommerce product galleries? There's a filter for that.

The plugin is built with PHP 8.0+ and WordPress 6.0+ in mind. It follows WordPress coding standards, ships with machine-translated language files for eight locales, and includes an uninstall routine that cleans up after itself.
