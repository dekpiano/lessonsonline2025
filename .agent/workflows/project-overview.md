---
description: ภาพรวมและโครงสร้างทางเทคนิคของโปรเจกต์ lessonsonline (ฉบับภาษาไทย)
---

# รายละเอียดโปรเจกต์: lessonsonline

โปรเจกต์นี้เป็นระบบบทเรียนออนไลน์ (Online Learning System) สำหรับจัดการคอร์สเรียน บทเรียน และการทดสอบของศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์

## 🛠 ข้อมูลทางเทคนิค (Tech Stack)

- **ภาษา:** PHP 8.0 (โครงสร้างแบบผสม Procedural/OOP)
- **ฐานข้อมูล:** MySQL (เชื่อมต่อผ่าน PDO)
- **ชื่อฐานข้อมูล:** `skjacth_lessonsonline`
- **ระบบจัดเก็บตัวอักษร:** UTF-8 (utf8mb4_unicode_ci)
- **Frontend Framework:** AdminLTE 3 (Bootstrap 4)
- **ไลบรารีเสริม:** jQuery, SweetAlert2, Font Awesome 5, Bootstrap Icons (bi)
- **Containerization:** Docker (Apache + PHP 8.0)

## 📂 โครงสร้างโฟลเดอร์หลัก

- `pages/Users/`: ส่วนของนักเรียน (หน้าหลัก, ดูคอร์ส, บทเรียน, ทำแบบทดสอบ)
- `pages/Teacher/`: ส่วนของครู (จัดการเนื้อหา, ดูรายงาน)
- `pages/Admin/`: ส่วนของผู้ดูแลระบบ (จัดการความปลอดภัยและภาพรวม)
- `php/Database/Database.php`: ไฟล์เชื่อมต่อฐานข้อมูลหลัก (รองรับ Docker Environment)
- `php/Login/`: ระบบล็อกอินและตรวจสอบสิทธิ์
- `uploads/`: โฟลเดอร์เก็บสื่อการสอนและไฟล์รูปภาพ

## 🔑 กฎการเขียนโค้ดและการออกแบบ

- **Layout:** ใช้การ `include_once` ส่วนประกอบหลัก เช่น Header, Navbar, Footer
- **ความสวยงาม (Aesthetics):** เน้นดีไซน์ที่ทันสมัย สีสันสดใส มี Transition ที่ลื่นไหล และใช้ Glassmorphism ตามความต้องการของผู้ใช้
- **การตั้งชื่อ:** ไฟล์ View ในส่วนจัดการให้ขึ้นต้นด้วย `PageAdmin...` หรือ `Admin...` และเก็บ Class ไว้ใน `PhpClass`

## 🗄 ข้อมูลฐานข้อมูลที่สำคัญ

- รองรับภาษาไทยสมบูรณ์ผ่าน UTF-8
- มีระบบจัดการความก้าวหน้าการเรียน (Enrollment & Progress Tracking)
- ระบบแบบทดสอบก่อนเรียน-หลังเรียน (Pre-test & Post-test)
