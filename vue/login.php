<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>
<link rel="stylesheet" href="/public/assets/css/login.css">
<link rel="icon" href="/public/assets/img/logo2.png" />

<div id="fond-login">
</div>

<div id="div-login">
    <div class="div-logo">
    <img src="/public/assets/img/logo2.png" alt="Plein la bobine !">
    </div>
    <div id="error"><?php   
                    if (isset($erreur)) {
                     
                        echo $erreur;
                    }
                    ?></div>
    <form method="post" id="formulaire" action="/User/login">
        <div class="mb-3">
            <label class="form-label" for="username">Login:</label>
            <input class="form-control" type="text" id="username" name="login" value="" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Mot de passe:</label>
            <input class="form-control" type="password" id="password" name="password" required />
        </div>
        <div class="div-submit">
            <button class="btn btn-primary" id="btn-login" type="submit">S'identifier</button>
        </div>
    </form>
</div>