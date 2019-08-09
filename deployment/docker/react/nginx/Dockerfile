FROM mariusbuescher/k8s-example-code AS build

FROM nginx:1.17-alpine

COPY --from=build /opt/build/public /usr/share/nginx/html
