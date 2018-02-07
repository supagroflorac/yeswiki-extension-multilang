Extension multilang
====================

Permet de gérer un wiki multilingue.

L'action 'translate'
--------------------

L'extension propose une action 'translate' qui prend le paramètre 'ref'
Sans paramètre l'action n'a aucun effet.

ex : {{translate ref="hat"}}

Si l'action est appelé sans paramètre. Elle ajoute a la fin du nom de la page
les deux caractères de la langue (ex : PagePrincipale devient PagePrincipaleFr)
Si cette nouvelle page existe, l'utilisateur est automatiquement redirigé vers
celle-ci. Si elle n'existe pas, que l'utilisateur est connecté et a le droit de
créer cette page alors un bouton est ajouté pour lui proposer de traduire la
page.

ex : {{translate}}


Les fichiers de traduction
--------------------------

Le fichiers de traduction doivent être placé dans le dossier du thème dans un
sous-répertoire 'lang'. Il doit y avoir un fichier par traduction. Le nom de
chacun de ses fichiers est composé des deux caractères de la langue (ex fr pour
français, en pour anglais, it pour italien) suivi de l'extension '.php'.

Ce fichier contient un tableau appelé '$translations'. Dans ce tableau :
 - la clé est l'identifiant de la chaîne de caractères (paramètre ref de
    l'action trad)
 - La valeur, sa traduction dans la langue du fichier

Si le fichier correspondant a la langue demandée n'existe pas, c'est alors
l'anglais qui est choisis par défaut.

Si la clé correspondant a la référence passé en paramètre de l'action n'existe
pas un message d'erreur apparaît (No traduction available for 'ref').

Déterminé la langue
-------------------

La langue est déterminé via le paramètre 'HTTP_ACCEPT_LANGUAGE' de $_SERVER.
(cf : https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language)
Seule la première langue est prise en compte et seulement les deux premiers
caractère de celle ci.

ex :
 - pour 'fr-FR', seul 'fr' est pris en compte.
 - pour 'en-GB', seuls 'en' est pris en compte.
