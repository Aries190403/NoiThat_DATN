<?php
return [
    'roles' => [
        'admin' => [
            'name' => 'ROLE_SUPER_ADMIN',
            'permissions' => [
                // Các quyền của vai trò Admin
            ],
        ],
        'product_editor' => [
            'name' => 'ROLE_PRODUCT_EDITOR',
            'inherits' => ['admin'],
            'permissions' => [
            ],
        ],
        'user' => [
            'name' => 'USER',
            'inherits' => [],
            'permissions' => [
            ],
        ],
    ],
];
