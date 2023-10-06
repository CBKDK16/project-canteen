<?php

require_once('login_system/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $feedback_text = $_POST["feedback_text"];
    
 
    $conn = mysqli_connect('localhost','root','','user_db')
    
    $sql = "INSERT INTO public_feedback (full_name, email, feedback_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $full_name, $email, $feedback_text);
    
    if ($stmt->execute()) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
 
    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jwaladevi Vidhya Mandir School</title>
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <style >
        
       
form {
    max-width: 300px; 
    margin: 0 auto;
    padding: 20px;
    background-color: #f7f7f7; 
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); 
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}

textarea {
    resize: vertical; 
}

input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 18px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

header, footer {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: #fff;
}


.hero {
    text-align: center;
    padding: 20px;
    background-color: #4CAF50; 
    color: #fff;
}

.scrolling-text {
    font-size: 18px;
    font-style: italic;
    animation: scrollText 10s linear infinite;
}

@keyframes scrollText {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-20px);
    }
}
     .image-container {
            display: flex;
             width: 2000%;
            height: 100%; 
        }

        .image-container img {
            max-width: 1000px;
            height: auto;
            margin: 0 10px; 
            object-fit: cover;
        }

    </style>
</head>
<body>
    <header>
        <h1>Welcome to Jwaladevi Vidhya Mandir School</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="Gallery.php">Gallery</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="login_system/login_form.php">Exam</a></li>
        </ul>
    </nav>
    <main>
        <section class="hero">
            <h2>Empowering Students for a Bright Future</h2>
            <marquee scrolldelay="100"><p>At Jwaladevi Vidhya Mandir School, we are committed to providing quality education.</p></marquee>
        </section>
    </main>
            <marquee behavior="scroll" direction="left" scrollamount="20" onmouseover="this.stop();" onmouseout="this.start();" style="background-color: #f2f2f2; background-image: url('image/background.jpg'); background-size: cover;">
                <div class="image-container">
                <img src="image/school.jpg" alt="Image 1">
                <img src="image/teacher.jpg" alt="Image 2">
                <img src="image/SLC.jpg" alt="Image 3">
            </div>
         </marquee>
        

    <h1>Feedback Form</h1>
    <form action="file.php" method="post">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="feedback_text">Feedback:</label>
        <textarea id="feedback_text" name="feedback_text" rows="4" required></textarea><br><br>
        
        <input type="submit" value="Submit Feedback">
    </form>
    <div class="map-container">
        
            <div class="map-text">
                <h2>Our School Location</h2>
                <p>Find us on the map below:</p>
            </div>
            
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3135.8098674994176!2d85.34730155277782!3d27.621135379111962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb172ae4716b8b%3A0xe6fcf0a22c14d453!2sJVM%20Secretary%20School!5e0!3m2!1sen!2snp!4v1695276886573!5m2!1sen!2snp" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    <footer>
        <p>&copy; 2023 Jwaladevi Vidhya Mandir School</p>
    </footer>

</body>
</html>
