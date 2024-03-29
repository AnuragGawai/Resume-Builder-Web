<?php

require_once('tcpdf/tcpdf.php');

// Check if the form is submitted and the button is clicked
if (isset($_POST['generate_pdf'])) 
{
    // Create a new TCPDF object
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('TCPDF Example');
    $pdf->SetAuthor('John Doe');
    $pdf->SetTitle('Database Data to PDF');
    $pdf->SetSubject('Database Data');
    $pdf->SetKeywords('TCPDF, PDF, database, data');

    // Set default header data
    $pdf->SetHeaderData('', 0, 'Resume', '');

    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Connect to your database (replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "resume_builder";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql="SELECT MAX(resume_id) AS max_id FROM `personal_info`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$max_id = $row['max_id'];

if ($max_id === null) {
    $max_id = 0;
}

$new_id = $max_id ;
    // Query to fetch data from your database (replace 'your_table' with your table name)
    $sql = "SELECT personal_info.*, education.*, experience.*, GROUP_CONCAT(DISTINCT skill.skillsss SEPARATOR ', ') AS skills,
    GROUP_CONCAT(DISTINCT CONCAT(languages.name, ' (', languages.lang_level, ')') SEPARATOR ', ') AS languages, certification.*,
    GROUP_CONCAT(DISTINCT hobbies.hobbi SEPARATOR ', ') AS hobby, projects.*
    FROM personal_info 
    LEFT JOIN education ON personal_info.resume_id = education.resume_id
    LEFT JOIN experience ON personal_info.resume_id = experience.resume_id
    LEFT JOIN skill ON personal_info.resume_id = skill.resume_id 
    LEFT JOIN languages ON personal_info.resume_id = languages.resume_id
    LEFT JOIN certification ON personal_info.resume_id = certification.resume_id
    LEFT JOIN hobbies ON personal_info.resume_id = hobbies.resume_id
    LEFT JOIN projects ON personal_info.resume_id = projects.resume_id
    WHERE personal_info.resume_id = $new_id";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
// Flag to check if personal information is already output
$personal_info_output = false;

// Output data of each row
while($row = $result->fetch_assoc()) {
    // Output personal information only once
    if (!$personal_info_output) {
        $pdf->Cell(0, 10, "Name: " . $row['full_name'], 0, 1);
        $pdf->Cell(0, 10, "Professional Title: " . $row['prof_title'], 0, 1);
        $pdf->Cell(0, 10, "Email: " . $row['email_id'], 0, 1);
        $pdf->Cell(0, 10, "Mobile No: " . $row['mob_no'], 0, 1);
        $pdf->Cell(0, 10, "Address: " . $row['address'], 0, 1);
        $pdf->Cell(0, 10, "Summary: " . $row['Summery'], 0, 1);

        // Mark personal information as output
        $personal_info_output = true;
    }

    // Output education information
    $pdf->Cell(0, 10, "Education: " . $row['degree'] . " from " . $row['clg_name'] . " at " . $row['location'] . " in " . $row['year'], 0, 1);
     // Output work experience information in one line
$pdf->Cell(0, 10, "Experience: " . $row['job_role'] . " at " . $row['company'] . " in " . $row['location'] . " in " . $row['date_of_emp'], 0, 1);
$pdf->Cell(0, 10, "Skills: " . $row['skills'], 0, 1);
$pdf->Cell(0, 10, "Languages: " . $row['languages'], 0, 1);
$pdf->Cell(0, 10, "Certification: " . $row['certification_name'] . " from " . $row['orgeni_name'] .  " in " . $row['date'], 0, 1);
$pdf->Cell(0, 10, "Hobbies: " . $row['hobby'], 0, 1);
$pdf->Cell(0, 10, "Project Title: " . $row['project_name'], 0, 1);
$pdf->Cell(0, 10, "Discription: " . $row['description'], 0, 1);
$pdf->Cell(0, 10, "Tecnology: " . $row['techno'], 0, 1);
$pdf->Cell(0, 10, "Project Link: " . $row['project_link'], 0, 1);

    // Add more fields from education table as needed
}
}else {
        $pdf->Cell(0, 10, "No results found", 0, 1);
    }

    // Close database connection
    $conn->close();

    // Close and output PDF document
    $pdf->Output('database_data.pdf', 'I');
    exit; // Exit after generating PDF to prevent HTML output
}



