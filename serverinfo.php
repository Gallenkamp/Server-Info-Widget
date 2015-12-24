<?php
$output = '';
$values = array();

$section = 'PHP';
$values[$section][] = array('infoname' => 'PHP Version', 'info' => phpversion());

$section = 'Cache';
$values[$section][] = array('infoname' => 'APC available?', 'info' => extension_loaded('apc'));
$values[$section][] = array('infoname' => 'Memcache available?', 'info' => extension_loaded('memcached'));
$values[$section][] = array('infoname' => 'Cache handler in use', 'info' => $modx->getOption('cache_handler'));
$values[$section][] = array('infoname' => 'SQL queries cached?', 'info' => $modx->getOption('cache_db'));

$section = 'htaccess';
$values[$section][] = array('infoname' => 'Core Path', 'info' => $modx->getOption('base_path'));
$values[$section][] = array('infoname' => '.htaccess active?', 'info' => checkhtaccess('exists'));
$values[$section][] = array('infoname' => 'mod_rewrite enabled?', 'info' => checkhtaccess('rewrite'));

ksort($values);
#return var_dump($values);

while (list ($key, $val) = each ($values) ) {
  $output .= '<tr><td colspan="2"><strong>'.$key.'</strong></td></tr>';
  $i=0;
  while (list ($key2, $val2 ) = each ($val) ) {
   $output .= $modx->getChunk('tplServerinfo', $val[$i]); 
$i++;
  }
}

return '<table>'.$output.'</table>';

function checkhtaccess($mode) {
$handle = fopen($modx->getOption('base_path').'.htaccess', 'r');
switch ($mode) {
  case 'exists':
    if ($handle) {
      return 'yes';
    }
    else {
      return false;
    }
  case 'rewrite':
    $content = file_get_contents($handle);
    # here: scan for line that activates mod rewrite
    return $content;
  default:
    return false;
}
fclose($handle);
}
