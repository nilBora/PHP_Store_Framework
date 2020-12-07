<?php
namespace Jtrw\Store;

use Jtrw\Store\Exceptions\StoreModelException;
use Jtrw\Store\Model\CustomModelInterface;
use Jtrw\Store\Proxy\ProxyInterface;

class StoreModel implements StoreModelInterface
{
    protected $store;
    protected $struct;
    protected $hasModelFile = false;
    protected $customModel;
    
    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }
    
    public function load(): array
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
                $namespace = "\Jtrw\Store\Parsers\\".$parserName;

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
        throw new StoreModelException("File Not Found");
    }
    
    public function getStruct(): array
    {
        return $this->struct;
    }
    
    public function getStore(): StoreInterface
    {
        return $this->store;
    }
    
    public function getFields(): array
    {
        if (!$this->hasKeyInStruct('fields')) {
            new StoreModelException("Key 'Fields' Not Found In Struct");
        }
        return $this->struct['fields'];
    } // end getFields
    
    public function hasKeyInStruct(string $key): bool
    {
        return array_key_exists($key, $this->struct);
    }
    
    public function getTableName(): string
    {
        return $this->struct['table']['name'];
    }
    
    public function getProxy(): ProxyInterface
    {
        return $this->store->getProxy();
    } // end getProxy
    
    protected function hasModelByLoad(): bool
    {
        $options = $this->store->getOptions();
        $tableName = $fileName = $this->store->getTableName();
        $modelName = ucfirst($tableName);

        if (file_exists($options['plugins_dir'].$modelName."/".$modelName.".php")) {
            
            $namespace = $options['plugins_namespace']."\\".$modelName."\\".$modelName;
            $model = new $namespace();
            if (!($model instanceof CustomModelInterface)) {
                throw new StoreModelException("Model must be repeated CustomModelInterface");
            }
            $this->struct = $model->getStruct();
            $this->hasModelFile = true;
            $this->customModel = $model;
            return true;
        }
        return false;
    }
    
    public function hasModelFile(): bool
    {
        return $this->hasModelFile;
    } // end hasModelFile
    
    public function getCustomModel(): CustomModelInterface
    {
        return $this->customModel;
    } // getModel
    
}
