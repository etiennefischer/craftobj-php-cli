# PHP-Challenge: CRAFTOBJ

Le but du challenge est de développer en PHP 8, un générateur de classe PHP en CLI.

## Exemples d'utilisation:

- `./craftobj -i Pomme -o output/edible -c Fruit` // Créera le fichier `Fruit.php` dans le dossier `output/edible`

ou bien: 

- `./craftobj` // Le mode interactif me demandera la valeur des options `input`, `output` et `classname`

## Niveau 1 (les basiques):

- L'input viendra de wikipédia, si on continue avec l'exemple "Pomme", on ira alors crawler (sans utiliser l'api) les métadonnées d'une pomme sur `https://fr.wikipedia.org/wiki/Pomme` (voir encadré en rouge ci-dessous).
- Les attributs en gras seront les propriétés de la classe.

![Wikipédia](/wiki.png)

- Par conséquent, l'output sera une classe PHP (voir l'exemple ci-dessous)

```php
class Fruit
{
    private string $plante;
    private string $espece;
    private string $famille;
    private string $origine;
    private array $vitamines;
    private array $mineraux;
    
    public function __construct()
    {
    }

    public static function sample(): Fruit
    {
        return (new self())
            ->setPlante('Pommier')
            ->setEspece('Malus')
            ->setFamille('Rosaceae')
            ->setOrigine('Asie centrale')
            ->setVitamines(['A', 'B1', 'B2', 'B3', 'B5', 'B6', 'B9', 'C', 'E', 'K'])
            ->setMineraux(['calcium', 'fer', 'magnésium', 'manganèse', 'phosphore', 'potassium', 'sodium', 'zinc']);
    }

    public function getPlante(): string
    {
        return $this->plante;
    }

    public function setPlante(string $plante): self
    {
        $this->plante = $plante;

        return $this;
    }

    public function getEspece(): string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function getFamille(): string
    {
        return $this->famille;
    }

    public function setFamille(string $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function getOrigine(): string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getVitamines(): array
    {
        return $this->vitamines;
    }

    public function setVitamines(array $vitamines): self
    {
        $this->vitamines = $vitamines;

        return $this;
    }

    public function getMineraux(): array
    {
        return $this->mineraux;
    }

    public function setMineraux(array $mineraux): self
    {
        $this->mineraux = $mineraux;

        return $this;
    }
}

```

- À la fin, tu devras instancier un objet de la classe nouvellement créée et afficher le résultat de la méthode `sample` dans la console. (via un simple var_dump/dump/print_r).


## Précisions:

1. Développer en PHP 8 (typage fort et arguments nommées sont appréciés)
2. L'outil sera une CLI et devra fonctionner aussi bien en mode "one line" que "interactive".
3. Tu peux utiliser toutes les librairies que tu veux, manuellement (simple include) ou via composer (mais pas de framework entier).
4. Il se peut que le tableau des métadonnées de Wikipédia soit absent, tu n'as pas à gérer ce cas et il suffira de lever une erreur dans la console.
5. Le projet devra être disponible sur un dépôt privé github

## Niveau 2 (c'est encore mieux avec - facultatif)

- Exposer une API très simple

Exemple : 

- Requête :
`method:POST uri:/craftobj/fetch body:{"input":"Pomme", "classname":"Fruit"}`

- Réponse :
```json
{
    "id": "Fruit",
    "properties": {
        "plante": { "type": "string", "visibility": "private" },
        "espece": { "type": "string", "visibility": "private" },
        "famille": { "type": "string", "visibility": "private" },
        "origine": { "type": "string", "visibility": "private" },
        "vitamines": { "type": "array", "visibility": "private" },
        "mineraux": { "type": "array", "visibility": "private" }
    },
    "sample": {
        "plante": "Pommier",
        "espece": "Malus",
        "famille": "Rosaceae",
        "origine": "Asie centrale",
        "vitamines": ["A", "B1", "B2", "B3", "B5", "B6", "B9", "C", "E", "K"],
        "mineraux": ["calcium", "fer", "magnésium", "manganèse", "phosphore", "potassium", "sodium", "zinc"]
    }
}
```

## Niveau 3 (si t'en veux encore - facultatif)

- Tu pourrais enregistrer le résultat du crawl dans un fichier JSON (https://github.com/donjajo/php-jsondb)
- Il n'y a alors plus forcément besoin de crawler, et il faut donc aller chercher en priorité dans la jsondb

Exemple : 

- Requête :
```sql
SELECT * FROM objects WHERE id = 'Fruit';
```

- Réponse : 
```json
{
    "id": "Fruit",
    "properties": {
        "plante": { "type": "string", "visibility": "private" },
        "espece": { "type": "string", "visibility": "private" },
        "famille": { "type": "string", "visibility": "private" },
        "origine": { "type": "string", "visibility": "private" },
        "vitamines": { "type": "array", "visibility": "private" },
        "mineraux": { "type": "array", "visibility": "private" }
    },
    "sample": {
        "plante": "Pommier",
        "espece": "Malus",
        "famille": "Rosaceae",
        "origine": "Asie centrale",
        "vitamines": ["A", "B1", "B2", "B3", "B5", "B6", "B9", "C", "E", "K"],
        "mineraux": ["calcium", "fer", "magnésium", "manganèse", "phosphore", "potassium", "sodium", "zinc"]
    }
}
```

## Test

- Si ton générateur marche bien, tu peux le tester avec une autre page par exemple https://fr.wikipedia.org/wiki/Mars_(plan%C3%A8te)

#

*Toute amélioration sera la bienvenue*

**Have fun !**
