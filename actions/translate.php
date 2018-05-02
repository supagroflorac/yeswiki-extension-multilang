<?php
// test de sécurité pour vérifier si on passe par wiki
if (!defined('WIKINI_VERSION')) {
    die('accès direct interdit');
}

include_once('tools/multilang/includes/multilang.func.php');

$defaultLang = getDefaultLang();
$lang = getLang();

/*******************************************************************************
 * SANS PARAMETRES
 */
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
            print("<a class='tradLink' href='$link/edit'>Traduct it</a><br />");
        }
    }
    return;
}

/*******************************************************************************
 * AVEC PARAMETRES
 */
$langFilespath = getLangfilesPath($this);
$file = "$langFilespath$defaultLang.php";
if (file_exists("$langFilespath$lang.php")) {
    $file = "$langFilespath$lang.php";
}
include($file);

$text = "No traduction available for '$ref'";
if (isset($translations[$ref])) {
    $text = $translations[$ref];
}
print($text);
