<?php

if (!defined("WIKINI_VERSION")) {
    die("accès directe interdit");
}

if (isset($_GET['forcelang']) and !empty($_GET['forcelang'])) {
    setcookie('MULTILANG_FORCELANG', $_GET['forcelang']);

    $defaultPage = substr($this->tag, 0, -2);
    if ($this->LoadPage($defaultPage) !== null
        and $this->HasAccess('read', $defaultPage)
    ) {
        $this->Redirect('?' . $defaultPage);
    }

    $this->Redirect('?' . $this->miniHref());
}
