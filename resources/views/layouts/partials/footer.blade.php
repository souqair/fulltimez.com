<section class="section download">
      <div class="container">
         <div class="row">
            <div class="col-md-6 col-12">
               <div class="section__header">
                  <h2 class="section__title">Download <span>FULLTIMEZ's</span> <br class="d-none d-md-block"> mobile app for
                     Free</h2>
                  <p class="section__desc">

                     FullTimez, empowering your career journey. Whether you're searching for your first job or
your next big opportunity, we connect you with employers who value your talent. Explore
thousands of jobs, get expert career advice, and take the next step toward a brighter future —
all in one place.
Helping you move forward in your career. Our platform is designed to support jobseekers by
providing access to job listings, career resources, and guidance tools. Please note that we do
not guarantee employment or endorse any specific employer. Always exercise due diligence
when applying and communicating with potential employers.

                  </p>

                  <div class="download__actions">
                            <a href="#">
   <img title="e-Invoice KSA iOS mobile APP" src="{{asset('images/apple.webp')}}" class="lazyload" alt="apple mobile accounting APP"></a>
<a href="#"> <img title="e-Invoice KSA andriod mobile APP" alt="andriod mobile accounting APP" src="{{asset('images/google-play.jpg')}}" class="lazyload"></a>
<a href="#" style="margin-top:5px"> <img title="e-Invoice KSA Huawei mobile APP" alt="Mobile Accounting APP Huawei " src="{{asset('images/huawei.webp')}}" class="lazyload"></a>
</div>
                
                         
               </div>
            </div>

            <div class="col-md-6 col-12">
            <div class="mobileapp text-center"><img src="{{asset('images/mobileapp.png')}}" alt=""></div>
         </div>
             
         </div>
      </div>
   </section>
<div class="ads_ text-center py-5"><img src="images/ads2.jpg" alt=""></div>


<style>
footer {
    background: #f8f8f8;
    padding: 50px 60px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    font-family: sans-serif;
}

footer div {
    width: 22%;
    min-width: 200px;
}

footer h4 {
    font-size: 14px;
    margin-bottom: 15px;
    color: #000;
    font-weight: 700;
    font-family: sans-serif;
}

footer p {
    font-size: 12px;
    color: #666;
    line-height: 1.6;
    margin: 0;
    font-family: sans-serif;
}

footer a {
    display: block;
    text-decoration: none;
    font-size: 12px;
    color: #444;
    margin: 6px 0;
    font-family: sans-serif;
    transition: color 0.3s ease;
}

footer a:hover {
    color: #000;
}

footer input[type="email"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 150px;
    font-size: 12px;
    font-family: sans-serif;
}

footer button {
    padding: 8px 12px;
    background: #000;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    margin-left: 6px;
    font-family: sans-serif;
    transition: background 0.3s ease;
}

footer button:hover {
    background: #333;
}

.footer-bottom {
    text-align: center;
    padding: 20px;
    font-size: 12px;
    color: #777;
    background: #f8f8f8;
    font-family: sans-serif;
}

@media (max-width: 991px) {
    footer {
        padding: 40px 30px;
    }
    
    footer div {
        width: 48%;
        margin-bottom: 30px;
    }
}

@media (max-width: 576px) {
    footer {
        padding: 30px 20px;
    }
    
    footer div {
        width: 100%;
        margin-bottom: 25px;
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






