
<?php

function sendMessage($chatID, $message){
  $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatID."&text=".urlencode($message)."&parse_mode=html";
  file_get_contents($url);
}
?>
