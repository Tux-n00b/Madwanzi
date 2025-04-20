// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            this.querySelector('i').classList.toggle('fa-times');
            this.querySelector('i').classList.toggle('fa-bars');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navLinks.style.display = 'none';
                    mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                    mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                }
            });
        });
    }

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Active Navigation Link Highlighting
    const sections = document.querySelectorAll('section');
    const navItems = document.querySelectorAll('.nav-links a');
    
    window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (pageYOffset >= (sectionTop - 100)) {
                current = section.getAttribute('id');
            }
        });
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${current}`) {
                item.classList.add('active');
            }
        });
    });

    // CTF Category Animation
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.category-icon i');
            if (icon) {
                icon.style.transform = 'rotate(15deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.category-icon i');
            if (icon) {
                icon.style.transform = 'rotate(0)';
            }
        });
    });

    // Team Member Social Links Animation
    const teamMembers = document.querySelectorAll('.team-member');
    teamMembers.forEach(member => {
        const socialLinks = member.querySelectorAll('.member-social a');
        
        member.addEventListener('mouseenter', function() {
            socialLinks.forEach((link, index) => {
                setTimeout(() => {
                    link.style.transform = 'translateY(0)';
                    link.style.opacity = '1';
                }, index * 100);
            });
        });
        
        member.addEventListener('mouseleave', function() {
            socialLinks.forEach(link => {
                link.style.transform = 'translateY(10px)';
                link.style.opacity = '0';
            });
        });
    });

    // Current Year for Footer
    const yearElement = document.querySelector('.footer-bottom p:first-child');
    if (yearElement) {
        const currentYear = new Date().getFullYear();
        yearElement.textContent = yearElement.textContent.replace('2023', currentYear);
    }

    // Event Countdown Timer (Example for first event)
    const eventDateElements = document.querySelectorAll('.event-date');
    if (eventDateElements.length > 0) {
        const firstEventDate = eventDateElements[0];
        const eventDay = firstEventDate.querySelector('.event-day');
        const eventMonth = firstEventDate.querySelector('.event-month');
        
        // Example event date (June 15, 2023)
        const eventDate = new Date(2023, 5, 15); // Note: months are 0-indexed
        
        // Update this with actual event dates from your database/API later
        const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        
        if (eventDay && eventMonth) {
            eventDay.textContent = eventDate.getDate();
            eventMonth.textContent = months[eventDate.getMonth()];
        }
    }
});

// Intersection Observer for Scroll Animations
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
        }
    });
}, observerOptions);

// Apply to sections
document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});

// Utility function for future API calls
async function fetchCTFEvents() {
    try {
        // This would be replaced with your actual API endpoint
        const response = await fetch('https://api.example.com/ctf-events');
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching CTF events:', error);
        return [];
    }
}

// Initialize any future event carousels
function initEventCarousel() {
    // This would be implemented when you have multiple events to display
    console.log('Event carousel initialized');
}

// Export functions if using modules (for future expansion)
// export { fetchCTFEvents, initEventCarousel };