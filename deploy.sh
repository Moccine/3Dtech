#!/bin/bash
echo -e 'Loading the github deployment key'

pkill -f 'ssh-agent -s'
eval `ssh-agent -s`

#ssh-add ~/.ssh/github-boilerplate-symfony
git pull origin $(git rev-parse --abbrev-ref HEAD)
#ssh-add ~/.ssh/github-3Dtech
echo -e 'Download updates'
echo -e 'Installing Symfony dependencies'

cd app/symfony
composer install
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
php bin/console assets:install public

cd ../integration/ && yarn run start



#echo -e 'Installation of assets'
#php bin/console assets:install public
#echo -e 'Installation of Front dependencies'
#cd ../integration/ && yarn run start:prod
#
#echo -e 'Clear du cache'
#php bin/console cache:clear
#php bin/console cache:warmup
#
#echo -e 'Updating permissions'
##chmod -R +w var
#chown www-data: ../* -R