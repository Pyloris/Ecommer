<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";

class AdminController {

    public function show($request) {
        // grab all the products
        $db = new DB();

        $products = $db->getProducts(['%']);
        // print_r($products);
        // exit();
        $context = [
            'products' => $products
        ];

        VIEW::init("admin/index.html", $context);
    }

    public function addProduct($request) {
        if ($request->method() == "GET") {
            VIEW::init("admin/add_product.html");
        }

        else if ($request->method() == "POST") {
            $db = new DB();

            // get the image names
            $allImgNames = $request->fileName('imgs');
            $exts = $request->fileExtension('imgs');

            // store generated names
            $genNames = [];

            // path to save product images at
            $product_imgs = __DIR__ . "/../../static/images/product_imgs/";

            // generate random names for each file and
            // store them using that name
            for ($fno = 0; $fno < count($allImgNames); $fno++) {
                $rand_str = hash("sha256", $allImgNames[$fno] . strval(rand(0, 100000000)));

                // get extensions
                $ext = $exts[$fno] ? '.'.$exts[$fno] : '';

                $new_name = substr($rand_str, 0, 10) . substr($rand_str, 5, 10) . $ext;

                // save the name
                $genNames[] = $new_name;
                
                // save the file
                if (!move_uploaded_file($request->File('imgs')[$fno], $product_imgs . $new_name)) {
                    echo("Error in saving the file. $allImgNames[$fno]");
                }
            }

            // generate imgs string for the product
            $imgs = implode(':', $genNames);

            $product_name = $request->formData('name');
            $product_description = $request->formData('description');
            $product_mrp = $request->formData('MRP');
            $product_sp = $request->formData('SP');
            $product_sku = $request->formData('sku');
            $product_category = $request->formData('category');
            $product_stock = $request->formData('stock');
            $rating = NULL;
            // add product to database
            if ($db->addProduct($product_name, $product_sku, $product_description, $product_mrp, $product_sp, $imgs, $rating, $product_category)) {
                // get the product
                $product = $db->getProduct($product_name);

                // insert stock in stock table
                if ($db->setStock($product['id'], $product_stock)) { 
                    echo("Product has been successfully Added to database");
                }
                else {
                    echo("product added but stock failed to update");
                }
            } else
                echo("Could not add the product");
        }
    }
}

?>