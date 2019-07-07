<?php

require_once dirname(__FILE__) . "/config.php"                               ;
require_once dirname(__FILE__) . "/php/tz.php"                               ;

class TimeZoneWiki
{

public static function setHooks ( &$parser )
{
  $parser -> setFunctionHook ( 'TimeZoneLists'    , [ self::class , 'TzEditor'   ] ) ;
  $parser -> setFunctionHook ( 'TimeZoneSelector' , [ self::class , 'TzSelector' ] ) ;
  return true ;
}

public static function TzEditor( Parser $parser , $LANG = "zh-TW" )
{
  ////////////////////////////////////////////////////////////////////////////
  $mypath   = dirname      ( __FILE__                                      ) ;
  $mypath   = str_replace  ( "\\" , "/" , $mypath                          ) ;
  $rootpt   = dirname      ( dirname ( $mypath )                           ) ;
  $rootpt   = str_replace  ( "\\" , "/" , $rootpt                          ) ;
  $croot    = str_replace  ( $rootpt , "" , $mypath                        ) ;
  ////////////////////////////////////////////////////////////////////////////
  $args     = func_get_args (                                              ) ;
  $outp     = TzWiki::SayTz ( $GLOBALS [ "TzHost" ] , $croot , $args       ) ;
  ////////////////////////////////////////////////////////////////////////////
  $parser -> getOutput ( ) -> addModules ( [ 'ext.TimeZones' ] )             ;
  ////////////////////////////////////////////////////////////////////////////
  return array ( $outp , 'noparse' => true , 'isHTML' => true )              ;
}

public static function TzSelector( Parser $parser , $LANG = "zh-TW" )
{
  ////////////////////////////////////////////////////////////////////////////
  $mypath   = dirname            ( __FILE__                                ) ;
  $mypath   = str_replace        ( "\\" , "/" , $mypath                    ) ;
  $rootpt   = dirname            ( dirname ( $mypath )                     ) ;
  $rootpt   = str_replace        ( "\\" , "/" , $rootpt                    ) ;
  $croot    = str_replace        ( $rootpt , "" , $mypath                  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $args     = func_get_args      (                                         ) ;
  $outp     = TzWiki::TzSelector ( $GLOBALS [ "TzHost" ] , $croot , $args  ) ;
  ////////////////////////////////////////////////////////////////////////////
  $parser -> getOutput ( ) -> addModules ( [ 'ext.TimeZones' ] )             ;
  ////////////////////////////////////////////////////////////////////////////
  return array ( $outp , 'noparse' => true , 'isHTML' => true )              ;
}

}

?>
