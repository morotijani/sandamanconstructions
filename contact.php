<?php
$page_title = 'Contact Us — Sandaman Constructions';
$page_description = 'Get in touch with Sandaman Constructions for road, building, water and earthworks project enquiries in Ghana.';
include 'includes/header.php';
?>

    <main>
        <!-- ============ PAGE BANNER ============ -->
        <section class="page-banner">
            <div class="blueprint-bg"></div>
            <div class="container">
                <p class="breadcrumb"><a href="index">Home</a><span class="sep">/</span>Contact</p>
                <p class="eyebrow">Get In Touch</p>
                <h1>Let's Talk About Your Site.</h1>
                <p class="lead">Tell us about the project and we'll come back with a scope and timeline within two
                    working days.
                </p>
            </div>
        </section>

        <!-- ============ CONTACT INFO CARDS ============ -->
        <section class="section-tight">
            <div class="container">
                <div class="contact-cards reveal">
                    <div class="contact-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 21s7-6.3 7-11.5A7 7 0 105 9.5C5 14.7 12 21 12 21z" />
                            <circle cx="12" cy="9.5" r="2.3" />
                        </svg>
                        <h4>Head Office</h4>
                        <p>AG-0196-3430, 37 Biem Gyamfi Street<br>Kumasi, Ghana</p>
                    </div>
                    <div class="contact-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path
                                d="M4 4h4l2 5-2.5 1.5a12 12 0 006 6L15 14l5 2v4a2 2 0 01-2 2C9.6 22 2 14.4 2 6a2 2 0 012-2z" />
                        </svg>
                        <h4>Phone</h4>
                        <p>+233 24 762 2522 / +233 50 801 1854<br>Mon–Fri, 8am–5pm GMT</p>
                    </div>
                    <div class="contact-card">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 5h18v14H3V5z" />
                            <path d="M3 6l9 7 9-7" />
                        </svg>
                        <h4>Email</h4>
                        <p>info@sandamanconstructions.com<br></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ FORM + MAP ============ -->
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">Project Enquiry</p>
                        <h2 style="max-width:14ch">Send Us the Brief</h2>
                    </div>
                    <p class="lead">The more detail you give us on scope, location and timeline, the faster we can turn
                        around a
                        response.</p>
                </div>

                <form id="contact-form" class="form-grid reveal">
                    <div class="field">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="company">Company / Organization</label>
                        <input type="text" id="company" name="company">
                    </div>
                    <div class="field">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="field">
                        <label for="service">Business Line</label>
                        <select id="service" name="service">
                            <option>Roads &amp; Highways</option>
                            <option>Building Construction</option>
                            <option>Earthworks &amp; Civil Engineering</option>
                            <option>Water &amp; Drainage</option>
                            <option>Energy &amp; Utilities</option>
                            <option>Quarry &amp; Mining Support</option>
                            <option>Not sure / other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="location">Project Location</label>
                        <input type="text" id="location" name="location" placeholder="Region / town">
                    </div>
                    <div class="field full">
                        <label for="message">Project Details</label>
                        <textarea id="message" name="message" required
                            placeholder="Scope, estimated timeline, and any relevant site details."></textarea>
                    </div>
                    <div class="field full">
                        <button type="submit" class="btn btn-primary">Submit Enquiry <span
                                class="btn-arrow">→</span></button>
                        <div class="form-success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <span>Thanks — your enquiry has been noted. Our team will follow up shortly.</span>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- ============ GOOGLE MAP ============ -->
        <section class="section-tight" style="padding-top:0">
            <div class="container">
                <iframe src="https://maps.google.com/maps?q=6.659472,-1.709741&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>