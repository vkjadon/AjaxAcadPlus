<?php
require('../requireSubModule.php');
//echo $_POST['action'];

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'addGrid') {

    $sql = "insert into $tn_amap (ac_id, at_id, amap_grid, amap_weightage, amap_internal, update_id, amap_status) values('" . data_check($_POST['sel_ac']) . "', '" . data_check($_POST['sel_at']) . "', '" . data_check($_POST['sel_grid']) . "', '" . data_check($_POST['weightage']) . "', '" . data_check($_POST['internal']) . "', '$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'selectGrid') {
    $sql = "select * from $tn_amap where amap_status='0' group by amap_grid order by amap_grid";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 1;
    echo '<select class="form-control form-control-sm" id="sel_grid" name="sel_grid" required>';
    //echo '<option>Select a Grid</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray["amap_grid"];
      echo '<option value="' . $id . '">Grid-' . $i++ . '</option>';
    }
    echo '<option value="' . $i . '">New Grid</option>';
    echo '</select>';
  } elseif ($_POST['action'] == 'amapList') {
    $totalGrids = getMaxField($conn, $tn_amap, "amap_grid");
    //echo $totalGrids;
    for ($i = 1; $i <= $totalGrids; $i++) {
      $sql = "select * from $tn_amap where amap_grid='$i' order by ac_id";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      echo '<div class="row">';
      echo '<div class="col-sm-2 m-0 p-1">';
      echo '<div class="card myCard m-2 text-center">';
      echo '<h4">Grid-'.$i.'</h4>';
      echo '</div>';
      echo '</div>';
      while ($rowsArray = $result->fetch_assoc()) {
        $status = $rowsArray["amap_status"];
        $internal = $rowsArray["amap_internal"];
        $ac = getField($conn, $rowsArray["ac_id"], "master_name", "mn_id", "mn_name");
        $at = getField($conn, $rowsArray["at_id"], "master_name", "mn_id", "mn_name");
        //echo $ac.'-'.$at;
        echo '<div class="col m-1 p-0">';
        echo '<div class="card myCard">';
        echo '<div class="row p-1">';
        echo '<div class="col-8 xsText">' . $ac . '</div>';
        echo '<div class="col-4 smallText m-0">'.$rowsArray["amap_weightage"].'</div>';
        echo '</div>';
        echo '<div class="row p-1">';
        echo '<div class="col-8 xsText">' . $at . '</div>';
        if($internal=='internal')echo '<div class="col-4 smallText m-0">I</div>';
        else echo '<div class="col-4 smallText m-0">E</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col ml-2">';
        echo '<a href="#" class="float-left rp_idE" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-edit"></i></a>';
        if ($status == "9") echo '<a href="#" class="float-right rp_idR" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-refresh" aria-hidden="true"></i></a>';
        else echo '<a href="#" class="float-right rp_idD" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-trash"></i></a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    }
  }
}
