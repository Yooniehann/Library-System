@extends('layouts.master')

@section('title', 'Welcome to Our Library')

@push('styles')
    <!-- Any page-specific styles would go here -->
    <style>
        /* Reset */
    *, *::before, *::after {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background-color: #000000;
      font-family: 'Open Sans', sans-serif;
      color: #EEBA30;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .container {
      max-width: 900px;
      display: flex;
      background-color: #121212;
      border-radius: 16px;
      box-shadow: 0 10px 35px rgba(238, 186, 48, 0.3);
      overflow: hidden;
      width: 100%;
      min-height: 440px;
    }

    /* Animated underline for the title */
    .contact-card h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 2.4rem;
      margin: 0 0 32px 0;
      letter-spacing: 1.2px;
      color: #EEBA30;
      position: relative;
      display: inline-block;
    }
    .contact-card h1::after {
      content: '';
      position: absolute;
      width: 0;
      height: 4px;
      background: #EEBA30;
      left: 0;
      bottom: -10px;
      border-radius: 2px;
      transition: width 0.4s ease;
    }
    .contact-card h1:hover::after,
    .contact-card h1:focus::after {
      width: 100%;
    }

    /* Contact Card (left) */
    .contact-card {
      flex: 1;
      padding: 36px 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 28px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* Label + icon wrapper */
    .label-icon {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      font-family: 'Open Sans', sans-serif;
      color: #EEBA30;
      font-size: 1.1rem;
      user-select: none;
      cursor: default;
    }
    .label-icon svg {
      width: 20px;
      height: 20px;
      fill: #EEBA30;
      flex-shrink: 0;
    }

    /* Input wrapper */
    .input-wrapper {
      position: relative;
      border-bottom: 2px solid #444;
      transition: border-color 0.3s ease;
    }

    .input-wrapper:focus-within {
      border-color: #EEBA30;
      box-shadow: none;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      background: transparent;
      border: none;
      color: #EEBA30;
      font-size: 1.05rem;
      font-family: 'Open Sans', sans-serif;
      padding: 8px 0 6px 0;
      outline: none;
      resize: none;
    }

    input::placeholder,
    textarea::placeholder {
      color: #b9951ccc;
      font-style: italic;
    }

    /* Animated underline */
    .input-wrapper::after {
      content: "";
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0%;
      height: 3px;
      background-color: #EEBA30;
      border-radius: 2px;
      transition: width 0.35s ease;
    }

    .input-wrapper:focus-within::after {
      width: 100%;
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
      border: none;
      cursor: pointer;
      font-size: 1.15rem;
      letter-spacing: 1.1px;
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      box-shadow: none;
      width: 100%;
    }

    .btn-send:hover,
    .btn-send:focus {
      background-color: #D3A625;
      transform: scale(1.05);
      box-shadow: 0 0 18px #D3A625cc;
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
      top: 0; left: 0; right:0; bottom:0;
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
    <div class="container" role="main" aria-labelledby="contact-title">
    <section class="contact-card">
      <h1 id="contact-title" tabindex="0">Contact Us</h1>
      <form method="GET" action="mailto:your-email@example.com" enctype="text/plain" onsubmit="return prepareEmail(event)">
        <label for="name" class="label-icon">
          <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
          Name
        </label>
        <div class="input-wrapper">
          <input type="text" id="name" name="name" required placeholder="Your Name" />
        </div>

        <label for="email" class="label-icon">
          <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
          </svg>
          Email
        </label>
        <div class="input-wrapper">
          <input type="email" id="email" name="email" required placeholder="Your Email" />
        </div>

        <label for="message" class="label-icon">
          <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v16l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
          </svg>
          Message
        </label>
        <div class="input-wrapper">
          <textarea id="message" name="message" required placeholder="Your Message"></textarea>
        </div>

        <button type="submit" class="btn-send">Send</button>
      </form>
    </section>

    <aside class="image-wrapper" aria-hidden="true">
      <img src="{{ asset('images/books.png')}}" alt="Library Contact Image" />
    </aside>
  </div>

  <!-- Custom modal -->
  <div id="login-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-content">
      <p id="modal-title">Please log in before sending a message.</p>
      <button onclick="closeModal()">Okay</button>
    </div>
  </div>

@endsection

@push('scripts')
    <!-- Any page-specific scripts would go here -->
    <script>
// Simulate login status — set to false for guest, true for logged-in user
    const isLoggedIn = false; // CHANGE THIS BASED ON YOUR LOGIN LOGIC

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
