<?php
include 'db_connect.php';

    $query="
        SELECT stations.id, stations.lat, stations.lng, stations.address, cities.name AS city, areas.name AS area
        FROM ((stations
        INNER JOIN cities ON stations.city_id=cities.id)
        INNER JOIN areas ON stations.area_id=areas.id)
        ";//WHERE stations.id = ".$_POST['station']."
    $data=array();
    $stations = $db->query($query);

