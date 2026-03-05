# Auto Image Link Maker – Plugin Page Content

Auto Image Link Maker scans your pages for images and groups them into lightboxes. It's configurable via CSS selectors and includes developer-friendly hooks for per-page overrides.

Images inside HTML tables and other block editor content often aren't wrapped in links — they're just static. This plugin fixes that by wrapping unwrapped images in anchor tags and opening them in a touch-friendly lightbox. Images in the same container (like a table or gallery block) form a swipeable gallery.

## A Client-Side Solution

Auto Image Link Maker takes a pragmatic approach: it runs a small JavaScript script on the front end that wraps unwrapped images in anchor links. The script checks each image to see if it already has a parent `<a>` tag using `element.closest('a')` — a clean, native DOM method. If there's no anchor, it wraps the image and links to the full-size source.

Why client-side instead of server-side? Because `element.closest()` is reliable and fast. The WordPress HTML API (`WP_HTML_Tag_Processor`) is a forward-only stream parser that can't easily inspect parent elements. Client-side keeps things simple and non-destructive — your stored content never changes.

## Built-In Lightbox

Wrapped images open in a smooth, touch-friendly lightbox powered by GLightbox. No jQuery dependency, no external CDN — everything is bundled. Images in the same container (like a table or gallery block) form a swipeable lightbox gallery, so visitors can navigate through multiple images without closing the overlay.

## Configurable & Developer-Friendly

You control which images are affected using CSS selectors (default: `#main img`), and which page types the plugin runs on (posts, pages, archives, etc.). There's also an exclude list for things like site logos and avatars.

For developers, the plugin provides `apply_filters()` hooks so you can override behaviour on a per-page basis. Want to disable the lightbox on specific pages, or add custom selectors for WooCommerce product galleries? There's a filter for that.

## Lightweight and Reliable

The plugin is built with PHP 8.0+ and WordPress 6.0+ in mind. It follows WordPress coding standards, ships with machine-translated language files for eight locales, and includes an uninstall routine that cleans up after itself.

If you need clickable images without modifying your content, this does the job.
