@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section class="breadcrumb-section">
    <div class="container-auto">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="page-title">
                    <h1>Contact Us</h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-header text-center mb-5">
            <h2 class="contact-main-title">Get In Touch</h2>
            <p class="contact-subtitle">Have a question or need help? We're here to assist you. Reach out to us and we'll get back to you as soon as possible.</p>
        </div>

        <div class="contact-content">
            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form-card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group-half">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user"></i> Your Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Enter your full name">
                                    </div>
                                </div>
                                <div class="form-group-half">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="your.email@example.com">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="+971 50 123 4567">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject" class="form-label">
                                    <i class="fas fa-tag"></i> Subject <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required placeholder="What is this regarding?">
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="form-label">
                                    <i class="fas fa-comment"></i> Message <span class="text-danger">*</span>
                                </label>
                                <textarea name="message" id="message" class="form-control" rows="6" required placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn-submit-contact">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Follow Us Section -->
                <div class="col-lg-4">
                    <div class="social-card">
                        <h3 class="social-title">Follow Us</h3>
                        <p class="social-subtitle">Stay connected with us on social media</p>
                        <div class="social-icons">
                            <a href="#" class="social-icon facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon twitter" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon linkedin" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-icon instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-section {
    padding: 80px 0;
    background: #ffffff;
    min-height: 70vh;
}

.contact-header {
    margin-bottom: 50px;
}

.contact-main-title {
    font-size: 48px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.contact-subtitle {
    font-size: 18px;
    color: #666666;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.7;
}

.contact-form-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 50px;
    box-shadow: 0 2px 30px rgba(0, 0, 0, 0.06);
    border: 1px solid #e8e8e8;
    transition: box-shadow 0.3s ease;
}

.contact-form-card:hover {
    box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);
}

.contact-form {
    width: 100%;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group-half {
    flex: 1;
}

.form-group {
    margin-bottom: 24px;
}

.contact-form .form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.contact-form .form-label i {
    color: #0061da;
    font-size: 14px;
}

.contact-form .form-control {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #ffffff;
    color: #333333;
    width: 100%;
    font-family: inherit;
}

.contact-form .form-control:focus {
    border-color: #0061da;
    box-shadow: 0 0 0 3px rgba(0, 97, 218, 0.08);
    outline: none;
}

.contact-form .form-control::placeholder {
    color: #999999;
}

.contact-form textarea.form-control {
    resize: vertical;
    min-height: 160px;
    font-family: inherit;
}

.btn-submit-contact {
    background: #0061da;
    color: #ffffff;
    border: none;
    padding: 16px 50px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(0, 97, 218, 0.25);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit-contact:hover {
    background: #0052b8;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 97, 218, 0.35);
    color: #ffffff;
}

.btn-submit-contact:active {
    transform: translateY(0);
}

/* Social Section */
.social-section {
    width: 100%;
}

.social-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    border: 1px solid #e8e8e8;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.social-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
    letter-spacing: -0.3px;
}

.social-subtitle {
    font-size: 15px;
    color: #666666;
    margin-bottom: 30px;
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.social-icon {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 20px;
    border: 2px solid transparent;
}

.social-icon.facebook {
    background: #1877f2;
    color: #ffffff;
}

.social-icon.twitter {
    background: #1da1f2;
    color: #ffffff;
}

.social-icon.linkedin {
    background: #0077b5;
    color: #ffffff;
}

.social-icon.instagram {
    background: #e4405f;
    color: #ffffff;
}

.social-icon:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.social-icon.facebook:hover {
    background: #166fe5;
}

.social-icon.twitter:hover {
    background: #1a91da;
}

.social-icon.linkedin:hover {
    background: #006399;
}

.social-icon.instagram:hover {
    background: #d32e4a;
}

/* Alerts */
.alert {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
    margin-bottom: 30px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert ul {
    padding-left: 20px;
}

/* Responsive */
@media (max-width: 992px) {
    .contact-section {
        padding: 60px 0;
    }
    
    .contact-main-title {
        font-size: 40px;
    }
    
    .contact-form-card {
        padding: 40px;
    }
    
    .social-card {
        margin-top: 30px;
        height: auto;
    }
}

@media (max-width: 768px) {
    .contact-section {
        padding: 50px 0;
    }
    
    .contact-header {
        margin-bottom: 40px;
    }
    
    .contact-main-title {
        font-size: 32px;
    }
    
    .contact-subtitle {
        font-size: 16px;
    }
    
    .contact-form-card {
        padding: 30px 25px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .social-card {
        padding: 30px 25px;
    }
    
    .social-title {
        font-size: 24px;
    }
    
    .social-icon {
        width: 50px;
        height: 50px;
        font-size: 18px;
    }
    
    .btn-submit-contact {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .contact-main-title {
        font-size: 28px;
    }
    
    .contact-form-card {
        padding: 25px 20px;
    }
    
    .social-card {
        padding: 25px 20px;
    }
}
</style>

@endsection
