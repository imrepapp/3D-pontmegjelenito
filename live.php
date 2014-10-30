<?php
if (array_key_exists('file', $_GET) && file_exists(sprintf('data/%s.data', $_GET['file']))) {
  $data = file(sprintf('data/%s.data', $_GET['file']));
  $row = 0;
  if (array_key_exists('row', $_GET) && !empty($_GET['row'])) {
    $row = $_GET['row'];
  }
  printf('[%s]', join(',', array_slice($data, $row)));
}


/* timestamp
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
      $ret = array();
      for ($j = $i+1; $j < count($timestamps); $j++) {
        $ret[] = json_decode($data[array_values($timestamps)[$j]]);
      }
      echo json_encode($ret);
    }
  } else {
    printf('[%s]', $data[array_values($timestamps)[0]]);
  }
}