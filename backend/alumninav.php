<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <?php
    /**
     * Includes the logo and header for the sidebar.
     * This file typically contains the school/application logo and name.
     */
    include('logo_header.php');
    ?>
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item">
          <a href="../index.php">
            <i class="fas fa-globe"></i>
            <p>Visit Site</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="alumni.php">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php
        // Conditional display for "Result" link based on user's 'access' level.
        // 'access' == 0 typically means full access, 'access' == 1 means restricted (e.g., owing fees).
        if ($_SESSION['access'] == 0) {
        ?>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#" onclick="showPopup()">
              <i class="fas fa-chart-bar"></i>
              <p>Result</p>
            </a>
          </li>
        <?php
        } elseif ($_SESSION['access'] == 1) {
        ?>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#"
              onclick="alert('You are still owing. Please contact the Admin.'); return false;">
              <i class="fas fa-chart-bar"></i>
              <p>Result</p>
            </a>
          </li>
        <?php
        }
        ?>

        <!-- Overlay for the popup form -->
        <div id="overlay" class="overlay" onclick="closePopup()"></div>

        <!-- Popup Form for selecting session and term to check results -->
        <div id="popup" class="popup">
          <span class="close" onclick="closePopup()">&times;</span>
          <form id="filterForm">
            <p></p>
            <p></p>
            <select id="session" name="session">
              <option value="">Select Session</option>
              <!-- Options for academic sessions will be added dynamically by JavaScript -->
            </select>

            <select id="term" name="term">
              <option value="">Select Term</option>
              <!-- Options for academic terms will be added dynamically by JavaScript -->
            </select>

            <button type="button" onclick="checkResult()">Check Result</button>
          </form>
        </div>

        <script>
          // JavaScript to handle the popup functionality for result checking.
          /**
           * Displays the result selection popup and loads options for sessions and terms.
           */
          function showPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            loadOptions(); // Call function to load dropdown options.
          }

          /**
           * Hides the result selection popup and its overlay.
           */
          function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
          }

          /**
           * Loads academic session and term options into the respective dropdowns.
           * Terms are static, while sessions are fetched dynamically via AJAX.
           */
          function loadOptions() {
            const sessionSelect = document.getElementById('session');
            const termSelect = document.getElementById('term');

            // Clear existing options to prevent duplicates.
            sessionSelect.innerHTML = '<option value="">Select Session</option>';
            termSelect.innerHTML = '<option value="">Select Term</option>';

            // Add static term options.
            const terms = ['1st Term', '2nd Term', '3rd Term'];
            terms.forEach(term => {
              const option = document.createElement('option');
              option.value = term;
              option.textContent = term;
              termSelect.appendChild(option);
            });

            // Fetch session values from the server using AJAX.
            fetch('get_sessions.php')
              .then(response => response.json()) // Parse the JSON response.
              .then(data => {
                // Add fetched sessions to the dropdown.
                data.sessions.forEach(session => {
                  const option = document.createElement('option');
                  option.value = session;
                  option.textContent = session;
                  sessionSelect.appendChild(option);
                });
              })
              .catch(error => {
                console.error('Error fetching sessions:', error); // Log any errors during fetch.
              });
          }

          /**
           * Redirects the user to the result page with selected session and term.
           * Validates if both session and term are selected before redirection.
           */
          function checkResult() {
            const session = document.getElementById('session').value;
            const term = document.getElementById('term').value;

            if (session && term) {
              // Encode URI components to handle special characters in URL.
              window.location.href = `checkresult.php?session=${encodeURIComponent(session)}&term=${encodeURIComponent(term)}`;
            } else {
              alert('Please select both session and term.'); // Alert if selections are incomplete.
            }
          }
        </script>

        <?php
        // Conditional display for "Transcript" link based on user's 'access' level.
        if ($_SESSION['access'] == 0) {
        ?>
          <li class="nav-item">
            <a href="transcript.php">
              <i class="fas fa-desktop"></i>
              <p>Transcript</p>
            </a>
          </li>
        <?php
        } elseif ($_SESSION['access'] == 1) {
        ?>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#"
              onclick="alert('You are still owing. Please contact the Admin.'); return false;">
              <i class="fas fa-chart-bar"></i>
              <p>Transcript</p>
            </a>
          </li>
        <?php
        }
        ?>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#threads">
            <i class="fas fa-comment-dots"></i>
            <p>Discussion Threads</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="threads">
            <ul class="nav nav-collapse">
              <li>
                <a href="threads.php">
                  <span class="sub-item">Threads</span>
                </a>
              </li>
              <li>
                <a href="create_thread.php">
                  <span class="sub-item">Create Thread</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->