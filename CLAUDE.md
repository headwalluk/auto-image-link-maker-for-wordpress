# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Auto Image Link Maker is a WordPress plugin that automatically wraps unwrapped images in clickable anchor links and opens them in a GLightbox lightbox. It targets images via configurable CSS selectors (e.g. `#main img`), checks for existing `<a>` ancestors via `element.closest('a')`, resolves full-size image URLs from `srcset` or by stripping WP dimension suffixes, and wraps bare images in links.

## Development Environment

- **Dev site:** `http://bench3.local/`
- **WP-CLI:** `wp` (installed globally)
- **PHP standards:** `phpcs` / `phpcbf` (installed globally)

## Commands

```bash
phpcs                    # Check all PHP files against WordPress Coding Standards
phpcbf                   # Auto-fix coding standards violations
phpcs includes/          # Check specific directory
```

## Coding Standards (from .github/copilot-instructions.md)

These are **mandatory** conventions — not suggestions:

- **WordPress Coding Standards** enforced via phpcs. Run before every commit.
- **No `declare(strict_types=1)`** — breaks WordPress/WooCommerce interop.
- **Single-Entry Single-Exit (SESE)** — functions should have one return statement at the end, not early returns.
- **No inline HTML in PHP** — use `printf()`/`echo` exclusively in templates. Never mix `<div>` with `<?php ?>` blocks.
- **No inline JavaScript** — all JS in separate files, loaded via `wp_enqueue_script()`.
- **Constants for magic values** — define in `constants.php`, prefixed: `DEF_` for defaults, `OPT_` for wp_options keys.
- **Boolean options** — use `filter_var($val, FILTER_VALIDATE_BOOLEAN)`, never check against specific strings like `'yes'`.
- **Date/time storage** — human-readable `Y-m-d H:i:s T` format, not Unix timestamps.
- **Namespaces** — all classes use namespaces (e.g. `namespace Auto_Image_Link_Maker;`). No global prefixes on class names.
- **Type hints** — use PHP 8.0+ type hints and return types on all functions/methods.
- **Security** — sanitize input, escape output, verify nonces, check capabilities.

## File Structure Conventions

- `class-{name}.php` for class files
- `constants.php` for all magic strings/numbers
- `functions-private.php` for internal helper functions
- `includes/` for core classes
- `assets/admin/` and `assets/public/` for CSS/JS
- `assets/vendor/` for bundled third-party libraries (e.g. GLightbox)
- `admin-templates/` and `templates/` for template files
- `dev-notes/` for development documentation (excluded from phpcs)

## Protected Directories

- **`pwpl/`** — if present, never modify. It's a sealed third-party licence controller.

## Git Workflow

Commit message format: `type: description` where type is one of `feat:`, `fix:`, `chore:`, `refactor:`, `docs:`, `style:`, `test:`.

Always run `phpcs` → `phpcbf` → `phpcs` before committing.

## Reference Documentation

Detailed patterns in `dev-notes/patterns/`:
- `javascript.md` — JS patterns, AJAX, class-based selectors
- `settings-api.md` — WordPress settings registration
- `templates.md` — template loading with theme overrides
- `database.md` — custom tables and migrations
- `caching.md` — transients API, rate limiting
- `admin-tabs.md` — hash-based tabbed navigation
