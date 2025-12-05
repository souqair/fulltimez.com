


<style>
footer {
    background-color: #000000;
    padding: 100px 30px 30px 56px !important;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    border-top: 3px solid #1a73e8;
}

footer div {
    width: 22%;
    min-width: 200px;
}

footer h4 {
    font-size: 16px;
    margin-bottom: 20px;
    color: #ffffff;
    font-weight: 700;
    font-family: sans-serif;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

footer p {
    font-size: 13px;
    color: #b0b0b0;
    line-height: 1.8;
    margin: 0 0 20px 0;
    font-family: sans-serif;
}

footer a {
    display: block;
    text-decoration: none;
    font-size: 13px;
    color: #d0d0d0;
    margin: 10px 0;
    font-family: sans-serif;
    transition: all 0.3s ease;
    position: relative;
    padding-left: 0;
}

footer a:hover {
    color: #1a73e8;
    padding-left: 8px;
}

footer a::before {
    content: '→';
    position: absolute;
    left: -15px;
    opacity: 0;
    transition: all 0.3s ease;
    color: #1a73e8;
}

footer a:hover::before {
    opacity: 1;
    left: -10px;
}

footer input[type="email"] {
    padding: 12px 15px;
    border: 1px solid #333;
    border-radius: 6px;
    width: 100%;
    max-width: 250px;
    font-size: 13px;
    font-family: sans-serif;
    background: #1a1a1a;
    color: #fff;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

footer input[type="email"]:focus {
    outline: none;
    border-color: #1a73e8;
    background: #252525;
}

footer input[type="email"]::placeholder {
    color: #666;
}

footer button {
    padding: 12px 24px;
    background: #1a73e8;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    font-family: sans-serif;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

footer button:hover {
    background: #1557b0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 115, 232, 0.4);
}

.footer-bottom {
    text-align: center;
    padding: 25px 20px;
    font-size: 13px;
    color: #888;
    background: #0a0a0a;
    font-family: sans-serif;
    border-top: 1px solid #1a1a1a;
}

.footer-bottom a {
    color: #1a73e8;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-bottom a:hover {
    color: #4a9eff;
}

@media (max-width: 991px) {
    footer {
        padding: 50px 50px 30px;
    }
    
    footer div {
        width: 48%;
        margin-bottom: 35px;
    }
}

@media (max-width: 576px) {
    footer {
        padding: 40px 30px 25px;
    }
    
    footer div {
        width: 100%;
        margin-bottom: 30px;
    }
    
    footer input[type="email"] {
        max-width: 100%;
    }
    
    footer button {
        width: 100%;
    }
}
</style>

<footer>
  <div>
    <h4>FullTimez</h4>
    <p>Empowering careers and connecting talent with opportunities across the globe.</p>
  </div>
  <div>
    <h4>For Job Seekers</h4>
    <a href="{{ route('jobs.index') }}">Browse Jobs</a>
    <a href="#">Companies</a>
    <a href="#">Create Resume</a>
    <a href="#">Career Advice</a>
  </div>
  <div>
    <h4>For Employers</h4>
    <a href="#">Post a Job</a>
    <a href="{{ route('candidates.index') }}">Browse Resumes</a>
    <a href="#">Pricing</a>
    <a href="#">Resources</a>
  </div>
  <div>
    <h4>Stay Updated</h4>
    <form action="#" method="POST">
      @csrf
      <input type="email" name="email" placeholder="Your email" required>
      <button type="submit">Subscribe</button>
    </form>
  </div>
</footer>

<div class="footer-bottom">© 2025 FullTimez. All rights reserved.</div>






