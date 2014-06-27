<?php

if ( ! function_exists('display_pagination'))
{
  /** 
   * Determine if pagination should be shown.
   * @param  [type] $paginatorObject [description]
   * @return boolean
   */
  function display_pagination( Illuminate\Pagination\Paginator $paginatorObject )
  {
    return number_format($paginatorObject->getTotal() / $paginatorObject->getPerPage(), 2) > 1;
  }
}

if ( ! function_exists('format_mac_address'))
{
  /** 
   * Take a mac address and convert all colons to hypens.
   * 
   * @param  string $mac_address The computer's mac address.
   * @return string
   */
  function format_mac_address( $mac_address )
  {
    // Replace all colons with a hyphen.
    // 
    return str_replace( ':' , '-' , $mac_address );
  }
}

if ( ! function_exists('powershell_path'))
{
    /**
     * Get the path to the powershell folder.
     *
     * @param   string $path
     * @return  string
     */
    function powershell_path($path = '')
    {
        return app('path.powershell').($path ? '/'.$path : $path);
    }
}


if ( ! function_exists('remove_strange_characters'))
{
    function remove_strange_characters( $string = '' )
    {
          $string_array = STR_SPLIT( $string ); 
          $new_string = '';

          foreach( $string_array AS $character )
          {    
            $character_number = ord( $character );

            if( $character_number == 163 )
            { 
                $new_string .= $character; CONTINUE; 
            } // keep £ 

            if($character_number > 31 && $character_number < 127)
            {
                $new_string .= $character;
            }
            
          }  

          return $new_string;
    }
}