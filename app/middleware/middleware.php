<?php

//?  we make it for middleware has 1 func and it must be exist
interface Middleware
{
    public function handle(string ...$roles): void;
}
