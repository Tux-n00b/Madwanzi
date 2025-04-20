<?php
// Start session for potential user tracking
session_start();

// Define site-wide variables
$site_title = "Madwanzi CTF | Cybersecurity Team";
$current_year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/home/index.css">
</head>
<body>
    <!-- Dark theme navigation for security feel -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <span class="logo-icon"><i class="fas fa-shield-alt"></i></span>
                <span>Madwanzi</span>
            </a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#ctf">CTF</a>
                <a href="#team">Team</a>
                <a href="blog/index.php">Blog</a>
                <a href="#contact" class="cta-button">Join Us</a>
            </div>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Madwanzi CTF Team</h1>
                <p class="tagline">Breaking systems ethically to build better defenses</p>
                <div class="hero-buttons">
                    <a href="#ctf" class="cta-button">Our CTF Events</a>
                    <a href="#contact" class="secondary-button">Train With Us</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="images/OIP (1).jpeg" alt="CTF Competition">
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <h2 class="section-title">Who We Are</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Madwanzi is a competitive cybersecurity team specializing in Capture The Flag (CTF) competitions. We train, compete, and share knowledge to advance cybersecurity skills.</p>
                    <p>Founded in 2020, we've competed in over 50 CTF events worldwide, ranking in the top 100 teams globally.</p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">CTF Events</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">15</div>
                            <div class="stat-label">Team Members</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">International Wins</div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <!--<img src="images/Logo.jpg" alt="Madwanzi Team">-->
                </div>
            </div>
        </div>
    </section>

    <!-- CTF Section -->
    <section id="ctf" class="section ctf-section dark-section">
        <div class="container">
            <h2 class="section-title">Our CTF Specialties</h2>
            <div class="ctf-categories">
                <?php
                $categories = [
                    [
                        'icon' => 'fa-lock',
                        'title' => 'Cryptography',
                        'desc' => 'Breaking and building encryption systems, analyzing ciphers, and cryptographic attacks.'
                    ],
                    [
                        'icon' => 'fa-bug',
                        'title' => 'Binary Exploitation',
                        'desc' => 'Reverse engineering, memory corruption, and privilege escalation challenges.'
                    ],
                    [
                        'icon' => 'fa-globe',
                        'title' => 'Web Security',
                        'desc' => 'Web application vulnerabilities, injection attacks, and client-side security.'
                    ],
                    [
                        'icon' => 'fa-network-wired',
                        'title' => 'Network Security',
                        'desc' => 'Packet analysis, network protocols, and infrastructure security.'
                    ]
                ];

                foreach ($categories as $category) {
                    echo '
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas ' . htmlspecialchars($category['icon']) . '"></i>
                        </div>
                        <h3>' . htmlspecialchars($category['title']) . '</h3>
                        <p>' . htmlspecialchars($category['desc']) . '</p>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="section events-section"> 
        <div class="container">
            <h2 class="section-title">Upcoming Events</h2>
            <div class="events-timeline">
                <?php
                $events = [
                    [
                        'day' => '15',
                        'month' => 'JUN',
                        'title' => 'DEF CON CTF Qualifiers',
                        'location' => 'Online Competition',
                        'link' => '#'
                    ],
                    [
                        'day' => '28',
                        'month' => 'JUL',
                        'title' => 'Hack The Box University CTF',
                        'location' => 'Online Competition',
                        'link' => '#'
                    ]
                ];

                foreach ($events as $event) {
                    echo '
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">' . htmlspecialchars($event['day']) . '</span>
                            <span class="event-month">' . htmlspecialchars($event['month']) . '</span>
                        </div>
                        <div class="event-details">
                            <h3>' . htmlspecialchars($event['title']) . '</h3>
                            <p class="event-location">' . htmlspecialchars($event['location']) . '</p>
                            <a href="' . htmlspecialchars($event['link']) . '" class="event-link">Register Team <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="section team-section dark-section">
        <div class="container">
            <h2 class="section-title">Meet Our Team</h2>
            <div class="team-grid">
                <?php
                $team_members = [
                    [
                        'image' => 'images/team-member1.jpg',
                        'name' => 'Tux',
                        'role' => 'Binary Exploitation & Web Exploitation',
                        'bio' => 'Tux is a seasoned binary exploiter with a passion',
                        'social' => [
                            ['icon' => 'fa-twitter', 'url' => 'https://x.com/tuxn00b'],
                            ['icon' => 'fa-linkedin', 'url' => '#']
                        ]
                    ],
                    [
                        'image' => 'images/team-member2.jpg',
                        'name' => 'Kitana254',
                        'role' => 'Reverse Engineering & Cryptography',
                        'bio' => 'Kitana254 is a seasoned Reverse engineering protoje with sharpned skills',
                        'social' => [
                            ['icon' => 'fa-twitter', 'url' => '#'],
                            ['icon' => 'fa-github', 'url' => '#']
                        ]
                    ],
                    [
                        'image' => 'images/team-member3.jpg',
                        'name' => 'Eddx',
                        'role' => 'Web Exploitation & Miscellaneous',
                        'bio' => 'The internet his play ground, nothing is hidden when it comes to him',
                        'social' => [
                            ['icon' => 'fa-twitter', 'url' => '#'],
                            ['icon' => 'fa-github', 'url' => '#']
                        ]
                    ]
                ];

                foreach ($team_members as $member) {
                    echo '
                    <div class="team-member">
                        <div class="member-image">
                            <img src="' . htmlspecialchars($member['image']) . '" alt="' . htmlspecialchars($member['name']) . '">
                        </div>
                        <h3>' . htmlspecialchars($member['name']) . '</h3>
                        <p class="member-role">' . htmlspecialchars($member['role']) . '</p>
                        <p class="member-bio">' . htmlspecialchars($member['bio']) . '</p>
                        <div class="member-social">';
                    
                    foreach ($member['social'] as $social) {
                        echo '<a href="' . htmlspecialchars($social['url']) . '"><i class="fab ' . htmlspecialchars($social['icon']) . '"></i></a>';
                    }
                    
                    echo '
                        </div>
                    </div>';
                }
                ?>
            </div>
            <div class="section-footer">
                <a href="team.php" class="cta-button">View Full Team</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="logo">
                        <span class="logo-icon"><i class="fas fa-shield-alt"></i></span>
                        <span>Madwanzi</span>
                    </div>
                    <p>Ethical hackers training the next generation of cybersecurity professionals through CTF competitions.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#ctf">CTF Events</a></li>
                        <li><a href="#team">Our Team</a></li>
                        <li><a href="blog/index.php">Blog</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contact Us</h4>
                    <p><i class="fas fa-envelope"></i> contact@madwanzi.com</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-discord"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo $current_year; ?> Madwanzi CTF Team. All rights reserved.</p>
                <p class="legal-links">
                    <a href="#">Privacy Policy</a> | 
                    <a href="#">Code of Conduct</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>