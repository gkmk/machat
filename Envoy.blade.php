{{-- https://laravel.com/docs/5.6/envoy --}}

@servers(['localhost' => '127.0.0.1'])

{{-- @setup
    $now = new DateTime();

    $environment = isset($env) ? $env : "testing";
@endsetup --}}

{{-- @task('foo', ['on' => 'web'])
    ls -la
@endtask --}}

@task('servers')
    nohup php artisan horizon &
    {{-- https://github.com/tlaverdure/laravel-echo-server --}}
    nohup laravel-echo-server start &
@endtask