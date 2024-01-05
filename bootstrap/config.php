<?php

return [
    'activitylog' => [
        'enabled' => true,
        'delete_records_older_than_days' => 1,
        'default_log_name' => 'default',
        'default_auth_driver' => null,
        'subject_returns_soft_deleted_models' => false,
        'activity_model' => 'Spatie\\Activitylog\\Models\\Activity',
        'table_name' => 'activity_log',
        'database_connection' => null,
    ],
    'app' => [
        'name' => 'Laravel',
        'env' => 'local',
        'debug' => true,
        'url' => 'http://pharmacy-management.test/',
        'asset_url' => null,
        'timezone' => 'UTC',
        'locale' => 'en',
        'fallback_locale' => 'en',
        'faker_locale' => 'en_US',
        'key' => 'base64:GuPjBKSY3/y+LGxhCnCkPUljEfVfHgxc3W1QclYeMlI=',
        'cipher' => 'AES-256-CBC',
        'maintenance' => [
            'driver' => 'file',
        ],
        'providers' => [
            0 => 'Illuminate\\Auth\\AuthServiceProvider',
            1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
            2 => 'Illuminate\\Bus\\BusServiceProvider',
            3 => 'Illuminate\\Cache\\CacheServiceProvider',
            4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
            5 => 'Illuminate\\Cookie\\CookieServiceProvider',
            6 => 'Illuminate\\Database\\DatabaseServiceProvider',
            7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
            8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
            9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
            10 => 'Illuminate\\Hashing\\HashServiceProvider',
            11 => 'Illuminate\\Mail\\MailServiceProvider',
            12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
            13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
            14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
            15 => 'Illuminate\\Queue\\QueueServiceProvider',
            16 => 'Illuminate\\Redis\\RedisServiceProvider',
            17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
            18 => 'Illuminate\\Session\\SessionServiceProvider',
            19 => 'Illuminate\\Translation\\TranslationServiceProvider',
            20 => 'Illuminate\\Validation\\ValidationServiceProvider',
            21 => 'Illuminate\\View\\ViewServiceProvider',
            22 => 'App\\Providers\\AppServiceProvider',
            23 => 'App\\Providers\\AuthServiceProvider',
            24 => 'App\\Providers\\EventServiceProvider',
            25 => 'App\\Providers\\RouteServiceProvider',
            26 => 'App\\Providers\\TelescopeServiceProvider',
            27 => 'Ladumor\\LaravelPwa\\PWAServiceProvider',
        ],
        'aliases' => [
            'App' => 'Illuminate\\Support\\Facades\\App',
            'Arr' => 'Illuminate\\Support\\Arr',
            'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
            'Auth' => 'Illuminate\\Support\\Facades\\Auth',
            'Blade' => 'Illuminate\\Support\\Facades\\Blade',
            'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
            'Bus' => 'Illuminate\\Support\\Facades\\Bus',
            'Cache' => 'Illuminate\\Support\\Facades\\Cache',
            'Config' => 'Illuminate\\Support\\Facades\\Config',
            'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
            'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
            'Date' => 'Illuminate\\Support\\Facades\\Date',
            'DB' => 'Illuminate\\Support\\Facades\\DB',
            'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
            'Event' => 'Illuminate\\Support\\Facades\\Event',
            'File' => 'Illuminate\\Support\\Facades\\File',
            'Gate' => 'Illuminate\\Support\\Facades\\Gate',
            'Hash' => 'Illuminate\\Support\\Facades\\Hash',
            'Http' => 'Illuminate\\Support\\Facades\\Http',
            'Js' => 'Illuminate\\Support\\Js',
            'Lang' => 'Illuminate\\Support\\Facades\\Lang',
            'Log' => 'Illuminate\\Support\\Facades\\Log',
            'Mail' => 'Illuminate\\Support\\Facades\\Mail',
            'Notification' => 'Illuminate\\Support\\Facades\\Notification',
            'Number' => 'Illuminate\\Support\\Number',
            'Password' => 'Illuminate\\Support\\Facades\\Password',
            'Process' => 'Illuminate\\Support\\Facades\\Process',
            'Queue' => 'Illuminate\\Support\\Facades\\Queue',
            'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
            'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
            'Request' => 'Illuminate\\Support\\Facades\\Request',
            'Response' => 'Illuminate\\Support\\Facades\\Response',
            'Route' => 'Illuminate\\Support\\Facades\\Route',
            'Schema' => 'Illuminate\\Support\\Facades\\Schema',
            'Session' => 'Illuminate\\Support\\Facades\\Session',
            'Storage' => 'Illuminate\\Support\\Facades\\Storage',
            'Str' => 'Illuminate\\Support\\Str',
            'URL' => 'Illuminate\\Support\\Facades\\URL',
            'Validator' => 'Illuminate\\Support\\Facades\\Validator',
            'View' => 'Illuminate\\Support\\Facades\\View',
            'Vite' => 'Illuminate\\Support\\Facades\\Vite',
            'LaravelPwa' => 'Ladumor\\LaravelPwa\\LaravelPwa',
        ],
    ],
    'auth' => [
        'defaults' => [
            'guard' => 'web',
            'passwords' => 'users',
        ],
        'guards' => [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
            ],
            'sanctum' => [
                'driver' => 'sanctum',
                'provider' => null,
            ],
        ],
        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => 'App\\Models\\User',
            ],
        ],
        'passwords' => [
            'users' => [
                'provider' => 'users',
                'table' => 'password_reset_tokens',
                'expire' => 60,
                'throttle' => 60,
            ],
        ],
        'password_timeout' => 10800,
    ],
    'broadcasting' => [
        'default' => 'log',
        'connections' => [
            'pusher' => [
                'driver' => 'pusher',
                'key' => '',
                'secret' => '',
                'app_id' => '',
                'options' => [
                    'host' => 'api-mt1.pusher.com',
                    'port' => '443',
                    'scheme' => 'https',
                    'encrypted' => true,
                    'useTLS' => true,
                ],
                'client_options' => [
                ],
            ],
            'ably' => [
                'driver' => 'ably',
                'key' => null,
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
            ],
            'log' => [
                'driver' => 'log',
            ],
            'null' => [
                'driver' => 'null',
            ],
        ],
    ],
    'cache' => [
        'default' => 'file',
        'stores' => [
            'apc' => [
                'driver' => 'apc',
            ],
            'array' => [
                'driver' => 'array',
                'serialize' => false,
            ],
            'database' => [
                'driver' => 'database',
                'table' => 'cache',
                'connection' => null,
                'lock_connection' => null,
            ],
            'file' => [
                'driver' => 'file',
                'path' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\framework/cache/data',
            ],
            'memcached' => [
                'driver' => 'memcached',
                'persistent_id' => null,
                'sasl' => [
                    0 => null,
                    1 => null,
                ],
                'options' => [
                ],
                'servers' => [
                    0 => [
                        'host' => '127.0.0.1',
                        'port' => 11211,
                        'weight' => 100,
                    ],
                ],
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'cache',
                'lock_connection' => 'default',
            ],
            'dynamodb' => [
                'driver' => 'dynamodb',
                'key' => '',
                'secret' => '',
                'region' => 'us-east-1',
                'table' => 'cache',
                'endpoint' => null,
            ],
            'octane' => [
                'driver' => 'octane',
            ],
        ],
        'prefix' => 'laravel_cache_',
    ],
    'cors' => [
        'paths' => [
            0 => 'api/*',
            1 => 'sanctum/csrf-cookie',
        ],
        'allowed_methods' => [
            0 => '*',
        ],
        'allowed_origins' => [
            0 => '*',
        ],
        'allowed_origins_patterns' => [
        ],
        'allowed_headers' => [
            0 => '*',
        ],
        'exposed_headers' => [
        ],
        'max_age' => 0,
        'supports_credentials' => false,
    ],
    'database' => [
        'default' => 'mysql',
        'connections' => [
            'sqlite' => [
                'driver' => 'sqlite',
                'url' => null,
                'database' => 'amarlodge_pharmacy',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'mysql' => [
                'driver' => 'mysql',
                'url' => null,
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'amarlodge_pharmacy',
                'username' => 'root',
                'password' => 'root',
                'unix_socket' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => false,
                'engine' => null,
                'options' => [
                ],
            ],
            'pgsql' => [
                'driver' => 'pgsql',
                'url' => null,
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'amarlodge_pharmacy',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'search_path' => 'public',
                'sslmode' => 'prefer',
            ],
            'sqlsrv' => [
                'driver' => 'sqlsrv',
                'url' => null,
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'amarlodge_pharmacy',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
            ],
        ],
        'migrations' => 'migrations',
        'redis' => [
            'client' => 'phpredis',
            'options' => [
                'cluster' => 'redis',
                'prefix' => 'laravel_database_',
            ],
            'default' => [
                'url' => null,
                'host' => '127.0.0.1',
                'username' => null,
                'password' => null,
                'port' => '6379',
                'database' => '0',
            ],
            'cache' => [
                'url' => null,
                'host' => '127.0.0.1',
                'username' => null,
                'password' => null,
                'port' => '6379',
                'database' => '1',
            ],
        ],
    ],
    'filesystems' => [
        'default' => 'local',
        'disks' => [
            'local' => [
                'driver' => 'local',
                'root' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\app',
                'throw' => false,
            ],
            'public' => [
                'driver' => 'local',
                'root' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\app/public',
                'url' => 'http://pharmacy-management.test//storage',
                'visibility' => 'public',
                'throw' => false,
            ],
            's3' => [
                'driver' => 's3',
                'key' => '',
                'secret' => '',
                'region' => 'us-east-1',
                'bucket' => '',
                'url' => null,
                'endpoint' => null,
                'use_path_style_endpoint' => false,
                'throw' => false,
            ],
        ],
        'links' => [
            'D:\\wamp64\\www\\pharmacy-management\\public\\storage' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\app/public',
        ],
    ],
    'hashing' => [
        'driver' => 'bcrypt',
        'bcrypt' => [
            'rounds' => 10,
        ],
        'argon' => [
            'memory' => 65536,
            'threads' => 1,
            'time' => 4,
        ],
    ],
    'logging' => [
        'default' => 'stack',
        'deprecations' => [
            'channel' => null,
            'trace' => false,
        ],
        'channels' => [
            'stack' => [
                'driver' => 'stack',
                'channels' => [
                    0 => 'single',
                ],
                'ignore_exceptions' => false,
            ],
            'single' => [
                'driver' => 'single',
                'path' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\logs/laravel.log',
                'level' => 'debug',
                'replace_placeholders' => true,
            ],
            'daily' => [
                'driver' => 'daily',
                'path' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\logs/laravel.log',
                'level' => 'debug',
                'days' => 14,
                'replace_placeholders' => true,
            ],
            'slack' => [
                'driver' => 'slack',
                'url' => null,
                'username' => 'Laravel Log',
                'emoji' => ':boom:',
                'level' => 'debug',
                'replace_placeholders' => true,
            ],
            'papertrail' => [
                'driver' => 'monolog',
                'level' => 'debug',
                'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
                'handler_with' => [
                    'host' => null,
                    'port' => null,
                    'connectionString' => 'tls://:',
                ],
                'processors' => [
                    0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
                ],
            ],
            'stderr' => [
                'driver' => 'monolog',
                'level' => 'debug',
                'handler' => 'Monolog\\Handler\\StreamHandler',
                'formatter' => null,
                'with' => [
                    'stream' => 'php://stderr',
                ],
                'processors' => [
                    0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
                ],
            ],
            'syslog' => [
                'driver' => 'syslog',
                'level' => 'debug',
                'facility' => 8,
                'replace_placeholders' => true,
            ],
            'errorlog' => [
                'driver' => 'errorlog',
                'level' => 'debug',
                'replace_placeholders' => true,
            ],
            'null' => [
                'driver' => 'monolog',
                'handler' => 'Monolog\\Handler\\NullHandler',
            ],
            'emergency' => [
                'path' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\logs/laravel.log',
            ],
        ],
    ],
    'mail' => [
        'default' => 'smtp',
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => 'smtp.gmail.com',
                'port' => '465',
                'encryption' => 'ssl',
                'username' => 'ictbanglabd@gmail.com',
                'password' => 'pane lqnl hjgs rplk',
                'timeout' => null,
                'local_domain' => null,
            ],
            'ses' => [
                'transport' => 'ses',
            ],
            'mailgun' => [
                'transport' => 'mailgun',
            ],
            'postmark' => [
                'transport' => 'postmark',
            ],
            'sendmail' => [
                'transport' => 'sendmail',
                'path' => '/usr/sbin/sendmail -bs -i',
            ],
            'log' => [
                'transport' => 'log',
                'channel' => null,
            ],
            'array' => [
                'transport' => 'array',
            ],
            'failover' => [
                'transport' => 'failover',
                'mailers' => [
                    0 => 'smtp',
                    1 => 'log',
                ],
            ],
        ],
        'from' => [
            'address' => 'ictbanglabd@gmail.com',
            'name' => 'Laravel',
        ],
        'markdown' => [
            'theme' => 'default',
            'paths' => [
                0 => 'D:\\wamp64\\www\\pharmacy-management\\resources\\views/vendor/mail',
            ],
        ],
    ],
    'queue' => [
        'default' => 'sync',
        'connections' => [
            'sync' => [
                'driver' => 'sync',
            ],
            'database' => [
                'driver' => 'database',
                'table' => 'jobs',
                'queue' => 'default',
                'retry_after' => 90,
                'after_commit' => false,
            ],
            'beanstalkd' => [
                'driver' => 'beanstalkd',
                'host' => 'localhost',
                'queue' => 'default',
                'retry_after' => 90,
                'block_for' => 0,
                'after_commit' => false,
            ],
            'sqs' => [
                'driver' => 'sqs',
                'key' => '',
                'secret' => '',
                'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
                'queue' => 'default',
                'suffix' => null,
                'region' => 'us-east-1',
                'after_commit' => false,
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => 'default',
                'retry_after' => 90,
                'block_for' => null,
                'after_commit' => false,
            ],
        ],
        'failed' => [
            'driver' => 'database-uuids',
            'database' => 'mysql',
            'table' => 'failed_jobs',
        ],
    ],
    'sanctum' => [
        'stateful' => [
            0 => 'localhost',
            1 => 'localhost:3000',
            2 => '127.0.0.1',
            3 => '127.0.0.1:8000',
            4 => '::1',
            5 => 'pharmacy-management.test',
        ],
        'guard' => [
            0 => 'web',
        ],
        'expiration' => null,
        'token_prefix' => '',
        'middleware' => [
            'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
            'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
        ],
    ],
    'scout' => [
        'driver' => 'algolia',
        'prefix' => '',
        'queue' => false,
        'after_commit' => false,
        'chunk' => [
            'searchable' => 500,
            'unsearchable' => 500,
        ],
        'soft_delete' => false,
        'identify' => false,
        'algolia' => [
            'id' => '',
            'secret' => '',
        ],
        'meilisearch' => [
            'host' => 'http://localhost:7700',
            'key' => null,
            'index-settings' => [
            ],
        ],
    ],
    'services' => [
        'mailgun' => [
            'domain' => null,
            'secret' => null,
            'endpoint' => 'api.mailgun.net',
            'scheme' => 'https',
        ],
        'postmark' => [
            'token' => null,
        ],
        'ses' => [
            'key' => '',
            'secret' => '',
            'region' => 'us-east-1',
        ],
    ],
    'session' => [
        'driver' => 'file',
        'lifetime' => '120',
        'expire_on_close' => false,
        'encrypt' => false,
        'files' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\framework/sessions',
        'connection' => null,
        'table' => 'sessions',
        'store' => null,
        'lottery' => [
            0 => 2,
            1 => 100,
        ],
        'cookie' => 'laravel_session',
        'path' => '/',
        'domain' => null,
        'secure' => null,
        'http_only' => true,
        'same_site' => 'lax',
    ],
    'sslcommerz' => [
        'apiCredentials' => [
            'store_id' => 'amarl624437d9a7a52',
            'store_password' => 'amarl624437d9a7a52@ssl',
        ],
        'apiUrl' => [
            'make_payment' => '/gwprocess/v4/api.php',
            'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
            'order_validate' => '/validator/api/validationserverAPI.php',
            'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
            'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
        ],
        'apiDomain' => 'https://sandbox.sslcommerz.com',
        'connect_from_localhost' => false,
        'success_url' => '/success',
        'failed_url' => '/fail',
        'cancel_url' => '/cancel',
        'ipn_url' => '/ipn',
    ],
    'telescope' => [
        'domain' => null,
        'path' => 'telescope',
        'driver' => 'database',
        'storage' => [
            'database' => [
                'connection' => 'mysql',
                'chunk' => 1000,
            ],
        ],
        'enabled' => true,
        'middleware' => [
            0 => 'web',
            1 => 'Laravel\\Telescope\\Http\\Middleware\\Authorize',
        ],
        'only_paths' => [
        ],
        'ignore_paths' => [
            0 => 'nova-api*',
        ],
        'ignore_commands' => [
        ],
        'watchers' => [
            'Laravel\\Telescope\\Watchers\\BatchWatcher' => true,
            'Laravel\\Telescope\\Watchers\\CacheWatcher' => [
                'enabled' => true,
                'hidden' => [
                ],
            ],
            'Laravel\\Telescope\\Watchers\\ClientRequestWatcher' => true,
            'Laravel\\Telescope\\Watchers\\CommandWatcher' => [
                'enabled' => true,
                'ignore' => [
                ],
            ],
            'Laravel\\Telescope\\Watchers\\DumpWatcher' => [
                'enabled' => true,
                'always' => false,
            ],
            'Laravel\\Telescope\\Watchers\\EventWatcher' => [
                'enabled' => true,
                'ignore' => [
                ],
            ],
            'Laravel\\Telescope\\Watchers\\ExceptionWatcher' => true,
            'Laravel\\Telescope\\Watchers\\GateWatcher' => [
                'enabled' => true,
                'ignore_abilities' => [
                ],
                'ignore_packages' => true,
                'ignore_paths' => [
                ],
            ],
            'Laravel\\Telescope\\Watchers\\JobWatcher' => true,
            'Laravel\\Telescope\\Watchers\\LogWatcher' => [
                'enabled' => true,
                'level' => 'error',
            ],
            'Laravel\\Telescope\\Watchers\\MailWatcher' => true,
            'Laravel\\Telescope\\Watchers\\ModelWatcher' => [
                'enabled' => true,
                'events' => [
                    0 => 'eloquent.*',
                ],
                'hydrations' => true,
            ],
            'Laravel\\Telescope\\Watchers\\NotificationWatcher' => true,
            'Laravel\\Telescope\\Watchers\\QueryWatcher' => [
                'enabled' => true,
                'ignore_packages' => true,
                'ignore_paths' => [
                ],
                'slow' => 100,
            ],
            'Laravel\\Telescope\\Watchers\\RedisWatcher' => true,
            'Laravel\\Telescope\\Watchers\\RequestWatcher' => [
                'enabled' => true,
                'size_limit' => 64,
                'ignore_http_methods' => [
                ],
                'ignore_status_codes' => [
                ],
            ],
            'Laravel\\Telescope\\Watchers\\ScheduleWatcher' => true,
            'Laravel\\Telescope\\Watchers\\ViewWatcher' => true,
        ],
    ],
    'view' => [
        'paths' => [
            0 => 'D:\\wamp64\\www\\pharmacy-management\\resources\\views',
        ],
        'compiled' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\framework\\views',
    ],
    'debugbar' => [
        'enabled' => null,
        'except' => [
            0 => 'telescope*',
            1 => 'horizon*',
        ],
        'storage' => [
            'enabled' => true,
            'open' => false,
            'driver' => 'file',
            'path' => 'D:\\wamp64\\www\\pharmacy-management\\storage\\debugbar',
            'connection' => null,
            'provider' => '',
            'hostname' => '127.0.0.1',
            'port' => 2304,
        ],
        'editor' => 'phpstorm',
        'remote_sites_path' => '',
        'local_sites_path' => '',
        'include_vendors' => true,
        'capture_ajax' => true,
        'add_ajax_timing' => false,
        'error_handler' => false,
        'clockwork' => false,
        'collectors' => [
            'phpinfo' => true,
            'messages' => true,
            'time' => true,
            'memory' => true,
            'exceptions' => true,
            'log' => true,
            'db' => true,
            'views' => true,
            'route' => true,
            'auth' => false,
            'gate' => true,
            'session' => true,
            'symfony_request' => true,
            'mail' => true,
            'laravel' => false,
            'events' => false,
            'default_request' => false,
            'logs' => false,
            'files' => false,
            'config' => false,
            'cache' => false,
            'models' => true,
            'livewire' => true,
        ],
        'options' => [
            'auth' => [
                'show_name' => true,
            ],
            'db' => [
                'with_params' => true,
                'backtrace' => true,
                'backtrace_exclude_paths' => [
                ],
                'timeline' => false,
                'duration_background' => true,
                'explain' => [
                    'enabled' => false,
                    'types' => [
                        0 => 'SELECT',
                    ],
                ],
                'hints' => false,
                'show_copy' => false,
                'slow_threshold' => false,
            ],
            'mail' => [
                'full_log' => false,
            ],
            'views' => [
                'timeline' => false,
                'data' => false,
                'exclude_paths' => [
                ],
            ],
            'route' => [
                'label' => true,
            ],
            'logs' => [
                'file' => null,
            ],
            'cache' => [
                'values' => true,
            ],
        ],
        'inject' => true,
        'route_prefix' => '_debugbar',
        'route_domain' => null,
        'theme' => 'auto',
        'debug_backtrace_limit' => 50,
    ],
    'bangladesh-geocode' => [
    ],
    'image' => [
        'driver' => 'gd',
    ],
    'flare' => [
        'key' => null,
        'flare_middleware' => [
            0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
            1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
            2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
            3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
            4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
            5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
            'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' => [
                'maximum_number_of_collected_logs' => 200,
            ],
            'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' => [
                'maximum_number_of_collected_queries' => 200,
                'report_query_bindings' => true,
            ],
            'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' => [
                'max_chained_job_reporting_depth' => 5,
            ],
            'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' => [
                'censor_fields' => [
                    0 => 'password',
                    1 => 'password_confirmation',
                ],
            ],
            'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' => [
                'headers' => [
                    0 => 'API-KEY',
                ],
            ],
        ],
        'send_logs_as_events' => true,
    ],
    'ignition' => [
        'editor' => 'phpstorm',
        'theme' => 'auto',
        'enable_share_button' => true,
        'register_commands' => false,
        'solution_providers' => [
            0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
            1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
            2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
            3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
            4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
            5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
            6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
            7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
            8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
            9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
            10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
            11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
            12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
            13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
            14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
            15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
            16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
            17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
            18 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\OpenAiSolutionProvider',
            19 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\SailNetworkSolutionProvider',
        ],
        'ignored_solution_providers' => [
        ],
        'enable_runnable_solutions' => null,
        'remote_sites_path' => 'D:\\wamp64\\www\\pharmacy-management',
        'local_sites_path' => '',
        'housekeeping_endpoint_prefix' => '_ignition',
        'settings_file_path' => '',
        'recorders' => [
            0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
            1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
            2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
            3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
        ],
        'open_ai_key' => null,
        'with_stack_frame_arguments' => true,
        'argument_reducers' => [
            0 => 'Spatie\\Backtrace\\Arguments\\Reducers\\BaseTypeArgumentReducer',
            1 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ArrayArgumentReducer',
            2 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StdClassArgumentReducer',
            3 => 'Spatie\\Backtrace\\Arguments\\Reducers\\EnumArgumentReducer',
            4 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ClosureArgumentReducer',
            5 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeArgumentReducer',
            6 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeZoneArgumentReducer',
            7 => 'Spatie\\Backtrace\\Arguments\\Reducers\\SymphonyRequestArgumentReducer',
            8 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\ModelArgumentReducer',
            9 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\CollectionArgumentReducer',
            10 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StringableArgumentReducer',
        ],
    ],
    'tinker' => [
        'commands' => [
        ],
        'alias' => [
        ],
        'dont_alias' => [
            0 => 'App\\Nova',
        ],
    ],
];
