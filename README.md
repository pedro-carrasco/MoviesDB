# FilmDB

# Decisiones técnicas
## Tipos de datos en la BB.DD.
En base de datos he utilizado el tipo int para los ids, si fuese una API habría que evaluar si utilizar un tipo
de datos UUID para los ids que se expusiesen en los endpoints de la API. Para lograr el máximo rendimiento en 
consultas es recomendable utilizar int para ids en tablas sobre las que se hagan JOIN o consultas relacionadas.

## EasyAdmin
Hace muchos años que no usaba EasyAdmin, de hecho nunca lo usaría por la poca escalabilidad que tiene. En este caso
cuando se carga toda la base de datos los filtros de películas darían OutOfMemory, imagino que tendría que hacer CustomFilters con 
las tablas asociadas (Movies), pero no me he puesto a investigar con eso. En estos casos la interfaz de usuario
la hacemos personalizada y normalmente estas cosas las hacemos con endpoints REST o similar y frontends tipo SPA.

## Caché
Para guardar los datos utilizo la caché Redis.

## Docker
En desarrollo he creado el dockercompose con los servicios y la imagen ya compilada (se puede ver la compilación el 
Dockerfile)

## Inicio de la aplicación
```bash
$ docker-compose up
```

## Carga de datos
Desde la carpeta donde tengamos el fichero **IMDb\ movies.csv** ejecutamos
los comandos de docker.

```bash
$ docker cp film_app:/usr/src/filmdb/ IMDb\ movies.csv 
$ docker exec -it film_app bin/console filmsdb:loadcsv IMDb\ movies.csv
```