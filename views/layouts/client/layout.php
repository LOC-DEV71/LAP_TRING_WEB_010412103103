<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $title ?? 'VOGUE | Aurelian Luxe' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <!-- Tailwind Configuration -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-tint": "#5e5e5e",
                    "outline-variant": "#cfc4c5",
                    "surface-container-low": "#f6f3f2",
                    "tertiary-fixed": "#fbdfaf",
                    "on-secondary-container": "#5f6161",
                    "on-background": "#1c1b1b",
                    "secondary-fixed-dim": "#c6c6c6",
                    "secondary-container": "#dcdddd",
                    "primary": "#000000",
                    "surface-container-high": "#eae7e7",
                    "inverse-on-surface": "#f3f0ef",
                    "background": "#fcf9f8",
                    "on-surface": "#1c1b1b",
                    "inverse-primary": "#c6c6c6",
                    "on-tertiary-container": "#978158",
                    "surface-container-lowest": "#ffffff",
                    "on-error": "#ffffff",
                    "surface-dim": "#dcd9d9",
                    "primary-fixed-dim": "#c6c6c6",
                    "on-tertiary-fixed-variant": "#564421",
                    "on-primary-fixed": "#1b1b1b",
                    "on-tertiary-fixed": "#261900",
                    "surface-container": "#f0eded",
                    "outline": "#7e7576",
                    "secondary": "#5d5f5f",
                    "tertiary-container": "#261900",
                    "on-primary": "#ffffff",
                    "on-secondary": "#ffffff",
                    "error-container": "#ffdad6",
                    "on-surface-variant": "#4c4546",
                    "on-error-container": "#93000a",
                    "tertiary": "#000000",
                    "surface-container-highest": "#e5e2e1",
                    "surface": "#fcf9f8",
                    "surface-bright": "#fcf9f8",
                    "on-primary-container": "#848484",
                    "error": "#ba1a1a",
                    "on-secondary-fixed": "#1a1c1c",
                    "surface-variant": "#e5e2e1",
                    "primary-container": "#1b1b1b",
                    "on-secondary-fixed-variant": "#454747",
                    "tertiary-fixed-dim": "#dec395",
                    "primary-fixed": "#e2e2e2",
                    "on-primary-fixed-variant": "#474747",
                    "inverse-surface": "#313030",
                    "on-tertiary": "#ffffff",
                    "secondary-fixed": "#e2e2e2"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-xl": "64px",
                    "gutter": "24px",
                    "stack-sm": "8px",
                    "margin-desktop": "64px",
                    "margin-mobile": "20px",
                    "container-max": "1440px",
                    "stack-md": "16px",
                    "stack-lg": "32px"
            },
            "fontFamily": {
                    "body-lg": ["Inter"],
                    "label-sm": ["Inter"],
                    "label-md": ["Inter"],
                    "headline-lg": ["Playfair Display"],
                    "display-lg-mobile": ["Playfair Display"],
                    "body-md": ["Inter"],
                    "headline-md": ["Playfair Display"],
                    "display-lg": ["Playfair Display"]
            },
            "fontSize": {
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                    "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.1em", "fontWeight": "600"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "500"}],
                    "display-lg-mobile": ["40px", {"lineHeight": "48px", "fontWeight": "600"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "500"}],
                    "display-lg": ["64px", {"lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .whisper-shadow {
            box-shadow: 0px 4px 20px rgba(0,0,0,0.04);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md overflow-x-hidden">
    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 shadow-sm h-20">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto h-full">
            <div class="flex items-center gap-stack-lg">
                <a class="cursor-pointer transition-transform duration-200 active:scale-95" href="/">
                    <img alt="Aurelian Luxe Logo" class="h-8 w-auto" src="data:image/png;base64,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="/>
                </a>
                <div class="hidden md:flex items-center gap-gutter">
                    <a class="font-body-md text-body-md text-primary font-semibold border-b border-primary pb-1 transition-colors" href="#">New Arrivals</a>
                    <a class="font-body-md text-body-md text-secondary hover:text-primary transition-colors" href="#">Collections</a>
                    <a class="font-body-md text-body-md text-secondary hover:text-primary transition-colors" href="#">Men</a>
                    <a class="font-body-md text-body-md text-secondary hover:text-primary transition-colors" href="#">Women</a>
                </div>
            </div>
            <div class="flex items-center gap-stack-md">
                <div class="hidden lg:flex items-center bg-surface-container-low px-4 py-2 rounded-md border border-outline-variant/20">
                    <span class="material-symbols-outlined text-secondary mr-2">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-label-md w-32 xl:w-48 placeholder-secondary" placeholder="Search" type="text"/>
                </div>
                <div class="flex items-center gap-4">
                    <button class="cursor-pointer transition-transform duration-200 active:scale-95 hover:opacity-70">
                        <span class="material-symbols-outlined text-primary">person</span>
                    </button>
                    <button class="cursor-pointer transition-transform duration-200 active:scale-95 hover:opacity-70 relative">
                        <span class="material-symbols-outlined text-primary">shopping_bag</span>
                        <span class="absolute -top-1 -right-1 bg-primary text-on-primary text-[10px] w-4 h-4 flex items-center justify-center rounded-full">2</span>
                    </button>
                    <button class="md:hidden cursor-pointer transition-transform duration-200 active:scale-95">
                        <span class="material-symbols-outlined text-primary">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="pt-20">
        <!-- Vùng render View con động -->
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-lowest py-stack-xl border-t border-outline-variant/30">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
            <!-- Brand & Info -->
            <div class="col-span-1 md:col-span-1">
                <img alt="Aurelian Luxe Logo" class="h-6 w-auto mb-stack-md" src="data:image/png;base64,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="/>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xs">
                    Redefining contemporary luxury through artisanal craftsmanship and timeless design.
                </p>
            </div>
            <!-- Customer Service -->
            <div>
                <h5 class="font-label-md text-label-md text-primary mb-stack-md">CUSTOMER SERVICE</h5>
                <ul class="space-y-3">
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Shipping &amp; Returns</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Store Locator</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Size Guide</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Contact Us</a></li>
                </ul>
            </div>
            <!-- Company -->
            <div>
                <h5 class="font-label-md text-label-md text-primary mb-stack-md">ABOUT</h5>
                <ul class="space-y-3">
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Our Story</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Sustainability</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Journal</a></li>
                    <li><a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <!-- Socials -->
            <div>
                <h5 class="font-label-md text-label-md text-primary mb-stack-md">FOLLOW US</h5>
                <div class="flex gap-4">
                    <a class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-full hover:bg-primary hover:text-white transition-all" href="#">
                        <i class="material-symbols-outlined !text-[18px]">public</i>
                    </a>
                    <a class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-full hover:bg-primary hover:text-white transition-all" href="#">
                        <i class="material-symbols-outlined !text-[18px]">share</i>
                    </a>
                    <a class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-full hover:bg-primary hover:text-white transition-all" href="#">
                        <i class="material-symbols-outlined !text-[18px]">camera</i>
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-stack-xl pt-stack-md border-t border-outline-variant/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="font-label-sm text-label-sm text-secondary">© 2024 VOGUE. All rights reserved.</p>
            <div class="flex gap-stack-md">
                <span class="material-symbols-outlined text-secondary hover:text-primary cursor-pointer">payments</span>
                <span class="material-symbols-outlined text-secondary hover:text-primary cursor-pointer">credit_card</span>
            </div>
        </div>
    </footer>

    <script>
        // Simple Carousel Logic
        const carousel = document.getElementById('carousel');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        if (carousel && nextBtn && prevBtn) {
            nextBtn.addEventListener('click', () => {
                carousel.scrollBy({ left: 350, behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', () => {
                carousel.scrollBy({ left: -350, behavior: 'smooth' });
            });
        }

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (nav) {
                if (window.scrollY > 50) {
                    nav.classList.add('shadow-md');
                    nav.classList.remove('shadow-sm');
                } else {
                    nav.classList.remove('shadow-md');
                    nav.classList.add('shadow-sm');
                }
            }
        });
    </script>
</body>
</html>
