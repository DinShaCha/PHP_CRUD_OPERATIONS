<?php

$id = $_GET['id'] ?? null;


if(!$id){
    header('Location:index.php');
    exit;
}

$dbname = "product_crud";
$dbuser = "root";
$dbpass = "";

$pdo = new PDO("mysql:host=localhost;port=8111;dbname=$dbname", $dbuser . $dbpass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare("SELECT * FROM products WHERE id=:id");
$statement->bindValue(':id',$id);
$statement->execute();
$products = $statement->fetch(PDO::FETCH_ASSOC);

$title = $products['title'];
$description = $products['description'];
$price = $products['price'];

$errors = [];

if(!is_dir('images')){
    mkdir('images');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
        $errors[] = 'Title is required';
    }

    if (!$price) {
        $errors[] = 'Price is required';
    }

    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;
        $imagePath = $products['image'];

        if($image && $image['tmp_name']){
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'],$imagePath);
        }

        $statement = $pdo->prepare("UPDATE products SET title=:title,image=:image,price=:price,description=:description WHERE id = :id");
        $statement->bindValue(":title", $title);
        $statement->bindValue(":image", $imagePath);
        $statement->bindValue(":price", $price);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":id", $id);
        $statement->execute();
        header('Location:index.php');
    }
}

function randomString ($stringLen){
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $newString = '';
    for($i= 0 ; $i<$stringLen;$i++){
        $character = rand(0,strlen($characters)-1);
        $newString .= $characters[$character];
    }
    return $newString;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Products</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php if($products['image']): ?>
    <img src="<?php echo $products['image'] ?>" class='update-image' >
    <?php endif; ?>
    <h1>Create New Product</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <?php if ($errors): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Image</label><br>
            <input type="file" name="image">
        </div>
        <div class="mb-3">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description"><?php echo $description ?></textarea>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $price ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>