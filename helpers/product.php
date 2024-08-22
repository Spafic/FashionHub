<?php
class Product {
    private $id;
    private $name;
    private $category;
    private $price;
    private $rating;
    private $image;
    private $description;
    private $numRatings;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->category = $data['category'];
        $this->price = $data['price'];
        $this->rating = $data['rating'];
        $this->image = $data['image'];
        $this->description = $data['description'];
        $this->numRatings = $data['numRatings'] ?? 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getNumRatings() {
        return $this->numRatings;
    }

    public static function getProducts($category = null) {
        $json = file_get_contents('../data/products/products.json');
        $products = json_decode($json, true);
        
        if ($category) {
            $products = array_filter($products, function($product) use ($category) {
                return $product['category'] === $category;
            });
        }

        return array_map(function($product) {
            return new Product($product);
        }, $products);
    }

    public static function sortProducts($products, $sortBy) {
        usort($products, function($a, $b) use ($sortBy) {
            return $a->$sortBy <=> $b->$sortBy;
        });
        return $products;
    }

    public static function searchProducts($products, $search) {
        return array_filter($products, function($product) use ($search) {
            return (stripos($product->getName(), $search) !== false) || 
                   (stripos($product->getCategory(), $search) !== false);
        });
    }

    public function setNumRatings($numRatings) {
        $this->numRatings = $numRatings;
    }

    public function setRating($newRating) {
        $totalRating = $this->rating * $this->numRatings;
        $this->numRatings++;
        $this->rating = ($totalRating + $newRating) / $this->numRatings;
    }

    public static function getProductById($id) {
        $products = self::getProducts();
        foreach ($products as $product) {
            if ($product->getId() == $id) {
                return $product;
            }
        }
        return null;
    }
   

    public static function addProduct($data) {
        $products = self::getAllProductsArray();
        $lastProduct = end($products);
        $newId = $lastProduct ? $lastProduct['id'] + 1 : 1;
        $data['id'] = $newId; // Set the new ID
        $data['rating'] = 0;
        $data['numRatings'] = 0;
        $products[] = $data;
        self::saveProducts($products);
        return new Product($data);
    }

    public static function updateProduct($id, $data) {
        $products = self::getAllProductsArray();
        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $product = array_merge($product, $data);
                break;
            }
        }
        self::saveProducts($products);
        return new Product($data);
    }

    public static function removeProduct($id) {
        $products = self::getAllProductsArray();
        $updatedProducts = array_filter($products, function($product) use ($id) {
            return $product['id'] != $id;
        });
    
        if (count($updatedProducts) === count($products)) {
            // No product was removed
            return false;
        }
    
        self::saveProducts(array_values($updatedProducts));
        return true;
    }
    

    private static function getAllProductsArray() {
        $json = file_get_contents('../data/products/products.json');
        return json_decode($json, true);
    }

    private static function saveProducts($products) {
        file_put_contents('../data/products/products.json', json_encode($products, JSON_PRETTY_PRINT));
    }


    public function updateDetails($data) {
        $this->name = $data['name'];
        $this->category = $data['category'];
        $this->price = floatval($data['price']);
        if (isset($data['image'])) {
            $this->image = $data['image'];
        }
        $this->description = $data['description'];
    }
    
    public function saveToFile($filePath) {
        $jsonData = file_get_contents($filePath);
        $products = json_decode($jsonData, true);
    
        foreach ($products as &$product) {
            if ($product['id'] == $this->id) {
                $product = $this->toArray();
                break;
            }
        }
    
        $result = file_put_contents($filePath, json_encode($products, JSON_PRETTY_PRINT));
        if ($result === false) {
            throw new Exception("Failed to write to file: $filePath");
        }
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'rating' => $this->rating,
            'image' => $this->image,
            'description' => $this->description,
            'numRatings' => $this->numRatings
        ];
    }
}
