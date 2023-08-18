# contact_form
This is a simple contact form and I have used XAMPP server. 
I have also used a mailer system using core php only which will send a email to the owner of the beauty saloon.
The owner is having the email id : suchintachanda@gmail.com. So in our case we are sending the email to the owner and also in the index.php we are using
                $headers  = 'From: '.$email . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';
            
Here $email is the email_id of the person raising the Query and we are fetching the detail from the person during the submission of the form.

### We need to keep in mind that since in the local we are using XAMPP server we need to make some critical changes in the following files too for marking the mailer work perfectly
#### In php.ini 
Find the [mail function]
[mail function]
SMTP = smtp.gmail.com
smtp_port = 587
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

#### In sendmail.ini. It is usually located in the C:\xampp\sendmail if the XAMPP installed in the C: Drive.

N.B. -> we are not setting any sendmail_from as we want the send the email id of the Query raiser directly to the owner.

## Configure the Database 
To configure the Database first we need to create the database. In my case I created the database with name contact_form and inside it I created the table contact_form
You can simply run the below query to create the table 
CREATE TABLE contact_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(2000) NOT NULL,
    message TEXT NOT NULL,
    user_ip VARCHAR(45) NOT NULL,
    timestamp DATETIME NOT NULL
);


