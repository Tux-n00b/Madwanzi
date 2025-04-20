<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Database connection
require_once '/db/database.sql';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $title = trim($_POST['post_title']);
        $content = trim($_POST['post_content']);
        $category = $_POST['post_category'];
        $authorId = $_POST['author_id'];
        $isPublished = $_POST['is_published'] === '1' ? 1 : 0;
        
        if (empty($title) || empty($content)) {
            throw new Exception('Title and content are required');
        }

        // Handle file upload
        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['featured_image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            // Validate image
            $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (!in_array($imageFileType, $allowedExtensions)) {
                throw new Exception('Only JPG, JPEG, PNG & GIF files are allowed');
            }
            
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetPath)) {
                $featuredImage = $fileName;
            }
        }

        // Generate excerpt
        $excerpt = substr(strip_tags($content), 0, 150);
        if (strlen(strip_tags($content)) > 150) {
            $excerpt .= '...';
        }

        // Calculate read time
        $wordCount = str_word_count(strip_tags($content));
        $readTime = ceil($wordCount / 200); // 200 words per minute

        // Insert into database
        $stmt = $db->prepare("
            INSERT INTO posts 
            (title, content, excerpt, category, author_id, featured_image, is_published, read_time, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $title,
            $content,
            $excerpt,
            $category,
            $authorId,
            $featuredImage,
            $isPublished,
            $readTime
        ]);

        // Redirect with success message
        $_SESSION['flash_message'] = $isPublished 
            ? 'Post published successfully!' 
            : 'Draft saved successfully!';
        
        header('Location: ../blog/index.php');
        exit();

    } catch (Exception $e) {
        // Handle error
        $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
        header('Location: create.php');
        exit();
    }
}