?>
<?php 
$conn = new mysqli("localhost", "root", "", "resume_builder");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateNewResumeID($conn) {
    // Initialize new_id
    $new_id = 1;
    
    // Query to get the maximum resume_id
    $sql = "SELECT MAX(resume_id) AS max_id FROM `personal_info`";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);
    
    // Check if max_id is null
    if ($row['max_id'] !== null) {
        // If not null, increment max_id by 1
        $new_id = $row['max_id'] + 1;
    }
    
    // Return the new_id
    return $new_id;
}

// Usage:
// Assuming $conn is your database connection

$new_id = generateNewResumeID($conn);

if(isset($_POST['save']))
{
    $connection = new mysqli("localhost", "root", "", "resume_builder");
    if($connection) {
        $key = $new_id;
        $fullname = $_POST['full-name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $title = $_POST['professional-title'];
        $summary = $_POST['profile-summary'];

        // Insert data into personal_info table
        $sql = "INSERT INTO `personal_info` (`resume_id`, `full_name`, `mob_no`, `email_id`, `address`, `prof_title`, `Summery`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssss", $key, $fullname, $phone, $email, $address, $title, $summary);

        if ($stmt->execute())
         {
            // Insert data into skill table
           
            $skill_datas = $_POST['skill_data'];
             
            $sql8="INSERT INTO `skill`( `resume_id`, `skillsss`) VALUES ( ?, ?)";
            $stmt8 = $connection->prepare($sql8);
               
             foreach ($skill_datas as  $skill_data) {
                 $stmt8->bind_param("ss", $key, $skill_data);
                 $stmt8->execute();
             }

            // Insert data into experience table
            $job_titles = $_POST['job_title'];
            $company_names = $_POST['company_name'];
            $company_locations = $_POST['company_location'];
            $emp_dates = $_POST['emp_date'];

            $sql1 = "INSERT INTO `experience` (`resume_id`, `job_role`, `company`, `location`, `date_of_emp`) VALUES (?, ?, ?, ?, ?)";
            $stmt1 = $connection->prepare($sql1);
            // $stmt1->bind_param("sssss", $key, $job_title, $company_names, $company_locations, $emp_dates);
              
            foreach ($job_titles as $index => $job_title) {
                $stmt1->bind_param("sssss", $key, $job_title, $company_names[$index], $company_locations[$index], $emp_dates[$index]);
                $stmt1->execute();
            }

          // Insert data into education table
            $degrees = $_POST['degree'];
            $institute = $_POST['institute'];
            $insti_location = $_POST['insti_location'];
            $pass_year = $_POST['pass_year'];

            $sql3="INSERT INTO `education`( `resume_id`, `degree`, `clg_name`, `location`, `year`) VALUES (?, ?, ?, ?, ?)";
            $stmt3 = $connection->prepare($sql3);
              
            foreach ($degrees as $index => $degree) {
                $stmt3->bind_param("sssss", $key, $degree, $institute[$index], $insti_location[$index], $pass_year[$index]);
                $stmt3->execute();
            }
           

            // Insert data into certification table
            $certinames = $_POST['certi_name'];
            $orgname = $_POST['org_name'];
            $dateofcerti = $_POST['date_of_certi'];
            

            $sql4=" INSERT INTO `certification`( `resume_id`, `certification_name`, `orgeni_name`, `date`)  VALUES (?, ?, ?, ?)";
            $stmt4 = $connection->prepare($sql4);
            $stmt4->bind_param("ssss", $key, $certiname, $orgname, $dateofcerti);
              
            foreach ($certinames as $index => $certiname) {
                $stmt4->bind_param("ssss", $key, $certiname, $orgname[$index], $dateofcerti[$index]);
                $stmt4->execute();
            }
            // Insert data into projects table
            $project_names = $_POST['project_name'];
            $description = $_POST['description'];
            $techno = $_POST['techno'];
            $project_link = $_POST['project_link'];
           
            // $sql5="INSERT INTO `education`( `resume_id`, `degree`, `clg_name`, `location`, `year`) VALUES (?, ?, ?, ?, ?)";
            $sql5="INSERT INTO `projects`( `resume_id`, `project_name`, `description`, `techno`, `project_link`) VALUES (?, ?, ?, ?, ?)";
            $stmt5 = $connection->prepare($sql5);
              
            foreach ($project_names as $index => $project_name) {
                $stmt5->bind_param("sssss", $key, $project_name, $description[$index], $techno[$index], $project_link[$index]);
                $stmt5->execute();
            }
             // Insert data into languages table
             $lang_names = $_POST['lang_name'];
             $level_name = $_POST['level_name'];
            $sql6="INSERT INTO `languages`( `resume_id`, `name`, `lang_level`) VALUES (?, ?, ?)";
            $stmt6 = $connection->prepare($sql6);
               
             foreach ($lang_names as $index => $lang_name) {
                 $stmt6->bind_param("sss", $key, $lang_name, $level_name[$index]);
                 $stmt6->execute();
             }
              // Insert data into hobbies table
              $hobbies = $_POST['hobbies'];
             
             $sql7="INSERT INTO `hobbies`( `resume_id`, `hobbi`) VALUES ( ?, ?)";
             $stmt7 = $connection->prepare($sql7);
                
              foreach ($hobbies as  $hobby) {
                  $stmt7->bind_param("ss", $key, $hobby);
                  $stmt7->execute();
              }
            echo '<script>alert("Data saved ")</script>';
            // $new_id =generateNewResumeID($conn);
            
            
        } else {
            echo '<script>alert("Failed To Save data")</script>';
        }
    } else {
        echo '<script>alert("Please Check password and confirm Password")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link rel="stylesheet" href="info_style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Resume Builder</h1>
        </header>
        <form action="" method="POST">
        <section class="personal-info">
            <h2>Personal Information</h2>
            <!-- <div class="input-container">
                <label for="Resume ID">Resume Id:</label>
                <input type="text" id="resumeid" name="resumeid" placeholder="$new_id" value="<?php echo $new_id ?>" readonly>
            </div> -->
            <div class="input-container">
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full-name" placeholder="Enter your full name" required>
            </div>
            <div class="input-container">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="input-container">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="input-container">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <div class="input-container">
                <label for="professional-title">Professional Title :</label>
                <input type="text" id="professional-title" name="professional-title"
                    placeholder="Enter your professional title " required>
            </div>

            <section class="profile-summary">
                <h2>Profile Summary</h2>
                <textarea id="profile-summary" name="profile-summary"
                    placeholder="Brief overview highlighting key skills, experiences, and career goals." rows="6"
                    required></textarea>
            </section>
            <section class="skills">
                <h2>Skills</h2>
                <div id="skills-container">
                    <div class="skill-input">
                        <input type="text" class="skill" placeholder="Enter skill..." name="skill_data[]">
                        <button class="delete-skill-btn">Delete</button>
                    </div>
                </div>
                <button id="add-skill-btn">Add Skill</button>
            </section>
            <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addSkillBtn = document.getElementById('add-skill-btn');
            const skillsContainer = document.getElementById('skills-container');

            addSkillBtn.addEventListener('click', function () {
                event.preventDefault();
                addSkillInput();
            });

            function addSkillInput() {
                const skillInputDiv = document.createElement('div');
                skillInputDiv.classList.add('skill-input');
                skillInputDiv.innerHTML = `
                    <input type="text" class="skill" placeholder="Enter skill..." name="skill_data[]">
                    <button class="delete-skill-btn">Delete</button>
                `;
                skillsContainer.appendChild(skillInputDiv);

                const deleteSkillBtn = skillInputDiv.querySelector('.delete-skill-btn');
                deleteSkillBtn.addEventListener('click', function () {
                    skillInputDiv.remove();
                });
            }
        });
    </script>


            <section class="work-experience">
                <h2>Work Experience</h2>
               
                <div id="work-experience-container">
                    <!-- Work experience entries will be dynamically added here -->
                </div>
                <button id="add-experience-btn">Add Work Experience</button>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const addExperienceBtn = document.getElementById('add-experience-btn');
                    const experienceContainer = document.getElementById('work-experience-container');

                    addExperienceBtn.addEventListener('click', function () {
                        event.preventDefault();
                        addExperienceInput();
                    });

                    function addExperienceInput() {
                        const experienceDiv = document.createElement('div');
                        experienceDiv.classList.add('experience');

                        experienceDiv.innerHTML = `
            <div class="experience-header">
                <input type="text" class="job-title" placeholder="Job Title" name="job_title[]">
                <input type="text" class="company" placeholder="Company Name" name="company_name[]">
                <input type="text" class="location" placeholder="Location" name="company_location[]">
                <input type="text" class="dates" placeholder="Dates of Employment" name="emp_date[]">
                <button class="delete-experience-btn">Delete</button>
            </div>
           
            `;

                        experienceContainer.appendChild(experienceDiv);

                        const deleteExperienceBtns = document.querySelectorAll('.delete-experience-btn');
                        deleteExperienceBtns.forEach(btn => {
                            btn.addEventListener('click', function () {
                                experienceDiv.remove();
                            });
                        });
                    }
                });

            </script>


            <section class="education">
                <h2>Education</h2>
                <div id="education-container">
                    <!-- Education entries will be dynamically added here -->
                </div>
                <button id="add-education-btn">Add Education</button>
            </section>
            <script>document.addEventListener('DOMContentLoaded', function () {
                    const addEducationBtn = document.getElementById('add-education-btn');
                    const educationContainer = document.getElementById('education-container');

                    addEducationBtn.addEventListener('click', function () {
                        event.preventDefault();
                        addEducationInput();
                    });

                    function addEducationInput() {
                        const educationDiv = document.createElement('div');
                        educationDiv.classList.add('education-entry');

                        educationDiv.innerHTML = `
            <div class="education-header">
                <input type="text" class="degree" placeholder="Degree" name="degree[]">
                <input type="text" class="institution" placeholder="Institution Name" name="institute[]">
                <input type="text" class="location" placeholder="Location" name="insti_location[]">
                <input type="text" class="graduation-year" placeholder="Graduation Year" name="pass_year[]">
                <button class="delete-education-btn">Delete</button>
            </div>
            `;

                        educationContainer.appendChild(educationDiv);

                        const deleteEducationBtns = document.querySelectorAll('.delete-education-btn');
                        deleteEducationBtns.forEach(btn => {
                            btn.addEventListener('click', function () {
                                educationDiv.remove();
                            });
                        });
                    }
                });
            </script>
            <section class="certifications">
                <h2>Certifications and Licenses</h2>
                <div id="certifications-container">
                    <!-- Certification entries will be dynamically added here -->
                </div>
                <button id="add-certification-btn">Add Certification or License</button>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const addCertificationBtn = document.getElementById('add-certification-btn');
                    const certificationsContainer = document.getElementById('certifications-container');

                    addCertificationBtn.addEventListener('click', function () {
                        event.preventDefault();
                        addCertificationInput();
                    });

                    function addCertificationInput() {
                        const certificationDiv = document.createElement('div');
                        certificationDiv.classList.add('certification-entry');

                        certificationDiv.innerHTML = `
            <div class="certification-header">
                <input type="text" class="certification-name" placeholder="Certification Name" name="certi_name[]">
                <input type="text" class="issuing-organization" placeholder="Issuing Organization" name="org_name[]">
                <input type="text" class="date-of-certification" placeholder="Date of Certification" name="date_of_certi[]">
                <button class="delete-certification-btn">Delete</button>
            </div>
        `;

                        certificationsContainer.appendChild(certificationDiv);

                        const deleteCertificationBtns = document.querySelectorAll('.delete-certification-btn');
                        deleteCertificationBtns.forEach(btn => {
                            btn.addEventListener('click', function () {
                                certificationDiv.remove();
                            });
                        });
                    }
                });

            </script>

            <section class="projects">
                <h2>Projects or Portfolio</h2>
                <div id="projects-container">
                    <!-- Project entries will be dynamically added here -->
                </div>
                <button id="add-project-btn">Add Project or Portfolio Piece</button>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const addProjectBtn = document.getElementById('add-project-btn');
                    const projectsContainer = document.getElementById('projects-container');

                    addProjectBtn.addEventListener('click', function () {
                        event.preventDefault();
                        addProjectInput();
                    });

                    function addProjectInput() {
                        const projectDiv = document.createElement('div');
                        projectDiv.classList.add('project-entry');

                        projectDiv.innerHTML = `
            <div class="project-header">
                <input type="text" class="project-name" placeholder="Project Name" name="project_name[]">
                <textarea class="description" placeholder="Description" name="description[]"></textarea>
                <input type="text" class="technologies-used" placeholder="Technologies Used" name="techno[]">
                <input type="text" class="portfolio-link" placeholder="Link to Portfolio (if available)" name="project_link[]">
                <button class="delete-project-btn">Delete</button>
            </div>
        `;
      

                        projectsContainer.appendChild(projectDiv);

                        const deleteProjectBtns = document.querySelectorAll('.delete-project-btn');
                        deleteProjectBtns.forEach(btn => {
                            btn.addEventListener('click', function () {
                                projectDiv.remove();
                            });
                        });
                    }
                });

            </script>

           
            <section class="languages">
                <h2>Languages (Optional)</h2>
                <div id="languages-container">
                    <!-- Language entries will be dynamically added here -->
                </div>
                <button id="add-language-btn">Add Language</button>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
    const addLanguageBtn = document.getElementById('add-language-btn');
    const languagesContainer = document.getElementById('languages-container');

    addLanguageBtn.addEventListener('click', function() {
        event.preventDefault();
        addLanguageInput();
    });

    function addLanguageInput() {
        const languageDiv = document.createElement('div');
        languageDiv.classList.add('language-entry');

        languageDiv.innerHTML = `
            <div class="language-header">
                <input type="text" class="language-name" placeholder="Language Name" name="lang_name[]">
                <select class="proficiency-level" name="level_name[]">
                    <option value="Fluent">Fluent</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Beginner">Beginner</option>
                </select>
                <button class="delete-language-btn">Delete</button>
            </div>
        `;

        languagesContainer.appendChild(languageDiv);

        const deleteLanguageBtns = document.querySelectorAll('.delete-language-btn');
        deleteLanguageBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                languageDiv.remove();
            });
        });
    }
});

            </script>

