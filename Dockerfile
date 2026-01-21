FROM nginx:alpine

COPY build/documentation /usr/share/nginx/html
