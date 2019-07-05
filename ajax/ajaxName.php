<?php
//////////////////////////////////////////////////////////////////////////////
require_once dirname(__FILE__) . "/../config.php"                            ;
require_once dirname(__FILE__) . "/../vendor/autoload.php"                   ;
use CIOS\DB         as CiosDB                                                ;
use CIOS\Strings    as Strings                                               ;
use CIOS\Name       as Name                                                  ;
use CIOS\Parameters as Parameters                                            ;
//////////////////////////////////////////////////////////////////////////////
$TABLES      = $GLOBALS [ "TzTables" ]                                       ;
$TZH         = $GLOBALS [ "TzHost"   ]                                       ;
$TzTable     = $TABLES  [ "TimeZone" ]                                       ;
$TzNames     = $TABLES  [ "TzNames"  ]                                       ;
//////////////////////////////////////////////////////////////////////////////
$DB          = new CiosDB       (                                          ) ;
$HH          = new Parameters   (                                          ) ;
$AA          = array            (                                          ) ;
//////////////////////////////////////////////////////////////////////////////
if                              ( $DB -> Connect ( $TZH )                  ) {
  ////////////////////////////////////////////////////////////////////////////
  $NN        = $HH -> Parameter ( "Name"                                   ) ;
  $TZID      = $HH -> Parameter ( "Uuid"                                   ) ;
  $LOCALITY  = $HH -> Parameter ( "Locality"                               ) ;
  $PRIORITY  = $HH -> Parameter ( "Priority"                               ) ;
  $RELEVANCE = $HH -> Parameter ( "Relevance"                              ) ;
  ////////////////////////////////////////////////////////////////////////////
  $NI        = new Name         (                                          ) ;
  $NI       -> set              ( "Uuid"      , $TZID                      ) ;
  $NI       -> set              ( "Locality"  , $LOCALITY                  ) ;
  $NI       -> set              ( "Priority"  , $PRIORITY                  ) ;
  $NI       -> set              ( "Relevance" , $RELEVANCE                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  if                            ( strlen ( $NN ) > 0                       ) {
    $NI     -> set              ( "Name" , $NN                             ) ;
    $DB     -> LockWrite        (          $TzNames                        ) ;
    $NI     -> Assure           ( $DB    , $TzNames                        ) ;
    $DB     -> UnlockTables     (                                          ) ;
  } else                                                                     {
    $QQ      = $NI -> Delete    (          $TzNames                        ) ;
    $DB     -> LockWrite        (          $TzNames                        ) ;
    $DB     -> Query            ( $QQ                                      ) ;
    $DB     -> UnlockTables     (                                          ) ;
  }                                                                          ;
  ////////////////////////////////////////////////////////////////////////////
  $DB -> Close                  (                                          ) ;
  unset                         ( $NI                                      ) ;
  ////////////////////////////////////////////////////////////////////////////
  $AA [ "Answer"  ] = "Yes"                                                  ;
  ////////////////////////////////////////////////////////////////////////////
} else                                                                       {
  ////////////////////////////////////////////////////////////////////////////
  $AA [ "Answer"  ] = "No"                                                   ;
  $AA [ "Problem" ] = $DB -> ConnectionError ( )                             ;
  ////////////////////////////////////////////////////////////////////////////
}                                                                            ;
//////////////////////////////////////////////////////////////////////////////
$RJ = json_encode                     ( $AA                                ) ;
//////////////////////////////////////////////////////////////////////////////
unset                                 ( $HH                                ) ;
unset                                 ( $DB                                ) ;
unset                                 ( $AA                                ) ;
//////////////////////////////////////////////////////////////////////////////
header                                ( "Content-Type: application/json"   ) ;
echo $RJ                                                                     ;
//////////////////////////////////////////////////////////////////////////////
?>
