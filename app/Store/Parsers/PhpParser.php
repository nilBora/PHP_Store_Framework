<?php
namespace NilBora\NSF\Store\Parsers;
class PhpParser implements ParserInterface
{
    protected $path;
    
    public function __construct($path)
    {
        $this->path = $path;
    } // end __construct
    
    public function parse()
    {
        include_once $this->path;

        return $table;
    } // end parse
}
