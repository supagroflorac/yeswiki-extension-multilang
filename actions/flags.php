<?php
// test de sécurité pour vérifier si on passe par wiki
if (!defined('WIKINI_VERSION')) {
    die('accès direct interdit');
}

// Cette action permet d'ajouter une liste de drapeaux afin de forcer
// l'affichage d'une langue.

$langList = explode(',', str_replace(' ', '', $this->GetParameter('list')));
$link = $this->MiniHref();

print('<ul class="flaglist">');
foreach ($langList as $lang) {
    $flagFilename = "tools/multilang/flags/" . strtoupper($lang) . ".png";
    $class = "";
    if (isset($_COOKIE['MULTILANG_FORCELANG'])
        and $_COOKIE['MULTILANG_FORCELANG'] === $lang) {
        $class = "class=\"selected\"";
    }

    print("<li $class><a href=\"?$link&forcelang=$lang\"><img src=\"$flagFilename\"></a>");
}
print('</ul>');
