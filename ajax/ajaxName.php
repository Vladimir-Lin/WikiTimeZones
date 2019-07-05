<?php
//////////////////////////////////////////////////////////////////////////
// 更新人物名稱
// 位置：/php/ajaxName.php
// SQL Table Locked Ready
//////////////////////////////////////////////////////////////////////////
require_once dirname(__FILE__) . "/actions.php"                          ;
require_once dirname(__FILE__) . "/NameItem.php"                         ;
//////////////////////////////////////////////////////////////////////////
$PU  = $_SESSION [ "ACTIONS_UUID" ]                                      ;
$HH  = new Parameters (                                                ) ;
$DB  = new ActionsDB  (                                                ) ;
$AA  = array          (                                                ) ;
$URL = ""                                                                ;
//////////////////////////////////////////////////////////////////////////
GetCurrentDB          (                                                ) ;
if                    ( $DB -> ConnectDB ( $CurrentDB )                ) {
  ////////////////////////////////////////////////////////////////////////
  $NN  = $HH -> Parameter ( "Name" )                                     ;
  $XU  = $HH -> Parameter ( "Uuid" )                                     ;
  if ( strlen ( $XU ) > 0 ) $PU = $XU                                    ;
  ////////////////////////////////////////////////////////////////////////
  $NI  = new NameItem (                                                ) ;
  $NI -> set          ( "Uuid"      , $PU                              ) ;
  $NI -> set          ( "Locality"  , $HH -> Parameter ( "Locality"  ) ) ;
  $NI -> set          ( "Priority"  , $HH -> Parameter ( "Priority"  ) ) ;
  $NI -> set          ( "Relevance" , $HH -> Parameter ( "Relevance" ) ) ;
  if ( strlen ( $NN ) > 0 )                                              {
    $NI -> set           ( "Name"   , $NN             )                  ;
    $DB -> LockWrite     (            "`erp`.`names`" )                  ;
    $NI -> Assure        ( $DB      , "`erp`.`names`" )                  ;
    $DB -> UnlockTables  (                            )                  ;
  } else                                                                 {
    $QQ  = $NI -> Delete (            "`erp`.`names`" )                  ;
    $DB -> LockWrite     (            "`erp`.`names`" )                  ;
    $DB -> Query         ( $QQ                        )                  ;
    $DB -> UnlockTables  (                            )                  ;
  }                                                                      ;
  ////////////////////////////////////////////////////////////////////////
  $DB -> CloseDB ( )                                                     ;
  unset ( $NI )                                                          ;
  ////////////////////////////////////////////////////////////////////////
  $AA [ "Answer"  ] = "Yes"                                              ;
} else                                                                   {
  $AA [ "Answer"  ] = "No"                                               ;
  $AA [ "Problem" ] = "SQL connection fail"                              ;
}                                                                        ;
$RJ = json_encode ( $AA )                                                ;
//////////////////////////////////////////////////////////////////////////
unset ( $HH )                                                            ;
unset ( $DB )                                                            ;
//////////////////////////////////////////////////////////////////////////
unset ( $AA )                                                            ;
echo $RJ                                                                 ;
//////////////////////////////////////////////////////////////////////////
?>