<section class="interests-hobbies">
    <h2>Interests and Hobbies (Optional)</h2>
    <div id="interests-hobbies-container">
        <!-- Interests and hobbies entries will be dynamically added here -->
    </div>
    <button id="add-interest-hobby-btn">Add Interest or Hobby</button>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const addInterestHobbyBtn = document.getElementById('add-interest-hobby-btn');
    const interestsHobbiesContainer = document.getElementById('interests-hobbies-container');

    addInterestHobbyBtn.addEventListener('click', function() {
        event.preventDefault();
        addInterestHobbyInput();
    });

    function addInterestHobbyInput() {
        const interestHobbyDiv = document.createElement('div');
        interestHobbyDiv.classList.add('interest-hobby-entry');

        interestHobbyDiv.innerHTML = `
            <div class="interest-hobby-header">
                <textarea class="interest-hobby-description" placeholder="Brief description of interest or hobby" name="hobbies[]"></textarea>
                <button class="delete-interest-hobby-btn">Delete</button>
            </div>
        `;

        interestsHobbiesContainer.appendChild(interestHobbyDiv);

        const deleteInterestHobbyBtns = document.querySelectorAll('.delete-interest-hobby-btn');
        deleteInterestHobbyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                interestHobbyDiv.remove();
            });
        });
    }
});

</script>
            <div class="input-container">
                <h5 style="color:white">First use save button to save your data before check your resume *</h5>
                <button type="submit" class="submit-button" name="save" >Save</button> 
                <br>
                <br>

                 </div>
            
        </section>
        </form>
        <form action="" method="post">
        <button type="submit" class="submit-button" name="generate_pdf" >Check Your Resume</button>
           
        </form>
    </div>
</body>

</html>
