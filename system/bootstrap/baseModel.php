<?php
namespace Rian\HMVC;

class baseModel {

	protected $app;

	public function __construct($c)  {
        $this->app = $c;
    }
}