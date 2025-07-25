<?php

return [
    'alert'   => [
        'position'          => 'top-end',
        'timer'             => 3000,
        'toast'             => true,
        'text'              => null,
        'showCancelButton'  => false,
        'showConfirmButton' => false
    ],
    'confirm' => [
        'icon'               => 'warning',
        'position'           => 'center',
        'toast'              => false,
        'timer'              => null,
        'showConfirmButton'  => true,
        'showCancelButton'   => true,
        'confirmButtonText'  => 'Yes, do it!',
        'cancelButtonText'   => 'No, cancel!',
        'customClass'       => [
            'buttonsStyling' => false,
            'confirmButton'  => 'btn btn-danger',
            'cancelButton'   => 'btn btn-secondary'
        ],
    ],
    'success' => [
        'icon'              => 'success',
        'position'          => 'center',
        'toast'             => false,
        'timer'             => null,
        'showConfirmButton' => true,
        'showCancelButton'  => false,
        'confirmButtonText' => 'Ok, got it!',
        'customClass'       => [
            'buttonsStyling' => false,
            'confirmButton'  => 'btn btn-success'
        ],
    ],
    'error'   => [
        'icon'              => 'error',
        'position'          => 'center',
        'toast'             => false,
        'timer'             => null,
        'showConfirmButton' => true,
        'showCancelButton'  => false,
        'confirmButtonText' => 'Ok, got it!',
        'customClass'       => [
            'buttonsStyling' => false,
            'confirmButton'  => 'btn btn-danger'
        ]
    ],
];
