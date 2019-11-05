    <?php

    error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
    include 'env.php';
    $target_dir = getcwd().'/./assets/img/logos/';
    echo $target_dir;
    echo "<br>\n".getcwd();

    if (file_exists($target_dir.'fb.png')) {
        echo "file exists\n <br>";
    }
    