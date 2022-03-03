<?php
require('../requireSubModule.php');
require("../css.php");
$sql = "select s.* from staff s where staff_id>1 order by s.staff_name";
$result = $conn->query($sql);
?>
<a href="#" class="fa fa-download m-4 p-4" id="export">Download</a>
<table id="example" border="1" class="display  m-4 p-4" style="width:100%">
  <thead>
    <tr>
      <th>Name</th>
      <th>User Id</th>
      <th>Mobile</th>
      <th>Email</th>
      <th>Father Name</th>
      <th>Mother Name</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (!$result) echo $conn->error;
    else {
      while ($rowsStaff = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $rowsStaff["staff_name"] . '</td>';
        echo '<td>' . $rowsStaff["user_id"] . '</td>';
        echo '<td>' . $rowsStaff["staff_mobile"] . '</td>';
        echo '<td>' . $rowsStaff["staff_email"] . '</td>';
        echo '<td>' . $rowsStaff["staff_fname"] . '</td>';
        echo '<td>' . $rowsStaff["staff_mname"] . '</td>';
        echo '</tr>';
      }
    }
    ?>
  </tbody>
</table>
<script>
  document.getElementById('export').onclick = function() {
    var tableId = document.getElementById('example').id;
    htmlTableToExcel(tableId, filename = '');
  }
  var htmlTableToExcel = function(tableId, fileName = '') {
    var excelFileName = 'excel_table_data';
    var TableDataType = 'application/vnd.ms-excel';
    var selectTable = document.getElementById(tableId);
    var htmlTable = selectTable.outerHTML.replace(/ /g, '%20');

    filename = filename ? filename + '.xls' : excelFileName + '.xls';
    var excelFileURL = document.createElement("a");
    document.body.appendChild(excelFileURL);

    if (navigator.msSaveOrOpenBlob) {
      var blob = new Blob(['\ufeff', htmlTable], {
        type: TableDataType
      });
      navigator.msSaveOrOpenBlob(blob, fileName);
    } else {

      excelFileURL.href = 'data:' + TableDataType + ', ' + htmlTable;
      excelFileURL.download = fileName;
      excelFileURL.click();
    }
  }
</script>