@servers(['dev' => ['ec2-user@127.0.0.1']], ['uat' => ['ec2-user@127.0.0.1']], ['prod' => ['ec2-user@127.0.0.1']])

@setup
    $dir = "/var/www/vaccine";
@endsetup

@story('deploy')
    git
    build
@endstory

@task('git', ['on' => $server])
    cd {{ $dir }}
    pwd
    git pull
@endtask

@task('build', ['on' => $server])
    cd {{ $dir }}
    pwd
    composer install
    php artisan migrate --force
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan queue:restart
    npm install
    npm run {{ $npm }}
@endtask
