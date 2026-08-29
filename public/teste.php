<?php
echo 'File Uploads: ' . ini_get('file_uploads') . '<br>';
echo 'Max Size: ' . ini_get('upload_max_filesize') . '<br>';
echo 'Post Max: ' . ini_get('post_max_size') . '<br>';
echo 'Temp Dir: ' . sys_get_temp_dir() . '<br>';
echo 'Temp Dir Writable: ' . (is_writable(sys_get_temp_dir()) ? 'Yes' : 'No');
