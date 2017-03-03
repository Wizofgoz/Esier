<?php

namespace Esier\Models\Data;

class ItemList implements \Countable, \Iterator
{
    /*
    *	Array of items in the list
    *
    *	@var array
    */
    private $items = [];

    /*
    *	The index that the pointer is currently at
    *
    *	@var int
    */
    private $currentIndex = 0;

    /*
    *	Adds an item to the list
    *
    *	@param Esier\Models\Data\Item $item
    *
    *	@return void
    */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /*
    *	Removes a specified item from the list
    *
    *	@param Esier\Models\Data\Item $item
    *
    *	@return void
    */
    public function removeItem(Item $itemToRemove)
    {
        foreach ($this->items as $key => $item) {
            if ($item->getId() === $itemToRemove->getId()) {
                unset($this->items[$key]);
            }
        }
    }

    /*
    *	Returns count of items in the list
    *
    *	@return int
    */
    public function count(): int
    {
        return count($this->items);
    }

    /*
    *	Returns Item at current index
    *
    *	@return Esier\Models\Data\Item
    */
    public function current(): Item
    {
        return $this->items[$this->currentIndex];
    }

    /*
    *	Returns what index the internal pointer is at
    *
    *	@return int
    */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /*
    *	Moves the internal pointer ahead
    *
    *	@return void
    */
    public function next()
    {
        $this->currentIndex++;
    }

    /*
    *	Resets the internal pointer to 0
    *
    *	@return void
    */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /*
    *	Returns whether the item at the current index is valid
    *
    *	@return bool
    */
    public function valid(): bool
    {
        return isset($this->items[$this->currentIndex]);
    }
}
