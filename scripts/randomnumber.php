<?php

//四位的随机数
for ($j=0;$j<10;$j++) {
    $rand = '';
    for ($i=0;$i<4;$i++) {
        $rand = $rand.rand(0,9);
    }
    echo $rand.PHP_EOL;
}