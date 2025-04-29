<?php
$passwords = ['@1!c3', 'B0b', 'Ch@rl!3', 'D@v3'];
foreach ($passwords as $pwd) {
    echo "Password: $pwd, SHA1: " . sha1($pwd) . "\n";
}
?>


