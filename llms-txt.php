<?php
header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: public, max-age=86400');
header('X-Robots-Tag: noindex');
readfile(__DIR__ . '/llms.txt');
