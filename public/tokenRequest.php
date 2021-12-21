<?php

header(header: 'HTTP/1.1 410 Gone', response_code: 410);
header('Content-Type: text/plain; charset=utf-8');

echo 'This resource is no longer available.';
