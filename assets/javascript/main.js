// JavaScript Document
jQuery(document).ready(function($) {
    $(".frm_sightline.ajax_save").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var action = form.attr('action');
        var data = form.serializeArray(); // serializes the form's elements.
        
        $(".frm_sightline .btnsave").hide();
        $(".frm_sightline .ajax-loader").show();
       
        data.push({ name:'action', value:action }); 
        
        $(".sightline_checkbox_field").each(function(){
            data.push({ name:$(this).attr("name"), value:$(this).val() }); 
        });
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: sightline_data.ajaxurl,
            data: data, //data: {action: 'sightline_load_action'},
            success: function(response) {
                $(".ajax-message-container").html(response.message);
                $(".ajax-message-container").slideDown();
                setTimeout(function(){$(".ajax-message-container").slideUp();},3000);
            },
            error: function (xhr, status, error) {
                alert("There is some error to connect with server. Please try again.");
            }
        }).always(function(){  
            $(".frm_sightline .btnsave").show();
            $(".frm_sightline .ajax-loader").hide();
        });
    });
    
    if( $(".frm_sightline .btnsave").length ) {
        $(".frm_sightline .btnsave").click(function(){
            $(".frm_sightline #frm_section").val($(this).attr('data-section'));
        });
    }
    
    if( $(".sightline_checkbox_field").length ) {
        $(".sightline_checkbox_field").change(function(){
            if( $(this).is(':checked') ) {
                $(this).val($(this).attr("data-checked-val"));
            }else{
                $(this).val($(this).attr("data-unchecked-val"));
            }
        });
        $(".sightline_checkbox_field").trigger("change");
    }
    
    if( $(".sightline_wp_image_upload").length ) {
        $(".sightline_wp_image_upload").click(function(){
            sightline_wp_image_upload($(this));
            return false;
        });
    }
    
    if( $(".sightline_selects2").length ) {        
        $(".sightline_selects2").select2();
    }
    
    if( sightline_data.sightline_filter_for === 'search' || 
                sightline_data.sightline_filter_for === 'sightline_press' || 
                    sightline_data.sightline_filter_for === 'release'
            ) {
        $(".sightline_filter_posts_required .entry-content .gb-query-loop-wrapper").before('<div class="lds-ellipsis ajax-loader"><div></div><div></div><div></div><div></div></div>');
        if( $("#ofcategory").length ) {
            $("#ofcategory").change(function(){
                sightline_filter_posts();
            });
            if( sightline_data.ofcategory !== '' ) {
                $("#ofcategory").val(sightline_data.ofcategory);
            }

            sightline_filter_posts();
        }

        if( $("#ofpost_tag").length ) {
            $("#ofpost_tag").change(function(){
                sightline_filter_posts();
            });
            if( sightline_data.ofpost_tag !== '' ) {
                $("#ofpost_tag").val(sightline_data.ofpost_tag);
            }
        }

        if( $("#ofregion").length ) {
            $("#ofregion").change(function(){
                sightline_filter_posts();
            });
            if( sightline_data.ofregion !== '' ) {
                $("#ofregion").val(sightline_data.ofregion);
            }
        }
    }
    
    if( $("form.search-modal-form").length ) {
        let filter_elements = $(sightline_data.filter_fields_html);
        let html = filter_elements.find("div").html();
        $("form.search-modal-form .search-modal-fields").after('<div class="search-filters">'+html+'</div>');
        $("form.search-modal-form .search-filters input[type='hidden']").remove();
    }
    
    if( $(".sightline_web_scraping_fetch_yes").length ) {
        $(".sightline_web_scraping_fetch_yes input").change(function(){
            if( $(this).is(":checked") ) {
                sightline_scrap_web_page();
            }
        });
    }
});

