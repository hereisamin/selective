<?php
include "db_connect.php";

$query = "SELECT * FROM cities";
$cities = $db->query($query);
$query = "SELECT * FROM materials";
$materials = $db->query($query);

if (isset($_POST['city'])){
    $query = "SELECT * FROM cities WHERE id=".$_POST['city'];
    $result = $db->query($query);
    $data=array();
    while($enr = mysqli_fetch_assoc($result)){
        $a = array($enr['id'], $enr['name'], $enr['lat'], $enr['lng']);//, $enr['address'], $enr['area'], $enr['city']
        array_push($data, $a);
    }
    echo json_encode($data);
}
?>
