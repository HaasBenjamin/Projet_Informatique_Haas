
# Builds all the necessary images from the local Dockerfile
docker build --tag $USER/demo-zootechpark --target zootechpark_php_prod .
docker build --tag $USER/demo-zootechpark-web --target zootechpark_nginx_prod .

# Deploys the necessary services for the ZooTechPark App from the docker-compose.yml
docker-compose up -d

# Inject the db dump (docker/dump.sql) to the db service
docker run --rm \
  --network=sae4-01-api_production \
  -v ./docker:/request \
  mariadb:10.2.25 \
  sh -c "mysql -h db -u demo_prod --password=MySuperPassw0rd sae_s4 < /request/dump.sql"