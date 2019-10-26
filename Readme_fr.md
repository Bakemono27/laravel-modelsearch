# Laravel ModelSearch
[![Status](https://travis-ci.org/bumbummen99/laravel-modelsearch.png?branch=master)](https://travis-ci.org/bumbummen99/laravel-modelsearch)
[![codecov](https://codecov.io/gh/bumbummen99/laravel-modelsearch/branch/master/graph/badge.svg)](https://codecov.io/gh/bumbummen99/laravel-modelsearch)
[![StyleCI](https://styleci.io/repos/159666547/shield?branch=master)](https://styleci.io/repos/159666547)
[![Téléchacgement Total](https://poser.pugx.org/skyraptor/modelsearch/downloads.png)](https://packagist.org/packages/skyraptor/modelsearch)
[![Dernière Version Stable](https://poser.pugx.org/skyraptor/modelsearch/v/stable)](https://packagist.org/packages/skyraptor/modelsearch)
[![Dernière version instable](https://poser.pugx.org/skyraptor/modelsearch/v/unstable)](https://packagist.org/packages/skyraptor/modelsearch)
[![Licence](https://poser.pugx.org/skyraptor/modelsearch/license)](https://packagist.org/packages/skyraptor/modelsearch)
[![Page d'accueil](https://img.shields.io/badge/homepage-skyraptor.eu-informational.svg?style=flat&logo=appveyor)](https://skyraptor.eu)

 Laravel ModelSearch est un package lèger et facile à utiliser permettant de créer des requêtes de recherche dynamiques pour des modèles spécifiques avec Laravel et Illuminate 5.8.

 # Exigences
 - Laravel 5.7+

 # Installation
 ## Composer

Il suffit de courir ```composer require skyraptor/modelsearch``` installer le paquet dans sa dernière version, après cette exécution  ```composer update```. Le package enregistrera son propre fournisseur de services à l'aide de la  découverte de packages Laravels.

## Configuration

 Ce paquet comprendre son propre fichier de configuration que vous devriez publier avec la commande ```php artisan vendor:publish``` et suivre les instuctions à l'écran. Dans le fichier de configuration vous devez ajuster l'espace de noms pour votre répertoire de filtres et votre préfixe de filtre de requête.

 ```
return [
    'filtersFQCN' => 'App\\Filters\\',
    'requestFilterPrefix' => 'filter_'
];
 ```

## Filtre

 A fin de  définir un filtre, vous devez créer un dossier nommé comme modèle dans votre répertoire de filtres. Dans ce dossier, vous pouvez créer un fichier spécifique au modèle.
 Par example:
 ```path\to\laravel\app\Filters\User\HasId.php```
Votre filtre doit étendre ModelSearch\Contracts\Filter.

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


## Demander des filtres
 Le préfixe de filtre de requête dans la configuration définit le préfixe utilisé pour les noms de filtre dans les paramètres de raquête. Ceci peut êtres utilisé pour permettre  à l'utilisateur d'appliquer des filtres via de requêtes POST et GET. Ceci doit être fait manuellement en appelant le ```addRequestFilters``` Méthode et fourniture d'une instance de demande.

Rappelez-vous toujours d'appliquer les filtres dans l'ordre approprié.
 ```
 $search = new ModelSearch( User::class );
 $search->addRequestFilters( $request );
 $result = $search->result();
 ```

Vous pouvez modifier le préfixe de filtre de la recherche après en appelant le ```setRequestFilterPrefix()```  méthode, fournissant un nouveau prefix.

## Exemples

L'exemple suivant vous montre comment utiliser la recherch dans votre contrôleur:

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
