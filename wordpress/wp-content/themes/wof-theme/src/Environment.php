<?php


namespace WOF\Org\Theme;


class Environment {

    public function registerHooks () {
        add_action( 'added_option',   array($this, 'tryClearOptionsCache') );
        add_action( 'updated_option', array($this, 'tryClearOptionsCache') );
        add_action( 'deleted_option', array($this, 'tryClearOptionsCache') );
    }

    /**
     * Fix a race condition in alloptions caching
     *
     * See https://core.trac.wordpress.org/ticket/31245
     */
    function tryClearOptionsCache( $option ) {
        if ( ! wp_installing() ) {
            $alloptions = wp_load_alloptions(); //alloptions should be cached at this point

            if ( isset( $alloptions[ $option ] ) ) { //only if option is among alloptions
                wp_cache_delete( 'alloptions', 'options' );
            }
        }
    }

}