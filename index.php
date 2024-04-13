<?php

$dbname = "product_crud";
$dbuser = "root";
$dbpass = "";

$pdo = new PDO("mysql:host=localhost;port=8111;dbname=$dbname", $dbuser . $dbpass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare("SELECT * FROM products ORDER BY create_date DESC");
$statement->execute();
$products = $statement->fetchall(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <a href="create.php" class="btn btn-secondary">Create Products</a>
    <title>Product CRUD</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>Product CRUD</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Create Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $row): ?>
                <tr>
                    <th scope="row"><?php echo $index + 1 ?></th>
                    <td>
                        <img src="<?php echo $row['image'] ?>" class="thumb-image">
                    </td>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['price'] ?></td>
                    <td><?php echo $row['create_date'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                        <form style="display: inline-block" action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>