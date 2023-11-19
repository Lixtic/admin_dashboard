<?php
session_start();
include 'connect.php';
$success_message = $error_message = "";
$firstname = ""; 
$userrole = "";

    // Fetch job listings from the database
    $query = "SELECT * FROM job_post";
    $result = $conn->query($query); 
    
        // select user from datdabase
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    // echo "<p id='welcome-message'>Welcome, $email</p>";
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    
        // lets prepare a statement to avoid SQL injection
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Access the user data using $row
                $firstname = $row['firstname'];
                $lastname = $row['lastname']; 
                $userrole = $row['role'];
                $profilePicture = $row['profile_picture'];

            }

            if ($userrole !== "Admin" || empty($userrole)) {
                session_destroy(); 
                header("Location: login.php"); 
                exit();
            }
        } else {
            // session_start(); // Start the session

// Assuming $userrole holds the role fetched from the database
           

        }
    
        $stmt->close();
    } else {
  
    }
                // Query to count all from database
            $queryCountUsers = "SELECT COUNT(*) AS total_users FROM users";
            $queryCountJobs=" SELECT COUNT(*) AS total_jobs FROM job_post";


            // Execute the query to count users
            $resultCount = $conn->query($queryCountUsers);
            $resultCountJobs = $conn->query($queryCountJobs);

            if ($resultCount) {
                // Fetch the count
                $rowCount = $resultCount->fetch_assoc();
                $totalUsers = $rowCount['total_users'];

                
            } else {
                // Handle query execution failure
                echo "Error: ";
            } 
            if ($resultCountJobs) {
                // Fetch the count
                $rowCountJobs = $resultCountJobs->fetch_assoc();
                $totalJobs = $rowCountJobs['total_jobs'];
            
                // Display the count
                // echo "Total posted jobs: " . $totalJobs;
            } else {
                // Handle query execution failure
                echo "Error: ";
            }

    

// variables to store form data and  handle job submission when the form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST["job_title"];
    $job_description = $_POST["job_description"];
    $location =$_POST["location"];
    $qualification =$_POST["qualification"];
    $salary =$_POST["salary"];
    $deadline =$_POST["deadline"];
    $start_date =$_POST["start_date"];
    $websites =$_POST["websites"];

    // lets insert the job listing data into our database.

    $query = "INSERT INTO job_post (job_title, location, qualification,salary, deadline,start_date, job_description, websites) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $job_title, $location, $qualification,$salary,$deadline,$start_date, $job_description, $websites);
    
    if ($stmt->execute()) {
        $success_message = "Job listing added successfully.";
    } else {
        $error_message = "Failed to add the job listing.";
    }

}


// Fetch top 5 latest job listings from the database
$query = "SELECT * FROM job_post ORDER BY start_date DESC LIMIT 5";
$result = $conn->query($query);

// Initialize variables for each job
$job_one = $job_two = $job_three = $job_four = $job_five = $job_six = null;

// Counter to track the job number
$counter = 1;

