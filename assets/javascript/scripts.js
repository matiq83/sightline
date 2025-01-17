document.addEventListener( 'DOMContentLoaded', function() {
	var msnryContainer = document.querySelector( '.masonry-container' );

	if ( msnryContainer ) {
		// eslint-disable-next-line no-undef -- Masonry is a dependency.
		var msnry = new Masonry( msnryContainer, generateBlog.masonryInit ),
			navBelow = document.querySelector( '#nav-below' ),
			loadMore = document.querySelector( '.load-more' );

		// eslint-disable-next-line no-undef -- imagesLoaded is a dependency.
		imagesLoaded( msnryContainer, function() {
			msnry.layout();
			msnryContainer.classList.remove( 'are-images-unloaded' );

			if ( loadMore ) {
				loadMore.classList.remove( 'are-images-unloaded' );
			}

			if ( navBelow ) {
				navBelow.style.opacity = 1;
			}
		} );

		if ( navBelow ) {
			msnryContainer.parentNode.insertBefore( navBelow, msnryContainer.nextSibling );
		}

		window.addEventListener( 'orientationchange', function() {
			msnry.layout();
		} );
	}

	var hasInfiniteScroll = document.querySelector( '.infinite-scroll' ),
		nextLink = document.querySelector( '.infinite-scroll-path a' );
    
	if ( hasInfiniteScroll && nextLink ) {
		var infiniteItems = document.querySelectorAll( '.infinite-scroll-item' ),
			container = infiniteItems[ 0 ].parentNode,
			button = document.querySelector( '.load-more a' ),
			svgIcon = '';

		if ( generateBlog.icon ) {
			svgIcon = generateBlog.icon;
		}

		var infiniteScrollInit = generateBlog.infiniteScrollInit;

		infiniteScrollInit.outlayer = msnry;
        
        infiniteScrollInit.path = () => {
            let ofcategory = jQuery("#ofcategory").val();
            let ofpost_tag = jQuery("#ofpost_tag").val();
            let ofregion = jQuery("#ofregion").val();            
            let url = sightline_data.baseurl+'page/'+sightline_data.page+'/';
            if( sightline_data.querystring !== "" ) {
                url = url+'?'+sightline_data.querystring+'&ofcat='+ofcategory+'&oftag='+ofpost_tag+'&ofregion='+ofregion;
            }else{
                url = url+'?ofcat='+ofcategory+'&oftag='+ofpost_tag+'&ofregion='+ofregion;
            }
            return url;
        };

		// eslint-disable-next-line no-undef -- InfiniteScroll is a dependency.
		var infiniteScroll = new InfiniteScroll( container, infiniteScrollInit );

		if ( button ) {
			button.addEventListener( 'click', function( e ) {
				document.activeElement.blur();
				e.target.innerHTML = svgIcon + generateBlog.loading;
				e.target.classList.add( 'loading' );
			} );
		}
        
        infiniteScroll.on( 'request', function( event, path, fetchPromise ) {
            
            let ScrollPath = infiniteScroll.getPath();
            //console.log(`Loading page: ${ScrollPath}`);
        });
        
		infiniteScroll.on( 'append', function( response, path, items ) {
            console.log(sightline_data.page);
            if( sightline_data.page === 1 ) {
                jQuery("#main .infinite-scroll-item").remove();
            }
            
            sightline_data.page++;
            
			if ( button && ! document.querySelector( '.generate-columns-container' ) ) {
				container.appendChild( button.parentNode );
			}

			items.forEach( function( element ) {
				var images = element.querySelectorAll( 'img' );

				if ( images ) {
					images.forEach( function( image ) {
						var imgOuterHTML = image.outerHTML;
						image.outerHTML = imgOuterHTML;
					} );
				}
			} );
            /*
			if ( msnryContainer && msnry ) {
				// eslint-disable-next-line no-undef -- ImagesLoaded is a dependency.
				imagesLoaded( msnryContainer, function() {
					msnry.layout();
				} );
			}
            */
			if ( button ) {
				button.innerHTML = svgIcon + generateBlog.more;
				button.classList.remove( 'loading' );
			}

			document.body.dispatchEvent( new Event( 'post-load' ) );
		} );

		infiniteScroll.on( 'last', function() {
			var loadMoreElement = document.querySelector( '.load-more' );

			if ( loadMoreElement ) {
				loadMoreElement.style.display = 'none';
			}
		} );
	}
} );