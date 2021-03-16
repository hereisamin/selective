<?php
include "db_connect.php";

if (isset($_POST['lat']) && isset($_POST['lng'])){
    $lat=$_POST['lat'];
    $lng=$_POST['lng'];
$query = "
SELECT id, lat, lng, SQRT(
    POW(69.1 * (lat - ".$lat."), 2) +
    POW(69.1 * (".$lng." - lng) * COS(lat / 57.3), 2)) AS distance
FROM stations HAVING distance < 9000000 ORDER BY distance
";
    $data = array();
    $a = array('yourLocation', $lat, $lng);
    array_push($data, $a);
    $cities = $db->query($query);
    while($enr = mysqli_fetch_assoc($cities)){
        $dis = SQRT(
            POW(69.1 * ($enr['lat'] - $lat), 2) +
            POW(69.1 * ($lng - $enr['lng']) * COS($enr['lat'] / 57.3), 2));
        $a = array($enr['id'], $enr['lat'], $enr['lng'], $dis);
        array_push($data, $a);
    }
    echo json_encode($data);

}elseif (isset($_POST['station'])){
    $query="
    SELECT stations.id, stations.address, cities.name AS city, areas.name AS area
    FROM ((stations
    INNER JOIN cities ON stations.city_id=cities.id)
    INNER JOIN areas ON stations.area_id=areas.id)
    WHERE stations.id = ".$_POST['station']." 
    ";
    $data = array();
    $cities = $db->query($query);
    while($enr = mysqli_fetch_assoc($cities)){
        $a = array($enr['id'], $enr['address'], $enr['area'], $enr['city']);
        array_push($data, $a);
    }
    echo json_encode($data);
}elseif (isset($_POST['search'])){
    $city = $_POST['city'];
    $materialsArray = json_decode(stripslashes($_POST['materials']));
    $materialsString='';
    $i=0;
    foreach ($materialsArray as $material){
        $i++;
        if ($i<count($materialsArray)){
            $materialsString .= $material.', ';
        }else{
            $materialsString .= $material;
        }

    }

    $query="
            select id, lat, lng
            from stations inner join material_station
            on material_station.station_id=stations.id
            where material_station.material_id IN (".$materialsString.")
            AND stations.city_id=".$city."
            GROUP BY stations.id
            HAVING COUNT(DISTINCT material_station.material_id)=".count($materialsArray);
    $result = $db->query($query);
    $data=array();

    while($enr = mysqli_fetch_assoc($result)){
        $a = array($enr['id'], $enr['lat'], $enr['lng']);//, $enr['address'], $enr['area'], $enr['city']
        array_push($data, $a);
    }
    echo json_encode($data);

}

else{
    $query = "SELECT * FROM stations";
    $data = array();
    $cities = $db->query($query);
    while($enr = mysqli_fetch_assoc($cities)){
        $dis = SQRT(
            POW(69.1 * ($enr['lat'] - $lat), 2) +
            POW(69.1 * ($lng - $enr['lng']) * COS($enr['lat'] / 57.3), 2));
        $a = array($enr['id'], $enr['lat'], $enr['lng'], $dis);
        array_push($data, $a);
    }
    echo json_encode($data);
}



///SELECT lat, lng, SQRT(
//    POW(69.1 * (lat - 30.287847), 2) +
//    POW(69.1 * (57.045871 - lng) * COS(lat / 57.3), 2)) AS distance
//FROM cities HAVING distance < 25 ORDER BY distance

//select stations.id
//from stations inner join material_station
//on material_station.station_id=stations.id
//where material_station.material_id IN (1,2)
//AND stations.city_id=1
//GROUP BY stations.id
//HAVING COUNT(DISTINCT material_station.material_id)=2