// Display job listings and assign to variables
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $jobTitle = $row['job_title'];
        $jobDescription = $row['job_description'];
        $location = $row['location'];
        $qualification = $row['qualification'];
        $salary = $row['salary'];
        $startDate = $row['start_date'];
        $deadline = $row['deadline'];
        $websites = $row['websites'];

        
        switch ($counter) {
            case 1:
                $job_one = [
                    'title' => $jobTitle,
                    'description' => $jobDescription,
                    'location' => $location,
                    'qualification' => $qualification,
                    'salary' => $salary,
                    'start_date' => $startDate,
                    'deadline' => $deadline,
                    'websites' => $websites
                ];
                break;
            case 2:
                $job_two = [
                    'title' => $jobTitle,
                    'description' => $jobDescription,
                    'location' => $location,
                    'qualification' => $qualification,
                    'salary' => $salary,
                    'start_date' => $startDate,
                    'deadline' => $deadline,
                    'websites' => $websites

                ];
                break;
           case 3:
            $job_three = [
                'title'=> $jobTitle,
                'description'=> $jobDescription,
                'location'=> $location,
                'qualification'=> $qualification,
                'salary' => $salary,
                 'start_date' => $startDate,
                'deadline' => $deadline,
                'websites' => $websites
            ];
            break;
            case 4:
                $job_four = [
                    'title'=> $jobTitle,
                    'description'=> $jobDescription,
                    'location'=> $location,
                    'qualification'=> $qualification,
                    'salary' => $salary,
                    'start_date' => $startDate,
                    'deadline' => $deadline,
                    'websites' => $websites
                    ];
                    break;
            case 5:
                $job_five = [
                    'title'=> $jobTitle,
                    'description'=> $jobDescription,
                    'location'=> $location,
                    'qualification'=> $qualification,
                    'salary'=> $salary,
                    'start_date'=> $startDate,
                    'deadline'=> $deadline,
                    'websites' => $websites
                    ];
                    break;
            
                    

        }

        // Increment the counter
        $counter++;
    }
} else {
    echo "<p>No job listings available.</p>";
}







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Post Job - Yeafah Healthcare</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

    <?php
    if (!empty($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    } elseif (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
        <!-- sidebar menu -->
        <input type="checkbox" id="nav-toggle" >
         <div class="sidebar">
        <div class="sidebar-brand">
        <h2>
            <span class="las la-heartbeat">
                <!-- <img src="yeafah-logo-gif.png" width="100" height="50" alt="logo"> -->
            </span><span>Yeafah Healthcare</span>
        </h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="#" class="active"><span class="las la-igloo"></span><span>Dashboard</span></a>
                </li>
                <li>
                    <a href="#">   <span class="las la-users"></span><span>Registered Users</span></a>
                </li>
                <li>
                    <a href="#"><span class="las la-users"></span><span>Applied Users</span></a>
                </li>
                <li>
                    <a href="#"><span class="las la-pen-alt"></span><span>New Job Post</span></a>
                </li>
                <li>
                    <a href="#"><span class="las la-history"></span><span>View Job Post</span></a>
                </li>
                
            </ul>
        </div>
        </div>
        <div class="main-content">
            <header>
            <h2>
                <!-- nav-bar-toggle label linked to a checkbox -->
            <label for="nav-toggle">
                    <span  class="las la-bars"></span>
                </label>
                Dashboard
            </h2>

            <div class="search-wrapper">
                <span class="las la-search" >
                    <input type="search" placeholder="search here"/>
                </span>
            </div>

            <div class="user-wrapper">

                <!-- user profile picture is retrieved as binary -->
                <img src="data:image/*;base64,  <?php echo base64_encode($profilePicture); ?> " width ="30px" height="30px" alt="Profile Picture">
                
                <div>

                    <!-- <h4>Username</h4> -->
                    <h4>
                    <?php
                     echo htmlspecialchars($firstname) ;
                    ?>  
                    </h4>
                        <small>
                        <?php
                        echo htmlspecialchars($userrole) ;
                        ?>  
                        </small>
                    <small>
                        <p><a href="logout.php">Logout</a></p>
                    </small>
                    
                </div>
            </div>
            </header>

        <main>
            <div class="cards">
                <div class="cards-single">
                <div>
                    <h1>
                    <?php
                     echo  htmlspecialchars($totalUsers) ;
                    ?> 
                   
                    </h1>
                    <span>Registered Users</span>
                </div>
                <div>
                    <span class= "las la-users"></span>
                </div>
            </div>
            <div class="cards-single">
                <div>
                    <h1>0</h1>
                    <span>Applied Users</span>
                </div>
                <div>
                    <span class= "las la-users"></span>
                </div>
            </div>
            <div class="cards-single">
                <div>
                    <h1>
                    <?php
                     echo  htmlspecialchars($totalJobs) ;
                    ?> 
                    </h1>
                    <span>Jobs </span>
                </div>
                <div>
                    <span class= "las la-pen-alt"></span>
                </div>
            </div>
            <div class="cards-single">
                <div>
                    <h1>$10k</h1>
                    <span>Revenue </span>
                </div>
                <div>
                    <span class= "las la-funnel-dollar"></span>
                </div>
            </div>
        </div>

        <div class="recent-grid">

            <div class="jobs">
                <div class="card">
                    <div class="card-header">
                    <h2>Post New Jobs</h2>
                    <button type="submit">Update<span class="las la-arrow-right" ></span></button>
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                       <table width = "100%" >
                            <thead>
                                <tr>
                                    <td>Job Details</td>
                                     </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    <form method="POST">
                                        <div   class="input-box">
                                        <label for="job_title">Job Title:</label>
                                        <input type="text" name="job_title" required>
                                        </div>
                                        <div   class="input-box">
                                        <label for="location">Location: </label>
                                        <input type="text" name="location" required>
                                        </div>
                                        <div   class="input-box">
                                        <label for="qualification">Qualification: </label>
                                        <input type="text" name="qualification" required>
                                        </div>
                                        <div   class="input-box">
                                        <label for="salary">Salary: </label>
                                        <input type="text" name="salary" >
                                        </div>
                                        <div   class="input-box">
                                        <label for="start_date">Start Date: </label>
                                        <input type="Date" name="start_date" required>
                                        </div>
                                        <div   class="input-box">
                                        <label for="deadline">Deadline: </label>
                                        <input type="Date" name="deadline" required>
                                        </div>
                                        <div   class="input-box">
                                        <label for="deadline">Website: </label>
                                        <input type="text" name="websites" required>
                                        </div>
                                        <div    class="input-box">
                                        <label for="job_description">Job Description:</label>
                                        <textarea name="job_description" required></textarea>
                                        </div>
                                        <div >
                                        <button type="submit">Submit Job Listing</button>
                                        <button id="view-listings">View Listings</button>
                                        </div>
                                            <script >
                                            document.getElementById("view-listings").addEventListener("click", function() {
                                                window.location.href = "posted_jobs.php"; 
                                            });
                                        </script>
                                    </form>     
                                    </td>
                                </tr>                     
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
            </div>
       
            <div class="user-grid">
                <div class="card">
            <div class="card-header">
                <h3>New Users</h3>
                <button>See all <span class="las la-arrow-right" ></span> </button>
            </div>
            <div class="card-body">
                <div class="user">
                    <div class="info" >
                    <img src="img/nurseguy.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Akon Ray</h4>
                            <small> Nurse Administrator</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>

                <div class="user">
                    <div class="info">
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Lydia Ampomaa</h4>
                            <small>Certified Nurse Midwife (CNM)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div   class="info"  >
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Grace Sam</h4>
                            <small>Nurse Practitioner (NP)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div class="info" >
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Jacob Mpadi</h4>
                            <small>Nurse Practitioner(NP)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div class="info" >
                    <img src="img/nurse2.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Belinda Osei-Tutu</h4>
                            <small>Nurse Educator</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
        <div class="recent-grid">

            <div class="jobs">
                <div class="card">
                    <div class="card-header">
                    <h2>Recent Jobs</h2>
                    <button>See all <span class="las la-arrow-right" ></span></button>
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                       <table width = "100%" >
                            <thead>
                                <tr>
                                    <td>Job Title</td>
                                    <td>Applied Users</td>
                                    <td>Application Status</td>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- Nurse Practitioner (NP) -->
                                        <?php
                                             echo htmlspecialchars( $job_one['title'] ) ; 
                                             
                                         ?>  
                                    </td>
                                    <td>0 Applicants </td>
                                    <td>
                                        <span class="status purple" ></span>
                                        Under review
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                    <?php
                                             echo htmlspecialchars( $job_two['title'] ) ; 
                                             
                                         ?> 
                                    </td>
                                    <td>0 Applicants </td>
                                    <td>
                                        <span class="status pink" ></span>
                                        in progress
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                    <?php
                                             echo htmlspecialchars( $job_three['title'] ) ; 
                                             
                                         ?>
                                    </td>
                                    <td>0 Applicants </td>
                                    <td>
                                        <span class="status orange" ></span>
                                         pending
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <!-- Nurse Practitioner (NP) -->
                                        <?php
                                             echo htmlspecialchars( $job_four['title'] ) ; 
                                             
                                         ?>  
                                    </td>
                                    <td>0 Applicants </td>
                                    <td>
                                        <span class="status purple" ></span>
                                        Under review
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                    <?php
                                             echo htmlspecialchars( $job_five['title'] ) ; 
                                         ?> 
                                    </td>
                                    <td>0 Applicants </td>
                                    <td>
                                        <span class="status pink" ></span>
                                        in progress
                                    </td>

                               
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
            </div>
       
            <div class="user-grid">
                <div class="card">
            <div class="card-header">
                <h3>New Users</h3>
                <button>See all <span class="las la-arrow-right" ></span> </button>
            </div>
            <div class="card-body">
                <div class="user">
                    <div class="info" >
                    <img src="img/nurseguy.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Akon Ray</h4>
                            <small> Nurse Administrator</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>

                <div class="user">
                    <div class="info">
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Lydia Ampomaa</h4>
                            <small>Certified Nurse Midwife (CNM)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div   class="info"  >
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Grace Sam</h4>
                            <small>Nurse Practitioner (NP)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div class="info" >
                    <img src="img/nurse.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Jacob Mpadi</h4>
                            <small>Nurse Practitioner(NP)</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
                <div class="user">
                    <div class="info" >
                    <img src="img/nurse2.png" width="40px" height="40px" alt="">
                        <div>
                            <h4>Belinda Osei-Tutu</h4>
                            <small>Nurse Educator</small>
                        </div>
                    </div>
                    <div class="contact" >
                        <span class="las la-user-circle" ></span>
                        <span class="las la-comment" ></span>
                        <span class="las la-phone" ></span>

                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

     </main>
</div>

        
      <div class="form-box">
        <h2>Post a New Job</h2>
    <form method="POST">
        <div   class="input-box">
        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" required>
        </div>
        <div   class="input-box">
        <label for="location">Location: </label>
        <input type="text" name="location" required>
        </div>
        <div   class="input-box">
        <label for="qualification">Qualification: </label>
        <input type="text" name="qualification" required>
        </div>
        <div   class="input-box">
        <label for="salary">Salary: </label>
        <input type="text" name="salary" >
        </div>
        <div   class="input-box">
        <label for="start_date">Start Date: </label>
        <input type="Date" name="start_date" required>
        </div>
        <div   class="input-box">
         <label for="deadline">Deadline: </label>
        <input type="Date" name="deadline" required>
        </div>
        <div    class="input-box">
        <label for="job_description">Job Description:</label>
        <textarea name="job_description" required></textarea>
        </div>
        <div >
        <button type="submit">Submit Job Listing</button>
        <button id="view-listings">View Listings</button>
        </div>
             <script >
            document.getElementById("view-listings").addEventListener("click", function() {
                window.location.href = "posted_jobs.php"; 
            });
        </script>
    
        
    </form>
         </div>
  
             <div class="right-panel">

             </div>
    
             <div class="posted-jobs">
                <h2>Available Job Listings</h2>
                <ul>
                   
                </ul>
            </div>

        <style>
            :root{
                /* Yeafah Brand Colours */
                --main-color: #043b5c;
                --color-dark: #1d2231;
                --text-grey: #8390a2;
                --five-percent: #F2F5F7;
                --seventhyfive-percent: #e5ebee;
            }
        
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            list-style-type: none;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            
        }
        .sidebar
             {
            width: 345px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background-color: var(--main-color);
            z-index: 100;
            transition: width 300ms ;
        }
        .sidebar-brand{
            height: 90px;
            padding: 1rem 0rem 1rem 2rem;
            color: #fff;
        }
        .sidebar-menu{
            margin-top: 1rem;
        }
       

        .sidebar-brand span{
            display: inline-block;
            padding-right: 1rem ;
        }
        .sidebar-menu li{
            width: 100%;
            margin-bottom: 1.3rem;
            padding-left: 2rem;

        }
        .sidebar-menu a{
            display: block;
            color: #fff;
            font-size: 1rem;
        }
        .sidebar-menu a.active{
            background: #fff;
            padding-top: 1rem;
            padding-bottom: 1rem;
            color: var(---main-color);
            border-radius: 30px 0px 0px 30px ;
        }
        .sidebar-menu a span:first-child{
            font-size: 1.5rem;
            padding-right: 1rem;
            padding-left: 1rem;
        }
        form{
            display: table;
        }
        form input{
            width:  100%;
            padding: 1rem;
            margin: 10px 0px;
            border: none;
            border-bottom: 2px solid #8390a2  ;
            border-radius: 4px;
        }

        /* TOGGLES */
       #nav-toggle:checked +.sidebar{
        width: 70px;
       }
       /* this toggle aligns the first children */
       #nav-toggle:checked +.sidebar .sidebar-brand ,
       #nav-toggle:checked +.sidebar li   {
        padding-left: .1rem;
        /* padding-right: .1rem; */
        text-align: center;
       }
       #nav-toggle:checked +.sidebar li a{
        padding-left: 0rem;
        
       }

       /* On toggle ,hides all the last children */
       #nav-toggle:checked +.sidebar .sidebar-brand h2 span:last-child,
       #nav-toggle:checked +.sidebar li a span:last-child {
        display: none;

       }
       #nav-toggle:checked ~.main-content{
        margin-left: 70px;
       }
       #nav-toggle:checked ~.main-content{
       width: calc(100%-70px);
       left: 70px;
       }

       .main-content{
        transition: margin-left 300ms ;
        margin-left: 345px;

       }

        

        /* header and navbar */
        header{
            position: sticky;
            background: #fff;
            display: flex;
            justify-content: space-between;
            padding: 1rem 2.1rem;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            left: 345px;
            width: calc(100% -345px);
            top: 0;
            z-index: 100;
            transition: left 300ms;
            
        }
        #nav-toggle{
            display: none;
        }

        header h2{
            color: #222;
        }
        header label span{
            font-size: 1.7rem;
            padding-right: 1rem;
        }

        .search-wrapper{
            border: 1px solid #ccc;
            border-radius: 30px;
            height: 50px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .search-wrapper span{
            display: inline-block;
            padding: 0rem 1rem;
            font-size: 1-2rem;
        }
        .search-wrapper input{
            height: 100%;
            padding: 5rem;
            border: none;
            outline: none;
        }
        .user-wrapper{
            display: flex;
            align-items: center;

        }
        .user-wrapper img{
            border-radius:50% ;
            margin-right: 1rem;
        }
        .user-wrapper small{
            display: inline-block;
            color: var(--text-grey);

        }
        .user-wrapper small p a {
            color: var(--text-grey);
        }
        .user-wrapper small p a:hover {
            color: var(--color-dark);
        }

        main{
            margin-top: 55px;
            padding: 2rem 1.5rem;
            background: #f1f5f9;
            min-height: calc(100vh - 90px);

        }
        .cards{
            display: grid;
            grid-template-columns: repeat(4,1fr);
            grid-gap: 2rem;
            margin-top: 1rem;

        }
        .cards-single{
            display: flex;
            justify-content: space-between;
            background: #fff;
            padding: 2rem;
            border-radius: 2px;
        }
        .cards-single :last-child span{
            font-size: 3rem;
            color: var(--main-color);
        }
        .cards-single div:first-child span{
            color: var(--text-grey);
        }
            
        .cards-single:last-child{
           
            background: var(--main-color);
        }
        .cards-single:last-child h1,
        .cards-single:last-child div:first-child span,
        .cards-single:last-child div:last-child span{
            color: #fff;
        }
        /* recent grids */
        .recent-grid{
            margin-top: 3.5rem;
            display: grid;
            grid-gap: 2rem;
            grid-template-columns: 62% auto;
        }
        .card{
            background: #fff;
            border-radius: 10px;
        }
        .card-header,
        .card-body{
            padding: 1rem;
        }
        .card-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .card-header button{
            background: var(--main-color);
            border-radius: 10px;
            color: #fff;
            font-size: .8rem;
            padding: .5rem 1rem;
            border: 1px solid var(--main-color);
        }


        table{
            border-collapse: collapse;
        }

        thead tr{
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
        }
       thead td{
        font-weight: 700;
       }
       td{
        padding: 2rem 1rem;
        font-size: .9rem;
      
       }
       
       td .status{
        display: inline-block;
        height:15px ;
        width: 15px;
        border-radius: 50%;
        margin-right: 1rem ;

       }
       tr td:last-child{
        display: flex;
        align-items: center;
        
       }
       .status.purple{
        background: rebeccapurple;
       }
       .status.pink{
        background: deeppink;
       }
       .status.orange{
        background: orangered;
       }


       .table-responsive{
        width: 100%;
        overflow-x: auto ;
       }
       /* user and info */
       .user{
        display:flex ;
        justify-content: space-between;
        align-items: center;
        padding: 1rem .6rem;

       }
       .info{
        display: flex;
        align-items: center;
       }
       .info img{
        border-radius: 50%;
        margin-right: 1rem;
       }
       .info h4{
        font-size: .8rem;
        font-weight: 700;
        color: #222;
       }
       .info small{
        font-weight:550 ;
        color: var(--text-grey);
       }
       .contact small{
        font-size: 1.2rem;
       }
       .contact span{
        font-size: 1.2rem;
        display: inline-block;
        margin-left: 1rem;
        color: var(--main-color);

       }



        .right-panel{
                display: none;
            }
        .form-box
             {
                position: relative;
                width: 100%;
                padding: 50px;
                display: none;
            }


            /* The responsive part */
            @media (max-width: 1200px) {
    /* TOGGLES */
    .sidebar {
        width: 70px;
    }

    /* Aligns the first children */
    .sidebar .sidebar-brand,
    .sidebar li {
        padding-left: 0.1rem;
        text-align: center;
    }

    .sidebar li a {
        padding-left: 0rem;
    }

    /* On toggle, hides all the last children */
    .sidebar .sidebar-brand h2 span:last-child,
    .sidebar li a span:last-child {
        display: none;
    }

    .main-content {
        margin-left: 70px;
    }

    .main-content header {
        width: calc(100% - 70px);
        left: 70px;
    }

    
}
            /* Tablet screens */
            @media only screen and (max-width:960px){
                .cards{
                    grid-template-columns: repeat(3, 1fr) ;
                }
                .recent-grid{
                    grid-template-columns:60% 40%;
                }
            }
                /* Mobile Devices */
            @media only screen and (max-width:768px){
                .cards{
                    grid-template-columns: repeat(2, 1fr) ;
                }
                .recent-grid{
                    grid-template-columns:100%;
                }
                .search-wrapper{
                    display: none;
                }
                .sidebar{
                    left: -100% !important;
                }
                header h2 label{
                    display: inline-block;
                  
                    background: var(--main-color);
                    padding-right: 0rem ;
                    margin-right: 1rem;
                    height: 40px;
                    width: 40px;
                    border-radius: 50%;
                    color: #fff;
                    display: flex;
                    align-items: center;
                    justify-content: center !important;
                }
                header h2 span{
                   
                    text-align: center;
                    padding-right: 0rem;
                   
                }
                header h2 {
                    font-size: 1.1rem;
                }

                .main-content{
                    width: 100%;
                    margin-left: 0rem;
                }
                header{
                    left: 0 !important;
                    width: 100% !important;
                    z-index: 200;
                }
                #nav-toggle:checked + header{
                    border-radius: 30  0 0 30 ;
                }

                #nav-toggle:checked + .sidebar {
                    left: 0 !important;
                    /* z-index: 100; */
                    width: 345px;
                    position: fixed;

                }
                #nav-toggle:checked +.sidebar .sidebar-brand,
                #nav-toggle:checked +.sidebar li 
                 {
                    padding-left: 2.1rem;
                        text-align: left;
                    }
                    #nav-toggle:checked +.sidebar li a {
                        padding-left: 1rem;
                    }

                    #nav-toggle:checked + .sidebar .sidebar-brand h2 span:last-child,
                    #nav-toggle:checked +.sidebar li a span:last-child {
                        display: inline;
                    }

                    #nav-toggle:checked ~ .main{
                        margin-left: 0rem !important;
                    }

            }
            @media only screen and (max-width:560px){
                .cards{
                    grid-template-columns: 100% ;
                }
            
            }

            



            </style>

</body>
</html>
