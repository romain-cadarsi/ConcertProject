<?php

namespace App\Exception;

class NonAuthorizedModification extends \Exception
{
    public function __construct()
    {
        parent::__construct("Vous n'avez pas le droit d'accèder à cette page");
    }
}