<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( $_POST['payload'] ) {
shell_exec( 'cd /python/nguvu/public_html/insights/ && git reset –hard HEAD && git pull' );
}
function isEnabled($func) {
    return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
}
if (isEnabled('shell_exec')) {
    shell_exec('echo "enabled"');
    echo "it works, from echo functions";
}else{
	echo 'its not enabled<br><br> >>>>>>>>>>>>';
}

if(is_callable($func)){
	echo "it's not callable";
elseif(false === stripos(ini_get('disable_functions'), $func)){
	echo "It is disabled";
}else{
	echo "idk wtf is happening";
}

?>