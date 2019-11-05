<?php


if ($_SERVER["HTTP_HOST"] == "localhost") {
  $variables = [
    //values for localhost. Ingrid, replace any value here if it doesnt work for your environment
      'dbuser' => 'root',      
      'dbpass' => '',
      'dbname' => 'nguvu',
      'DB_PORT' => '3306',
      'target_dir' => 'C:\\wamp64\\www\\nguvu\\assets\\img\\logos\\',
  ];
}else{
  $variables = [
      'dbuser' => 'nguvu_user',      
      'dbpass' => 'nguvu1sab!gman',
      'dbname' => 'nguvu_wp',
      'DB_PORT' => '3306',
      'target_dir' => getcwd().'/../assets/img/logos/',
  ];
}
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
  if(!function_exists('env')) {
      function env($key, $default = null)
      {
          $value = getenv($key);
          if ($value === false) {
              return $default;
          }
          return $value;
      }
  }
?>