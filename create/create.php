<?php
session_start();

// Check if user is logged in (you'll need to implement authentication)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Database connection (adjust credentials)
$db = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post | Madwanzi CTF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/create.css">
    <!-- CodeMirror for syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
</head>
<body class="create-page">
    <nav class="navbar">
        <div class="container">
            <a href="../index.php" class="logo">
                <span class="logo-icon"><i class="fas fa-shield-alt"></i></span>
                <span>Madwanzi</span>
            </a>
            <div class="nav-links">
                <a href="../index.php">Home</a>
                <a href="../blog/index.php">Blog</a>
                <a href="index.php" class="active">Create Post</a>
                <a href="../auth/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <main class="editor-container container">
        <div class="editor-header">
            <h1>Create New Blog Post</h1>
            <div class="action-buttons">
                <button id="save-draft" class="secondary-button">
                    <i class="fas fa-save"></i> Save Draft
                </button>
                <button id="publish-post" class="cta-button">
                    <i class="fas fa-paper-plane"></i> Publish
                </button>
            </div>
        </div>

        <form id="post-form" action="process_post.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="author_id" value="<?php echo $_SESSION['user_id']; ?>">
            
            <div class="form-group">
                <input type="text" id="post-title" name="post_title" placeholder="Enter post title..." required>
            </div>

            <div class="form-group">
                <select id="post-category" name="post_category">
                    <option value="">Select category</option>
                    <option value="ctf-writeups">CTF Writeups</option>
                    <option value="tutorials">Tutorials</option>
                    <option value="security-news">Security News</option>
                    <option value="tools">Tools & Reviews</option>
                </select>
            </div>

            <div class="form-group">
                <label for="featured-image">Featured Image</label>
                <input type="file" id="featured-image" name="featured_image" accept="image/*">
            </div>

            <!-- Rest of your editor toolbar and content remains the same -->
            <div class="editor-toolbar">
                <!-- ... existing toolbar buttons ... -->
            </div>

            <div class="editor-wrapper">
                <div id="post-editor" contenteditable="true" placeholder="Write your post here..."></div>
                <textarea id="post-content" name="post_content" style="display:none;"></textarea>
                <div id="post-preview" class="preview-mode"></div>
            </div>

            <!-- Code Insertion Modal -->
            <!-- ... existing modal code ... -->
            
            <input type="hidden" name="is_published" id="is-published" value="0">
        </form>
    </main>

    <!-- Same script includes as before -->
    <script src="../js/create.js"></script>
</body>
</html>