<div align="center">

# 🏰 The Glass Fortress

### A Vulnerable Web Application Lab for Offensive Security

![Language](https://img.shields.io/badge/Language-PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Intentionally%20Vulnerable-red?style=for-the-badge&logo=security)

<br>


</div>

> [!important]
> **The Glass Fortress** is a beginner-friendly, intentionally vulnerable web application.  
> It serves as a safe "sandbox" environment to practice offensive security, penetration testing, and secure coding.

---

> [!CAUTION]
> **DANGER: DO NOT DEPLOY PUBLICLY**
> 
> This application contains intentional **Remote Code Execution (RCE)** flaws and critical security vulnerabilities. 
> * **Do NOT** upload this to a live server (Heroku, AWS, Shared Hosting).
> * **ONLY** use this in an isolated environment (e.g., Localhost XAMPP, Docker, or a Virtual Machine).

---

## 🛠️ Installation & Setup

### Prerequisites
* **XAMPP** (or any LAMP stack)
* Basic understanding of SQLi, XSS, IDOR, and Web Requests.

### 🚀 Deployment Steps

**1. Clone the Repository**
Navigate to your `htdocs` folder.
Click the green **"Code"** button above to get the URL, or run:
```bash
cd C:\xampp\htdocs
# Replace <username> with the current owner's username (ME)
git clone [https://github.com/](https://github.com/)<username>/glass-fortress.git
```

**2. Database Setup**
* Open **XAMPP Control Panel** and start **Apache** and **MySQL**.
* Navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
* Click **Import** and select the `glass_db.sql` file from the cloned repository.
	(it will create everything for you glass_db , tables ect. )

**3. Configuration**
* The project uses default XAMPP credentials:
    * **User:** `root`
    * **Password:** *(empty)*

**4. Enter the Fortress**
* Open your browser and visit:
    * `http://localhost/projects/glass-fortress`


---

## 🚩 Mission Checklist (Lab Goals)

Can you shatter the fortress? Try to complete these objectives in order.

- [ ] **Login without a Password**
  - **Goal:** Log in as the admin without knowing the real password (without brute force)
  - *(Try to guess the columns number and get the data )*

- [ ] **Become the Admin**
  - **Goal:** Log in as a normal user, then trick the system into making you an Admin.
  - **Hint:** cookies 🍪 .

- [ ] **Read Secret Notes**
  - **Goal:** Find and read notes that belong to other users.

- [ ] **Delete Other People's Files**
  - **Goal:** Delete a file that you did not upload.

- [ ] **Run System Commands (The Shell)**
  - **Goal:** Upload a special PHP file that lets you control the server or get server info.

- [ ] **Hacked Profile Page**
  - **Goal:** Make a pop-up window appear whenever someone visits your profile.
  - **Hint:** Write a script in your "Bio" box, or check hacker's profile
---

## 🗺️ Vulnerability Roadmap (Spoilers)

**Note:** Try to find the vulnerabilities yourself first!

<details>
<summary> 🚨 <strong>Click to Reveal Stronger hints (Spoilers)</strong> 🚨 </summary>

<br>

| **Vulnerability**       | **Vector**             | **Failure Logic (Technique)**                                                            |
| ------------------------ | ---------------------- | ---------------------------------------------------------------------------------------- |
| **SQL Injection (SQLi)** | `login.php`            | **Auth Bypass:** Manipulating boolean logic to force true conditions . |
| **Stored XSS**           | `profile.php`          | **Persistence:** Injecting executable JS payloads into user bio/notes fields.            |
| **Unrestricted Upload**  | `files.php`            | **RCE Risk:** Uploading PHP files (Web Shells).                                          |
| **IDOR**                 | `note.php` `notes.php` | **Data Leak and Deletion :** tampering with the `id` parameter in URL.                   |
| **Privilege Escalation** | `admin/dashboard.php`  | **Broken Auth:** Trusting client-side `cookies` for role verification .                  |
| **Arbitrary Deletion**   | `files.php`            | **Destructive:** Manipulating file paths in delete requests to remove system files.      |
</details>


---

## ⚖️ Legal Disclaimer

> **Educational Purposes Only**
>
> This repository is strictly for **ethical research and learning**. The user assumes all responsibility for any actions performed using this material. Unauthorized attacks against systems you do not own is illegal.
