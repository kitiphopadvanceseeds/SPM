{{-- resources/views/test-seeds.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Seed Table</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>

<body>
    <h2>ข้อมูลรับเมล็ด</h2>

    <button onclick="loadType('main')">ข้อมูลชุดหลัก</button>
    <button onclick="loadType('pre')">ข้อมูลก่อนถึงสถานะ</button>

    <div class="table-responsive">
        <table border="1" width="100%" id="RequistionTable">
            <thead>
                <tr>
                    <th>JobNo.</th>
                    <th>วันที่คาดว่าจะรับเมล็ด</th>
                    <th>รหัสผลิต</th>
                    <th>พืช</th>
                    <th>เกษตรกร</th>
                </tr>
            </thead>
            <tbody id="DataSeeds">
                <tr>
                    <td colspan="5">กรุณาเลือกประเภทข้อมูล</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function loadType(type) {
            console.log("type:", type);

            $.ajax({
                url: "{{ url('/GetSdFr/test-seeds-data') }}", // URL ไปยัง route ที่ให้ข้อมูล
                type: 'GET',
                data: {
                    type: type
                },
                success: function(response) {
                    console.log(response);
                    let rows = '';
                    response.data.forEach(item => {
                        rows += `
                            <tr>
                                <td>${item.job_no}</td>
                                <td>${item.expect_date}</td>
                                <td>${item.prod_code}</td>
                                <td>${item.plant}</td>
                                <td>${item.farmer}</td>
                            </tr>`;
                    });

                    $('#DataSeeds').html(rows);
                }
            });
        }
    </script>
</body>

</html>
