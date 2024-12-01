ARG NODE_VERSION=20.11.1
ARG NGINX_VERSION=1.25.3
ARG REACT_APP_API_ENTRYPOINT=http://localhost:8000/api

FROM node:${NODE_VERSION}-alpine AS front_dev

WORKDIR /usr/src/admin

COPY ./package.json ./package.json
COPY ./package-lock.json ./package-lock.json

RUN set -eux; \
    npm install;

COPY --chown=node:node ./public ./public
COPY --chown=node:node ./src ./src
COPY --chown=node:node ./.eslintrc.cjs ./.eslintrc.cjs
COPY --chown=node:node ./index.html ./index.html
COPY --chown=node:node ./vite.config.js ./vite.config.js

ENV REACT_APP_API_ENTRYPOINT=$REACT_APP_API_ENTRYPOINT

VOLUME [ "/usr/src/admin/node_modules" ]

CMD [ "npm", "run", "dev" ]

######

FROM front_dev AS front_build

ARG REACT_APP_API_ENTRYPOINT
ENV REACT_APP_API_ENTRYPOINT=$REACT_APP_API_ENTRYPOINT

RUN set -eux; \
    npm run build;

######

FROM nginx:${NGINX_VERSION}-alpine AS front_nginx

COPY ./docker/nginx/conf.d /etc/nginx/conf.d

WORKDIR /usr/src/admin/build

COPY --chown=nginx:nginx --from=front_build /usr/src/admin/dist /usr/src/admin/build