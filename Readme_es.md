# Laravel ModelSearch
[![Estado de desarrollo](https://travis-ci.org/bumbummen99/laravel-modelsearch.png?branch=master)](https://travis-ci.org/bumbummen99/laravel-modelsearch)
[![codecov](https://codecov.io/gh/bumbummen99/laravel-modelsearch/branch/master/graph/badge.svg)](https://codecov.io/gh/bumbummen99/laravel-modelsearch)
[![StyleCI](https://styleci.io/repos/159666547/shield?branch=master)](https://styleci.io/repos/159666547)
[![Total de descargas](https://poser.pugx.org/skyraptor/modelsearch/downloads.png)](https://packagist.org/packages/skyraptor/modelsearch)
[![Última versión estable](https://poser.pugx.org/skyraptor/modelsearch/v/stable)](https://packagist.org/packages/skyraptor/modelsearch)
[![Versión anterior](https://poser.pugx.org/skyraptor/modelsearch/v/unstable)](https://packagist.org/packages/skyraptor/modelsearch)
[![Licencia](https://poser.pugx.org/skyraptor/modelsearch/license)](https://packagist.org/packages/skyraptor/modelsearch)
[![Página principal](https://img.shields.io/badge/homepage-skyraptor.eu-informational.svg?style=flat&logo=appveyor)](https://skyraptor.eu)

 Laravel ModelSearch es un paquete liviano, fácil de usar para realizar consultas dinámicas para Modelos específicos con Laravel o Illuminate 5.8.

 # Requerimientos
 - Laravel 5.7+

 # Instalación
 ## Componer

Haga correr  ```composer require skyraptor/modelsearch``` para instalar la última versión del paquete, Después haga correr ```composer update```. El paquete registrará su propio ServiceProvider usando el paquete Laravels discovery.

## Configuración

 Este paquete incluye su propio archivo de configuración que debe configuración que debe ser publicado con el comando ```php artisan vendor:publish``` y continuar las instrucciones de las pantallas. En el archivo de configuración debe ajustar el namespace para sus filtros de directorio y su solicitud de prefijo de precios.

 ```
return [
    'filtersFQCN' => 'App\\Filters\\',
    'requestFilterPrefix' => 'filter_'
];
 ```

## Filtros

 A fin de definir un filtro debe crear una carpeta llamada como su modelo con su directorio de filtrs.  Dentro de esta carpeta puede una carpeta especifica en el modelo.
 Por ejemplo:   
 ```path\to\laravel\app\Filters\User\HasId.php```
 Su filtro tiene la tiene que encontrarse en la siguiente extensión ModelSearch\Contracts\Filter.

 ```
 <?php

namespace App\Filters\User;

use ModelSearch\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;


class HasId implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param integer $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where( 'id', $value );
    }
}
 ```


## Filtros requeridos
Los siguientes filtros de prefijo en la configuración definen el prefijo que está siendo usado por el nombre del filtro.
Esto puede usarse para permitir al usuario aplicar filtros mediante solicitudes POST y GET. Esto puede realizarse manualmente llamando al```addRequestFilters``` metodo y proveyendo una instancia de solicitud.

 Recuerde siempre aplicar filtros en el orden apropiado.
 ```
 $search = new ModelSearch( User::class );
 $search->addRequestFilters( $request );
 $result = $search->result();
 ```

Puede cambiar el prefijo filtro de la busqeuda luego de llamar al ```setRequestFilterPrefix()``` metodo, proveyendo un nuevo prefijo.

## Ejemplos

El siguiente ejemplo muestra como debe utilizar la busqeuda en su controlador:

```
namespace ModelSearch\ModelSearch;


public function someController( Request $request ) {
    ...

    $search = new ModelSearch( User::class );
    $search->addFilters([
        'HasId' => 1,
        'HasLastName' => 'Doe'
    ]);
    $search->addFilter('SomeFilter', 'value');
    $result = $search->result();

    // The search can be extended after processing results
    $search->addFilter('AnotherFilter', 'value');
    $result2 = $search->result();

    ...
}
```
