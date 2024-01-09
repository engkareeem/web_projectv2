<?php

class Product {
    public $id;
    public $title;
    public $description;
    public $price;
    public $category; // New property
    public $imageID;
    public $creationDate;
    public $discount;
    public $stock;
    public $numSold;

    /**
     * @param $title
     * @param $description
     * @param $price
     * @param $category
     * @param $imageID
     * @param $creationDate
     * @param $discount
     * @param $stock
     * @param $numSold
     */
    public function __construct($title, $description, $price, $category, $imageID, $creationDate, $discount, $stock, $numSold)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->imageID = $imageID;
        $this->creationDate = $creationDate;
        $this->discount = $discount;
        $this->stock = $stock;
        $this->numSold = $numSold;
    }

    // ... (other methods remain unchanged)

    public function getJson(): array {
        $arr = [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'imageID' => $this->imageID,
            'creationDate' => $this->creationDate,
            'discount' => $this->discount,
            'stock' => $this->stock,
            'numSold' => $this->numSold,
        ];
        return array_filter($arr, function ($value) {
            return $value !== null;
        });
    }

    public function setJson($document): void {
        $this->id = $document['_id'] ?? -1;
        $this->title = $document['title'] ?? null;
        $this->description = $document['description'] ?? null;
        $this->price = $document['price'] ?? null;
        $this->imageID = $document['imageID'] ?? null;
        $this->creationDate = $document['creationDate'] ?? null;
        $this->discount = $document['discount'] ?? null;
        $this->stock = $document['stock'] ?? null;
        $this->numSold = $document['numSold'] ?? null;
        $this->category = $document['category'] ?? null;
    }


    public static function createEmptyInstance():self {
        return new self(null,null,null,null,null,null,null,null,null);
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }



    /**
     * @return mixed
     */
    public function getimageID()
    {
        return $this->imageID;
    }

    /**
     * @param mixed $imageID
     */
    public function setimageID($imageID): void
    {
        $this->imageID = $imageID;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getcreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setcreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getNumSold()
    {
        return $this->numSold;
    }

    /**
     * @param mixed $numSold
     */
    public function setNumSold($numSold): void
    {
        $this->numSold = $numSold;
    }


}
?>