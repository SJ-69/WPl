    <?php
    session_start(); 

    $host = 'localhost';
    $dbname = 'wpl';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['Name']);
        $email = htmlspecialchars($_POST['Email']);
        $subject = htmlspecialchars($_POST['Subject']);
        $message = htmlspecialchars($_POST['Message']);

    
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

    
        setcookie("name", $name, time() + (7 * 24 * 60 * 60), "/");
        setcookie("email", $email, time() + (7 * 24 * 60 * 60), "/");

    
        $sql = "INSERT INTO contactus (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "Message sent successfully!";
        }
    }
    ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Us</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            }

            body {
                background-color: #f5f6f7;
                color: #333;
            }

            h3 {
                color: #0070ba;
                font-size: 36px;
        
                margin-bottom: 16px;
            }

            .het-center {
                text-align: center;
            }

            .het-container {
                background-color: #ffffff;
                padding: 50px 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .het-light-grey {
                background-color: #f0f0f0;
            }

            .het-large {
                font-size: 24px;
            }

            .het-xxlarge {
                font-size: 30px;
            }

            .het-input,
            textarea {
                width: 60%;
                padding: 12px;
                margin: 10px 0;
                border-radius: 5px;
                border: 1px solid #ccc;
                background-color: #f9f9f9;
                color: #333;
                font-size: 16px;
            }

            .het-input:focus,
            textarea:focus {
                border: 2px solid #0070ba;
                outline: none;
            }

            .het-button {
                background-color: #0070ba;
                border: none;
                padding: 12px 20px;
                font-size: 18px;
                color: white;
                border-radius: 5px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
            }

            .het-button i {
                margin-right: 10px;
            }

            .het-button:hover {
                opacity: 0.9;
            }

            .het-margin-right {
                margin-right: 8px;
            }

            footer {
                background-color: #003b5c;
                padding: 30px 0;
                text-align: center;
                color: white;
            }

            .wrapper {
                display: flex;
                justify-content: center;
                gap: 20px;
            }

            .wrapper .button {
                text-decoration: none;
                background-color: #0070ba;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                gap: 10px;
                transition: background-color 0.3s;
            }

            .wrapper .button:hover {
                background-color: #005f8a;
            }

            .wrapper .button .icon {
                font-size: 20px;
            }

            footer p {
                margin-top: 20px;
                font-size: 14px;
            }

            footer a {
                text-decoration: none;
                color: white;
            }

            footer a:hover {
                color: #4caf50;
            }

            p {
                text-align: center;
                color: #333;
                font-size: 20px;
            }
        </style>
    </head>

    <body>
        <div class="het-container het-light-grey" style="padding:128px 16px" id="contact">
            <h3 class="het-center">CONTACT US</h3>
            <p class="het-center het-large">Let's get in touch. Send us a message:</p>
            <div style="margin-top:48px">
                <p><i class="fa fa-map-marker fa-fw het-xxlarge het-margin-right"></i>KJSCE, VIDYAVIHAR</p>
                <p><i class="fa fa-phone fa-fw het-xxlarge het-margin-right"></i> Phone: +022 21023456</p>
                <p><i class="fa fa-envelope fa-fw het-xxlarge het-margin-right"> </i> Email: <u>paypal@gmail.com</u></p>
                <br>

            <form action="" method="post">
                    <p><input class="het-input het-border" type="text" placeholder="Name" required name="Name"></p>
                    <p><input class="het-input het-border" type="email" placeholder="Email" required name="Email"></p>
                    <p><input class="het-input het-border" type="text" placeholder="Subject" required name="Subject"></p>
                    <p><textarea class="het-input het-border" placeholder="Message" required name="Message"></textarea></p>
                    <p>
                        <button class="het-button -black" type="submit">
                            <i class="fa fa-paper-plane"></i> SEND MESSAGE
                        </button>
                    </p>
            </form>
    </div>
        </div>
        <footer>
            <div class="wrapper">
                <a href="#" class="button">
                    <div class="icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <span>Facebook</span>
                </a>
                <a href="#" class="button">
                    <div class="icon">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <span>Twitter</span>
                </a>
                <a href="#" class="button">
                    <div class="icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <span>Instagram</span>
                </a>
                <a href="#" class="button">
                    <div class="icon">
                        <i class="fab fa-github"></i>
                    </div>
                    <span>Github</span>
                </a>
                <a href="#" class="button">
                    <div class="icon">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <span>YouTube</span>
                </a>
            </div>
          
        </footer>


        






    </body>
    </html>
