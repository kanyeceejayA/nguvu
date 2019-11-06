<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( $_POST['payload'] ) {
shell_exec( 'cd /python/nguvu/public_html/insights/ && git reset –hard HEAD && git pull' );
}

?>