<?php

use \Core\Route;

return [
    new Route('/', 'links', 'getLinkForm'),
    new Route('/show/', 'links', 'show'),
    new Route('/delete/:id', 'links', 'delete'),
    new Route('/redirect/:link', 'links', 'redirect'),
];
