# James Kirby - Portfolio

Site repository for [jedkirby.com](https://jedkirby.com).

[![Author](https://img.shields.io/badge/author-@jedkirby-blue.svg?style=flat-square)](https://twitter.com/jedkirby)
[![Build Status](https://img.shields.io/travis/jedkirby/portfolio/master.svg?style=flat-square)](https://travis-ci.org/jedkirby/portfolio)
[![Test Coverage](https://img.shields.io/coveralls/jedkirby/portfolio/master.svg?style=flat-square)](https://coveralls.io/github/jedkirby/portfolio)


## Pre-requisites

The following should be installed before proceeding:

- [Docker](https://www.docker.com/community-edition) - `v17.12.x`
- [Docker Compose](https://docs.docker.com/compose/install) - `v1.18.x`



## Common Commands

Because the entire project makes use of Docker, and is held together using a Makefile, these are the general commands you'll need:

| Command  | Description |
| --- | --- |
| `make start`  | Start/restart local instance  |
| `make depend`  | Install all dependencies  |
| `make compile`  | Compile production ready assets  |
| `make test`  | Run all testing suites  |
| `make cs`  | Run coding standards enforcers  |
| `make migrate`  | Run database migrations  |
| `make clean`  | **!!** This will remove all dependencies, and stop & delete the instance containers  |


## Other Commands

If the command you need is not within the above Common Commands list, you can access the containers needed using the below, replacing `$command` with the command you'd like to perform, like `yarn version` for example:

1. `docker-compose -f ./docker-compose.build.yml run --rm node $command`
1. `docker-compose -f ./docker-compose.build.yml run --rm cli $command`



## Usage

1. Run the command `make start` from the root of the site, this'll do everything needed to get an instance running

2. Point your browser to either http://jedkirby.localhost:15080 (HTTP) or https://jedkirby.localhost:15443 (HTTPS) to view the site  
*Note, if you've defined a different `APP_PORT`, or `APP_PORT_SSL` within the `.env` file, you'll need to change the ports in the above URLs*

3. In order to recieve emails via the contact form, you'll need to replace `USER_META_EMAIL_TO` within the `.env` file to be your email address  
*Note, this email must be on the approved list within Mailgun*
