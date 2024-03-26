<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------


    public array $add_party = [
        'party' => 'required|is_unique[party.name]',
        'abbreviation' => 'required|is_unique[party.abbreviation]',
    ];

    public array $add_party_errors = [
        'party' =>[
            'required' => 'Party must be filled',
            'is_unique' => 'Party already exists'
        ],
        'abbreviation' => [
            'required' => 'Party abbreviation must be filled',
            'is_unique' => 'Party abbreviation already exists'
        ]
    ];
    public array $admin_login = [
        'username' => 'required|max_length[30]|min_length[6]',
        'password' => 'required|max_length[30]|min_length[6]'
        ];
    public array $admin_login_errors = [
        'username' => [
            'required' => "You must choose a username",
        ],
        'password' => [
            'required' => 'Please enter password',
        ]
        ];
}
