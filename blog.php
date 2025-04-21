<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;

session_start();

// Usage example
$post = new Post();

// checks if the button is clicked and the form is submitted. If true, run the createUser() function from our User class
// Then pass in an array of data to the createUser class since createUser accepts an array of data
if(isset($_POST['submit'])) {
    $post->addPost([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'author_id' => $_POST['author_id']
    ]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AxciBlog - Post a blog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class = "blog-form">
        <form method="POST" action="blog.php">
         <a href="index.php">Go Back</a>
            <p>
                <?php 
                if (isset($_SESSION['user']) && isset($_SESSION['user']['first_name'])) {
                    echo "Hello, " . htmlspecialchars($_SESSION['user']['first_name']);
                } else {
                    echo "Hello, Guest! Please log in to add a blog post.";
                }
                ?>
            </p>
            <h1>Add a Blog Post</h1>
            <input type="text" name="title" placeholder="Title">
            <input type="hidden" name="author_id" value="<?php echo isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : ''; ?>">
            <textarea name="content" id=""></textarea>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>