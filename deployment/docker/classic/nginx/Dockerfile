FROM mariusbuescher/k8s-example-code AS build

FROM nginx:1.17-alpine

COPY ./nginx.conf /etc/nginx/conf.d/default.template
COPY --from=build /opt/build/public /var/www/html/public

ENV PHP_FPM_HOST=127.0.0.1

CMD /bin/sh -c "envsubst '\$PHP_FPM_HOST' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf && exec nginx -g 'daemon off;'"