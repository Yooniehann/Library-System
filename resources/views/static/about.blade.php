@extends('layouts.master')

@section('title', 'About Our Library')

@push('styles')
    <!-- Any page-specific styles would go here -->
    <style>
        body {
            background-color: #000000;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #EEBA30;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 1px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Half-colored title effect */
        .title-half span.white {
            color: #ffffff;
        }

        p {
            line-height: 1.8;
            font-size: 17px;
            margin-bottom: 15px;
            font-family: 'Open Sans', sans-serif;
        }

        .section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 70px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .section.show {
            opacity: 1;
            transform: translateY(0);
        }

        .image-wrapper {
            position: relative;
            flex: 1;
        }

        .image-wrapper img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
        }

        .section-text {
            flex: 1;
        }

        .btn {
            display: inline-block;
            background-color: #EEBA30;
            color: #000000;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #D3A625;
            transform: scale(1.05);
        }

        /* Reverse layout for alternating sections */
        .reverse {
            flex-direction: row-reverse;
        }

        @media (max-width: 768px) {
            .section {
                flex-direction: column;
            }
            .reverse {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1><span style="color:#EEBA30;">About</span> <span style="color:white;">Our Library</span></h1>
        <p style="text-align:center; max-width: 800px; margin: 0 auto 50px;">
            Welcome to our Library System — your trusted gateway to a world of knowledge and imagination.
            From timeless classics to the latest academic resources, our library offers an extensive
            collection to fuel your curiosity and support your learning journey.
        </p>

        <!-- Section 1 -->
        <div class="section">
            <div class="image-wrapper">
                <img src="{{ asset('images/library.jpg')  }}" alt="Library Building" />
            </div>
            <div class="section-text">
                <h2 class="title-half"><span>Our</span> <span class="white">Story</span></h2>
                <p>
                    Established with the vision of connecting people to knowledge, our library has been
                    serving the community for decades. What started as a small collection of books
                    has grown into a modern library system with thousands of physical and digital resources.
                </p>
                <p>
                    We believe in making information accessible to all, regardless of location or background.
                </p>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="section reverse">
            <div class="image-wrapper">
                <img src="{{ asset('images/library.jpg')  }}" alt="Reading Area" />
            </div>
            <div class="section-text">
                <h2 class="title-half"><span>What</span> <span class="white">We Offer</span></h2>
                <p>
                    Our system allows you to easily search, borrow, and manage your books online.
                    From academic references to your favorite novels, our catalog is designed
                    to meet diverse needs.
                </p>
                <p>
                    We also host community events, reading clubs, and workshops to bring
                    readers together and promote a love for learning.
                </p>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="section">
            <div class="image-wrapper">
                <img src="{{ asset('images/library.jpg')  }}" alt="Digital Library" />
            </div>
            <div class="section-text">
                <h2 class="title-half"><span>Digital</span> <span class="white">Access</span></h2>
                <p>
                    We understand the importance of convenience in today’s world.
                    Our digital library lets you explore e-books, audiobooks, and research papers
                    from the comfort of your home.
                </p>
                <p>
                    With just a few clicks, you can borrow materials, renew loans, and
                    reserve upcoming titles.
                </p>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="section reverse">
            <div class="image-wrapper">
                <img src="{{ asset('images/library.jpg')  }}" alt="Community Events" />
            </div>
            <div class="section-text">
                <h2 class="title-half"><span>Our</span> <span class="white">Vision</span></h2>
                <p>
                    We aim to be more than just a place to borrow books —
                    we want to be a hub for education, culture, and community.
                </p>
                <p>
                    By blending tradition with innovation, we continue to grow and adapt
                    to meet the changing needs of our readers.
                </p>
                <a href="{{ url('/') }}" class="btn">Back to Home</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Any page-specific scripts would go here -->
    <script>
        // Simple scroll animation
        const sections = document.querySelectorAll('.section');
        const revealOnScroll = () => {
            sections.forEach(sec => {
                const secTop = sec.getBoundingClientRect().top;
                if (secTop < window.innerHeight - 100) {
                    sec.classList.add('show');
                }
            });
        };
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();

    </script>
@endpush
