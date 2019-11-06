<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( 1 ) {
shell_exec( 'cd /python/nguvu/public_html/insights/ && git reset –hard HEAD && git pull' );
}
function isEnabled($func) {
    return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}
if (isEnabled('shell_exec')) {
    shell_exec('echo "enabled"');
    echo "it is enabled, from echo functions<br>";
}else{
	echo 'its not enabled<br><br> >>>>>>>>>>>><br><br>';
}

if(is_callable('shell_exec')){
	echo "it's callable";
}
elseif(false === stripos(ini_get('disable_functions'), 'shell_exec')){
	echo "It is enabled";
}else{
	echo "idk wtf is happening";
}

?>