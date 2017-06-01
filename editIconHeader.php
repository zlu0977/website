<?php
  //stff
  //editHeader
  $userId = getUserId($user);
  $headerOld = $_POST['headerOld'];
  $headerNew = $_POST['headerNew'];
  
  $headerOldId = checkHeaderId($headerOld);
  $headerNewId = checkHeaderId($headerNew);
  
  $cmd = "UPDATE `uh`
          SET `header_id1` = '$headerNewId'
          WHERE `user_id1` = '$userId'
          AND `header_id1` = '$headerOldId'"
  getDBResults($cmd);
  
  //editIcon
  $userId = getUserId($user);
  
  $header = $_POST['header'];
  $headerId = checkHeader($header);
  $uhId = checkUh($header, $user);
  
  $urlOld = $_POST['urlOld'];
  $urlExtensionNew = explode("/", $_POST['urlNew'], 2);
  $urlNew = $urlExtensionNew[0];
  $extension = ""
  if(count($urlExntesionNew) > 1)
    $extension = $urlExtensionNew[1];
  
  
  $urlOldId = checkWebsite($urlOld);
  $urlNewId = checkWebsite($urlNew);
  
  
  
  $displayOld = $_POST['displayOld'];
  $displayNew = $_POST['displayNew'];
  $displayOldId = checkWebicon($displayOld);
  $displayNewId = checkWebicon($displayNew);
   
  $webOldId = checkWeb($displayOldId, $urlOldId);
  $webNewId = checkWeb($displayNewId, $urlNewId);
   
  $uhId = checkUh($headerId, $userId);
  
  $cmd = "UPDATE `uhw`
          SET `web_id1' = $webNewId', `extension` = '$extension'
          WHERE `uh_id1` = '$uhId'
          AND `web_id1` = '$webOldId'";
  if($extension == "")
    $cmd = "UPDATE `uhw`
            SET `web_id1' = $webNewId', `extension` = NULL
            WHERE `uh_id1` = '$uhId'
            AND `web_id1` = '$webOldId'";
            
  getDBResults($cmd);
?>
