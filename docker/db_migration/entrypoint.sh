#!/bin/bash

dockerize -wait tcp://mariadb:3306 -timeout 120s

/brg_meetup/vendor/bin/phinx migrate -c /brg_meetup/config/phinx.php
/brg_meetup/vendor/bin/phinx seed:run -c /brg_meetup/config/phinx.php
