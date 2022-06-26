<?php
require('../requireSubModule.php');
require("../css.php");
$sql = "select s.* from staff s where staff_id>1 order by s.staff_name";
$result = $conn->query($sql);
?>
<a onclick="export_data()" class="fa fa-download m-4 p-4">Download</a>

<table id="example" border="1" class="display  m-4 p-4" style="width:100%">
  <thead>
    <tr>
      <th>User Id</th>
      <th>Name</th>
      <th>DoB</th>
      <th>Mobile</th>
      <th>Email</th>
      <th>Father Name</th>
      <th>Mother Name</th>
      <th>DoJ</th>
      <th>A/C Number</th>
      <th>Bank</th>
      <th>IFSC</th>
      <th>ADHAAR</th>
      <th>Address</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (!$result) echo $conn->error;
    else {
      while ($rowsStaff = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $rowsStaff["user_id"] . '</td>';
        echo '<td>' . $rowsStaff["staff_name"] . '</td>';
        echo '<td>' . $rowsStaff["staff_dob"] . '</td>';
        echo '<td>' . $rowsStaff["staff_mobile"] . '</td>';
        echo '<td>' . $rowsStaff["staff_email"] . '</td>';
        echo '<td>' . $rowsStaff["staff_fname"] . '</td>';
        echo '<td>' . $rowsStaff["staff_mname"] . '</td>';
        echo '<td>' . $rowsStaff["staff_doj"] . '</td>';
        echo '<td>' . $rowsStaff["staff_account"] . '</td>';
        echo '<td>' . $rowsStaff["staff_bank"] . '</td>';
        echo '<td>' . $rowsStaff["staff_ifsc"] . '</td>';
        echo '<td>' . $rowsStaff["staff_adhaar"] . '</td>';
        echo '<td>' . $rowsStaff["staff_address"] . '</td>';
        echo '</tr>';
      }
    }
    ?>
  </tbody>
</table>
<script>
  function export_data() {
    let data = document.getElementById('example');
    var fp = XLSX.utils.table_to_book(data, {
      sheet: 'sheet1'
    });
    XLSX.write(fp, {
      bookType: 'xlsx',
      type: 'base64'
    });
    XLSX.writeFile(fp, 'staff.xlsx');
  }
</script>