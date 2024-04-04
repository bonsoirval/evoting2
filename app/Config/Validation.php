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

    public array $update_party = [
        'name' => 'required|is_unique[party.name]',
        'abbreviation' => 'required|is_unique[party.abbreviation]',
        'slogan'    => 'required|is_unique[party.slogan]',
        'ideology' => 'required|is_unique[party.ideology]',
        'status' => 'required',
    ];

    public array $manage_party = [
        'query' => 'required',
        'search_type' => 'required'
    ];

    public array $update_party_errors = [
        'name' => ['required' => '<style color="red">Search Query needed</style>'],
        'abbreviation' => ['required' => '<style color:"red">Party abbreviation is required</style>'],
        'slogan' => ['required' => '<style color:"red">Party slogan is required</style>'],
        'ideology' => ['required' => '<style color:"red">Ideology is required</style>'],
        'status' => ['required' => '<style color:"red">Status is required</style>']
    ];

    public array $manage_party_errors = [
        'query' => ['required' => '<style color:"red">Search Qery needed</style>'],
        'search_type' => ['required' => '<style color:"red">Search Qery needed</style>']
    ];

    public array $add_party = [
        'name' => 'required|is_unique[party.name]',
        'abbreviation' => 'required|is_unique[party.abbreviation]',
        'slogan' => 'required|is_unique[party.slogan]',
        'ideology' => 'required|is_unique[party.ideology]',
    ];

    public array $add_party_errors = [
        'name' =>[
            'required' => 'Party must be filled',
            'is_unique' => 'Party already exists'
        ],
        'abbreviation' => [
            'required' => '<style color:"red">Party abbreviation must be filled',
            'is_unique' => '<style color:"red">Party abbreviation already exists'
        ],
        'slogan' => [
            'required' => '<style color:"red">Party slogan must be filled</style>',
            'is_unique' => '<style color:"red">Party slogan already exists</style>'
        ],
        'ideology' => [
            'required' => '<style color:"red">Party ideology must be filled</style>',
            'is_unique' => '<style color:"red">Ideology already exists</style>'
        ]

    ];
    public array $admin_login = [
        'username' => 'required|max_length[30]|min_length[6]',
        'password' => 'required|max_length[30]|min_length[6]'
        ];
    public array $admin_login_errors = [
        'username' => [
            'required' => '<style color:"red">You must choose a username</style>',
        ],
        'password' => [
            'required' => '<style color:"red">Please enter password</style>',
        ]
        ];
}
