/**
 * Auto Image Link Maker - Front-end script.
 *
 * Wraps images that are not already inside an anchor tag
 * with a link to their source, then opens them in a GLightbox lightbox.
 *
 * @package Auto_Image_Link_Maker
 */

document.addEventListener( 'DOMContentLoaded', function() {
	if ( typeof ailmData === 'undefined' || ! ailmData.selectors ) {
		return;
	}

	var selector = ailmData.selectors.join( ', ' );

	if ( ! selector ) {
		return;
	}

	/**
	 * Resolve the full-size image URL from a WordPress image element.
	 *
	 * Checks srcset for the largest available source first, then strips
	 * the WP dimension suffix (e.g. -1024x768) from src as a fallback.
	 *
	 * @param {HTMLImageElement} img The image element.
	 * @return {string} The best available full-size URL.
	 */
	function getFullSizeUrl( img ) {
		var srcset = img.getAttribute( 'srcset' );

		if ( srcset ) {
			var largest  = 0;
			var bestUrl  = '';
			var entries  = srcset.split( ',' );

			entries.forEach( function( entry ) {
				var parts = entry.trim().split( /\s+/ );
				var url   = parts[0];
				var width = parseInt( parts[1], 10 ) || 0;

				if ( width > largest ) {
					largest = width;
					bestUrl = url;
				}
			} );

			if ( bestUrl ) {
				return bestUrl;
			}
		}

		var src = img.getAttribute( 'src' ) || '';

		// Strip WordPress dimension suffix: image-1024x768.jpg -> image.jpg
		var stripped = src.replace( /-\d+x\d+(\.[a-zA-Z]+)$/, '$1' );

		return stripped;
	}

	var images = document.querySelectorAll( selector );

	images.forEach( function( img ) {
		if ( img.closest( 'a' ) ) {
			return;
		}

		var fullUrl = getFullSizeUrl( img );

		if ( ! fullUrl ) {
			return;
		}

		var anchor = document.createElement( 'a' );
		anchor.setAttribute( 'href', fullUrl );
		anchor.classList.add( 'glightbox' );
		anchor.classList.add( 'ailm-link' );
		img.parentNode.insertBefore( anchor, img );
		anchor.appendChild( img );
	} );

	if ( typeof GLightbox !== 'undefined' ) {
		GLightbox( {
			selector: '.glightbox',
		} );
	}
} );
