<?php
if (array_key_exists('file', $_GET) && file_exists(sprintf('data/%s.data', $_GET['file']))) {
  $data = file(sprintf('data/%s.data', $_GET['file']));
  $timestamps = array();
  foreach ($data as $key => $row) {
    $p = json_decode($row, true);
    $timestamps[$p[0]] = $key;
  }
  ksort($timestamps);
  if (array_key_exists('ts', $_GET) && !empty($_GET['ts'])) {
    $i = array_search($_GET['ts'], array_keys($timestamps));
    if ($i !== false && count($timestamps) > $i + 1) {
      echo $data[array_values($timestamps)[$i + 1]];
    }
  } else {
    echo $data[array_values($timestamps)[0]];
  }
}