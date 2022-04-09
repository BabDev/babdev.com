<?php

return [
    'options' => [
        'init' => [
            'autoresize_bottom_margin' => 40,
            'branding' => false,
            'image_caption' => true,
            'menubar' => false,
            'paste_as_text' => true,
        ],
        'plugins' => 'advlist autolink autoresize code lists link image media table wordcount',
        'toolbar' => [
            'undo redo | blocks forecolor backcolor |
                 bold italic underline strikethrough blockquote removeformat |
                 align bullist numlist outdent indent | link table media | code',
        ],
        'apiKey' => env('TINYMCE_API_KEY', ''),
    ],
];
