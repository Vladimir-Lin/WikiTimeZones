<?php

require_once dirname(__FILE__) . "/config.php"                               ;
require_once dirname(__FILE__) . "/php/tz.php"                               ;

class TimeZoneWiki
{

public static function setHooks ( &$parser )
{
  $parser -> setFunctionHook ( 'TimeZoneLists' , [ self::class , 'TzEditor' ] ) ;
  return true ;
}

public static function TzEditor( Parser $parser , $LANG = "zh-TW" )
{
  ////////////////////////////////////////////////////////////////////////////
  $args     = func_get_args ( ) ;
  $outp     = Say ( $GLOBALS [ "TzHost" ] ) ;
  ////////////////////////////////////////////////////////////////////////////
  $parser -> getOutput ( ) -> addModules ( [ 'ext.TimeZones' ] )             ;
  ////////////////////////////////////////////////////////////////////////////
  return array ( $outp , 'noparse' => true , 'isHTML' => true )              ;
}

}

?>
