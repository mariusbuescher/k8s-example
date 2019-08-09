#!/usr/bin/env bash

set -e

VERSION=$1
REGISTRY=mariusbuescher

docker build -t $REGISTRY/k8s-example-base -f deployment/docker/base/Dockerfile .
docker build -t code -f deployment/docker/code/Dockerfile .

docker build -t $REGISTRY/k8s-example-nginx:$VERSION deployment/docker/classic/nginx
docker build -t $REGISTRY/k8s-example-php-fpm:$VERSION deployment/docker/classic/php-fpm
docker build -t $REGISTRY/k8s-example-nginx-react:$VERSION deployment/docker/react/nginx
docker build -t $REGISTRY/k8s-example-php-react:$VERSION deployment/docker/react/php

docker push $REGISTRY/k8s-example-nginx:$VERSION
docker push $REGISTRY/k8s-example-php-fpm:$VERSION
docker push $REGISTRY/k8s-example-nginx-react:$VERSION
docker push $REGISTRY/k8s-example-php-react:$VERSION