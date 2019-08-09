FROM mariusbuescher/k8s-example-base

COPY . /opt/build

ENV APP_ENV=prod

RUN npm install \
    && npm run build \
    && composer install --no-dev -a --no-scripts \
    && bin/console cache:clear --env=prod \
    && bin/console assets:install public --env=prod