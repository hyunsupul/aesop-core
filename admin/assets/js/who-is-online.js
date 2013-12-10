var whoisonline = { online: false, onlinePrev: false };

jQuery(document).ready(function(){

        //Set initial beat to fast
        wp.heartbeat.interval( 'fast' );

        //Enqueue are data
        wp.heartbeat.enqueue( 'who-is-online', 'whoisonline', false );

        jQuery(document).on( 'heartbeat-tick.whoisonline', function( event, data, textStatus, jqXHR ) {

             if( data.hasOwnProperty( 'whoisonline' ) ){        

                if( whoisonline.online === false ){
                        //If just loaded, don't say anything...
                        whoisonline.online = data.whoisonline;
                }
                whoisonline.onlinePrev = whoisonline.online || {};
        
                for( var id in whoisonline.onlinePrev ) {
                        if( ! whoisonline.online.hasOwnProperty( id ) ){
                                 jQuery.noticeAdd( { text: whoisonline.onlinePrev[id] + " is now offline" } );
                        }
                }

                for(var id in whoisonline.online) {
                        if( ! whoisonline.onlinePrev.hasOwnProperty( id) ){
                                 jQuery.noticeAdd( { text: whoisonline.online[id] + " is now online" } );
                        }
                }
             }
                wp.heartbeat.enqueue( 'who-is-online', 'whoisonline', false );
        });

});