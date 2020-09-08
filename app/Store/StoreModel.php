<?php
namespace NilBora\NSF\Store;

use NilBora\NSF\Store\Exceptions\StoreModelException;

class StoreModel implements IStoreModel
{
    protected $store;
    protected $struct;
    
    public function __construct(Store $store)
    {
        $this->store = $store;
    }
    
    public function load()
    {
        $extensions = ['php', 'xml'];
        $options = $this->store->getOptions();
        $tableName = $fileName = $this->store->getTableName();

        foreach ($extensions as $ext) {
            $filePath = $options['plugins_dir'].ucfirst(mb_strtolower($tableName))."/tblDefs/".$tableName.".".$ext;
        
            if (file_exists($filePath)) {
                $parserName = ucfirst($ext)."Parser";
                $namespace = "\NilBora\NSF\Store\Parsers\\".$parserName;

                $parserInstance = new $namespace($filePath);
                $struct = $parserInstance->parse();
                
                if (array_key_exists("listeners", $struct)) {
                    foreach ($struct['listeners'] as $listener) {
                        $this->store->addListener($listener['name'], $listener);
                    }
                }
                
                $this->struct = $struct;

                return $this->struct;
            }
        }
        throw new \Exception("File Not Found");
    }
    
    public function getStruct()
    {
        return $this->struct;
    }
    
    public function getStore()
    {
        return $this->store;
    }
    
    public function getFields()
    {
        if (!$this->hasKeyInStruct('fields')) {
            new StoreModelException("Key 'Fields' Not Found In Struct");
        }
        return $this->struct['fields'];
    } // end getFields
    
    public function hasKeyInStruct($key)
    {
        return array_key_exists($key, $this->struct);
    }
    
    public function getTableName()
    {
        return $this->struct['table']['name'];
    }
    
}
