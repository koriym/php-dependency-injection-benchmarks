<?php

class Module extends \Ray\Di\AbstractModule
{
    protected function configure()
    {
        $this->bind('A');
        $this->bind('B');
        $this->bind('C');
        $this->bind('D');
        $this->bind('E');
        $this->bind('F');
        $this->bind('G');
        $this->bind('H');
        $this->bind('I');
        $this->bind('J');
    }
}
