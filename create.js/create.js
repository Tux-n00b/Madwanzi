document.addEventListener('DOMContentLoaded', function() {
    // Editor elements
    const editor = document.getElementById('post-editor');
    const preview = document.getElementById('post-preview');
    const togglePreview = document.getElementById('toggle-preview');
    const postForm = document.getElementById('post-form');
    const saveDraftBtn = document.getElementById('save-draft');
    const publishBtn = document.getElementById('publish-post');
    const insertImageBtn = document.getElementById('insert-image');
    const imageUpload = document.getElementById('image-upload');
    const insertFileBtn = document.getElementById('insert-file');
    const fileUpload = document.getElementById('file-upload');
    const insertCodeBtn = document.getElementById('insert-code');
    const codeModal = document.getElementById('code-modal');
    const closeModal = document.querySelector('.close-modal');
    const insertCodeFinalBtn = document.getElementById('insert-code-btn');
    const codeLanguage = document.getElementById('code-language');
    const codeContent = document.getElementById('code-content');

    // Toggle preview mode
    togglePreview.addEventListener('click', function() {
        preview.innerHTML = editor.innerHTML;
        editor.parentElement.classList.toggle('preview-mode');
        this.classList.toggle('active');
    });

    // Formatting buttons
    document.querySelectorAll('.editor-toolbar button[data-command]').forEach(button => {
        button.addEventListener('click', function() {
            const command = this.getAttribute('data-command');
            if (command === 'createLink') {
                const url = prompt('Enter the URL:');
                if (url) document.execCommand(command, false, url);
            } else {
                document.execCommand(command, false, null);
            }
            editor.focus();
        });
    });

    // Image upload
    insertImageBtn.addEventListener('click', () => imageUpload.click());
    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.maxWidth = '100%';
                insertAtCursor(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // File attachment
    insertFileBtn.addEventListener('click', () => fileUpload.click());
    fileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const link = document.createElement('a');
                link.href = event.target.result;
                link.textContent = file.name;
                link.download = file.name;
                link.style.display = 'block';
                link.style.margin = '10px 0';
                insertAtCursor(link);
            };
            reader.readAsDataURL(file);
        }
    });

    // Code insertion
    insertCodeBtn.addEventListener('click', () => {
        codeModal.style.display = 'block';
        codeContent.value = '';
    });

    closeModal.addEventListener('click', () => {
        codeModal.style.display = 'none';
    });

    insertCodeFinalBtn.addEventListener('click', function() {
        const language = codeLanguage.value;
        const code = codeContent.value;
        
        if (code.trim()) {
            const pre = document.createElement('pre');
            const codeElem = document.createElement('code');
            codeElem.className = `language-${language}`;
            codeElem.textContent = code;
            pre.appendChild(codeElem);
            insertAtCursor(pre);
            
            // Apply syntax highlighting (CodeMirror will handle this in preview)
            codeModal.style.display = 'none';
        }
    });

    // Save draft
    saveDraftBtn.addEventListener('click', function(e) {
        e.preventDefault();
        savePost(false);
        alert('Draft saved successfully!');
    });

    // Publish post
    publishBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (validatePost()) {
            savePost(true);
            alert('Post published successfully!');
            window.location.href = '../blog/index.html';
        }
    });

    // In create.js - Update the publish button event handler
publishBtn.addEventListener('click', async function(e) {
    e.preventDefault();
    
    if (!validatePost()) {
        return;
    }

    // Show loading state
    publishBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publishing...';
    publishBtn.disabled = true;

    try {
        // Get form data
        const title = document.getElementById('post-title').value.trim();
        const category = document.getElementById('post-category').value;
        const content = editor.innerHTML;
        const excerpt = generateExcerpt(content);
        
        // Create post object
        const post = {
            id: Date.now().toString(),
            title,
            category,
            content,
            excerpt,
            author: {
                name: "Madwanzi Team", // Replace with actual author
                avatar: "../images/default-avatar.png"
            },
            date: new Date().toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            }),
            published: true,
            readTime: calculateReadTime(content),
            featuredImage: getFirstImageFromContent(content) || "../images/blog/default-post.jpg"
        };

        // Save to localStorage (temporary solution)
        savePostToStorage(post);

        // In a real app, you would send to a server here:
        // await savePostToServer(post);

        // Show success message
        showNotification('Post published successfully!', 'success');
        
        // Redirect to blog page after 1.5 seconds
        setTimeout(() => {
            window.location.href = "../blog/index.html";
        }, 1500);
        
    } catch (error) {
        console.error("Publishing failed:", error);
        showNotification('Failed to publish post. Please try again.', 'error');
        publishBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Publish';
        publishBtn.disabled = false;
    }
});

// Helper functions for publishing
function generateExcerpt(content) {
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = content;
    const text = tempDiv.textContent || tempDiv.innerText || '';
    return text.substring(0, 150) + (text.length > 150 ? '...' : '');
}

function calculateReadTime(content) {
    const text = content.replace(/<[^>]*>/g, ' ');
    const wordCount = text.trim().split(/\s+/).length;
    return Math.ceil(wordCount / 200); // 200 words per minute
}

function savePostToStorage(post) {
    let posts = JSON.parse(localStorage.getItem('madwanzi-blog-posts')) || [];
    posts.unshift(post); // Add new post at beginning
    localStorage.setItem('madwanzi-blog-posts', JSON.stringify(posts));
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}



    // Helper function to insert content at cursor
    function insertAtCursor(node) {
        const selection = window.getSelection();
        if (selection.rangeCount) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(node);
            
            // Move cursor after inserted node
            const newRange = document.createRange();
            newRange.setStartAfter(node);
            newRange.collapse(true);
            selection.removeAllRanges();
            selection.addRange(newRange);
        } else {
            editor.appendChild(node);
        }
        editor.focus();
    }

    // Validate post before saving
    function validatePost() {
        const title = document.getElementById('post-title').value.trim();
        const content = editor.innerHTML.trim();
        
        if (!title) {
            alert('Please enter a post title');
            return false;
        }
        
        if (!content || content === '<br>' || content === '<div><br></div>') {
            alert('Please write some content for your post');
            return false;
        }
        
        return true;
    }

    // Save post to localStorage (simulated database)
    function savePost(publish = false) {
        const title = document.getElementById('post-title').value.trim();
        const category = document.getElementById('post-category').value;
        const content = editor.innerHTML;
        
        const post = {
            id: Date.now().toString(),
            title,
            category,
            content,
            author: "Your Name", // Replace with actual author
            date: new Date().toISOString(),
            published: publish,
            image: getFirstImageFromContent(content)
        };
        
        // Get existing posts or initialize array
        let posts = JSON.parse(localStorage.getItem('madwanzi-blog-posts')) || [];
        
        // Add new post
        posts.unshift(post);
        
        // Save back to localStorage
        localStorage.setItem('madwanzi-blog-posts', JSON.stringify(posts));
        
        // Clear form if published
        if (publish) {
            postForm.reset();
            editor.innerHTML = '';
        }
    }

    // Helper to extract first image from content
    function getFirstImageFromContent(content) {
        const temp = document.createElement('div');
        temp.innerHTML = content;
        const img = temp.querySelector('img');
        return img ? img.src : '../images/blog/default-post.jpg';
    }
});

// Initialize CodeMirror for code blocks in preview
function initializeCodeHighlighting() {
    document.querySelectorAll('pre code').forEach((block) => {
        CodeMirror.runMode(
            block.textContent,
            CodeMirror.findModeByMIME(`text/${block.className.replace('language-', '')}`).mode,
            block
        );
    });
}