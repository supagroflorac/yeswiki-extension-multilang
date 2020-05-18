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
$link = $this->GetParameter('link');
$file = $this->GetParameter('file');

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
$langFile = "$langFilespath$defaultLang.php";
if (file_exists("$langFilespath$lang.php")) {
    $langFile = "$langFilespath$lang.php";
}
include($langFile);

$text = "No traduction available for '$ref'";
if (isset($translations[$ref])) {
    $text = $translations[$ref];
}

// Si un lien est définis.
if ($link !== "" and  $file === "") {
    $text = "[[${link} ${text}]]";
    print($this->Format($text, 'wakka'));
    return;
} 

if ($file !== "") {
    // Récupère la liste des parametres compatibles avec attach
    $parameterToGet = array(
        'nofullimagelink',
        'class',
        'size',
        'width',
        'height',
        'legend',
        'caption',
        'link',
    );

    $parameters = "";
    foreach($parameterToGet as $parameter) {
        $value = $this->GetParameter($parameter);

        if ($value !== "") {
            if ($parameter === 'legend' or $parameter === 'caption') {  
                $valtext = "No traduction available for '$value'";
                if (isset($translations[$value])) {
                    $valtext = $translations[$value];
                }
                $value = $valtext;
            }
            $parameters .= "${parameter}=\"$value\" ";
        }
    }

    $text = "{{attach file=\"${file}\" desc=\"${text}\" ${parameters} }}";
    print($this->Format($text, 'wakka'));
    return;
}

print($text);

