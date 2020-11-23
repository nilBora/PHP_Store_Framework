<?php
namespace NilBora\NSF\Store;

use NilBora\NSF\Store\Exceptions\StoreModelException;
use NilBora\NSF\Store\Plugins\CustomModelInterface;

class StoreModel implements StoreModelInterface
{
    protected $store;
    protected $struct;
    protected $hasModelFile = false;
    protected $customModel;
    
    public function __construct(Store $store)
    {
        $this->store = $store;
    }
    
    public function load()
    {
        $options = $this->store->getOptions();
        $tableName = $fileName = $this->store->getTableName();
        
        if ($this->hasModelByLoad()) {
            return $this->struct;
        }
     
    
        $extensions = ['php', 'xml'];
        
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
    
    public function getProxy()
    {
        return $this->store->getProxy();
    } // end getProxy
    
    protected function hasModelByLoad()
    {
        $options = $this->store->getOptions();
        $tableName = $fileName = $this->store->getTableName();
        $modelName = ucfirst($tableName);

        if (file_exists($options['plugins_dir'].$modelName."/".$modelName.".php")) {
            
            $namespace = $options['plugins_namespace']."\\".$modelName."\\".$modelName;
            $model = new $namespace();
            if (!($model instanceof CustomModelInterface)) {
                throw new StoreModelException("Model must be repeated ICustomModel");
            }
            $this->struct = $model->getStruct();
            $this->hasModelFile = true;
            $this->customModel = $model;
            return true;
        }
        return false;
    }
    
    public function hasModelFile()
    {
        return $this->hasModelFile;
    } // end hasModelFile
    
    public function getCustomModel(): CustomModelInterface
    {
        return $this->customModel;
    } // getModel
    
}
