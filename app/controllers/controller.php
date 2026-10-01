<?php
class Controller
{
    protected function view(string $path,mixed $data=null)
    {
        //*make it global on the system if it exists
        extract($data ?? []);
        require_once __DIR__ ."/../views/{$path}.php";
    }
}
