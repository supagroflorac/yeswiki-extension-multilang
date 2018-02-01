<?php

/**
 * getLang Découpe $_SERVER['HTTP_ACCEPT_LANGUAGE'] pour obtenir la première
 * langue choisie (uniquement les deux premiers caractères)
 * @return [type] [description]
 */
include_once('tools/multilang/includes/multilang.func.php');

// test de sécurité pour vérifier si on passe par wiki
if (!defined('WIKINI_VERSION')) {
    die('acc&egrave;s direct interdit');
}

$defaultLang = getDefaultLang();
$lang = getLang();

// Si le parmètre ref n'est pas déterminé, on tente une redirection vers la
// version traduite de la page.
//TODO Filtrer le contenu de ref.
$ref = $this->GetParameter('ref');
if (empty($ref)) {
    $redirectedPageName = $this->tag . ucfirst($lang);

    if ($lang !== $defaultLang) {
        $link = $this->Href('', $redirectedPageName);

        // La page traduite existe et les acl autorisent la lecture, on redirige vers celle-ci.
        if ($this->LoadPage($redirectedPageName) !== null
            and $this->HasAccess('read', $redirectedPageName)
        ) {
            $this->Redirect($link);
        }

        if ($this->HasAccess('write', $redirectedPageName)) {
            print("<a class='tradLink' href='$link/edit'>Traduct it</a>");
        }
    }
    return;
}

$file = "tools/multilang/lang/$defaultLang.php";
if (file_exists("tools/multilang/lang/$lang.php")) {
    $file = "tools/multilang/lang/$lang.php";
}
include($file);

$text = "No traduction available for '$ref'";
if (isset($etresTraductions[$ref])) {
    $text = $etresTraductions[$ref];
}
print($text);
