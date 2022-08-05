#!/bin/sh

docker-compose exec -T mysql mysql -uadmin -psecret mydb < dump.sql
