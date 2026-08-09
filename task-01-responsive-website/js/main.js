document.addEventListener("DOMContentLoaded", function () {
    initializeApp();
});
const prefersReducedMotion =
    window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const POSTS_API_URL = "https://jsonplaceholder.typicode.com/posts";

const projects = [
    {
        id: 1,
        title: "E-Commerce Website",
        category: "Web",
        description: "A responsive online shopping platform with product browsing and checkout features.",
        technology: "HTML, CSS, JavaScript"
    },
    {
        id: 2,
        title: "Business Management System",
        category: "Web",
        description: "A web-based system designed to help businesses manage their daily operations.",
        technology: "JavaScript, REST API"
    },
    {
        id: 3,
        title: "Task Management App",
        category: "Mobile",
        description: "A mobile application that helps users organize tasks and track their daily progress.",
        technology: "Flutter, Dart"
    },
    {
        id: 4,
        title: "Food Delivery App",
        category: "Mobile",
        description: "A mobile application for browsing restaurants, ordering meals, and tracking deliveries.",
        technology: "Flutter, REST API"
    },
    {
        id: 5,
        title: "Company Dashboard",
        category: "UI/UX",
        description: "A modern dashboard interface designed to present company statistics and reports clearly.",
        technology: "Figma"
    },
    {
        id: 6,
        title: "Travel Booking Interface",
        category: "UI/UX",
        description: "A user-friendly interface for searching destinations and managing travel reservations.",
        technology: "Figma, Adobe XD"
    }
];

function initializeApp() {
    initializeMobileMenu();
    initializeContactForm();
    initializeBackToTop();
    initializeActiveNavigation();
    initializeStatisticsCounter();
    renderProjects(projects);
    initializeProjectFilters();
    fetchPosts();
}
// Mobile Navigation
function initializeMobileMenu() {
    const menuToggle = document.querySelector(".menu-toggle")
    const menu = document.querySelector("#menu")
    const menuLinks = document.querySelectorAll("#menu a");
    if (!menuToggle || !menu) {
        return;
    }
    menuToggle.addEventListener("click", () => {
        menu.classList.toggle("active")
        menuToggle.setAttribute(
            "aria-expanded",
            menu.classList.contains("active")
        );
        if (menu.classList.contains("active")) {
            menuToggle.textContent = "✕";
        } else {
            menuToggle.textContent = "☰";
        }
    });
    menuLinks.forEach((link) => {
        link.addEventListener("click", () => {
            menu.classList.remove("active")
            menuToggle.textContent = "☰";
            menuToggle.setAttribute("aria-expanded", "false");
        })
    })

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && menu.classList.contains("active")) {
            menu.classList.remove("active");
            menuToggle.textContent = "☰";
            menuToggle.setAttribute("aria-expanded", "false");
            menuToggle.focus();
        }
    });
}

// Form Validation

