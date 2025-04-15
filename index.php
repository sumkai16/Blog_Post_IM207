<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;

session_start();

// Fetch posts based on user login status
$post = new Post();
if (isset($_SESSION['user'])) {
    $userPosts = $post->getPostsByLoggedInUser($_SESSION['user']['id']); // Fetch posts by the logged-in user
} else {
    $recentPosts = $post->getPosts(); // Fetch all recent posts
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AxciBlog - Home</title>
    <link rel="stylesheet" href="assets/css/blog.css">
</head>
<body>
    <header>
        <div class="nav"> 
            <ul>
                <h1>AxciBlog Posts</h1>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="blog.php">Add Post</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>
    <div class="welcome">
        <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['first_name'])): ?>
            <h2>Welcome <?php echo htmlspecialchars($_SESSION['user']['first_name'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
        <?php else: ?>
            <h2>Welcome to AxciBlog</h2>
        <?php endif; ?>           
    </div>
    <div class="posts">
        <h2><?php echo isset($_SESSION['user']) ? "Your Blog Posts" : "Recent Blog Posts"; ?></h2>
        <ul>
            <?php
            if (isset($_SESSION['user'])) {
                // Display posts by the logged-in user
                foreach ($userPosts as $post) {
                    echo "<li>";
                    echo "<p><strong>" . htmlspecialchars($post['first_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($post['last_name'] ?? 'Author', ENT_QUOTES, 'UTF-8') . "</strong></p>";
                    echo "<h3>" . htmlspecialchars($post['title'] ?? 'Untitled', ENT_QUOTES, 'UTF-8') . "</h3>";
                    echo "<p>" . htmlspecialchars($post['content'] ?? 'No content available.', ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "<p><em>Posted on: " . htmlspecialchars($post['date_posted'] ?? 'Unknown date', ENT_QUOTES, 'UTF-8') . "</em></p>";
                    echo "</li>";
                }
            } else {
                // Display recent posts from all users
                foreach ($recentPosts as $post) {
                    echo "<li>";
                    echo "<p><strong>" . htmlspecialchars($post['first_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($post['last_name'] ?? 'Author', ENT_QUOTES, 'UTF-8') . "</strong></p>";
                    echo "<h3>" . htmlspecialchars($post['title'] ?? 'Untitled', ENT_QUOTES, 'UTF-8') . "</h3>";
                    echo "<p>" . htmlspecialchars($post['content'] ?? 'No content available.', ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "<p><em>Posted on: " . htmlspecialchars($post['date_posted'] ?? 'Unknown date', ENT_QUOTES, 'UTF-8') . "</em></p>";
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </div>
    <div class="footer">
        <p>© 2025 AxciBlog. All rights reserved.</p>
    </div>
</body>
</html>