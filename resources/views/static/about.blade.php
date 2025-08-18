@extends('layouts.master')

@section('title', 'About Our Library')

@push('styles')
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
    width: 460px;
    height: 350px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow:
      8px 8px 15px rgba(0, 0, 0, 0.6),
      4px 4px 10px rgba(0, 0, 0, 0.4),
      inset 0 0 8px rgba(255, 255, 255, 0.1);
    display: block;
    margin-left: auto;
    margin-right: auto;
    transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.5s ease;
    transform-style: preserve-3d;
}

.image-wrapper img:hover {
    transform: perspective(700px) rotateX(5deg) rotateY(5deg) scale(1.05);
    box-shadow:
      15px 15px 25px rgba(0, 0, 0, 0.85),
      8px 8px 15px rgba(0, 0, 0, 0.6);
    cursor: pointer;
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
        cursor: pointer;
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

        .image-wrapper img {
            width: 100%;
            height: auto;
            max-height: 250px;
        }
    }

    /* Librarians grid fixed spacing */
    .librarians-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin: 20px auto 0;
        max-width: 1100px;
        padding: 0 15px;
    }

    /* Card style */
    .librarian-card {
        background-color: #1a1a1a;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(238, 186, 48, 0.3);
        padding: 15px;
        text-align: center;
        color: #EEBA30;
        font-family: 'Open Sans', sans-serif;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Hover effect */
    .librarian-card:hover,
    .librarian-card:focus {
        transform: scale(1.05);
        box-shadow: 0 0 15px 3px #EEBA30cc;
        outline: none;
    }

    /* Uniform image size for all cards */
    .librarian-card img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 10px;
        user-select: none;
        pointer-events: none;
    }

    /* Name styling (aligned across all cards) */
    .librarian-card h3 {
        margin: 8px 0 6px;
        font-size: 1.1rem;
        font-weight: 700;
        min-height: 28px;
    }

    /* Description text styling */
    .librarian-card p {
        font-size: 0.9rem;
        line-height: 1.3;
        color: #d4b545cc;
        margin: 0;
        min-height: 38px;
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
            <img src="{{ asset('images/library.jpg') }}" alt="Library Building" />
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
            <img src="{{ asset('images/read.png') }}" alt="Reading Area" />
        </div>
        <div class="section-text">
            <h2 class="title-half"><span>What</span> <span class="white">We Offer</span></h2>
            <p>
               You can easily browse and reserve physical books through our online system — then simply visit us to pick them up. Our collection has everything from popular novels to helpful academic books.
            </p>
            <p>
             Our library is a welcoming space where you can explore and enjoy a wide variety of books at your own pace. We’re here to help you discover something new and support your reading journey.
            </p>

            <!-- Join Now button -->
            <a href="{{ url('/join') }}" class="btn" style="margin-top: 20px;">Join Now</a>
        </div>
    </div>

    <!-- Section 3 -->
    <div class="section">
        <div class="image-wrapper">
            <img src="{{ asset('images/browse.png') }}" alt="Digital Library" />
        </div>
        <div class="section-text">
            <h2 class="title-half"><span>Easy</span> <span class="white">Borrowing</span></h2>
            <p>
              You can easily reserve physical books online and pick them up at the library. Just register, choose your books, and come by when they’re ready.
            </p>
            <p>
                We also make renewing your loans simple, so you can keep enjoying your favorite reads without any hassle.
            </p>
        </div>
    </div>

    <!-- Section 4 -->
    <div class="section reverse">
        <div class="image-wrapper">
            <img src="{{ asset('images/carry.png') }}" alt="Community Events" />
        </div>
        <div class="section-text">
            <h2 class="title-half"><span>Our</span> <span class="white">Vision</span></h2>
            <p>
                We’re more than just a library — we’re a welcoming place where people come together to learn and grow.
            </p>
            <p>
                By staying true to our roots while embracing new ideas, we’re here to support our community and help everyone enjoy reading.
            </p>
        </div>
    </div>
</div>

<!-- Our Librarians Section -->
<div class="section reverse">
    <div class="container">
        <div class="section-text">
            <h2 class="title-half"><span>Our</span> <span class="white">Librarians</span></h2>
            <p>Meet the friendly faces who are here to help you discover the joy of reading and find the perfect book.</p>
            <div class="librarians-grid">
                <!-- Librarian Cards -->
                <div class="librarian-card">
                    <img src="{{ asset('images/anne.png') }}" alt="Librarian 1" />
                    <h3>Anne Hathaway</h3>
                    <p>Head Librarian with 15 years of experience in helping readers find what they need.</p>
                </div>
                <div class="librarian-card">
                    <img src="{{ asset('images/two.png') }}" alt="Librarian 2" />
                    <h3>Carlos Smith</h3>
                    <p>Specialist in rare books and archival materials.</p>
                </div>
                <div class="librarian-card">
                    <img src="{{ asset('images/one.png') }}" alt="Librarian 3" />
                    <h3>Maria Violet</h3>
                    <p>Passionate about children's literature and community outreach.</p>
                </div>
                <div class="librarian-card">
                    <img src="{{ asset('images/sammy.png') }}" alt="Librarian 4" />
                    <h3>Sam Winchester</h3>
                    <p>Expert in cataloging and book management systems.</p>
                </div>
                <div class="librarian-card">
                    <img src="{{ asset('images/asian.png') }}" alt="Librarian 5" />
                    <h3>Linda Lee</h3>
                    <p>Dedicated to helping readers with personalized recommendations.</p>
                </div>
                <div class="librarian-card">
                        <img src="{{ asset('images/jensen.png') }}" alt="Librarian 5" />
                        <h3>Dean Winchester</h3>
                        <p>Dedicated to helping readers with personalized recommendations.</p>
                    </div>
            </div>


                <!-- Back to Home Button -->
                <div style="margin-top: 30px; text-align: left;">
                    <a href="{{ url('/') }}" class="btn">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
