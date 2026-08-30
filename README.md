🎓 AWS Student Management Portal — LAMP Deployment

A simple cloud-hosted student management application developed with PHP and deployed on AWS. The web tier runs on an Ubuntu EC2 instance with Apache, while student records are maintained in an Amazon RDS MySQL database.

📌 Overview

This project demonstrates how a traditional PHP/MySQL application can be moved to an AWS environment.

The deployment separates the application server from the database:

EC2 — runs the web application

Apache — handles incoming HTTP requests

PHP — contains the application logic

RDS for MySQL — stores student information

VPC and Security Groups — provide network isolation and access control

🎯 Project Goals

The main goals of this project are to:

Deploy a PHP application on an Ubuntu EC2 server.

Configure Apache as the web server.

Connect the application to Amazon RDS.

Create and manage a MySQL database for student records.

Apply basic AWS networking and security practices.

Verify the complete application-to-database flow.

🧰 Technology Stack

Category

Technology

Cloud

Amazon Web Services

Compute

Amazon EC2

Operating System

Ubuntu Linux

Web Server

Apache2

Backend

PHP

Database

MySQL

Managed Database

Amazon RDS

Networking

Amazon VPC

Access Control

AWS Security Groups

Frontend

HTML, CSS

Database Access

SQL / MySQLi

☁️ AWS Components

Amazon EC2

The EC2 instance acts as the application server. Ubuntu, Apache, PHP, and the MySQL client are installed on this machine.

Amazon RDS

RDS hosts the MySQL database separately from the web server. This keeps persistent application data outside the EC2 instance.

Amazon VPC

The VPC provides the network in which the application and database resources communicate.

Security Groups

Security Groups determine which network connections are permitted. HTTP is available for the web application, SSH is restricted for administration, and database access is limited to the application server.

🏗️ System Architecture

                    INTERNET
                       |
                    HTTP :80
                       |
                       v
              +-------------------+
              |    Web Browser    |
              +---------+---------+
                        |
                        v
              +-------------------+
              |     EC2 Server    |
              |   Ubuntu Linux    |
              |      Apache       |
              |        PHP        |
              +---------+---------+
                        |
                  MySQL :3306
                        |
                        v
              +-------------------+
              |    Amazon RDS     |
              |      MySQL        |
              |                   |
              |    student_db     |
              |        |          |
              |     students      |
              +-------------------+

🔄 How the Application Works

The general request flow is:

User
  |
  v
Browser
  |
  v
EC2 / Apache
  |
  v
PHP Application
  |
  +------> index.php --------> Read student records
  |
  +------> add_student.php --> Submit new student
                    |
                    v
                  db.php
                    |
                    v
             Amazon RDS MySQL
                    |
                    v
              student_db
                    |
                    v
                students

When a visitor opens the portal, Apache receives the request and passes it to the PHP application. PHP uses the database connection defined in db.php to read or insert records in RDS.

🧩 Application Layers

1. Presentation Layer

The browser provides the user interface. Users can enter student information and view records.

2. Application Layer

PHP runs on the EC2 server. Apache receives HTTP traffic and serves the PHP pages.

Main application files:

index.php
add_student.php
db.php

3. Data Layer

Amazon RDS runs MySQL and stores the application's persistent student data.

student_db
└── students

📁 Repository Layout

aws-lamp-student-portal/
│
├── README.md
├── index.php
├── add_student.php
└── db.php

🖥️ EC2 Server Setup

The application server uses Ubuntu Linux.

Update packages

sudo apt update

Install Apache

sudo apt install apache2 -y

Start and enable the service:

sudo systemctl start apache2
sudo systemctl enable apache2

Check the service:

sudo systemctl status apache2

Install PHP

sudo apt install php libapache2-mod-php php-mysql -y

Verify the installation:

php -v

Install the MySQL Client

The client can be used from EC2 to verify connectivity with the RDS database.

sudo apt install mysql-client -y

🗄️ Database Configuration

The application uses a MySQL database named:

student_db

The main table is:

students

A suitable table definition is:

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Table Fields

Field

Type

Purpose

id

INT

Unique record identifier

name

