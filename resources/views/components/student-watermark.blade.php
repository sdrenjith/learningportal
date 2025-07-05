<!-- Security Watermark Component - Marquee Style for Continuous Visibility -->
<div class="watermark-wrapper">
    <div id="watermark-container" class="fixed inset-0 pointer-events-none z-[9999] overflow-hidden">
        <!-- Multiple Marquee Lines for Full Coverage -->
        <div class="watermark-marquee-line" style="top: 15%; transform: rotate(-45deg);">
            <div class="marquee-content">
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
            </div>
        </div>
        
        <div class="watermark-marquee-line" style="top: 35%; transform: rotate(-45deg);">
            <div class="marquee-content" style="animation-delay: -2s;">
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
            </div>
        </div>
        
        <div class="watermark-marquee-line" style="top: 55%; transform: rotate(-45deg);">
            <div class="marquee-content" style="animation-delay: -4s;">
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
            </div>
        </div>
        
        <div class="watermark-marquee-line" style="top: 75%; transform: rotate(-45deg);">
            <div class="marquee-content" style="animation-delay: -6s;">
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
                <span class="watermark-text">{{ $username ?? auth()->user()->name ?? 'Student' }}</span>
            </div>
        </div>
    </div>

    <style>
        .watermark-wrapper {
            position: relative;
            z-index: 0;
        }
        
        #watermark-container {
            /* Ensure watermark is always on top but doesn't interfere with interactions */
            pointer-events: none;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        
        .watermark-marquee-line {
            position: absolute;
            width: 200%;
            height: 60px;
            left: -50%;
            pointer-events: none;
            user-select: none;
            overflow: hidden;
            white-space: nowrap;
        }
        
        .marquee-content {
            display: inline-block;
            animation: marqueeScroll 10s linear infinite;
            white-space: nowrap;
        }
        
        .watermark-text {
            display: inline-block;
            font-size: clamp(1.8rem, 3.5vw, 3.5rem);
            font-weight: 700;
            color: #9CA3AF;
            opacity: 0.12;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            margin-right: 150px;
            pointer-events: none;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        
        @keyframes marqueeScroll {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-20%);
            }
        }
        
        /* Responsive text sizing */
        @media (max-width: 768px) {
            .watermark-text {
                font-size: clamp(1.2rem, 2.5vw, 2rem);
                margin-right: 100px;
            }
        }
        
        /* Ensure watermark works on different backgrounds */
        @media (prefers-color-scheme: dark) {
            .watermark-text {
                color: #6B7280;
            }
        }
    </style>

    <script>
        // Anti-tampering protection for marquee watermark
        document.addEventListener('DOMContentLoaded', function() {
            const watermarkContainer = document.getElementById('watermark-container');
            
            if (watermarkContainer) {
                // Prevent watermark from being removed via console
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList') {
                            mutation.removedNodes.forEach(function(node) {
                                if (node.id === 'watermark-container') {
                                    document.body.appendChild(node);
                                }
                            });
                        }
                    });
                });
                
                observer.observe(document.body, { childList: true, subtree: true });
            }
        });
    </script>
</div> 