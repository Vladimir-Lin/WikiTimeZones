<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php"                   ;
use CIOS\DB as CiosDB                                                        ;

function Say ( $TZH )
{
  $DB = new CiosDB ( ) ;
  if ( ! $DB -> Connect ( $TZH ) ) {
    return $DB -> SQL -> connect_error ;
  }
  $DB -> Close ( ) ;
  unset ( $DB ) ;
  return "TIMEZONE" ;
}

?>
