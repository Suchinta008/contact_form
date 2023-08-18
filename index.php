<?php 
$conn = new mysqli('localhost', 'root', '', 'contact_form');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
};
$msg=[];

if (isset($_POST['submit'])) {
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$userIP = $_SERVER['REMOTE_ADDR'];
$timestamp = date('Y-m-d H:i:s');
    if (!isset($name) || empty($name) || strlen($name)<2 || strlen($name)>50 ) {
        $msg['name'] = 'Please enter valid name with minimum 2 characters and maximum of 50 characters';
    }
        elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $msg['name'] = 'Only alphabets and white spaces are allowed in the name.';
    }
    if (!isset($number) || empty($number)||(strlen($number) !== 10) ) {
        $msg['number'] = "Please enter valid 10 digit phone number.";
    }
        elseif (!preg_match("/^\d+$/", $number)) {
        $msg['number'] = "Please enter a valid phone number.";
    }
    if (!isset($email) || empty($email)) {
        $msg['email'] = "Email is required.";
    } 
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg['email'] = "Email is not valid.";
    }
    if (!isset($subject) || empty($subject)|| strlen($subject)<5 || strlen($subject)>50){
        $msg['subject'] = "Please enter valid subject with minimum 5 characters and maximum of 50 characters";
    }
    elseif (!preg_match("/^[a-zA-Z\s]+$/", $subject)) {
        $msg['subject'] = 'Only alphabets and white spaces are allowed in the name.';
    }
    if (!isset($message) || empty($message)|| strlen($message)<5 ||strlen($message)>5000) {
        $msg['message'] = "Please enter valid message with minimum 5 characters and maximum of 5000 characters";
    }
// Sending Notification to the Owner Email from the comp
    $to = 'suchintachanda@gmail.com';
    $subject_mail  = $subject;
    $message_mail  = $message;
    $headers  = 'From: '.$email . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';
    $mailBody = "Name: $name <br> Email: $email <br> Message: $message_mail";

    if (empty($msg) && mail($to, $subject_mail, $mailBody, $headers)) {
        $sql = "INSERT INTO contact_form (full_name, phone_number, email, subject, message, user_ip, timestamp) VALUES ('$name','$number','$email','$subject','$message','$userIP','$timestamp')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?success=1");
            exit();
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;}
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    

    <div class="container mt-5">
      <span class="text-primary h2 mb-5">Contact Form</span>
      <div class="mb-2"></div>
        <?php
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<p class='text-success'>Form submitted successfully!</p>";
                echo '<meta http-equiv="refresh" content="1.5;url=index.php">';
            }
        ?>
        <form id="contactForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  autocomplete="off">
            <div class="form-group">
              <label for="fullName" class="text-danger h5">* Full Name:</label>
              <input type="text" name="name" class="form-control" id="fullName" placeholder="Enter your full name"  value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
              <span class="text-danger"><?php if(isset($msg['name'])): ?><p><?php echo $msg['name']; ?><?php endif; ?></span>
            </div>
          <div class="form-group" >
              <label for="phoneNumber" class="text-danger h5">* Phone Number:</label>
              <input type="tel" name="number" class="form-control" id="phoneNumber" placeholder="Enter your phone number" value="<?php echo isset($number) ? htmlspecialchars($number) : ''; ?>">
              <span class="text-danger"><?php if(isset($msg['number'])): ?><p><?php echo $msg['number']; ?><?php endif; ?></span>
            </div>
          <div class="form-group">
              <label for="email" class="text-danger h5">* Email:</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
              <span class="text-danger"><?php if(isset($msg['email'])): ?><p><?php echo $msg['email']; ?><?php endif; ?></span>
            </div>
          <div class="form-group">
              <label for="subject" class="text-danger h5">* Subject:</label>
              <input type="text" name="subject" class="form-control" id="subject"  placeholder="Enter the subject" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
              <span class="text-danger"><?php if(isset($msg['subject'])): ?><p><?php echo $msg['subject']; ?><?php endif; ?></span>
            </div>
          <div class="form-group">
              <label for="message" class="text-danger h5">* Message:</label>
              <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
              <span class="text-danger"><?php if(isset($msg['message'])): ?><p><?php echo $msg['message']; ?><?php endif; ?></span><br>
              <span class="text-danger">All the * marked fields are required</span>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