VARCHAR(100)

Student name

email

VARCHAR(100)

Student email

phone

VARCHAR(20)

Contact number

course

VARCHAR(100)

Course name

created_at

TIMESTAMP

Time the record was created

🔌 Checking the RDS Connection

From the EC2 server, connect to RDS with:

mysql -h YOUR_RDS_ENDPOINT -P 3306 -u YOUR_DATABASE_USERNAME -p

After logging in:

USE student_db;
SHOW TABLES;
DESCRIBE students;
SELECT * FROM students;

🌐 Deploying the PHP Application

Apache's standard web directory is:

/var/www/html/

Place the application files there:

/var/www/html/index.php
/var/www/html/add_student.php
/var/www/html/db.php

For example:

sudo nano /var/www/html/index.php
sudo nano /var/www/html/add_student.php
sudo nano /var/www/html/db.php

Restart Apache after changes:

sudo systemctl restart apache2

🔗 PHP–MySQL Connection

The database connection is kept in db.php.

For the public GitHub repository, use placeholders rather than real credentials:

<?php

$host = "YOUR_RDS_ENDPOINT";
$username = "YOUR_DATABASE_USERNAME";
$password = "YOUR_DATABASE_PASSWORD";
$database = "student_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>

Configure the real values only on the deployed server or through a secure configuration mechanism.

👨‍🎓 Student Features

Add a Student

The student form collects:

Name

Email

Phone

Course

The insertion flow is:

Form
  |
  v
PHP
  |
  v
INSERT query
  |
  v
RDS MySQL
  |
  v
students table

View Students

index.php retrieves records from the database and displays them in a table.

Example query:

SELECT id, name, email, phone, course, created_at
FROM students
ORDER BY id DESC;

🎨 User Interface

The portal is designed to provide a straightforward student-record interface. Typical elements include:

Student Portal title

Add Student action

Student records table

Database/application status information

Responsive page layout

🔐 Network and Security Configuration

A basic deployment can use the following inbound rules:

Rule

Port

Source

Reason

HTTP

80

0.0.0.0/0

Public website access

SSH

22

Administrator IP

Server administration

For RDS, MySQL port 3306 should preferably accept traffic only from the EC2 application's Security Group.

Recommended approach

Internet
   |
   v
 EC2
   |
   | TCP 3306
   v
 RDS MySQL

The database should not be unnecessarily exposed directly to the public internet.

🔑 Protecting Credentials

Never commit sensitive information such as:

AWS access keys
AWS secret keys
Session tokens
Private SSH keys
.pem files
RDS passwords
Database passwords
API keys
IAM credentials

Also avoid committing a real database password inside db.php.

For a more secure deployment, credentials can be managed using AWS Secrets Manager or another secure configuration mechanism.

🌍 Accessing the Website

After deployment, the application can be reached using the EC2 instance's public IPv4 address:

http://YOUR_EC2_PUBLIC_IP

Do not permanently hard-code an environment-specific public IP in the repository.

For a production-style deployment, consider an Elastic IP and/or a domain name with HTTPS.

🧪 Testing Checklist

Apache

sudo systemctl status apache2

Expected state:

active (running)

PHP

php -v

RDS Connectivity

mysql -h YOUR_RDS_ENDPOINT -P 3306 -u YOUR_DATABASE_USERNAME -p

Database

USE student_db;

Tables

SHOW TABLES;

Expected table:

students

Stored Records

SELECT * FROM students;

Web Application

Open:

http://YOUR_EC2_PUBLIC_IP

Then submit a sample student through the form and confirm that the record appears in the database.

🚀 Deployment Sequence

1. Prepare AWS networking
        ↓
2. Launch Ubuntu EC2
        ↓
3. Configure EC2 Security Group
        ↓
4. Connect to the server
        ↓
5. Install Apache
        ↓
6. Install PHP
        ↓
7. Install MySQL client
        ↓
8. Create RDS MySQL
        ↓
9. Configure database Security Group
        ↓
10. Create student_db
        ↓
11. Create students table
        ↓
12. Configure the PHP database connection
        ↓
13. Copy application files to Apache
        ↓
14. Restart Apache
        ↓
