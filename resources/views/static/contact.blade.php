@extends('layouts.master')

@section('title', 'Welcome to Our Contact')

@push('styles')
<style>
    *, *::before, *::after {
    box-sizing: border-box;
}

body {
    margin: 0;
    background-color: #000;
    font-family: 'Open Sans', sans-serif;
    color: #EEBA30;
    padding: 40px 20px;
    min-height: 100vh;
}

.container {
    max-width: 850px;
    display: flex;
    background-color: #121212;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(238, 186, 48, 0.25);
    overflow: hidden;
    width: 100%;
    min-height: 400px;
    margin: auto;
}

.contact-card {
    flex: 1;
    padding: 32px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 24px;
}

.contact-card h1 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 2rem;
    margin: 0 0 24px 0;
    color: #EEBA30;
    position: relative;
    display: inline-block;
}
.contact-card h1::after {
    content: '';
    position: absolute;
    width: 0;
    height: 3px;
    background: #EEBA30;
    left: 0;
    bottom: -8px;
    border-radius: 2px;
    transition: width 0.4s ease;
}
.contact-card h1:hover::after {
    width: 100%;
}

.label-icon {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #EEBA30;
    font-size: 1rem;
}
.label-icon svg {
    width: 18px;
    height: 18px;
    fill: #EEBA30;
}

.input-wrapper {
    position: relative;
    border-bottom: 2px solid #333;
}
.input-wrapper:focus-within {
    border-color: #EEBA30;
}
.input-wrapper input,
.input-wrapper textarea {
    width: 100%;
    background: transparent;
    border: none;
    color: #EEBA30;
    font-size: 1rem;
    padding: 8px 0;
    outline: none;
}
.input-wrapper::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0%;
    height: 2px;
    background-color: #EEBA30;
    transition: width 0.35s ease;
}
.input-wrapper:focus-within::after {
    width: 100%;
}
input::placeholder,
textarea::placeholder {
    color: #b9951ccc;
    font-style: italic;
}
textarea {
    min-height: 100px;
    font-size: 1rem;
    line-height: 1.4;
}

/* Button */
.btn-send {
    background-color: #c79e25;
    color: #000000;
    font-weight: 700;
    padding: 14px 0;
    border-radius: 10px;
    border: 2px solid #a07d1b;
    cursor: pointer;
    font-size: 1.15rem;
    letter-spacing: 1.1px;
    box-shadow: 0 4px 6px rgba(199, 158, 37, 0.5);
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    width: 100%;
    margin-top: 24px; /* Space added here */
}

.btn-send:hover,
.btn-send:focus {
    background-color: #D3A625;
    border-color: #c79e25;
    transform: scale(1.05);
    box-shadow: 0 6px 12px #D3A625cc;
    outline: none;
}

/* Right side image */
.image-wrapper {
    flex: 1;
    border-left: 5px solid #EEBA30;
    border-radius: 0 16px 16px 0;
    box-shadow: inset 0 0 50px 6px rgba(238, 186, 48, 0.15);
    min-height: 440px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}
.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0 16px 16px 0;
    user-select: none;
    pointer-events: none;
}

/* Responsive */
@media (max-width: 900px) {
    .container {
        flex-direction: column;
        border-radius: 16px;
    }
    .image-wrapper {
        border-radius: 0 0 16px 16px;
        border-left: none;
        border-top: 5px solid #EEBA30;
        min-height: 240px;
        width: 100%;
    }
    .image-wrapper img {
        border-radius: 0 0 16px 16px;
    }
}

/* Custom modal styles */
#login-modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
#login-modal.active {
    display: flex;
}
#login-modal .modal-content {
    background: #121212;
    border-radius: 14px;
    padding: 30px 40px;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 0 30px #EEBA30aa;
    color: #EEBA30;
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    user-select: none;
    line-height: 1.5;
}
#login-modal button {
    margin-top: 20px;
    background-color: #c79e25;
    border: none;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 700;
    color: #000;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: none;
}
#login-modal button:hover,
#login-modal button:focus {
    background-color: #D3A625;
    transform: scale(1.05);
    box-shadow: 0 0 18px #D3A625cc;
    outline: none;
}

</style>
@endpush

@section('content')
<div class="container">
    <section class="contact-card">
        <h1>Contact Us</h1>
        <form method="GET" action="mailto:your-email@example.com" enctype="text/plain" onsubmit="return prepareEmail(event)">
            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                1.79-4 4 1.79 4 4 4zm0 2c-2.67
                0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                Name
            </label>
            <div class="input-wrapper">
                <input type="text" name="name" placeholder="Your Name" required>
            </div>

            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1
                0-2 .9-2 2v12c0 1.1.9 2
                2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0
                4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                Email
            </label>
            <div class="input-wrapper">
                <input type="email" name="email" placeholder="Your Email" required>
            </div>

            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1
                0-2 .9-2 2v16l4-4h14c1.1
                0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                Message
            </label>
            <div class="input-wrapper">
                <textarea name="message" placeholder="Your Message" required></textarea>
            </div>

            <button type="submit" class="btn-send">Send</button>
        </form>
    </section>

    <aside class="image-wrapper">
        <img src="{{ asset('images/books.png') }}" alt="Library Contact">
    </aside>
</div>

<div id="login-modal">
    <div class="modal-content">
        <p>Please log in before sending a message.</p>
        <button onclick="closeModal()">Okay</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
const isLoggedIn = false;

function prepareEmail(event) {
    if (!isLoggedIn) {
        event.preventDefault();
        openModal();
        return false;
    }
    const form = event.target;
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();
    if (!name || !email || !message) {
        alert('Please fill in all fields.');
        return false;
    }
    const subject = encodeURIComponent(`Contact from ${name}`);
    const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`);
    form.action = `mailto:your-email@example.com?subject=${subject}&body=${body}`;
    return true;
}
function openModal() {
    document.getElementById('login-modal').classList.add('active');
}
function closeModal() {
    document.getElementById('login-modal').classList.remove('active');
}
</script>
@endpush
