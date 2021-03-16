var mymap = L.map('mapid').setView([51.165691, 10.451526], 7);//Resources/Packages/leaflet/leaflet.js

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 20,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiaGVyZWlzYW1pbiIsImEiOiJja2w2b2t5NGUyajJnMm9xbzV1YTJ2NjBhIn0.lH0uonBecyXYY0SHvow0Lw'
}).addTo(mymap);

var greenIcon = L.icon({
    iconUrl: 'Resources/Images/pin.svg',
    //shadowUrl: 'shadow.png',''
    iconSize:     [25, 60], // size of the icon
    //shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
var paperIcon = L.icon({
    iconUrl: 'Resources/Images/paper.svg',
    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
var clothIcon = L.icon({
    iconUrl: 'Resources/Images/cloth.svg',
    iconSize:     [30, 30], // size of the icon
    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

function stationInfo(station){
    $.ajax('Resources/Php/getStations.php', {
        type: 'POST',  // http method
        data: {
            station: station,
        },  // data to submit
        success: function (data, status, xhr) {
            var obj = jQuery.parseJSON(data);
                console.log(obj);
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error' + errorMessage);
        }
    });
}
var theMarker = [];
function getStations(){
    $.ajax('Resources/Php/getStations.php', {
        type: 'POST',  // http method
        success: function (data, status, xhr) {
            var obj = jQuery.parseJSON(data);

            $.each(obj, function( index, value ) {
                theMarker.push(new L.marker([value[1],value[2]], {icon: greenIcon}).addTo(mymap).bindPopup('<div class="cursor-pointer" onclick="stationInfo('+value[0]+')">Station No.'+value[0]+'</div>' +
                    '<a href="https://www.google.com/maps/dir/'+currentPosition['lat']+','+currentPosition['lng']+'/'+value[1]+','+value[2]+'" target="_blank">Get Direction</a>'));//AIzaSyAYvkivEo3fIbn-YhE_TiSlsuQaF34kJfA
                //console.log(value[0]+' Lat:'+value[1]+' Lng: '+value[2]);
                //alert( index + ": " +  );
            });

            //$('p').append('status: ' + status + ', data: ' + data);'status: ' + status + ', data: ' +
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error' + errorMessage);
            //$('p').append('Error' + errorMessage);
        }
    });
}

var currentPosition;
var nearestStation=[];
function userLoc() {
    return new Promise(resolve => {
        navigator.geolocation.getCurrentPosition(function (location){
            currentPosition = new L.LatLng(location.coords.latitude, location.coords.longitude);
            resolve(currentPosition);
        });
    });
}
var locationPoint;
async function getUserLoc() {
    console.log('catching...');
    currentPosition = await userLoc();
    console.log('Your Location: '+currentPosition);//currentPosition['lat'], currentPosition['lng']
    getStations();

    locationPoint=new L.marker([currentPosition['lat'], currentPosition['lng']]).addTo(mymap).bindPopup('<div class="bg-red-500">your location</div>');
    mymap.setView([currentPosition['lat'], currentPosition['lng']], 10, {animation:true });
    document.getElementById("showNearestStation").removeAttribute('off');
    document.getElementById("showNearestStation").classList.remove('opacity-50');
    $.ajax('Resources/Php/getStations.php', {
        type: 'POST',  // http method
        data: {
                lat: currentPosition['lat'],//51.5326038070667, 10.331301564395927 currentPosition['lat']
                lng: currentPosition['lng']
        },  // data to submit
        success: function (data, status, xhr) {
            var obj = jQuery.parseJSON(data);
            nearestStation['lat']=obj[1][1];
            nearestStation['lng']=obj[1][2];
            alert('nearest Location: '+nearestStation['lat']+' | '+nearestStation['lng']);
            //console.log(nearestStation['lat']);
            //$('p').append('status: ' + status + ', data: ' + data);'status: ' + status + ', data: ' +
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error' + errorMessage);
            //$('p').append('Error' + errorMessage);
        }
    });
}
getUserLoc();

document.getElementById("showNearestStation").addEventListener("click", setNearestStation);

function setNearestStation(){
    if (document.getElementById("showNearestStation").hasAttribute('off')){
        document.getElementById('error').innerText='Please Turn on your Location Access!';
        return false;
    }

    getStations();
    mymap.setView([nearestStation['lat'], nearestStation['lng']], 15, {animation:true });

}

document.getElementById("search").addEventListener("click", searchCity);
function searchCity(){
    document.getElementById('error').innerText='';
    $.each(theMarker, function( index, value ) {
        mymap.removeLayer(value)
    });
    var materials = [];
    $("input:checkbox[id=material]:checked").each(function(){
        materials.push($(this).val());
    });
    var city = $('#city').find(":selected").val();
    if (city==0){
        document.getElementById('error').innerText='Please Select the City!';
        return false;
    }
    if (materials.length==0){
        document.getElementById('error').innerText='Please Select at least one Material!';
        return false;
    }
    var jsonsmaterial = JSON.stringify(materials);
    $.ajax('Resources/Php/getStations.php', {
        type: 'POST',  // http method
        data:{
            search:'search',
            city: city,
            materials:jsonsmaterial
        },
        success: function (data, status, xhr) {
            var obj = jQuery.parseJSON(data);
            console.log('result' + obj.length);
            if (obj.length == 0){
                document.getElementById('error').innerText='Sorry, We could not find any result for your search.';
                return false;
            }
            $.each(obj, function( index, value ) {
                theMarker.push(new L.marker([value[1],value[2]], {icon: greenIcon}).addTo(mymap).bindPopup('<div class="cursor-pointer" onclick="stationInfo('+value[0]+')">Station No.'+value[0]+'</div>' +
                    '<a href="https://www.google.com/maps/dir/'+currentPosition['lat']+','+currentPosition['lng']+'/'+value[1]+','+value[2]+'" target="_blank">Get Direction</a>'));//AIzaSyAYvkivEo3fIbn-YhE_TiSlsuQaF34kJfA
            });
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error' + errorMessage);
        }
    });
    $.ajax('Resources/Php/forIndex.php', {
        type: 'POST',
        data:{city:city},
        success: function (data, status, xhr) {
            var obj = jQuery.parseJSON(data);
            //console.log('city: ' + obj);
            $.each(obj, function( index, value ) {
                mymap.setView([value[2], value[3]], 8, {animation:true });
            });
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error' + errorMessage);
        }
    });

}
