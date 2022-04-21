# FilmDB

## Docker
En desarrollo he creado el docker-compose con los servicios y la imagen ya compilada (se puede ver la compilación el 
Dockerfile)

## Inicio de la aplicación
```bash
$ docker-compose up
```

## Primera ejecución
La primera vez que se ejecuta la aplicación hay que lanzar las migraciones de la base de datos:
```bash
$  docker exec -it film_app bin/console doctrine:migrations:migrate --no-interaction
```

## Carga de datos
Desde la carpeta donde tengamos el fichero **IMDb\ movies.csv** ejecutamos
los comandos de docker.

```bash
$ docker cp ../IMDb\ movies.csv film_app:/usr/src/filmdb/
$ docker exec -it film_app bin/console filmsdb:loadcsv IMDb\ movies.csv
```
