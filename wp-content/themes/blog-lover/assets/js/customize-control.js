/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function( $, api ) {
    wp.customize.bind('ready', function() {
    	// Show message on change.
        var blog_lover_settings = ['blog_lover_reset_settings'];
        _.each( blog_lover_settings, function( blog_lover_setting ) {
            wp.customize( blog_lover_setting, function( setting ) {
                var blogLoverNotice = function( value ) {
                    var name = 'needs_refresh';
                    if ( value && blog_lover_setting == 'blog_lover_reset_settings' ) {
                        setting.notifications.add( 'needs_refresh', new wp.customize.Notification(
                            name,
                            {
                                type: 'warning',
                                message: localized_data.reset_msg,
                            }
                        ) );
                    } else if( value ){
                        setting.notifications.add( 'reset_name', new wp.customize.Notification(
                            name,
                            {
                                type: 'info',
                                message: localized_data.refresh_msg,
                            }
                        ) );
                    } else {
                        setting.notifications.remove( name );
                    }
                };

                setting.bind( blogLoverNotice );
            });
        });

        /* === Radio Image Control === */
        api.controlConstructor['radio-color'] = api.Control.extend( {
            ready: function() {
                var control = this;

                $( 'input:radio', control.container ).change(
                    function() {
                        control.setting.set( $( this ).val() );
                    }
                );
            }
        } );

        wp.customize.bind('ready', function() {
            jQuery('a[data-open="blog-lover-recent-posts"]').click(function(e) {
                e.preventDefault();
                wp.customize.section( 'sidebar-widgets-homepage-sidebar' ).focus()
            });
        });
        
    });
})( jQuery, wp.customize );
