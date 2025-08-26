@extends('layouts.master')

@section('title', 'Library Contact')

@push('styles')
<style>
    *, *::before, *::after { box-sizing: border-box; }

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
    .contact-card h1:hover::after { width: 100%; }

    .label-icon { display: flex; align-items: center; gap: 8px; font-weight: 600; color: #EEBA30; font-size: 1rem; }
    .label-icon svg { width: 18px; height: 18px; fill: #EEBA30; }

    .input-wrapper { position: relative; border-bottom: 2px solid #333; }
    .input-wrapper:focus-within { border-color: #EEBA30; }
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
    input::placeholder, textarea::placeholder { color: #b9951ccc; font-style: italic; }
    textarea { min-height: 100px; font-size: 1rem; line-height: 1.4; }

    .btn-send {
        background-color: #c79e25;
        color: #000;
        font-weight: 700;
        padding: 14px 0;
        border-radius: 10px;
        border: 2px solid #a07d1b;
        cursor: pointer;
        font-size: 1.15rem;
        letter-spacing: 1.1px;
        width: 100%;
        margin-top: 24px;
        outline: none;
        transition: background-color 0.3s ease;
    }
    .btn-send:hover { background-color: #a07d1b; }

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

    @media (max-width: 900px) {
        .container { flex-direction: column; border-radius: 16px; }
        .image-wrapper {
            border-radius: 0 0 16px 16px;
            border-left: none;
            border-top: 5px solid #EEBA30;
            min-height: 240px;
            width: 100%;
        }
        .image-wrapper img { border-radius: 0 0 16px 16px; }
    }

    .custom-box {
        display: none;
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background: #1c1c1c;
        padding: 25px 30px;
        border-radius: 12px;
        color: #EEBA30;
        font-family: 'Playfair Display', serif;
        text-align: center;
        box-shadow: 0 0 15px rgba(238, 186, 48, 0.3);
        z-index: 10000;
        min-width: 280px;
    }
    .overlay {
        display: none;
        position: fixed;
        top:0; left:0; width:100%; height:100%;
        background: rgba(0,0,0,0.6);
        z-index: 9000;
    }
    .custom-box button {
        margin-top: 15px;
        background: #EEBA30;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 700;
        color: #000;
        cursor: pointer;
        font-size: 1rem;
        outline: none;
        transition: background-color 0.3s ease;
    }
    .custom-box button:hover { background: #b9951c; }

    .field-error {
        color: #ff5555;
        font-size: 0.85rem;
        margin-top: 4px;
        font-family: 'Open Sans', sans-serif;
    }
</style>
@endpush

@section('content')
<div class="container">
    <section class="contact-card">
        <h1>Contact Us</h1>
        <form id="contactForm">
            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                1.79-4 4 1.79 4 4 4zm0 2c-2.67
                0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                Name
            </label>
            <div class="input-wrapper">
                <input type="text" id="name" placeholder="Your Name" required>
            </div>

            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1
                0-2 .9-2 2v12c0 1.1.9 2
                2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0
                4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                Email
            </label>
            <div class="input-wrapper">
                <input type="email" id="email" placeholder="Your Email" required
                       value="{{ auth()->check() ? auth()->user()->email : '' }}">
            </div>

            <label class="label-icon">
                <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1
                0-2 .9-2 2v16l4-4h14c1.1
                0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                Message
            </label>
            <div class="input-wrapper">
                <textarea id="message" placeholder="Your Message" required></textarea>
            </div>

            <button type="button" class="btn-send" onclick="sendMessage()">Send</button>
        </form>
    </section>

    <aside class="image-wrapper">
        <img src="{{ asset('images/books.png') }}" alt="Library Contact">
    </aside>
</div>

<div class="overlay" id="overlay"></div>

<div class="custom-box" id="successBox">
    <p>Your message has been sent successfully! Thank you for reaching out to us. We'll get back to you shortly.</p>
    <button onclick="closeBox('successBox')">OK</button>
</div>

<div class="custom-box" id="loginBox">
    <p>Please sign in or sign up before sending a message!</p>
    <button onclick="redirectToSignIn()">Sign In</button>
    <button onclick="closeBox('loginBox')">Close</button>
</div>
@endsection

@push('scripts')
<script>
    const isUserLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    const myEmail = 'yonakou2002@gmail.com'; // <-- REPLACE THIS WITH YOUR EMAIL

    function sendMessage() {
        const fields = [
            { el: document.getElementById('name'), name: 'Name' },
            { el: document.getElementById('email'), name: 'Email' },
            { el: document.getElementById('message'), name: 'Message' }
        ];

        // Check empty fields
        for (let field of fields) {
            removeFieldError(field.el);
            if (!field.el.value.trim()) {
                showFieldError(field.el, `Please fill your ${field.name}`);
                field.el.focus();
                return;
            }
        }

        if (!isUserLoggedIn) {
            showBox('loginBox');
            return;
        }

        // Send email via mailto
        const subject = encodeURIComponent(`Contact from ${fields[0].el.value}`);
        const body = encodeURIComponent(`Name: ${fields[0].el.value}\nEmail: ${fields[1].el.value}\n\nMessage:\n${fields[2].el.value}`);
        window.location.href = `mailto:${myEmail}?subject=${subject}&body=${body}`;

        showBox('successBox');
        document.getElementById('contactForm').reset();
    }

    function showFieldError(field, message) {
        const error = document.createElement('div');
        error.className = 'field-error';
        error.innerText = message;
        field.parentNode.appendChild(error);
    }

    function removeFieldError(field) {
        const existing = field.parentNode.querySelector('.field-error');
        if (existing) existing.remove();
    }

    function showBox(boxId) {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById(boxId).style.display = 'block';
    }

    function closeBox(boxId) {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById(boxId).style.display = 'none';
    }

    function redirectToSignIn() {
        window.location.href = '/login'; // replace with your login page route
    }
</script>
@endpush