function sightline_scrap_web_page() {
    
    var $ = jQuery;
    
    let url = $(".sightline_web_scraping_fetch_url input").val();
    const fetch_opt = $(".sightline_web_scraping_fetch_yes");
    
    if( url === "" ) {
        alert("Please put Website URL to fetech its data");
        fetch_opt.find("input").prop("checked", false);
        return false;
    } 
    
    fetch_opt.find(".acf-input").before('<div class="lds-ellipsis ajax-loader" style="display: inline-flex;"><div></div><div></div><div></div><div></div></div>');
    fetch_opt.find(".acf-input").hide();
    fetch_opt.find(".acf-label").hide();
    $(".sightline_web_scraping_fields").hide();
    $.ajax({
            type: "POST",
            dataType: 'json',
            url: sightline_data.ajaxurl,
            data: {
                action: 'sightline_scrap_web_page',
                url: url
            },
            success: function(response) {
                if( !response.error ) {
                    for( let i=0; i<= response.titles.length; i++ ) {
                        $(".sightline_web_scraping_titles_fields .acf-row").each(function(){
                            if( $(this).attr('data-id') === 'row-'+i ) {
                                $(this).find('.acf-input-wrap input').val(response.titles[i]);
                            }
                        });
                    }
                    for( let i=0; i<= response.contents.length; i++ ) {
                        $(".sightline_web_scraping_contents_fields .acf-row").each(function(){
                            if( $(this).attr('data-id') === 'row-'+i ) {
                                $(this).find('textarea').val(response.contents[i]);
                            }
                        });
                    }
                    $(".sightline_web_scraping_fields").show();
                }else{
                    alert(response.message);
                    fetch_opt.find("input").prop("checked", false);
                    fetch_opt.find(".acf-input").show();
                    fetch_opt.find(".acf-label").show();
                }
            },
            error: function (xhr, status, error) {
                alert("There is some error to connect with server. Please try again.");
            }
        }).always(function(){ 
            $(".sightline_web_scraping_fetch_yes .ajax-loader" ).remove();      
        });
}

/*
 * Ajax called function to filters posts
 * 
 * @returns {undefined}
 */
function sightline_filter_posts() {
    
    let $           = jQuery;
    let cat         = $("#ofcategory").val();
    let tag         = $("#ofpost_tag").val();
    let region      = $("#ofregion").val();
    let filter_for   = sightline_data.sightline_filter_for;
    $(".sightline_filter_posts_required .entry-content .ajax-loader").show();
    $(".sightline_filter_posts_required .entry-content .gb-query-loop-wrapper").hide();
    $.ajax({
            type: "POST",
            dataType: 'json',
            url: sightline_data.ajaxurl,
            data: {
                action: 'sightline_filter_posts',
                ofcategory: cat,
                ofpost_tag: tag,
                ofregion: region,
                sightline_query: sightline_data.search,
                sightline_filter_for: filter_for,
                pg: sightline_data.pg
            },
            success: function(response) {
                if( !response.error ) {
                    $(".sightline_filter_posts_required .entry-content .gb-query-loop-wrapper").show();
                    $(".sightline_filter_posts_required .entry-content .gb-query-loop-pagination").remove();
                    $(".sightline_filter_posts_required .entry-content .gb-query-loop-wrapper").html(response.html);                    
                }else{
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("There is some error to connect with server. Please try again.");
            }
        }).always(function(){  
            $(".sightline_filter_posts_required .entry-content .ajax-loader").hide();
        });
}

/*
 * Function to remove the uploaded image
 * @param {DOM Object} obj
 */
function sightline_remove_wp_image( obj, btn_upload_title='Upload image' ) {
    
    var $ = jQuery;
    
    const button = $(obj);
    button.next().val( '' ); // emptying the hidden field
    button.hide().prev().addClass( 'button' ).html( btn_upload_title ); // replace the image with text
    
    return false;
}

/*
 * Function to show the image upload
 * @param {type} obj
 */
function sightline_wp_image_upload( obj, type='image' ) {
    
    const button = obj;
    const imageId = button.next().next().val();

    const customUploader = wp.media({
            title: 'Insert '+type, // modal window title
            library : {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type : type
            },
            button: {
                text: 'Use this '+type // button label text
            },
            multiple: false
    }).on( 'select', function() { // it also has "open" and "close" events
            const attachment = customUploader.state().get( 'selection' ).first().toJSON();
            button.removeClass( 'button' ).html( '<img src="' + attachment.url + '">'); // add image instead of "Upload Image"
            button.next().show(); // show "Remove image" link
            button.next().next().val( attachment.id ); // Populate the hidden field with image ID
            customUploader.close();
    });

    // already selected images
    customUploader.on( 'open', function() {

            if( imageId ) {
              const selection = customUploader.state().get( 'selection' )
              attachment = wp.media.attachment( imageId );
              attachment.fetch();
              selection.add( attachment ? [attachment] : [] );
            }

    });

    customUploader.open();
    
    return false;
}

/*
 * Function to delete the Dom row
 */
function sightline_del_row( row_id ) {
    
    var $ = jQuery;
    
    if( confirm( "Are you sure you want to delete it?") ) {
        $( "#"+row_id ).remove();
    }
    return false;
}

/*
* Function to get the unique ID for the TOC row
*/
function get_uniqueid() {

    var uniqueid = Math.random().toString(16).slice(2);

    return uniqueid;
}