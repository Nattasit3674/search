<!DOCTYPE html>
<html>
<head>
    <title>Search Employees</title>
    <style>
        /* CSS สำหรับการจัดรูปแบบหน้าเว็บ */
        #result {
            display: none; /* ซ่อนผลลัพธ์ของการค้นหาเริ่มต้น */
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>ค้นหารายชื่อ Provider ID</h1>   
    <div class="row">
        <div class="col">
          <input type="text" class="form-control" id="searchInput" placeholder="ค้นหารายชื่อ...">
        </div>
        <div class="col">
          <button class="btn btn-primary" onclick="search()">ค้นหา</button>
        </div>
        <div class="col">
          <a href="login_page" class="btn btn-secondary">เข้าสู่ระบบสำหรับแอดมิน</a>
        </div>
      </div>
    
    <div id="result">
        <!-- ตำแหน่งที่แสดงผลลัพธ์ของการค้นหา -->
    </div>
    <script>
        // JavaScript สำหรับการโหลดข้อมูลที่ค้นหาและแสดงผล
        function search() {
            var query = document.getElementById("searchInput").value;
            // ส่งคำค้นหาไปยังไฟล์ PHP ที่ทำการค้นหาข้อมูล
            fetch("search.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "query=" + encodeURIComponent(query) // ส่งข้อมูลคำค้นหาในรูปแบบ URL-encoded
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("result").innerHTML = data;
        document.getElementById("result").style.display = "block"; // แสดงผลลัพธ์หลังจากค้นหาเสร็จสิ้น
    });
}
    </script>
    </div>
</body>
</html>
