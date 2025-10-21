<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="alumni-page">

<?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Alumni</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Alumni</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

   <!-- Alumni Section -->
<section id="alumni" class="alumni section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="alumni-hero">
      <div class="row align-items-center">
        <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
          <div class="hero-content">
            <span class="alumni-badge">Alumni Community</span>
            <h2>Join Our Global Network of Changemakers</h2>
            <p>From classrooms filled with curiosity to boardrooms and communities across the world, our alumni continue to live out the values instilled at our school. Each graduate carries a legacy of excellence, service, and integrity — making a difference wherever they go.</p>
            <div class="alumni-metrics">
              <div class="metric">
                <div class="counter">7k+</div>
                <div class="label">Proud Alumni</div>
              </div>
              <div class="metric">
                <div class="counter">38</div>
                <div class="label">Countries Represented</div>
              </div>
              <div class="metric">
                <div class="counter">25</div>
                <div class="label">Years of Impact</div>
              </div>
            </div>
            <a href="#" class="btn btn-discover">Discover Network Benefits</a>
          </div>
        </div>
        <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="300">
          <div class="hero-image-wrapper">
            <div class="hero-image">
              <img src="assets/img/education/campus-5.webp" alt="Alumni Network" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="notable-alumni">
      <div class="section-header text-center" data-aos="fade-up" data-aos-delay="200">
        <h3>Notable Alumni Spotlights</h3>
        <p>Celebrating graduates who continue to shine in their careers and communities</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="alumni-profile">
            <div class="profile-header">
              <div class="profile-img">
                <img src="assets/img/person/person-f-3.webp" alt="Alumni" class="img-fluid">
              </div>
              <div class="profile-year">2009</div>
            </div>
            <div class="profile-body">
              <h4>Emma Richardson</h4>
              <span class="profile-title">Education Advocate & Community Leader</span>
              <p>Emma has dedicated her career to improving access to quality education for children in rural areas. Her work through local NGOs has touched hundreds of lives, ensuring that every child has a chance to learn and dream.</p>
              <a href="#" class="btn-view-profile">View Profile <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="achievement-badge">
              <i class="bi bi-award"></i>
              <span>Outstanding Humanitarian Service</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="alumni-profile">
            <div class="profile-header">
              <div class="profile-img">
                <img src="assets/img/person/person-m-7.webp" alt="Alumni" class="img-fluid">
              </div>
              <div class="profile-year">2013</div>
            </div>
            <div class="profile-body">
              <h4>Michael Johnson</h4>
              <span class="profile-title">Medical Doctor & Youth Mentor</span>
              <p>Michael’s passion for science began in our school’s laboratories. Today, he’s a practicing physician and a volunteer mentor, guiding young students interested in pursuing careers in medicine and public health.</p>
              <a href="#" class="btn-view-profile">View Profile <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="achievement-badge">
              <i class="bi bi-stars"></i>
              <span>Health & Community Leadership Award</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
          <div class="alumni-profile">
            <div class="profile-header">
              <div class="profile-img">
                <img src="assets/img/person/person-f-9.webp" alt="Alumni" class="img-fluid">
              </div>
              <div class="profile-year">2015</div>
            </div>
            <div class="profile-body">
              <h4>Sophia Lin</h4>
              <span class="profile-title">Tech Entrepreneur & Innovator</span>
              <p>Sophia founded a digital learning platform that empowers students with interactive tools for better learning. She continues to inspire the next generation to embrace technology with creativity and purpose.</p>
              <a href="#" class="btn-view-profile">View Profile <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="achievement-badge">
              <i class="bi bi-lightning"></i>
              <span>Innovation & Entrepreneurship Award</span>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="600">
        <a href="#" class="btn-explore">Explore More Alumni Stories</a>
      </div>
    </div>

    <div class="alumni-engagement">
      <div class="section-header text-center" data-aos="fade-up" data-aos-delay="200">
        <h3>How to Stay Connected</h3>
        <p>Stay engaged, give back, and continue to make a difference</p>
      </div>

      <div class="engagement-cards">
        <div class="row">
          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="engagement-card">
              <div class="card-icon">
                <i class="bi bi-people-fill"></i>
              </div>
              <h4>Mentorship Program</h4>
              <p>Inspire current students by sharing your experience, career journey, and lessons learned. Help guide them toward success.</p>
              <a href="#" class="card-link">Become a Mentor</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="engagement-card">
              <div class="card-icon">
                <i class="bi bi-calendar-event"></i>
              </div>
              <h4>Alumni Events</h4>
              <p>Reconnect with classmates and celebrate milestones through reunions, school anniversary galas, and networking events.</p>
              <a href="#" class="card-link">Upcoming Events</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="engagement-card">
              <div class="card-icon">
                <i class="bi bi-gift"></i>
              </div>
              <h4>Give Back</h4>
              <p>Support student scholarships, school projects, and development initiatives that continue the legacy of excellence.</p>
              <a href="#" class="card-link">Support Our Mission</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="engagement-card">
              <div class="card-icon">
                <i class="bi bi-briefcase"></i>
              </div>
              <h4>Career Network</h4>
              <p>Connect with other professionals, explore job opportunities, and share your expertise with the alumni community.</p>
              <a href="#" class="card-link">Join Network</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="upcoming-events">
      <div class="section-header text-center" data-aos="fade-up" data-aos-delay="200">
        <h3>Upcoming Alumni Events</h3>
        <p>Reconnect, celebrate, and share memories with fellow graduates</p>
      </div>

      <div class="events-wrapper" data-aos="fade-up" data-aos-delay="300">
        <div class="event">
          <div class="date-badge">
            <span class="month">JUN</span>
            <span class="day">18</span>
          </div>
          <div class="event-info">
            <h4>Annual Alumni Reunion & Awards Night</h4>
            <div class="event-meta">
              <span><i class="bi bi-pin-map"></i> School Auditorium</span>
              <span><i class="bi bi-clock"></i> 5:00 PM - 9:00 PM</span>
            </div>
            <p>A night to reconnect with old classmates, celebrate achievements, and honor outstanding alumni who continue to uphold the school’s values.</p>
          </div>
          <div class="event-action">
            <a href="#" class="btn-register">Register</a>
          </div>
        </div>

        <div class="event">
          <div class="date-badge">
            <span class="month">JUL</span>
            <span class="day">25</span>
          </div>
          <div class="event-info">
            <h4>Career Mentorship Forum</h4>
            <div class="event-meta">
              <span><i class="bi bi-pin-map"></i> Main Hall</span>
              <span><i class="bi bi-clock"></i> 10:00 AM - 2:00 PM</span>
            </div>
            <p>An interactive session where alumni professionals share insights with current students about university life, career choices, and personal growth.</p>
          </div>
          <div class="event-action">
            <a href="#" class="btn-register">Register</a>
          </div>
        </div>

        <div class="event">
          <div class="date-badge">
            <span class="month">SEP</span>
            <span class="day">09</span>
          </div>
          <div class="event-info">
            <h4>Homecoming Celebration</h4>
            <div class="event-meta">
              <span><i class="bi bi-pin-map"></i> School Sports Ground</span>
              <span><i class="bi bi-clock"></i> All Day</span>
            </div>
            <p>Join us for a weekend of sports, music, and memories as alumni from all generations return to celebrate the spirit of our school family.</p>
          </div>
          <div class="event-action">
            <a href="#" class="btn-register">Register</a>
          </div>
        </div>
      </div>

      <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
        <a href="#" class="calendar-link">View Full Events Calendar <i class="bi bi-arrow-right-circle"></i></a>
      </div>
    </div>

    <div class="impact-banner" data-aos="fade-up" data-aos-delay="200">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="impact-content">
            <h3>Make a Lasting Impact</h3>
            <p>Your contribution helps provide scholarships, upgrade facilities, and support the next generation of students. Together, our alumni community is shaping a brighter future — one act of kindness at a time.</p>
            <div class="impact-buttons">
              <a href="#" class="btn-donate">Donate Now</a>
              <a href="#" class="btn-learn-more">Learn About Impact <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="impact-image">
            <img src="assets/img/education/education-8.webp" alt="Student scholarship recipients" class="img-fluid">
            <div class="impact-stat">
              <span class="stat-number">₦12M</span>
              <span class="stat-text">in student scholarships funded by alumni last year</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</section>
<!-- /Alumni Section -->


  </main>

<?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>