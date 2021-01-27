<?php

namespace Jtrw\StoreView;

class Menu implements MenuInterface
{
    private ?string $_currentUrl;
    private array $_items;
    
    public function __construct(array $items, string $currentUrl = null)
    {
        $this->_items = $items;
        $this->_currentUrl = $currentUrl;
    } // end __construct
    
    public function getItems(): array
    {
        return $this->_getMenuItemsTree($this->_items);
    } // end getItems
    
    private function _getMenuItemsTree(array $rows, int $idParent = null, int $level = 0)
    {
        $result = array();
        $level++;
        foreach ($rows as $index => $row) {
            if ($row['id_parent'] != $idParent) {
                continue;
            }
            
            $menuItem = array(
                'caption'   => $row['caption'],
                'href'      => $this->_getMenuItemUrl($row['url']),
                'level'     => $level,
                'id_parent' => $row['id_parent'],
                'items'     => null,
                'ident'     => empty($row['ident']) ? null : $row['ident'],
                'icon'      => $row['icon']
            );
            
            $childs = $this->_getMenuItemsTree($rows, $row['id'], $level);
            
            $menuItem['items'] = $childs ? $childs : null;
            
            $result[$row['id']] = new MenuItem($menuItem, $this->_currentUrl);
            
            unset($rows[$index]);
        }
        
        return $result;
    } // end _getMenuItemsTree
    
    private function _getMenuItemUrl(string $url = null): string
    {
        return ''.$url;
    } // end _getMenuItemUrl
}
