#!/bin/bash
echo -e 'Loading the github deployment key'

pkill -f 'ssh-agent -s'
eval `ssh-agent -s`

#ssh-add ~/.ssh/github-3dtech
git pull origin $(git rev-parse --abbrev-ref HEAD)
#ssh-add ~/.ssh/github-3dtech
echo -e 'Download updates'
echo -e 'Installing Symfony dependencies'

cd app/symfony
composer install
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
php bin/console assets:install public

cd ../integration/ && yarn run start



echo -e 'Installation of assets'
php bin/console assets:install public
echo -e 'Installation of Front dependencies'
cd ../integration/ && yarn run start:prod
cd ../symfony
echo -e 'Clear du cache'
php bin/console cache:clear
php bin/console cache:warmup

echo -e 'Updating permissions'
chmod -R +w var
umask 0
chown www-data: ../* -R
