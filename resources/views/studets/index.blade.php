<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>صفحة الطالب</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --dark-bg: #121212;
      --card-bg: #1f1f1f;
      --card-hover: #2c2c2c;
      --accent: #90caf9;
      --subject-color: #f48fb1;
      --radius: 16px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      background-color: var(--dark-bg);
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .navbar {
      background-color: #1a1a1a;
      padding: 15px 25px;
      font-size: 1.3em;
      font-weight: bold;
      color: var(--accent);
      box-shadow: 0 2px 10px rgba(0,0,0,0.6);
      text-align: center;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 20px;
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 15px;
    }

    .card {
      background-color: var(--card-bg);
      border-radius: var(--radius);
      padding: 25px;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
      transition: 0.3s;
    }

    .card:hover {
      background-color: var(--card-hover);
    }

    .card h2 {
      color: var(--accent);
      margin-top: 0;
      margin-bottom: 15px;
      border-bottom: 1px solid #333;
      padding-bottom: 5px;
    }

    .student-info {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 20px;
    }

    .student-info img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--accent);
    }

    .student-details p {
      margin: 8px 0;
      font-size: 1.1em;
    }

    .subjects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 15px;
    }

    .subject-card {
      background-color: #292929;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      transition: 0.3s ease;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .subject-card:hover {
      transform: scale(1.05);
      background-color: #383838;
    }

    .subject-card i {
      font-size: 1.5em;
      margin-bottom: 8px;
      color: var(--accent);
      display: block;
    }

    .subject-card span {
      font-size: 1.1em;
      color: var(--subject-color);
      font-weight: 500;
    }

    .col-12 { grid-column: span 12; }

    @media (min-width: 768px) {
      .col-md-6 { grid-column: span 6; }
    }

  </style>
</head>
<body>
  <div class="navbar">مدرسة الأفق الحديثة</div>

  <div class="container">

    <!-- معلومات الطالب -->
    <div class="card col-12">
      <h2>معلومات الطالب</h2>
      <div class="student-info">
        <div class="student-details">
          <p><strong>الاسم:</strong> محمد أحمد</p>
          <p><strong>الصف:</strong> العاشر</p>
          <p><strong>الشعبة:</strong> ب</p>
        </div>
      </div>
    </div>

    <!-- المواد الدراسية -->
    <div class="card col-12">
      <h2>المواد الدراسية</h2>
      <div class="subjects-grid">
        <div class="subject-card"><i class="fas fa-calculator"></i><span>الرياضيات</span></div>
        <div class="subject-card"><i class="fas fa-atom"></i><span>الفيزياء</span></div>
        <div class="subject-card"><i class="fas fa-vial"></i><span>الكيمياء</span></div>
        <div class="subject-card"><i class="fas fa-dna"></i><span>الأحياء</span></div>
        <div class="subject-card"><i class="fas fa-language"></i><span>اللغة العربية</span></div>
        <div class="subject-card"><i class="fas fa-globe-americas"></i><span>اللغة الإنجليزية</span></div>
        <div class="subject-card"><i class="fas fa-landmark"></i><span>التاريخ</span></div>
        <div class="subject-card"><i class="fas fa-map-marked-alt"></i><span>الجغرافيا</span></div>
      </div>
    </div>

  </div>
</body>
</html>
