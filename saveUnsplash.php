<?php
$ch = curl_init($_POST['imgBase64']);
$uniqID = uniqid();
$fp = fopen('./images/unsplash/' . $uniqID . '.png', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

echo $uniqID;
return;
?>