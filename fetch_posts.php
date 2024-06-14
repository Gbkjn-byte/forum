<?php
$chat_id = isset($_GET['chat_id']) ? intval($_GET['chat_id']) : 0;
$files = array_diff(scandir('posts', SCANDIR_SORT_DESCENDING), array('.', '..'));
foreach ($files as $file) {
    if (strpos($file, "{$chat_id}_") === 0) {
        echo file_get_contents("posts/$file");
    }
}
?>
