<?php
/**
 * Created by PhpStorm.
 * User: voja
 * Date: 6.10.17.
 * Time: 11.26
 */



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data["repository"]["id"] == 101808407) {
        echo shell_exec("git pull");
        echo shell_exec("php ../../bin/console cache:clear --env=prod");
    }
}
//TODO: hmac check for autopull
//TODO: composer, npm and gulp tasks after pull