function initializeContactForm() {
    const form = document.querySelector("form")

    const name = document.querySelector("#name")
    const email = document.querySelector("#email")
    const phone = document.querySelector("#phone")
    const subject = document.querySelector("#subject")
    const message = document.querySelector("#message")

    const successMessage = document.querySelector("#success-message");
    const messageCounter = document.querySelector("#message-counter");

    if (!form) {
        return;
    }
    if (!name || !email || !phone || !subject || !message || !successMessage || !messageCounter) {
        return;
    }

    function validateName() {
        let isValid = true;
        const value = name.value.trim()
        const errorMessage = document.querySelector("#name-error")
        if (value === "") {
            errorMessage.textContent = "Name is required.";
            errorMessage.style.display = "block";
            name.setAttribute("aria-invalid", "true");
            isValid = false;
        } else if (value.length > 60 || value.length < 2) {
            errorMessage.textContent = "Name must be between 2 and 60 characters.";
            errorMessage.style.display = "block";
            name.setAttribute("aria-invalid", "true");
            isValid = false;
        } else {
            errorMessage.textContent = ""
            errorMessage.style.display = "none";
            name.setAttribute("aria-invalid", "false");

        }
        return isValid
    }
    function validateEmail() {
        let isValid = true;
        const value = email.value.trim()
        const errorMessage = document.querySelector("#email-error")
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value === "") {
            errorMessage.textContent = "Email is required.";
            errorMessage.style.display = "block";
            email.setAttribute("aria-invalid", "true");
            isValid = false;
        } else if (!emailRegex.test(value)) {
            errorMessage.textContent = "Please enter a valid email address.";
            email.setAttribute("aria-invalid", "true");
            errorMessage.style.display = "block";
            isValid = false;
        } else {
            errorMessage.textContent = ""
            errorMessage.style.display = "none";
            email.setAttribute("aria-invalid", "false");
        }
        return isValid
    }
    function validatePhone() {
        let isValid = true;
        const value = phone.value.trim()
        const errorMessage = document.querySelector("#phone-error")
        const phoneRegex = /^\+?[\d\s()-]+$/;

        if (value === "") {
            errorMessage.textContent = "";
            errorMessage.style.display = "none";
            phone.setAttribute("aria-invalid", "false");
            return true;
        }
        if (!phoneRegex.test(value)) {
            errorMessage.textContent = "Please enter a valid phone number.";
            errorMessage.style.display = "block";
            phone.setAttribute("aria-invalid", "true");
            isValid = false;
        }
        const cleanedPhone = value.replace(/\D/g, "");
        if (cleanedPhone.length < 7 || cleanedPhone.length > 15) {
            errorMessage.textContent = "Phone number must contain between 7 and 15 digits.";
            errorMessage.style.display = "block";
            phone.setAttribute("aria-invalid", "true");
            isValid = false;
        }
        if (isValid) {
            errorMessage.textContent = "";
            errorMessage.style.display = "none";
            phone.setAttribute("aria-invalid", "false");
        }
        return isValid
    }
    function validateSubject() {
        let isValid = true;
        const value = subject.value.trim()
        const errorMessage = document.querySelector("#subject-error")

        if (value === "") {
            errorMessage.textContent = "Subject is required.";
            errorMessage.style.display = "block";
            subject.setAttribute("aria-invalid", "true");
            isValid = false;
        } else if (value.length > 100 || value.length < 3) {
            errorMessage.textContent = "Subject must be between 3 and 100 characters.";
            errorMessage.style.display = "block";
            subject.setAttribute("aria-invalid", "true");
            isValid = false;
        } else {
            errorMessage.textContent = ""
            errorMessage.style.display = "none";
            subject.setAttribute("aria-invalid", "false");
        }
        return isValid
    }
    function validateMessage() {
        let isValid = true;
        const value = message.value.trim()
        const errorMessage = document.querySelector("#message-error")
        if (value === "") {
            errorMessage.textContent = "Message is required.";
            errorMessage.style.display = "block";
            message.setAttribute("aria-invalid", "true");
            isValid = false;
        } else if (value.length > 500 || value.length < 10) {
            errorMessage.textContent = "Message must be between 10 and 500 characters.";
            errorMessage.style.display = "block";
            message.setAttribute("aria-invalid", "true");
            isValid = false;
        } else {
            errorMessage.textContent = ""
            errorMessage.style.display = "none";
            message.setAttribute("aria-invalid", "false");
        }
        return isValid
    }
    function updateMessageCounter() {
        const currentLength = message.value.length;
        messageCounter.textContent = `${currentLength} / 500`;
    }
    name.addEventListener("input", validateName)
    email.addEventListener("input", validateEmail)
    phone.addEventListener("input", validatePhone)
    subject.addEventListener("input", validateSubject)
    message.addEventListener("input", validateMessage)
    message.addEventListener("input", updateMessageCounter)

    name.addEventListener("blur", validateName);
    email.addEventListener("blur", validateEmail);
    phone.addEventListener("blur", validatePhone);
    subject.addEventListener("blur", validateSubject);
    message.addEventListener("blur", validateMessage);

    form.addEventListener("submit", function (event) {
        let isValid = true;
        if (!validateName()) {
            name.focus();
            isValid = false;
        }
        if (!validateEmail()) {
            email.focus();
            isValid = false;
        }
        if (!validatePhone()) {
            phone.focus()
            isValid = false;
        }
        if (!validateSubject()) {
            subject.focus();
            isValid = false;
        };
        if (!validateMessage()) {
            message.focus();
            isValid = false;
        };

        event.preventDefault()
        if (!isValid) {
            return;
        }
        successMessage.textContent =
            "Your message has been sent successfully.";
        setTimeout(() => {
            successMessage.style.display = "none";
            successMessage.textContent = "";
        }, 3000);

        successMessage.style.display = "block";

        form.reset();
        name.setAttribute("aria-invalid", "false");
        email.setAttribute("aria-invalid", "false");
        phone.setAttribute("aria-invalid", "false");
        subject.setAttribute("aria-invalid", "false");
        message.setAttribute("aria-invalid", "false");
        updateMessageCounter();
        document.querySelectorAll(".error-message").forEach((error) => {
            error.textContent = "";
            error.style.display = "none";
        });
    })

}
// back to top 
function initializeBackToTop() {
    const backToTopButton = document.querySelector("#back-to-top");
    if (!backToTopButton) {
        return;
    }
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    });

    backToTopButton.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: prefersReducedMotion ? "auto" : "smooth"
        });
    });

}
function initializeActiveNavigation() {
    const sections = document.querySelectorAll("main section");
    const navLinks = document.querySelectorAll("#menu a");

    if (sections.length === 0 || navLinks.length === 0) {
        return;
    }
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {

            if (!entry.isIntersecting) {
                return;
            }

            navLinks.forEach((link) => {
                link.classList.remove("active");
            });

            const activeLink = document.querySelector(
                `#menu a[href="#${entry.target.id}"]`
            );

            if (activeLink) {
                activeLink.classList.add("active");
            }

        });
    }, {
        threshold: 0.2,
        rootMargin: "-80px 0px -50% 0px"
    });

    sections.forEach((section) => {
        observer.observe(section);
    });
}
function initializeStatisticsCounter() {
    const statisticsSection = document.querySelector("#statistics");
    const counters = document.querySelectorAll("#statistics article h3");
    if (!statisticsSection || counters.length === 0) {
        return;
    }
    if (prefersReducedMotion) {
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            counter.textContent = target + "+";
        });
        return;
    }
    function animateCounter(counter) {
        const target = parseInt(counter.textContent);

        let current = 0;

        const increment = Math.ceil(target / 100);

        const timer = setInterval(() => {
            current += increment;

            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            counter.textContent = current + "+";
        }, 20);
    }
    let hasAnimated = false;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {

            if (entry.isIntersecting && !hasAnimated) {

                counters.forEach((counter) => {
                    animateCounter(counter);
                });

                hasAnimated = true;
            }

        });
    }, {
        threshold: 0.5
    });

    observer.observe(statisticsSection);
}
function renderProjects(projects) {
    const projectsResult = document.getElementById("projects-container");
    projectsResult.innerHTML = projects.map(project => `
        <article class="project-card">
            <span class="project-category">${project.category}</span>

            <h3>${project.title}</h3>

            <p>${project.description}</p>

            <p class="project-technology">
                Technology: ${project.technology}
            </p>
        </article>
        `).join("");
}
function initializeProjectFilters() {
    const buttons = document.querySelectorAll(".filter-btn")
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            buttons.forEach(btn => {
                btn.classList.remove("active")
            })
            button.classList.add("active");
            const category = button.dataset.category;
            if (category === "All") {
                return renderProjects(projects);
            } else {
                const filteredArray = projects.filter(e => {
                    return e.category === category;
                })
                return renderProjects(filteredArray)
            }
        })
    })
}
function renderLoading() {
    const posts_container = document.getElementById("posts-container");
    posts_container.innerHTML = `

        <div class="loading-state">

            <div class="spinner"></div>

            <p>

                Loading Posts...

            </p>

        </div>

    `;
}
function renderErrorState() {
    const posts_container = document.getElementById("posts-container");
    posts_container.innerHTML = `
    <div class="error-state">
            <p>Unable to load posts. Please try again.</p>

            <button type="button" class="retry-btn">
                Retry
            </button>
        </div>
    `;
    const retryButton = posts_container.querySelector(".retry-btn");

    retryButton.addEventListener("click", fetchPosts);
}
function renderEmptyState() {
    const posts_container = document.getElementById("posts-container");

    posts_container.innerHTML = `
        <div class="empty-state">
            <p>No posts available.</p>
        </div>
    `;
}
function renderPosts(posts) {
    const postsResult = document.getElementById("posts-container");
    postsResult.innerHTML = posts.map(post => `
        <article class="post-card">
            <h3>${post.title}</h3>

            <p>${post.body}</p>
        </article>
        `).join("");
}
async function fetchPosts() {
    renderLoading();
    try {
        const response = await fetch(POSTS_API_URL)
        if (!response.ok) {
            throw new Error("Failed to fetch data");
        }
        const data = await response.json()
        if (data.length === 0) {
            return renderEmptyState()
        }
        const firstSix = data.slice(0, 6);
        return renderPosts(firstSix);
    } catch (error) {
        console.log(error);
        renderErrorState();
    }
}
