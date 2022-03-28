# FilmDB

# Decisiones técnicas
## Tipos de datos en la BB.DD.
En base de datos he utilizado el tipo int para los ids, si fuese una API habría que evaluar si utilizar un tipo
de datos UUID para los ids que se expusiesen en los endpoints de la API. Para lograr el máximo rendimiento en 
consultas es recomendable utilizar int para ids en tablas sobre las que se hagan JOIN o consultas relacionadas.

## EasyAdmin
Hace muchos años que no usaba EasyAdmin, de hecho nunca lo usaría por la poca escalabilidad que tiene. En estos casos 
la interfaz de usuario la hacemos personalizada y normalmente estas cosas las hacemos con endpoints REST o similar y 
frontends tipo SPA.

## Caché
Para guardar los datos utilizo la caché Redis.

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