<?php

namespace Aspectcs\MyForumBuilder\Database\Seeders;

use Aspectcs\MyForumBuilder\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $priority = 1;

        Setting::checkAndCreate(['id' => '11'], [
            'priority' => $priority++,
            'title' => 'Forum Name',
            'fields' => [
                [
                    'name' => 'name',
                    'type' => 'input',
                    'label' => 'Forum Name',
                ],
            ],
            'values' => [
                'name' => ''
            ]
        ]);

        Setting::checkAndCreate(['id' => '10'], [
            'priority' => $priority++,
            'title' => 'APP Keys',
            'fields' => [
                [
                    'name' => 'APP_KEY',
                    'type' => 'env',
                    'fieldType'=>'hidden',
                    'label' => 'APP Key',
                ],
                [
                    'name' => 'APP_SECRET',
                    'type' => 'env',
                    'fieldType'=>'hidden',
                    'label' => 'APP Secret',
                ],
            ],
            'values' => null
        ]);

        Setting::checkAndCreate(['id' => '8'], [
            'priority' => $priority++,
            'title' => 'Google Analytics',
            'fields' => [
                [
                    'name' => 'analytics',
                    'type' => 'textarea',
                    'label' => 'Google Analytics',
                ],
            ],
            'values' => [
                'analytics' => ''
            ]
        ]);

        Setting::checkAndCreate(['id' => '9'], [
            'priority' => $priority++,
            'title' => 'Google ADS Code',
            'fields' => [
                [
                    'name' => 'ads',
                    'type' => 'textarea',
                    'label' => 'Google ADS Code',
                ],
            ],
            'values' => [
                'ads' => ''
            ]
        ]);

        Setting::checkAndCreate(['id' => '6'], [
            'priority' => $priority++,
            'title' => 'Navbar Management',
            'fields' => [
                [
                    'name' => 'navbar',
                    'type' => 'navbar',
                    'label' => 'Navbar',
                ],
            ],
            'values' => [
                [
                    'label' => 'Home',
                    'href' => '/',
                ]
            ]
        ]);


        Setting::checkAndCreate(['id' => '14'], [
            'priority' => $priority++,
            'title' => 'Footer Management',
            'fields' => [
                [
                    'name' => 'footer',
                    'type' => 'footer',
                    'label' => 'Footer',
                ],
            ],
            'values' => [
                [
                    'label' => 'Privacy Policy',
                    'href' => '/privacy-policy',
                ]
            ]
        ]);

        Setting::checkAndCreate(['id' => '7'], [
            'priority' => $priority++,
            'title' => 'Favicon & Logo & Spinner',
            'fields' => [
                [
                    'name' => 'favicon',
                    'type' => 'file',
                    'label' => 'Favicon',
                ],
                [
                    'name' => 'logo',
                    'type' => 'file',
                    'label' => 'Color Logo (215 × 67)',
                ],
                [
                    'name' => 'logo-w',
                    'type' => 'file',
                    'label' => 'White Logo (215 × 67)',
                ],
                [
                    'type' => 'section-break',
                    'heading' => 'Spinner Section'
                ],
                [
                    'name' => 'spinner-logo',
                    'type' => 'file',
                    'label' => 'Spinner Logo (71 × 67)',
                ],
                [
                    'name' => 'spinner-heading',
                    'type' => 'input',
                    'label' => 'Spinner Heading',
                ],
                [
                    'name' => 'spinner-description',
                    'type' => 'input',
                    'label' => 'Spinner Description',
                ],
            ],
            'values' => [
                "logo" => "logo.png",
                "logo-w" => "logo-w.png",
                "favicon" => "favicon.ico",
                "spinner-logo" => "spinner-logo.png",
                "spinner-heading" => "What is Lorem Ipsum?",
                "spinner-description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
            ]
        ]);

        Setting::checkAndCreate(['id' => '1'], [
            'priority' => $priority++,
            'title' => 'Home Page Meta',
            'fields' => [
                [
                    'name' => 'title',
                    'type' => 'input',
                    'label' => 'Meta title',
                ],
                [
                    'name' => 'description',
                    'type' => 'textarea',
                    'label' => 'Meta Description',
                ]
            ],
            'values' => [
                'title' => '',
                'description' => '',
            ]
        ]);

        Setting::checkAndCreate(['id' => '2'], [
            'priority' => $priority++,
            'title' => 'Category Meta',
            'fields' => [
                [
                    'name' => 'title',
                    'type' => 'input',
                    'label' => 'Meta title [CATEGORY]',
                ],
                [
                    'name' => 'description',
                    'type' => 'textarea',
                    'label' => 'Meta Description [CATEGORY]',
                ]
            ],
            'values' => [
                'title' => '',
                'description' => '',
            ]
        ]);

        Setting::checkAndCreate(['id' => '3'], [
            'priority' => $priority++,
            'title' => 'Sub Category Meta',
            'fields' => [
                [
                    'name' => 'title',
                    'type' => 'input',
                    'label' => 'Meta title [CATEGORY],[SUB-CATEGORY]',
                ],
                [
                    'name' => 'description',
                    'type' => 'textarea',
                    'label' => 'Meta Description [CATEGORY],[SUB-CATEGORY]',
                ]
            ],
            'values' => [
                'title' => '',
                'description' => '',
            ]
        ]);

        Setting::checkAndCreate(['id' => '4'], [
            'priority' => $priority++,
            'title' => 'Tag Meta',
            'fields' => [
                [
                    'name' => 'title',
                    'type' => 'input',
                    'label' => 'Meta title [TAG]',
                ],
                [
                    'name' => 'description',
                    'type' => 'textarea',
                    'label' => 'Meta Description [TAG]',
                ]
            ],
            'values' => [
                'title' => '',
                'description' => '',
            ]
        ]);

        Setting::checkAndCreate(['id' => '5'], [
            'priority' => $priority++,
            'title' => 'User Meta',
            'fields' => [
                [
                    'name' => 'title',
                    'type' => 'input',
                    'label' => 'Meta title [NAME],[USERNAME]',
                ],
                [
                    'name' => 'description',
                    'type' => 'textarea',
                    'label' => 'Meta Description [NAME],[USERNAME]',
                ]
            ],
            'values' => [
                'title' => '',
                'description' => '',
            ]
        ]);

        Setting::checkAndCreate(['id' => '12'], [
            'priority' => $priority++,
            'title' => 'Admin Url Prefix',
            'fields' => [
                [
                    'name' => 'ADMIN_URL_PREFIX',
                    'type' => 'env',
                    'label' => 'Admin Url Prefix',
                ],
            ],
            'values' => null
        ]);

        Setting::checkAndCreate(['id' => '13'], [
            'priority' => $priority++,
            'title' => 'Forum Start Date',
            'fields' => [
                [
                    'name' => 'FORUM_START_DATE',
                    'type' => 'env',
                    'fieldType'=>'date',
                    'label' => 'Forum Start Date (YYYY-MM-DD) example (2020-10-01)',
                ],
            ],
            'values' => null
        ]);

    }
}
