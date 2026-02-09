<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .resume-container {
            width: 800px;
            max-width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
           background-color: lightblue;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0;
            color: #555;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px auto;
            display: block;
        }
        .section {
            padding: 15px 0;
        }
        .section-title {
            font-size: 30px;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #555;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-item {
            margin-bottom: 10px;
             
            font-size: 20px;
        }
        .info-item strong {
            display: inline-block;
            width: 100px;
        }
        .list-item {
            margin-bottom: 5px;
            font-size: 20px;
        }
    
        .edu_year{
            margin-right: 30px;
            padding-bottom: 20px;
        }
        .top_info{
            font-size: 30px;
        }
        .top_info2{
            font-size: 30px;
            font-weight:bolder;
            color: black;
        }
        #edu_sy{
            font-size: 30px;
        }
    </style>
</head>
<body>

<?php

$name = "Ruff Lawrenze Buyao";
$job_title = "Future Software Engineer";
$profile_pic_url = "pfp.jpg";
$natl = "Filipino";
$gender = "Male";
$adress = "Agno, Tayug Pangasinan";
$email = "ruffbuyao@gmail.com";
$phone = "+63 907 0272 694";
$linkedin = "linkedin.com/in/Ruff Lawrenze Buyao";
$birthdate = "September, 27 2004"; 
$shool_year_jhs = "2017 - 2021";
$shool_year_shs = "2021 - 2023";
$shool_year_clg = "Current";

$summary = "Highly motivated and results-driven IT Student with a passion in software engineering";

$education_title = "Bachelor of Science in Information Technology";
$education_title_jhs = "Junior HighSchool";
$education_title_shs = "Senior HighSchool";
$education_title_clg = "College(CURRENT)";
$education_school_jhs = "Tayug National Highschool";
$education_school_shs = "Tayug National Highschool";
$education_school_clg = "Pangasinan State University";
$education_achievements_jhs = "With Honors";
$education_achievements_shs = "With Honors";
$education_achievements_clg = "N/A";
$age = 21;

$experience_title = "N/A";
$experience_company = "N/A";
$experience_duration = "N/A";


$skill1 = "HTML";
$skill2 = "CSS";
$skill3 = "JavaScript";
$skill4 = "PHP";
$skill5 = "MySQL";
$skill6 = "Git";
$skill7 = "Figma";
$skill8 = "Dart";
$skill9 = "C#";
$skill0 = "Java";
?>

<div class="resume-container">
    <div class="header">
        <img class="profile-pic" src="<?php echo($profile_pic_url); ?>" alt="Profile Picture">
        <p class="top_info2"><?php echo($name); ?></p>
        <p class="top_info"><?php echo($job_title); ?></p>
    </div>

    
    <div class="section">
        <div class="info-item">
            <strong>Email:</strong> <?php echo htmlspecialchars($email); ?>
        </div>
        <div class="info-item">
            <strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?>
        </div>
        <div class="info-item">
            <strong>LinkedIn:</strong><a href="linkedin.com/in/Ruff Lawrenze Buyao"> <?php echo htmlspecialchars($linkedin); ?></a>
        </div>
        <div class="info-item">
            <strong>Birthdate:</strong> <?php echo htmlspecialchars($birthdate); ?>
        </div>
        <div class="info-item">
            <strong>Nationality:</strong> <?php echo htmlspecialchars($natl); ?>
        </div>
        <div class="info-item">
            <strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?>
        </div>
         <div class="info-item">
            <strong>Gender:</strong> <?php echo htmlspecialchars($age); ?><span> dalawamput isa</span>
        </div>
        <div class="info-item">
            <strong>Adress:</strong> <?php echo htmlspecialchars($adress); ?>
        </div>
    </div>

   
    <div class="section">
        <h2 class="section-title">Summary</h2>
        <p class="info-item"><?php echo htmlspecialchars($summary); ?></p>
    </div>

    
    <div class="section">
        <h1 class="section-title">Education</h1>
        <div class="edu_year"><strong id="edu_sy"><?php echo htmlspecialchars($shool_year_jhs); ?></strong></div>
       <ul> <li><div class="list-item"><strong><b>Title:</b></strong> <?php echo htmlspecialchars($education_title_jhs); ?></div> </li></ul>
       <ul> <li><div class="list-item"><strong>School:</b></strong> <?php echo htmlspecialchars($education_school_jhs); ?></div></li></ul>
       <ul> <li> <div class="list-item"><strong>Achievements:</b></strong> <?php echo htmlspecialchars($education_achievements_jhs); ?></div></li></ul><br>

        <div class="edu_year"><strong id="edu_sy"> <?php echo htmlspecialchars($shool_year_jhs); ?></strong></div>
       <ul> <li><div class="list-item"><strong><b>Title:</b></strong> <?php echo htmlspecialchars($education_title_shs); ?></div> </li></ul>
       <ul> <li><div class="list-item"><strong><b>School:</b></strong> <?php echo htmlspecialchars($education_school_shs); ?></div></li></ul>
       <ul> <li> <div class="list-item"><strong><b>Achievements:</b></strong> <?php echo htmlspecialchars($education_achievements_shs); ?></div></li></ul><br>

        <div class="edu_year"><strong id="edu_sy"> <?php echo htmlspecialchars($shool_year_clg); ?></strong></div>
       <ul> <li><div class="list-item"><strong><b>Title:</b></strong> <?php echo htmlspecialchars($education_title_clg); ?></div> </li></ul>
       <ul> <li><div class="list-item"><strong><b>School:</b></strong> <?php echo htmlspecialchars($education_school_clg); ?></div></li></ul>
       <ul> <li> <div class="list-item"><strong><b>Achievements:</b></strong> <?php echo htmlspecialchars($education_achievements_clg); ?></div></li></ul>
       
    </div>

    
    <div class="section">
        <h2 class="section-title">Experience</h2>
        <div class="list-item"><strong>Title:</strong> <?php echo htmlspecialchars($experience_title); ?></div>
        <div class="list-item"><strong>Company:</strong> <?php echo htmlspecialchars($experience_company); ?></div>
        <div class="list-item"><strong>Duration:</strong> <?php echo htmlspecialchars($experience_duration); ?></div>
       
    </div>

    
    <div class="section">
        <h2 class="section-title">Skills</h2>
        <ul>
            <li><?php echo htmlspecialchars($skill1); ?></li>
            <li><?php echo htmlspecialchars($skill2); ?></li>
            <li><?php echo htmlspecialchars($skill3); ?></li>
            <li><?php echo htmlspecialchars($skill4); ?></li>
            <li><?php echo htmlspecialchars($skill5); ?></li>
            <li><?php echo htmlspecialchars($skill6); ?></li>
            <li><?php echo htmlspecialchars($skill7); ?></li>
            <li><?php echo htmlspecialchars($skill8); ?></li>
            <li><?php echo htmlspecialchars($skill9); ?></li>
            <li><?php echo htmlspecialchars($skill0); ?></li>
        </ul>
        
    </div>

</div>

</body>
</html>