15. Open the EC2 endpoint
        ↓
16. Add test student
        ↓
17. Confirm the record in RDS

✨ Current Capabilities

The current implementation demonstrates:

Student record creation

Student record listing

PHP-based backend

Apache web hosting

Ubuntu server deployment

MySQL data storage

Amazon RDS integration

EC2 hosting

VPC networking

Security Group configuration

Basic responsive UI

🔮 Possible Enhancements

The application can be expanded with:

CRUD Operations

Add edit and delete functionality for student records.

Search

Allow users to search by:

Name

Email

Course

Phone

Dashboard

Display useful statistics such as:

Total Students
Total Courses
Recently Added Records

Authentication

Add an administrator login and authorization system.

HTTPS

Place the application behind HTTPS using SSL/TLS.

Secrets Management

Move database credentials into AWS Secrets Manager.

Monitoring

Add monitoring for:

EC2 resource usage

Apache logs

Application logs

RDS metrics

Automated Deployment

A future version could use GitHub Actions or AWS deployment services to automate application releases.

🏭 Production-Oriented Architecture

A stronger production design could look like:

                    INTERNET
                       |
                       v
                 HTTPS :443
                       |
                       v
                Load Balancer
                       |
                       v
                   EC2 / App
                       |
                  MySQL :3306
                       |
                       v
                  Amazon RDS

Recommended improvements include:

HTTPS instead of plain HTTP

Restricted SSH access

IAM roles where appropriate

Secure secret storage

Private database networking

RDS backups

Application and infrastructure monitoring

Regular OS and package updates

Least-privilege Security Group rules

🧠 Skills Demonstrated

AWS

EC2 provisioning

RDS configuration

VPC concepts

Security Groups

Public/private networking

Linux

Ubuntu administration

Package installation

Service management

Apache configuration

File management and permissions

Web Development

PHP

HTML

CSS

Form processing

Server-side application deployment

Database

MySQL

SQL

Database/table creation

INSERT and SELECT operations

PHP-to-MySQL connectivity

Security

SSH access restriction

Credential protection

Network access control

Database isolation

Least-privilege concepts

🗣️ Project Explanation

A concise explanation for a project presentation:

This project is a PHP-based Student Management Portal deployed on AWS. The application runs on an Ubuntu EC2 instance using Apache as the web server. PHP processes requests and communicates with a MySQL database hosted by Amazon RDS. The EC2 and RDS resources communicate through AWS networking, while Security Groups control permitted traffic. Student records are stored in RDS rather than on the application server. Sensitive credentials are kept outside the public GitHub repository.

❓ Frequently Asked Questions

Where is student information stored?

The records are persisted in the MySQL database hosted by Amazon RDS:

Amazon RDS
    ↓
MySQL
    ↓
student_db
    ↓
students

What happens when EC2 is stopped?

The website hosted on that EC2 instance becomes unavailable. The RDS database is a separate managed resource and can continue to exist independently.

What if the EC2 public IP changes?

A URL based on the previous public IP will no longer point to the instance. An Elastic IP or domain-based endpoint can provide a more stable access method.

Why use RDS instead of installing MySQL on EC2?

RDS provides a managed database service, separating persistent data from the application server and reducing the amount of database administration required on EC2.

📊 Project Summary

Component

Implementation

Cloud

AWS

Compute

EC2

Operating System

Ubuntu Linux

Web Server

Apache2

Application

PHP

Database Service

Amazon RDS

Database Engine

MySQL

Database

student_db

Main Table

students

Network

Amazon VPC

Access Control

Security Groups

🏁 Outcome

The completed deployment demonstrates an end-to-end AWS-hosted web application:

User
  ↓
Web Browser
  ↓
Apache on EC2
  ↓
PHP Application
  ↓
Amazon RDS
  ↓
MySQL
  ↓
student_db
  ↓
students

The project provides practical exposure to AWS infrastructure, Linux administration, web-server configuration, PHP development, MySQL, database connectivity, networking, and basic cloud security.

📚 Project Classification

Academic / Educational Cloud Computing Project

👨‍💻 Author

Varun Kadam

MCA Student
