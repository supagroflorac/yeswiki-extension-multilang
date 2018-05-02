<?php

/**
 * Retourne la lanque par défaut du site.
 * @return string La locale par défaut (code sur deux caractères)
 */
function getDefaultLang()
{
    return $GLOBALS['wiki']->config['default_language'];
}

/**
 * getLang Découpe $_SERVER['HTTP_ACCEPT_LANGUAGE'] pour obtenir la première
 * langue choisie (uniquement les deux premiers caractères)
 * @return string Les deux premiers caractères de la locale demandée par le
 *                navigateur (fr, en, it...)
 */
function getLang()
{
    // cf . https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language

    if (isset($_COOKIE['MULTILANG_FORCELANG'])
        and !empty($_COOKIE['MULTILANG_FORCELANG'])
    ) {
        return $_COOKIE['MULTILANG_FORCELANG'];
    }

    if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        return getDefaultLang();
    }

    // Récupère la première lang choisie dans HTTP_ACCEPT_LANGUAGE.
    $lang = trim(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0]);

    // enleve la quality value si besoin.
    $lang = explode(';', $lang)[0];

    // Supprimer les données apres le tiret.
    $lang = explode('-', $lang)[0];

    return $lang;
}

function getLangfilesPath($wiki)
{
    $langPath = 'tools/template/themes/' . THEME_PAR_DEFAUT;

    if (isset($wiki->config['favorite_theme'])) {
        $langPath = 'themes/' . $wiki->config['favorite_theme'];
    }

    if (isset($GLOBALS['wakkaConfig']['favorite_theme'])) {
        $favTheme = $GLOBALS['wakkaConfig']['favorite_theme'];
        $langPath = "themes/$favTheme";
    }

    return $langPath . '/lang/';
}
