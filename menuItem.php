<?php
class MenuItem {
  private $itemName;
  private $description;
  private $price;

  function __construct($itemName, $description, $price){
    $this->itemName = $itemName;
    $this->description = $description;
    $this->price = $price;
  }

  function itemName(){
    return $this->itemName;
  }

  function description(){
    return $this->description;
  }

  function price(){
    return $this->price;
  }
}
?>
