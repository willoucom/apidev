#!/bin/bash

docker build -t apidev .

docker run --rm -p 8080:80 -v $PWD:/var/www/html/ apidev
