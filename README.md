# state-city
State-city REST API

# Code distribution

* All code anted to PSR-1, PSR-2 and PSR-5
* migrations in src/database/migrations
* routes in src/routes/web.php
* controllers in src/app/Http/Controllers
* request validations in src/app/Http/Requests
* models in src/app/Models
* services in src/app/Services
* unit tests in src/tests/Unit

# How to run

* install docker
* install docker-compose
* git clone git@github.com:lhsantosazs/state-city.git
* cd src
* cp .env.example .env
* docker-compose build
* ./console migrate
* docker-compose start
