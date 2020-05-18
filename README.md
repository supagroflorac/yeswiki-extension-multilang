Extension multilang
====================

Permet de gérer un wiki multilingue.

L'action 'flags'
----------------

Affiche les langues disponible pour le site. Elles sont représentées par le
drapeau du pays d'origine de la langue. Un clic sur un drapeau force
l'affichage du site dans cette langue si le contenu a été traduit. Sinon c'est la
langue par défaut qui est affichée.

L'action 'flags' prend pour paramètre obligatoire 'list'. List doit contenir la
liste des drapeaux à afficher et donc des langues disponible sur le site.

ex : {{flags list="fr,en,it"}}

La mise en forme de la liste doit être prise en charge par le thème ou par du
CSS inclus dans la page.
Les éléments CSS sont :
 - ul.flaglist (liste des  drapeaux)
 - li.selected (langue choisie)


L'action 'translate'
--------------------

**Avec le paramètre 'ref'**
L'extension propose une action 'translate' qui prend le paramètre 'ref'. (Cf. les fichiers de traduction)

ex : {{translate ref="hat"}}

**Avec les paramètres 'ref' et 'link'**
En ajoutant le paramètre link cela crée un lien. link accepte une URL ou un nom de page YesWiki. Le parametre ref doit être définis pour que "link" soit pris en compte.

ex : {{translate ref="hat" link="HaT"}}

**Avec les paramètres 'ref' et 'file'**
Permet d'utiliser l'action attach tout en traduisant les textes affichées par 'desc', 'caption' et 'legend'.
Les paramètres 'nofullimagelink','class','size','width','height','legend','caption','link' sont pris en charge. Le parametre 'ref' remplace le parametre 'desc' de l'action attach.
Les parametres 'ref', 'caption' et 'legend' doivent faire référence au fichier de traduction.

ex : {{translate ref="hat" file="ma_photo_de_chapeau.jpg" caption="hat"}}

**Sans paramètres**
Si l'action est appelée sans paramètres. Elle ajoute à la fin du nom de la page
les deux caractères de la langue (ex : PagePrincipale devient PagePrincipaleFr)
Si cette nouvelle page existe, l'utilisateur est automatiquement redirigé vers
celle-ci. Si elle n'existe pas, que l'utilisateur est connecté et a le droit de
créer cette page alors un lien est ajouté pour lui proposer de traduire la
page.

ex : {{translate}}


Les fichiers de traduction
--------------------------

Le fichiers de traduction doivent être placé dans le dossier 'tools/multilang'.
Il doit y avoir un fichier par langue. Le nom de chacun de ces fichiers est 
composé des deux caractères de la langue (ex fr pour français, en pour anglais, 
it pour italien) suivi de l'extension '.php'.

ex : tools/multilang/fr.php

Ce fichier contient un tableau appelé '$translations'. Dans ce tableau :
 - la clé est l'identifiant de la chaîne de caractères (paramètre ref de
    l'action transate)
 - La valeur, sa traduction dans la langue du fichier

ex : 
```php
<?php
$translations = array(
    'BUTTON_SEND' => 'Envoyer',
    'BUTTON_CANCEL' => 'Annuler',
    'hat' => 'chapeau',
);
```
Si le fichier correspondant à la langue demandée n'existe pas, c'est alors
la langue par défaut du wiki qui est choisie par défaut.

Si la clé correspondant a la référence passé en paramètre de l'action n'existe
pas un message d'erreur apparaît (No traduction available for 'ref').

Déterminer la langue
-------------------

La langue est déterminé via le paramètre 'HTTP_ACCEPT_LANGUAGE' de $_SERVER.
(cf : https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language)
Seule la première langue est prise en compte et seulement les deux premiers
caractère de celle ci.

ex :
 - pour 'fr-FR', seul 'fr' est pris en compte.
 - pour 'en-GB', seuls 'en' est pris en compte.
