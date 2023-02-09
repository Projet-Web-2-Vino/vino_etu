# Relations

1 Usager peut avoir 1 à plusieurs Cellier.
1 Cellier appartient qu'à 1 Usager 
1:N

1 Cellier peut contenir plusieurs Bouteille
1 Bouteille peut être dans plusieurs Cellier
N:M

1 Note peut etre donné a un bouteille
1 Bouteille peut exiter san avoir un note
0:1

# Liste des opérations des modèles

## Usager

Usager::get
Usager::add

##### opération par l'admin
   - Usager::delete

## Cellier
Cellier::getListe
Cellier::getOne

Cellier::add
Cellier:update
Cellier:delete

## Bouteille
Bouteille::getListe
Bouteille::getOne

Bouteille::add
Bouteille:update
Bouteille:delete

## Note
Note::getOne

Note::add
Note:update
Note:delete

## SAQ
SAQ::update  // importation du catalogue par l'admin