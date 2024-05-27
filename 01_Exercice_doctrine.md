### Exercice : Gestion Avancée des Repositories dans Doctrine

#### Contexte
Vous travaillez sur une application de gestion de bibliothèque. Vous devez créer une application CLI (Command Line Interface) en PHP qui utilise Doctrine pour gérer les entités et les repositories. L'entité `Book` doit être gérée avec des méthodes avancées de repository.

#### Objectifs
1. Configurer Doctrine.
2. Créer l'entité `Book`.
3. Créer un repository personnalisé pour l'entité `Book`.
4. Implémenter des méthodes spécifiques dans le repository.
5. Créer des scripts CLI pour tester ces méthodes.

#### Schéma des Données
L'entité `Book` a les attributs suivants :

| Attribut      | Type        | Description                         |
|---------------|-------------|-------------------------------------|
| `id`          | Integer     | Identifiant unique du livre         |
| `title`       | String      | Titre du livre                      |
| `author`      | String      | Auteur du livre                     |
| `price`       | Float       | Prix du livre                       |
| `publishedAt` | DateTime    | Date de publication du livre        |

#### Étapes

1. **Configurer SF un nouveau projet**

2. **Créer l'entité `Book`**

   - Créer l'entité `Book` avec les attributs pour Doctrine.
   - Hydrater l'entité `Book` avec les Faker de Symfony.

3. **Créer le Repository Personnalisé**

   - Créer un repository personnalisé pour l'entité `Book`.
   - Implémenter les méthodes suivantes :
     - `findBooksByMinPrice(float $minPrice)`: Trouver les livres dont le prix est supérieur à un certain montant.
     - `findRecentBooks()`: Trouver les livres publiés dans les 30 derniers jours.
     - `findBooksByTitle(string $title)`: Trouver les livres par titre, recherche insensible à la casse.

4. **Tester**

- Une fois les fonctionalités en place, trouvez une méthode de tests adaptés à l'exercice.

#### Schéma UML de l'Entité `Book`

```
+-------------------+
|      Book         |
+-------------------+
| - id : Integer    |
| - title : String  |
| - author : String |
| - price : Float   |
| - publishedAt : DateTime |
+-------------------+
```
