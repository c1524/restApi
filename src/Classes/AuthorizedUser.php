<?php

namespace RestApi;


class AuthorizedUser
{
    public $id = null;

    public function __construct()
    {
        $this->id = $_SESSION['memberid'];
    }

    public function isAuthorized()
    {
        return !empty($this->id);
    }

}