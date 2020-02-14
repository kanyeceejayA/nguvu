<?php


if ($_SERVER["HTTP_HOST"] == "localhost") {
  $variables = [
    //values for localhost. Ingrid, replace any value here if it doesnt work for your environment
      'dbuser' => 'root',      
      'dbpass' => '',
      'dbname' => 'nguvu_wp',
      'DB_PORT' => '3306',
      'target_dir' => 'C:\\wamp64\\www\\nguvu\\assets\\img\\logos\\',
      'root' => 'http://localhost/nguvu'
  ];
}else{
  $variables = [
      'dbuser' => 'nguvu_user',      
      'dbpass' => 'nguvu1sab!gman',
      'dbname' => 'nguvu_wp',
      'DB_PORT' => '3306',
      'target_dir' => getcwd().'/../assets/img/logos/',
      'root' => 'https://nguvu.africa/insights'
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

  //root to pull on server
  // https://nguvu.africa:2083/cpsess7579149457/frontend/paper_lantern/version_control/index.html#/manage/%252Fpython%252Fnguvu%252Fpublic_html%252Finsights/deploy
?>