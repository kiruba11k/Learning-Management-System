<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS Files -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/contacts/contact-3/assets/css/contact-3.css" />
  <title>Contact Us</title>
  <style>
    .custom-top-margin {
      margin-top: 150px; /* Adjust this value as needed */
    }
  </style>
</head>
<body>
<?php
  include_once('./header.php');
  include('./dbconnection.php');

  $message = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $fullname = $conn->real_escape_string($_POST['fullname']);
      $email = $conn->real_escape_string($_POST['email']);
      $phone = $conn->real_escape_string($_POST['phone']);
      $subject = $conn->real_escape_string($_POST['subject']);
      $message = $conn->real_escape_string($_POST['message']);

      // Insert data into the database
      $sql = "INSERT INTO contacts (fullname, email, phone, subject, message) VALUES ('$fullname', '$email', '$phone', '$subject', '$message')";

      if ($conn->query($sql) === TRUE) {
          $message = "<div class='alert alert-success'>Message sent successfully!</div>";
      } else {
          $message = "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
      }
  }
  ?>

  <div class="bg-light py-3 py-md-5 py-xl-8 custom-top-margin">
    <div class="container">
      <div class="row gy-3 gy-md-4 gy-lg-0 align-items-md-center ">
        <div class="col-12 col-lg-6">
          <div class="row justify-content-xl-center">
            <div class="col-12 col-xl-11">
              <h2 class="h1 mb-3">Get in touch</h2>
              <p class="lead fs-4 text-secondary mb-5">We're always on the lookout to work with new clients. If you're interested in working with us, please get in touch in one of the following ways.</p>
              <div class="d-flex mb-5">
                <div class="me-4 text-primary">
                  <!-- Icon SVG -->
                </div>
                <div>
                  <h4 class="mb-3">Address</h4>
                  <address class="mb-0 text-secondary">A108 Gandhipuram, Coimbatore, Tamil Nadu, India</address>
                </div>
              </div>
              <div class="row mb-5">
                <div class="col-12 col-sm-6">
                  <div class="d-flex mb-5 mb-sm-0">
                    <div class="me-4 text-primary">
                      <!-- Icon SVG -->
                    </div>
                    <div>
                      <h4 class="mb-3">Phone</h4>
                      <p class="mb-0">
                        <a class="link-secondary text-decoration-none" href="tel:+9876543210">98765 43210</a>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="d-flex mb-0">
                    <div class="me-4 text-primary">
                      <!-- Icon SVG -->
                    </div>
                    <div>
                      <h4 class="mb-3">E-Mail</h4>
                      <p class="mb-0">
                        <a class="link-secondary text-decoration-none" href="mailto:Oneyesinfotech@gmail.com">Oneyesinfotech@gmail.com</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex">
                <div class="me-4 text-primary">
                  <!-- Icon SVG -->
                </div>
                <div>
                  <h4 class="mb-3">Opening Hours</h4>
                  <div class="d-flex mb-1">
                    <p class="text-secondary fw-bold mb-0 me-5">Mon - Fri</p>
                    <p class="text-secondary mb-0">9am - 5pm</p>
                  </div>
                  <div class="d-flex">
                    <p class="text-secondary fw-bold mb-0 me-5">Sat - Sun</p>
                    <p class="text-secondary mb-0">9am - 2pm</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 custom-top-margin">
          <div class="bg-white border rounded shadow-sm overflow-hidden">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="row gy-4 gy-xl-5 p-4 p-xl-5">
                <div class="col-12">
                  <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="fullname" name="fullname" required>
                  <div id="name-warning" class="text-danger" style="display:none;">Name is required</div>
                </div>
                <div class="col-12 col-md-6">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div id="email-warning" class="text-danger" style="display:none;">Email is required</div>
                </div>
                <div class="col-12 col-md-6">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                <div class="col-12">
                  <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="subject" name="subject" required>
                  <div id="subject-warning" class="text-danger" style="display:none;">Subject is required</div>
                </div>
                <div class="col-12">
                  <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                  <div id="message-warning" class="text-danger" style="display:none;">Message is required</div>
                </div>
                <div class="col-12">
                  <?php echo $message; ?>
                  <div class="d-grid">
                    <button class="btn btn-primary btn-lg" id="message-button" type="submit">Send Message</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('message-button').addEventListener('click', function(event) {
      var isValid = true;
      var name = document.getElementById('fullname').value.trim();
      var email = document.getElementById('email').value.trim();
      var subject = document.getElementById('subject').value.trim();
      var message = document.getElementById('message').value.trim();

      // Reset all previous error messages
      document.getElementById('name-warning').style.display = 'none';
      document.getElementById('email-warning').style.display = 'none';
      document.getElementById('subject-warning').style.display = 'none';
      document.getElementById('message-warning').style.display = 'none';

      // Validate Name
      if (name === '') {
        document.getElementById('name-warning').style.display = 'block';
        isValid = false;
      }

      // Validate Email
      if (email === '') {
        document.getElementById('email-warning').style.display = 'block';
        isValid = false;
      }

      // Validate Subject
      if (subject === '') {
        document.getElementById('subject-warning').style.display = 'block';
        isValid = false;
      }

      // Validate Message
      if (message === '') {
        document.getElementById('message-warning').style.display = 'block';
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
      }
    });
  </script>
    <?php include_once('./footer.php'); ?>
</body>
</html>