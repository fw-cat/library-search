<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function viewName(string $page): string
    {
        return "pages/{$page}";
    }
}
