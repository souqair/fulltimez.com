

<style>
footer {
    background-color: #1a1a1a;
    padding: 60px 5%;
    font-family: sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
}

.footer-column h4 {
    font-size: 16px;
    margin-bottom: 20px;
    color: #ffffff;
    font-weight: 700;
    font-family: sans-serif;
}

.footer-brand h4 {
    font-size: 24px;
    margin-bottom: 16px;
    color: #ffffff;
    font-weight: 700;
}

.footer-brand p {
    font-size: 14px;
    color: #d1d5db;
    line-height: 1.6;
    margin: 0 0 24px 0;
}

.social-icons {
    display: flex;
    gap: 16px;
    margin-top: 20px;
}

.social-icons a {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-decoration: none;
    transition: opacity 0.2s;
}

.social-icons a:hover {
    opacity: 0.7;
}

.social-icons svg {
    width: 20px;
    height: 20px;
}

.footer-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-column ul li {
    margin-bottom: 12px;
}

.footer-column ul li a {
    display: block;
    text-decoration: none;
    font-size: 14px;
    color: #d1d5db;
    transition: color 0.2s;
}

.footer-column ul li a:hover {
    color: #ffffff;
}

.subscribe-form {
    display: flex;
    gap: 8px;
    margin-top: 16px;
}

.subscribe-form input[type="email"] {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #374151;
    border-radius: 8px;
    font-size: 14px;
    font-family: sans-serif;
    background: #2d2d2d;
    color: #ffffff;
    outline: none;
    transition: border-color 0.2s;
}

.subscribe-form input[type="email"]:focus {
    border-color: #6b7280;
}

.subscribe-form input[type="email"]::placeholder {
    color: #9ca3af;
}

.subscribe-form button {
    padding: 10px 20px;
    background: #4b5563;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    font-family: sans-serif;
    transition: background 0.2s;
    white-space: nowrap;
}

.subscribe-form button:hover {
    background: #6b7280;
}

.footer-column p.subscribe-desc {
    font-size: 14px;
    color: #d1d5db;
    line-height: 1.6;
    margin: 0 0 0 0;
}

.footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 5%;
    border-top: 1px solid #374151;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #9ca3af;
    font-family: sans-serif;
}

.footer-bottom-links {
    display: flex;
    gap: 24px;
}

.footer-bottom-links a {
    color: #d1d5db;
    text-decoration: none;
    transition: color 0.2s;
}

.footer-bottom-links a:hover {
    color: #ffffff;
}

@media (max-width: 991px) {
    .footer-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }
    
    .footer-bottom {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
}

@media (max-width: 576px) {
    footer {
        padding: 40px 5%;
    }
    
    .footer-container {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    
    .subscribe-form {
        flex-direction: column;
    }
    
    .subscribe-form button {
        width: 100%;
    }
    
    .footer-bottom-links {
        flex-direction: column;
        gap: 12px;
    }
}
</style>

<footer>
  <div class="footer-container">
    <div class="footer-column footer-brand">
      <h4>FullTimez</h4>
      <p>Empowering careers and connecting talent with opportunity across the globe.</p>
      <div class="social-icons">
        <a href="#" aria-label="Facebook">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1h3z"/>
          </svg>
        </a>
        <a href="#" aria-label="Twitter">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
          </svg>
        </a>
        <a href="#" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/>
            <circle cx="4" cy="4" r="2"/>
          </svg>
        </a>
        <a href="#" aria-label="Instagram">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
          </svg>
        </a>
      </div>
    </div>
    
    <div class="footer-column">
      <h4>For Job Seekers</h4>
      <ul>
        <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
        <li><a href="#">Companies</a></li>
        <li><a href="#">Create Resume</a></li>
        <li><a href="#">Career Advice</a></li>
      </ul>
    </div>
    
    <div class="footer-column">
      <h4>For Employers</h4>
      <ul>
        <li><a href="#">Post a Job</a></li>
        <li><a href="{{ route('candidates.index') }}">Browse Resumes</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Resources</a></li>
      </ul>
    </div>
    
    <div class="footer-column">
      <h4>Stay Updated</h4>
      <p class="subscribe-desc">Subscribe to get the latest jobs and career tips.</p>
      <form class="subscribe-form" action="#" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Your email" required>
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</footer>

<div class="footer-bottom">
  <div>© 2025 FullTimez. All rights reserved.</div>
  <div class="footer-bottom-links">
    <a href="#">Privacy Policy</a>
    <a href="#">Terms of Service</a>
    <a href="#">Contact</a>
  </div>
</div>






