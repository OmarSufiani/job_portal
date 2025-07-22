<<<<<<< HEAD
<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome | Bandari Maritime Academy</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: #f4f6f8;
      color: #333;
    }

    header {
      background-color: rgb(4, 99, 194);
      color: white;
      padding: 20px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
      gap: 40px;
    }

    .logo-area {
      flex: 0 0 150px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logo-area img {
      height: 80px;
      width: auto;
    }

    .org-info {
      flex: 1;
      text-align: center;
    }

    .org-info h1 {
      margin: 0;
      font-size: 28px;
    }

    .org-info p {
      margin: 5px 0 0;
      font-size: 14px;
      color: #ecf0f1;
    }

    main {
      max-width: 1200px;
      margin: 40px auto;
      padding: 40px 60px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .quick-links {
      margin-bottom: 30px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .quick-links a {
      flex: 1 1 200px;
      background-color: teal;
      color: white;
      text-decoration: none;
      padding: 10px 18px;
      border-radius: 4px;
      transition: background 0.3s;
      text-align: center;
    }

    .quick-links a:hover {
      background-color: #024a94;
    }

    h4 {
      margin-top: 40px;
      color: #2c3e50;
    }

    ol {
      padding-left: 20px;
      line-height: 2;
      max-width: 800px;
      margin: 0 auto;
    }

    ol li {
      margin-bottom: 12px;
    }

    .disclaimer {
      margin-top: 30px;
      padding: 15px 20px;
      background-color: #fff3cd;
      border: 1px solid #ffeeba;
      border-radius: 5px;
      color: #856404;
      font-size: 15px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      white-space: pre-line; /* preserve line breaks */
    }

    .inquiries {
      max-width: 800px;
      margin: 40px auto 0;
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    .inquiries a.mail-link {
      color: #004085;
      text-decoration: underline;
    }

    footer {
      margin-top: 60px;xa
      text-align: center;
      font-size: 14px;
      color: #777;
      padding: 20px;
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        align-items: flex-start;
        text-align: center;
        padding: 20px 20px;
      }

      .logo-area {
        flex: initial;
      }

      .org-info {
        text-align: center;
        margin-top: 10px;
        flex: initial;
      }

      main {
        margin: 20px;
        padding: 20px;
      }

      .quick-links {
        flex-direction: column;
        gap: 10px;
      }

      .quick-links a {
        flex: initial;
      }

      ol, .disclaimer, .inquiries {
        max-width: 100%;
        margin: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo-area">
      <img src="uploads/bandari.png" alt="Bandari Logo">
    </div>
    <div class="org-info">
      <h1>BANDARI MARITIME ACADEMY</h1>
      <p>Excellence in Maritime Training and Development</p>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <div class="quick-links">
      <a href="login.php">Login</a>
      <a href="login.php">Advertised Jobs</a>
      <a href="login.php">Internship Opportunities</a>
    </div>

    <h4>Quick Guiding Steps</h4>
    <ol>
      <li>All first time users of the Online Recruitment and Selection system are required to register by providing ID / Passport Number, Surname, current Email address and a password to access the system.</li>
      <li>To apply for any advertised job or internship opportunities, log into the system using the ID / Passport Number and the Password created in (1) above.</li>
      <li>Applicant MUST ensure that information pertaining to personal details, professional and academic qualifications, experience, membership to professional bodies, referees and any other relevant information is provided before submitting the application. Incomplete applications will not be considered.</li>
      <li>Applicants are advised to print and keep a copy of the Feedback Report (application summary) by clicking on the Report tab or Application Summary link on the Application Menu.</li>
      <li>The Online Recruitment and Selection system allows applicants to amend/revisit their application(s) at any time BEFORE the Advert Closure Date.</li>
    </ol>

    <div class="disclaimer">
      <strong>Disclaimer:</strong><br>
      i) Section 100(4) of the Public Service Commission Act 2017 provides that a person who gives false or misleading information to the Commission is, on conviction, liable to a fine not exceeding Kshs. 200,000 or to imprisonment for a term not exceeding two years or to both such fine and imprisonment.
    </div>

    <div class="inquiries">
      <h4>Inquiries</h4>
      <p>Send an email to: <a class="mail-link" href="mailto:info@bma.ac.ke">info@bma.ac.ke</a><br>
      Please include your ID /Passport Number and full name, or call the following numbers:<br>
      <strong>Landline:</strong> +254 (020) 2223901, 254 20 2227471<br>
      <strong>Call Centre:</strong> 020 4865000
      </p>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
=======
<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome | Bandari Maritime Academy</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: #f4f6f8;
      color: #333;
    }

    header {
      background-color: rgb(4, 99, 194);
      color: white;
      padding: 20px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
      gap: 40px;
    }

    .logo-area {
      flex: 0 0 150px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logo-area img {
      height: 80px;
      width: auto;
    }

    .org-info {
      flex: 1;
      text-align: center;
    }

    .org-info h1 {
      margin: 0;
      font-size: 28px;
    }

    .org-info p {
      margin: 5px 0 0;
      font-size: 14px;
      color: #ecf0f1;
    }

    main {
      max-width: 1200px;
      margin: 40px auto;
      padding: 40px 60px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .quick-links {
      margin-bottom: 30px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .quick-links a {
      flex: 1 1 200px;
      background-color: teal;
      color: white;
      text-decoration: none;
      padding: 10px 18px;
      border-radius: 4px;
      transition: background 0.3s;
      text-align: center;
    }

    .quick-links a:hover {
      background-color: #024a94;
    }

    h4 {
      margin-top: 40px;
      color: #2c3e50;
    }

    ol {
      padding-left: 20px;
      line-height: 2;
      max-width: 800px;
      margin: 0 auto;
    }

    ol li {
      margin-bottom: 12px;
    }

    .disclaimer {
      margin-top: 30px;
      padding: 15px 20px;
      background-color: #fff3cd;
      border: 1px solid #ffeeba;
      border-radius: 5px;
      color: #856404;
      font-size: 15px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      white-space: pre-line; /* preserve line breaks */
    }

    .inquiries {
      max-width: 800px;
      margin: 40px auto 0;
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    .inquiries a.mail-link {
      color: #004085;
      text-decoration: underline;
    }

    footer {
      margin-top: 60px;
      text-align: center;
      font-size: 14px;
      color: #777;
      padding: 20px;
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        align-items: flex-start;
        text-align: center;
        padding: 20px 20px;
      }

      .logo-area {
        flex: initial;
      }

      .org-info {
        text-align: center;
        margin-top: 10px;
        flex: initial;
      }

      main {
        margin: 20px;
        padding: 20px;
      }

      .quick-links {
        flex-direction: column;
        gap: 10px;
      }

      .quick-links a {
        flex: initial;
      }

      ol, .disclaimer, .inquiries {
        max-width: 100%;
        margin: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo-area">
      <img src="uploads/bandari.png" alt="Bandari Logo">
    </div>
    <div class="org-info">
      <h1>BANDARI MARITIME ACADEMY</h1>
      <p>Excellence in Maritime Training and Development</p>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <div class="quick-links">
      <a href="login.php">Login</a>
      <a href="login.php">Advertised Jobs</a>
      <a href="login.php">Internship Opportunities</a>
    </div>

    <h4>Quick Guiding Steps</h4>
    <ol>
      <li>All first time users of the Online Recruitment and Selection system are required to register by providing ID / Passport Number, Surname, current Email address and a password to access the system.</li>
      <li>To apply for any advertised job or internship opportunities, log into the system using the ID / Passport Number and the Password created in (1) above.</li>
      <li>Applicant MUST ensure that information pertaining to personal details, professional and academic qualifications, experience, membership to professional bodies, referees and any other relevant information is provided before submitting the application. Incomplete applications will not be considered.</li>
      <li>Applicants are advised to print and keep a copy of the Feedback Report (application summary) by clicking on the Report tab or Application Summary link on the Application Menu.</li>
      <li>The Online Recruitment and Selection system allows applicants to amend/revisit their application(s) at any time BEFORE the Advert Closure Date.</li>
    </ol>

    <div class="disclaimer">
      <strong>Disclaimer:</strong><br>
      i) Section 100(4) of the Public Service Commission Act 2017 provides that a person who gives false or misleading information to the Commission is, on conviction, liable to a fine not exceeding Kshs. 200,000 or to imprisonment for a term not exceeding two years or to both such fine and imprisonment.
    </div>

    <div class="inquiries">
      <h4>Inquiries</h4>
      <p>Send an email to: <a class="mail-link" href="mailto:info@bma.ac.ke">info@bma.ac.ke</a><br>
      Please include your ID /Passport Number and full name, or call the following numbers:<br>
      <strong>Landline:</strong> +254 (020) 2223901, 254 20 2227471<br>
      <strong>Call Centre:</strong> 020 4865000
      </p>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
>>>>>>> 45a39b43c00407c36fae2a72151ba9a8e7f8caf6
