<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="admissions-page">

<?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Admissions</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Admissions</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<!-- Admissions Section -->
<section id="admissions" class="admissions section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-5 g-lg-5">
      <div class="col-lg-6">
        <div class="admissions-info" data-aos="fade-up">
          <h2>Begin Your Academic Journey Today</h2>
          <p>
            Choosing the right school is the first step toward a bright future. At EduPack, we believe that every learner deserves
            a place where curiosity is encouraged, creativity is celebrated, and excellence is achieved. Our admissions process
            is designed to be transparent, inclusive, and accessible for all students seeking quality education.
          </p>

          <div class="admissions-steps mt-5">
            <h3>How to Apply</h3>
            <div class="steps-wrapper mt-4">
              <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">1</div>
                <div class="step-content">
                  <h4>Submit Application</h4>
                  <p>
                    Complete our online application form by providing accurate details and selecting your desired program or level.
                    You’ll receive a confirmation email once your submission is received.
                  </p>
                </div>
              </div>

              <div class="step-item" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">2</div>
                <div class="step-content">
                  <h4>Send Supporting Documents</h4>
                  <p>
                    Upload your academic transcripts, birth certificate, and any other required documents to verify your eligibility.
                    Our admissions office will review your file promptly.
                  </p>
                </div>
              </div>

              <div class="step-item" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">3</div>
                <div class="step-content">
                  <h4>Interview or Assessment</h4>
                  <p>
                    Shortlisted applicants may be invited for an interview or entrance assessment to better understand their
                    academic goals and learning interests.
                  </p>
                </div>
              </div>

              <div class="step-item" data-aos="fade-up" data-aos-delay="400">
                <div class="step-number">4</div>
                <div class="step-content">
                  <h4>Receive Admission Decision</h4>
                  <p>
                    Successful applicants will receive an official admission letter via email. You can then proceed to
                    confirm your enrollment and begin preparing for your studies.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="deadlines mt-5" data-aos="fade-up">
            <h3>Key Admission Deadlines</h3>
            <div class="deadline-grid mt-4">
              <div class="deadline-item">
                <h4>First Term</h4>
                <div class="date">March 15, 2025</div>
              </div>
              <div class="deadline-item">
                <h4>Second Term</h4>
                <div class="date">July 10, 2025</div>
              </div>
              <div class="deadline-item">
                <h4>Third Term</h4>
                <div class="date">November 30, 2025</div>
              </div>
              <div class="deadline-item">
                <h4>Early Enrollment</h4>
                <div class="date">January 10, 2025</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="admissions-requirements" data-aos="fade-up">
          <h3>Admission Requirements</h3>
          <div class="requirements-list mt-4">
            <div class="requirement-item" data-aos="fade-up" data-aos-delay="100">
              <div class="icon-box">
                <i class="bi bi-mortarboard-fill"></i>
              </div>
              <div>
                <h4>Academic Records</h4>
                <p>
                  Applicants must present certified copies of their previous academic results or transcripts.
                  Strong academic performance is a key factor in admission decisions.
                </p>
              </div>
            </div>

            <div class="requirement-item" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box">
                <i class="bi bi-file-earmark-text"></i>
              </div>
              <div>
                <h4>Recommendation Letters</h4>
                <p>
                  Two recommendation letters from teachers, mentors, or community leaders highlighting the applicant’s
                  character, academic ability, and leadership potential.
                </p>
              </div>
            </div>

            <div class="requirement-item" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-journal-richtext"></i>
              </div>
              <div>
                <h4>Personal Statement</h4>
                <p>
                  A brief essay describing your goals, interests, and reasons for choosing EduPack.
                  This helps our admissions team understand your motivation and aspirations.
                </p>
              </div>
            </div>

            <div class="requirement-item" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-graph-up"></i>
              </div>
              <div>
                <h4>Entrance Examination (where applicable)</h4>
                <p>
                  Some programs may require a short aptitude test or online assessment to determine readiness
                  for the desired level or course of study.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="request-info mt-5" data-aos="fade-up">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Request Information</h3>
              <p>
                Have questions about our programs or admission process?
                Fill out the form below and our admissions team will get in touch to guide you through every step.
              </p>

              <form class="php-email-form mt-4" action="forms/contact.php">
                <div class="mb-3">
                  <input type="text" name="name" class="form-control" placeholder="Full Name" required="">
                </div>
                <div class="mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Email Address" required="">
                </div>
                <div class="mb-3">
                  <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                </div>
                <div class="mb-3">
                  <select name="subject" class="form-select" required="">
                    <option value="" selected="" disabled="">Program of Interest</option>
                    <option value="Primary">Primary Education</option>
                    <option value="Secondary">Secondary Education</option>
                    <option value="Tertiary">Tertiary / College</option>
                    <option value="Vocational">Vocational Training</option>
                  </select>
                </div>
                <div class="mb-3">
                  <textarea name="message" class="form-control" rows="3" placeholder="Questions or Comments" required=""></textarea>
                </div>
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your request has been sent. Thank you!</div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="cta-wrapper mt-5" data-aos="fade-up">


  </main>

<?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>