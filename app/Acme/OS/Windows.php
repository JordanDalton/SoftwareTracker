<?php namespace Acme\OS;

use Cache;

class Windows {

    /** 
     * Reverse ARP (Get IP from MAC address.)
     * 
     * @param  string $mac_address    The mac address we are to search for.
     * @param  boolean $modified_run  Modified mac address run.
     * @return boolean|string
     */
    public function rarp( $mac_address , $modified_run = false )
    {
        // Define the cache key.
        // 
        $cache_key = sprintf('%s-%s', $mac_address, (int) $modified_run ? 1 : 0 );

        // First attempt to retreive from cache. If no cache record exists then we
        // will create one.
        // 
        return Cache::get( $cache_key , function() use ($cache_key, $mac_address, $modified_run)
        {
            // Convert the $mac_address to lowercase letters.
            // 
            $mac_address = strtolower( $mac_address  );

            // By default we will output a false return.
            // 
            $output = false;

            // Execute arp -a command. This will give us a table of results
            // that we will look through to find a IP for the mac addresss.
            // 
            $arp = exec( 'arp -a' , $results );

            // Loop through the results.
            // 
            foreach ( $results as $result )
            {
                // Search inside the string for the mac addresss.
                // 
                $match = strpos( $result , $mac_address );

                // If we have a match then we will use the data.
                // 
                if ( $match )
                {
                    // Remove all whitespace wrapping.
                    // 
                    $trimMatch = trim( $result );

                    // Now split the string upon each space.
                    // 
                    $split = preg_split( '/[\s]+/' , $trimMatch );

                    // Use the first result.
                    // 
                    $output = $split[ 0 ];

                    // Now break out of the loop.
                    // 
                    break;
                }
            }

            // If we have a false return and this execution is not using a programatically
            // modified mac address then we we will try to run the Windows:rarp() again but
            // with a modified mac address where hyphens are used instead of colons.
            // 
            if ( ! $output AND ! $modified_run )
            {
                // Replace all colons with a hyphen.
                // 
                $modified_mac_address = str_replace( ':' , '-' , $mac_address );

                // Now run the rap check again.
                // 
                $output = $this->rarp( $modified_mac_address, true );
            }

            // Set the data into cache for 24 hours.
            // 
            Cache::put( $cache_key , $output, 1440 );

            // Return the output.
            // 
            return $output;
        });
    }
}