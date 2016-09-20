#!/bin/bash

sudo chmod -R ugo+rwx app/cache
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev
sudo chmod -R ugo+rwx app/cache
