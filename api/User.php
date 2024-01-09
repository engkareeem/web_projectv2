<?php
class User{
    public $id;
    public $username;
    public $email;
    public $password;
    public $isAdmin;
    public $purchasedList;
    public $favoritesList;
    public $cart;
    public $lastLogin;

    /**
     * @param $username
     * @param $email
     * @param $password
     * @param $isAdmin
     * @param $purchasedList
     * @param $favoritesList
     * @param $cart
     * @param $lastLogin
     */
    public function __construct($username, $email, $password, $isAdmin, $purchasedList, $favoritesList, $cart, $lastLogin)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->purchasedList = $purchasedList;
        $this->favoritesList = $favoritesList;
        $this->cart = $cart;
        $this->lastLogin = $lastLogin;
    }

    public static function createEmptyInstance(): self {
        return new self(null,null,null,null,null,null,null,null);
    }
    public function getJson(): array
    {
        return [
            'username'      => $this->username,
            'email'         => $this->email,
            'password'      => $this->password,
            'isAdmin'       => $this->isAdmin,
            'purchasedList' => $this->purchasedList,
            'favoritesList' => $this->favoritesList,
            'cart'      => $this->cart,
            'lastLogin'     => $this->lastLogin,
        ];
    }

    public function setJson($document): void {
        $this->id = $document['_id'] ?? -1;
        $this->username = $document['username'] ?? null;
        $this->email = $document['email'] ?? null;
        $this->password = $document['password'] ?? null;
        $this->isAdmin = $document['isAdmin'] ?? null;
        $this->purchasedList = $document['purchasedList'] ?? null;
        $this->favoritesList = $document['favoritesList'] ?? null;
        foreach ($document['cart'] as $value) {
            $this->cart[$value] = '1';
        }
        $this->cart = $document['cart'] ?? null;
        $this->lastLogin = $document['lastLogin'] ?? null;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return mixed
     */
    public function getPurchasedList()
    {
        return $this->purchasedList;
    }

    /**
     * @param mixed $purchasedList
     */
    public function setPurchasedList($purchasedList): void
    {
        $this->purchasedList = $purchasedList;
    }

    /**
     * @return mixed
     */
    public function getFavoritesList()
    {
        return $this->favoritesList;
    }

    /**
     * @param mixed $favoritesList
     */
    public function setFavoritesList($favoritesList): void
    {
        $this->favoritesList = $favoritesList;
    }

    /**
     * @return mixed
     */
    public function getcart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setcart($cart): void
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }



}


?>