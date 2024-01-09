<?php
require_once 'User.php';
require_once 'Product.php';
require_once 'ApiMessages.php';
class DBApi {
    public static $client = null;

    private static function ensureConnection(): void {
        try {
            if(self::$client == null) throw new Exception("Client undefined");
            $collection = self::$client->shop->users;
            $collection->findOne();
        } catch(Exception $e) {
            require __DIR__ . '/../vendor/autoload.php';
            self::$client = new MongoDB\Client("mongodb+srv://krkr:123mm123@victorz.kqg7kiz.mongodb.net/");
        }
    }
    private static function getUsersCollection() {
        self::ensureConnection();
        return self::$client->shop->users;
    }
    private static function getProductsCollection() {
        self::ensureConnection();
        return self::$client->shop->products;
    }
    public static function getGridFS() {
        self::ensureConnection();
        return self::$client->shop->selectGridFSBucket();
    }
    /*                 USERS                        */
    public static function isUserExist($username): bool {
        $check = self::getUsersCollection()->findOne(['username' => $username]);
        return $check !== null;
    }

    public static function registerUser($username,$email,$password,$isAdmin=false) : APIResponse{
        if(self::isUserExist($username)) return APIResponse::USER_EXIST;

        $user = new User($username,$email,$password,$isAdmin,[],[],[],time());

        $insertResult = self::getUsersCollection()->insertOne($user->getJson());

        return $insertResult->getInsertedCount() > 0 ? APIResponse::SUCCESSFUL:APIResponse::ERROR;
    }

    public static function userLogin($username,$password): User {
        $user = User::createEmptyInstance();
        $document = self::getUsersCollection()->findOne(['username' => $username,'password' => $password]);

        if($document !== null) {
            self::getUsersCollection()->updateOne(['username'=>$username],['$set' => ['lastLogin' => time()]]);
            $user->setJson($document);
        }
        return $user;
    }
    public static function ensureLogin(): User {
        $user = User::createEmptyInstance();
        if(!empty($_COOKIE['userId'])) {
            $document = self::getUsersCollection()->findOne(["_id" => new \MongoDB\BSON\ObjectId($_COOKIE['userId'])]);

            if($document !== null) {
                $user->setJson($document);
            }
        }

        return $user;
    }
    public static function updateUser($user): APIResponse {
        try {
            self::getUsersCollection()->updateOne(['username'=>$user->username],['$set' => $user->getJson()]);
            return APIResponse::SUCCESSFUL;
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
    public static function getUsersCount($isAdmin=false): int|APIResponse {
        try {
            return self::getUsersCollection()->countDocuments(['isAdmin'=>$isAdmin]);
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
    public static function getAllUsers($filter=[],$order = []): array{ // 1 ascending -1 descending
        $cursor = self::getUsersCollection()->find($filter,['sort' => $order]);
        return iterator_to_array($cursor);
    }
    /*                Product                         */

    public static function addProduct($title, $description, $price, $category, $imageID, $stock,$discount): APIResponse {
        $product = new Product($title,$description,$price,$category,$imageID,time(),$discount, $stock, 0);
        $insertResult = self::getProductsCollection()->insertOne($product->getJson());
        return $insertResult->getInsertedCount() > 0 ? APIResponse::SUCCESSFUL:APIResponse::ERROR;
    }
    public static function getProductByID($id): Product {
        $product = Product::createEmptyInstance();
        $document = self::getProductsCollection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        if($document !== null) {
            $product->setJson($document);
        }
        return $product;
    }
    public static function getAllProducts($filter=[],$order = []): array{ // 1 ascending -1 descending
        $cursor = self::getProductsCollection()->find($filter,['sort' => $order]);
        return iterator_to_array($cursor);
    }
    public static function updateProduct($product): APIResponse {
        try {
            self::getProductsCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($product->id)],['$set' => $product->getJson()]);
            return APIResponse::SUCCESSFUL;
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
    public static function removeProduct($productId): APIResponse {
        try {
            $deleteResult = self::getProductsCollection()->deleteOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);
            return $deleteResult->getDeletedCount() > 0 ? APIResponse::SUCCESSFUL : APIResponse::NOT_EXIST;
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
    public static function addProductToFav($id,$userId,$type='$addToSet'): APIResponse {
        try {
            $updateResult = self::getUsersCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($userId)]
                                                                    ,[$type => ['favoritesList'=>$id]]);
            return APIResponse::SUCCESSFUL;
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
    public static function purchaseProduct($id,$userId,$count): APIResponse {
        try {
            self::getUsersCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($userId)],['$addToSet' => ['purchasedList'=>$id]]);
            self::getProductsCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($id)],['$inc' => ['stock' => -1*$count,'numSold'=>1*$count]]);
            self::getUsersCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($userId)],['$pull' => ['cart'=>$id]]);
            self::getUsersCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($userId)],['$pull' => ['favoritesList'=>$id]]);
            return APIResponse::SUCCESSFUL;
        } catch (Exception $e) {
            error_log($e);
            return APIResponse::ERROR;
        }
    }
    public static function addProductToCart($id, $count, $type = 'add'): APIResponse {
        if($type === 'add') {
            setcookie("cart_".$id, $count, time() + 86400, "/"); // 86400 seconds = 1 day
        } else {
            setcookie("cart_".$id, $count, time() - 86400, "/"); // 86400 seconds = 1 day
        }
        return APIResponse::SUCCESSFUL;
//        try {
//            $updateResult = self::getUsersCollection()->updateOne(['_id'=> new \MongoDB\BSON\ObjectId($userId)]
//                ,[$type => ['cart'=>$id]]);
//            return APIResponse::SUCCESSFUL;
//        } catch (Exception $e) {
//            return APIResponse::ERROR;
//        }
    }

    public static function getCart(): array {
        $cookie = $_COOKIE;
        $cart = [];
        foreach ($cookie as $id => $value) {
            if(str_starts_with($id, 'cart_')) {
                $cart[substr($id,5)] = $value;
            }
        }
        return $cart;
    }
    public static function clearCart() {
        $cookie = $_COOKIE;
        $cart = [];
        foreach ($cookie as $id => $value) {
            if(str_starts_with($id, 'cart_')) {
                setcookie($id, 1, time() - 86400, "/"); // 86400 seconds = 1 day
            }
        }
        return $cart;
    }
    /*              Storage             */
    public static function uploadImage($file): mixed{
        $gridFSBucket = self::getGridFS();
        $imgSize = getimagesize($file["tmp_name"]);
        if ($imgSize === false) {
            return APIResponse::INVALID_IMAGE;
        }

        $uploadDir = 'uploads/';
        $uniqueFilename = uniqid() . '_' . $file['name'];

        $targetPath = $uploadDir . $uniqueFilename;
        move_uploaded_file($file['tmp_name'], $targetPath);

        try {
            $stream = fopen($targetPath, 'r');
            $fileID = $gridFSBucket->uploadFromStream(
                $_FILES['file']['name'],
                fopen($targetPath, 'rb'),
                [
                    'metadata' => ['contentType' => $_FILES['file']['type']],
                ]
            );
            fclose($stream);
            unlink($targetPath);
            return $fileID;
        } catch (Exception $e) {
            return APIResponse::ERROR;
        }
    }
}
?>