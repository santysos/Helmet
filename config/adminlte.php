<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Helmet',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Helmet</b> by Ergomas',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-light navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
  
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        [
            'type' => 'darkmode-widget',
            'topnav_right' => true,     // Or "topnav => true" to place on the left.
        ],
    
       

        // Sidebar items:
     

        [
            'text' => 'Perfil Empresa',
            'icon' => 'fas fa-fw fa-industry',
            'label_color' => 'success',
            'submenu' => [
                
                [
                    'text' => 'Datos de Empresa',
                    'url' => 'empresas',
                    'icon' => 'fas fa-fw fa-calendar-check',
                ],
            ],
        ],
       
        [
            'text' => 'Formatos',
            'icon' => 'fas fa-fw fa-list',
            'submenu' => [
                
                [
                    'text' => 'Inspección Mensual',
                    'icon' => 'fas fa-fw fa-calendar-check',
                    'url' => 'inspecciones',
                ],
                [
                    'text' => 'Reporte de Incidentes',
                    'icon' => 'fas fa-fw fa-chalkboard-teacher',
                    'url' => 'casi_accidente',
                ],
               
                [
                    'text' => 'Charlas de Seguridad',
                    'icon' => 'fas fa-fw fa-user-shield',
                    'url' => 'registros_charlas',
                ],
                [
                    'text' => 'Inspección de Vehículos',
                    'icon' => 'fas fa-fw fa-truck',
                    'url' => 'vehiculos',
                ],
                [
                    'text' => 'Check List de Extintores',
                    'icon' => 'fas fa-fw fa-fire-alt',
                    'url' => 'inspecciones_extintores',
                ],
              
            ],
        ],

        [
            'text' => 'Sistema de Gestión',
            'icon' => 'fas fa-fw fa-sitemap',
            'label_color' => 'success',
            'submenu' => [
                
               
                [
                    'text' => 'Administrativa',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        
                        [
                            'text' => 'Procedimientos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'administrativa/procedimientos',
                        ],
                        [
                            'text' => 'Formatos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'administrativa/formatos',
                        ],
                        [
                            'text' => 'Registros',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'administrativa/registros',
                        ],
                      
                    ],
                ],
                [
                    'text' => 'Técnica',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        
                        [
                            'text' => 'Procedimientos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'tecnica/procedimientos',
                        ],
                        [
                            'text' => 'Formatos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'tecnica/formatos',
                        ],
                        [
                            'text' => 'Registros',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'tecnica/registros',
                        ],
                      
                    ],
                ],
                [
                    'text' => 'Procesos Operativos',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        
                        [
                            'text' => 'Procedimientos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'procesosoperativos/procedimientos',
                        ],
                        [
                            'text' => 'Formatos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'procesosoperativos/formatos',
                        ],
                        [
                            'text' => 'Registros',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'procesosoperativos/registros',
                        ],
                      
                    ],
                ],
                [
                    'text' => 'Talento Humano',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        
                        [
                            'text' => 'Procedimientos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'talentohumano/procedimientos',
                        ],
                        [
                            'text' => 'Formatos',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'talentohumano/formatos',
                        ],
                        [
                            'text' => 'Registros',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => 'talentohumano/registros',
                        ],
                      
                    ],
                ],
              
            ],
        ],

        [
            'text' => 'Aprobaciones Ministerio de Trabajo',
            'icon' => 'fas fa-fw fa-folder-plus',
            'label_color' => 'success',
            'submenu' => [            
                [
                    'text' => 'Técnico de SSO',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
                [
                    'text' => 'Reglamento de SSO',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
                [
                    'text' => 'Programas',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        [
                            'text' => 'Psicosocial',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],
                        [
                            'text' => 'Drogas y Alcohol',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],
                        [
                            'text' => 'Prevención de Discriminación',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],
                        [
                            'text' => 'VIH Sida',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],

                    ],
                ],
                [
                    'text' => 'Plan de Emergencia',
                    'icon' => 'fas fa-fw fa-folder',
                    'submenu' => [
                        [
                            'text' => 'Brigadas',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],
                        [
                            'text' => 'Simulacros',
                            'icon' => 'far fa-fw fa-folder-open',
                            'url' => '#',
                        ],

                    ],
                ],
                [
                    'text' => 'Salud Ocupacional',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
            ],
        ],
        [
            'text' => 'Comité Paritario',
            'icon' => 'fas fa-fw fa-users',
            'submenu' => [            
                [
                    'text' => 'Aprobaciones',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
                [
                    'text' => 'Acta de Reuniones',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
                [
                    'text' => 'Informe de Gestión',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => '#',
                ],
            ],
        ],

        [
            'text' => 'Recursos',
            'icon' => 'fas fa-fw fa-folder-plus',
            'label_color' => 'success',
            'submenu' => [            
                [
                    'text' => 'Charlas de Seguridad',
                    'icon' => 'fas fa-fw fa-folder',
                    'url' => 'recursos/charlas_seguridad',
                ],
            ],
        ],
    

        ['header' => 'CONFIGURACIONES'],
        [
            'text' => 'Extintores',
            'icon' => 'fas fa-fw fa-fire-extinguisher',
            'url' => 'extintores',
        ],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'icon_color' => 'yellow',
            'url' => 'users',
        ],
        [
            'text' => 'Roles',
            'icon' => 'fas fa-fw fa-people-arrows',
            'icon_color' => 'cyan',
            'url' => 'roles',
        ],
        [
            'text' => 'Permisos',
            'icon' => 'fas fa-fw fa-user-check',
            'icon_color' => 'cyan',
            'url' => 'permissions',
        ],
        [
            'text' => 'Trabajadores',
            'url' => 'trabajadores',
            'icon' => 'fas fa-fw fa-user-friends',
        ],
        [
            'text' => 'Empresas',
            'url' => 'empresas',
            'icon' => 'fas fa-fw fa-calendar-check',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
