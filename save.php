<?php
$DEFAULTS = array(
  'axis'  => array(23.78, 10, 10.97),
  'scale' => 1.0,
  'floor' => 0,
  'zoom'  => 150,
  'grid'  => array(
    'visible' => true,
    'step' => 50
  ),
  'camera' => array(1000, 1000, 1000),
  'court'  => 'img/court.jpg'
);
if (array_key_exists('config', $_POST)) {
  $id = uniqid();
  if (!empty($_POST['config']) && json_decode($_POST['config']) !== null) {
    $config = array_merge($DEFAULTS, json_decode($_POST['config'], true));
  } else {
    echo 'wrong json syntax';
  }

  if ($fp = fopen(sprintf('data/%s.json', $id), 'w+')) {
    fwrite($fp, json_encode($config));
    fclose($fp);
  } else {
    echo 'file is not writeable';
  }

  echo $id;
} elseif (array_key_exists('id',  $_POST)) {
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
} else {
  echo 'error';
}

