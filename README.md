kulturklik-command
==================

# Comando Symfony para recuperar XML de la agenda de Kulturkilk

## Consideraciones iniciales
Podemos tener dos escenarios:
- será un acción puntual,
- o teniendo en cuenta que va a ser almacenado en una BD y posteriormente accedido desde una web/aplicación, será una acción periódica, para actualizar la BD (los datos del open data de kulturik indica que se actualizan diariamente). (Actualización que podrá realizarse por un crontab diario u horario que lance el comando).

Si es una acción puntual la acción será simplemente la carga del catálogo, deserialización y llenado de la BD.
 
Si es una acción periódica, a la hora de recuperar los datos en las veces posteriores a la inicial, tenemos que tener en cuenta la estructura y función de la BD (o de los objetos que manejan la estructura de la BD). Es decir alguna de las siguientes opciones:
Si vamos a tener otras tablas/objetos en nuestra aplicación que referencien (por su id) los registros obtenidos del open data (por ejemplo usuarios que asisten, nº de visualizaciones, información extra, etc).
Si queremos mantener guardando en BD todos los años, presente y pasados que hayamos recuperado (el open data nos da los registros de actividades del año en curso).

Si se da alguna de las dos opciones anteriores no podremos hacer una operación de borrado de todos los registros y recarga de todos nuevamente, pues perderemos referencias. Deberemos actualizar o añadir registros según existan ya en la BD o no existan.

Para poder identificar unívocamente los registros necesitamos un identificador único, que en principio no nos lo da el catálogo de datos, pero si nos da algún campo que podemos aprovechar (campos como “documentName”, o un hash de todo el registro no nos valen, pues pueden sufrir cambios en actualizaciones del catálogo, por corrección de errores, etc). El campo “friendlyurl” también podría cambiar si hay un cambio del “documentName” pues se usa como slug en su url. Deberíamos valorar qué campo usar (physicalurl, dataxml, metadataxml, etc).


En este ejemplo implementamos el primer escenario: importación puntual del catálogo a la BD.

## Arquitectura
Consideramos que el comando va a estar integrado en una aplicación Symfony, y usamos una instalación de Symfony3. Si el comando no va a estar integrado en una aplicación web y queremos simplificarlo podríamos usar solo el componente “Console” de Symfony.
De la misma manera, se usa el ORM Doctrine para la capa de datos y persistir los objetos, suponiendo que en la aplicación se usará también y se compartiran las entidades del ORM.
Igualmente usaremos Inyección de dependencias DI con el “Service Container” de Symfony.

**AgendaCommand**

Para la clase que define el comando, AgendaCommand, y punto de entrada, usamos la clase base ContainerAwareCommand, para tener acceso al “Service container”, y con el inyectar dependencias (Doctrine, AgendaLoader, parámetros, ...). Si no usaramos DI podríamos heredar directamente de la clase base “Command”.

El comando tiene como argumento opcional la URL de la agenda en formato XML.

El comando tiene como opción “clear”, que borra todos los eventos de la BD

**AgendaLoader**

La tarea de obtener la agenda, deserializarla y guardar/persistir los registros en BD se realiza con la clase/servicio AgendaLoader.

AgendaLoader se encarga de cargar y parsear el fichero XML de la agenda, y para ello usa la clase DOMDocument, y obtiene con DOMXPath la colección de nodos que representan los eventos. Cada nodo lo deserializa con la clase **EventXmlSerializer**, que se encarga de extraer los campos del evento y crear con ellos una instancia de la entidad “Event” (Doctrine Entity), para a continuación guardarlos/persistirlos en la BD mediante el entityManager de Doctrine.

Se configura como servicio en Symfony, mediante el “Service container” (app/config/services.yml). AgendaLoader será la única dependencia en el comando (a parte de las necesarias por el comando en si).

## Configuración
El parámetro de la URL de la agenda se configura en app/config/parameters.yml. Se puede personalizar en consola con el argumento “url”. Para los tests se personaliza la URL de la agenda a un archivo local para los tests (ver Tests más abajo).

## Gestión de errores
Se controlan excepciones en la carga del XML por parte de DOMDocument, lanzando una excepción (Son necesarias más).
En la ejecución del comando, no se recogen las excepciones. Si no hay errores tendrá un “exit code” de cero, como es normal, y un 1 si ha habido alguna excepción no controlada.

Podríamos recoger excepciones en el comando y lanzar excepciones customizadas para la consola o un logging.
Puede ser útil configurar un Logging de información de la ejecución del comando, o excepciones no detectadas, por si el comando se usa en un cron, para que quede registro de la información o errores.

## Modelo de datos
Doctrine con anotaciones. Una única entidad: Event

## BD
Se usa SQLite para simplificar el deploy de la demo (BD en app/data.db).
Usando la opción --nodb no se usa persisencia en BD, util en pruebas y en test del AgendaCommand


## Uso del comando:
```sh
$ php bin/console agenda:import [--clear] [--nodb] [url=URLALTERNATIVA]
```

**argumentos:**

url (opcional): URL o ruta local del XML de la agenda

**opciones:**

--clear: borra todos los registros de la entidad Event

--nodb: no persiste en DB ningún registro


## Prerequisitos:
SQLite:
```sh
$ sudo apt-get install sqlite3 libsqlite3-dev
$ sudo apt-get install php5-sqlite
```
phpunit global

## Instalación
```sh
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

## Tests
```sh
$ phpunit
```

Se realizan tests no exaustivos (es necesario cubrir más casos)  a:

El comando **AgendaCommand** con AgendaCommandTest, que carga, gracias al uso del entorno “test”, la agenda de un archivo local con solo dos eventos (tests/AppBundle/demoAgenda.xml, configurado en app/config/parameters_test.yml que es importado por app/config/config_test.yml)).

La clase **AgendaLoader** con AgendaLoaderTest, en donde se usa un Mock/Stub del entityManager para evitar persistir en BD.
Como test adicional, se puede añadir control de las llamadas a los métodos del Mock del entityManager (un único flush, etc).

La clase **EventXMLSerializer** con EventXMLSerializer, comprobando la deserialización de campos (date y boolean) y la deserialización de un evento entero.

#Arquitectura web pública

Podemos considerar si los datos tendrán que ser accedidos, además de por la web pública, también desde aplicaciones móviles u otros clientes (kiosk, IoT, etc), en cuyo caso podemos utilizar una arquitectura orientada a servicio web con, por ejemplo, una REST API en el backend y un cliente rico, que en web podría ser un frontend con SPA (aunque en este caso no favorecemos el SEO de la web). Aunque en web no usemos una SPA también podemos consumir la API desde backend (como la M de un MVC), desacoplando bastante capa de negocio y presentación de la capa de datos (pero quizás penalizando la velocidad de acceso).

Si nuestro objetivo es únicamente mostrar datos en la web, podemos usar una arquitectura estándar HTML con un patrón MVC en backend, con un modelo de datos con ORM, controladores, y plantillas de generación del HTML estático.
En general, la estructura de la web constaría de la página del listado de eventos de la agenda, con posible buscador/filtrado, y de la página de detalle de evento de la agenda.

El open data de la agenda separa el contenido descriptivo del evento en un HTML en un recurso externo (definido en los campos del XML principal), que podría ser interesante cargarlo en la BD mediante el comando de importación de la agenda, haciendo peticiones recursivas a esos recursos. En caso de no hacer esto último, si queremos presentar ese HTML de descripción del evento podemos incrustar en la página el contenido del evento, o en backend con una solicitud web y inyectandolo en la plantilla, o en frontend con un object de tipo text/html (si trabajamos con HTML5). 
