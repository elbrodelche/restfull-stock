# RESTfull API de Stock
Esta aplicacion puede mostrar el stock, actualizar productos, elinimarlos y crearlos mediante verbos HTTP. 


## Instrucciones rapidas
1. Crear una base de datos con el nombre de `symfony`.
~~~
> mysql -u <user> -p
create database symfony;
exit;
~~~
2. Popular la nueva base, con los datos de ejemplo:
~~~cmd
> mysql -u <user> -p symfony < symfony.sql
~~~
2. Clonar el repositiorio principal `> git clone <url>`.
3. CD a la carpeta `cd Stock`.
4. Ejecutar `> composer install` para descargar dependencias.
5. Ejecutar `> php bin/console server:run` para iniciar el webserver integrado.
6. Ingresar a  `http://localhost:8000/v1/stock` para obtener el listado de productos.

##Endpoints
 ### Get `/v1/stock`
 Obtiene el listado completo de prouctos
 ### Get `/v1/product/{id}`
 Obtiene un solo producto mediante el id del mismo
  Parametros:
  - int id 
 ### Post `/v1/product/`
 Crea un producto nuevo
  Parametros:
  - int id 
  - string producto
  - string descripcion
  - int cantidad
 ### Put `/v1/product/{id}`
  Actualiza un producto nuevo
  Parametros:
  - int id (del producto a actualizar)
  - string producto
  - string descripcion
  - int cantidad
 ### Delete `/v1/product/{id}`
 Elimina un producto mediante el id del mismo
  Parametros:
  - int id 