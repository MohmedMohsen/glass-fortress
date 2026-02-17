
---

# 🏰 The Glass Fortress


> **The Glass Fortress** is a very beginner-friendly, intentionally vulnerable web application designed as a safe lab to practice offensive security and penetration testing.


> [!CAUTION]
> 
> **WARNING:** Deployment on public-facing servers is strictly prohibited. This environment contains intentional Remote Code Execution (RCE) flaws. Use only within isolated environments (e.g., XAMPP, Docker, or VMs).


---

## 🛠️ Installation & Setup

### Prerequisites

- *XAMPP*
- *The very basics of SQLi, XSS, IDOR etc.*
### Deployment Steps

 **Clone the Source:**
    
1. **Database :**
	
	- open the **XAMPP Control Panel** and *start* Apache and MySQL
		
		
    - Access **XAMPP phpMyAdmin**.
        
        
    - Source the `glass_db.sql` file provided in the repository.
		
		
	- Import it 
	
2. **Environment Config:** 
	    We using the Default settings 
    - _Default (XAMPP):_ `root` / `no-password`. 
	    (no need to do anything )
3. **Initialize:**
    
    - Access via: `http://localhost/projects/glass-fortress`.
        

---

## 🎯 **Lab Goals** 🕵️‍♂️

1. **Login without a Password**
    
    - **Goal:** Log in as the `admin` without knowing the real password (without brute force).
	    (Try to guess the columns number and get the data )
	    
1. **Become the Admin**
    
    - **Goal:** Log in as a normal user, then trick the system into making you an Admin.
        
    - **Hint:** cookies 🍪 .
    
2. **Read Secret Notes**
    
    - **Goal:** Find and read notes that belong to other users.
    
3. **Delete Other People's Files**
    
    - **Goal:** Delete a file that you did not upload.
    
4. **Run System Commands (The Shell)**
    
    - **Goal:** Upload a special PHP file that lets you control the server or get info.
    
5. **Hacked Profile Page**
    
    - **Goal:** Make a pop-up window appear whenever someone visits your profile.
        
    - **Hint:** Write a script in your "Bio" box, or check hacker's profile  .

---

 
## 🎯 Vulnerability Roadmap (**Spoilers**)

This project simulates a legacy environment with the following intentional security gaps:

| **Vulnerability **       | **Vector**             | **Failure Logic (Technique)**                                                            |     |
| ------------------------ | ---------------------- | ---------------------------------------------------------------------------------------- | --- |
| **SQL Injection (SQLi)** | `login.php`            | **Auth Bypass:** Manipulating boolean logic to force true conditions (e.g., `' OR 1=1`). |     |
| **Stored XSS**           | `profile.php`          | **Persistence:** Injecting executable JS payloads into user bio/notes fields.            |     |
| **Unrestricted Upload**  | `files.php`            | **RCE Risk:** Uploading PHP files (Web Shells).                                          |     |
| **IDOR**                 | `note.php` `notes.php` | **Data Leak and Deletion :** tampering with the `id` parameter in URL.                   |     |
| **Privilege Escalation** | `admin/dashboard.php`  | **Broken Auth:** Trusting client-side `cookies` for role verification .                  |     |
| **Arbitrary Deletion**   | `files.php`            | **Destructive:** Manipulating file paths in delete requests to remove system files.      |     |

---

## ⚖️ Legal Disclaimer

This repository is for **Educational and Ethical Research purposes only**. The user assumes all responsibility for any actions performed using this material. Unauthorized access to computer systems is illegal.

---

