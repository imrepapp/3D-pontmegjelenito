<?php
if (empty($_POST['id'])) {
  $_POST['id'] = uniqid();
}
$fileName = sprintf('data/%s.data', $_POST['id']);

if (!empty($_POST['data']) && json_decode($_POST['data']) !== null) {
  $obj = json_decode($_POST['data'], true);
  if (array_key_exists('timestamp', $obj) && array_key_exists('point', $obj)) {
    $fp = fopen($fileName, 'a+');
    if ($fp) {
      if (is_array($obj['point']) && !is_array($obj['point'][0])) {
        $points = array($obj['point']);
      } else {
        $points = $obj['point'];
      }

      foreach ($points as $point) {
        array_unshift($point, $obj['timestamp']);
        fwrite($fp, sprintf("%s\n", json_encode($point)));
      }
      echo $_POST['id'];
    } else {
      echo 'file is not writeable';
    }
    fclose($fp);
  } else {
    echo 'wrong json syntax';
  }
} else {
  echo 'no json data';
}

