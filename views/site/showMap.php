<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Google Map';
$this->params['breadcrumbs'][] = $this->title;

$css = <<<css
#mapinfo table {
  width:100%;
  border-collapse:collapse;
  background-color:#fff;
  border:solid 1px #ccc;
}

#mapinfo table th, #mapinfo table td {
text-align:center;
  padding:10px;
  border:solid 1px #ccc;
}
css;

$this->registerCss($css);
?>
<div class="site-map">
    <h1><?= Html::encode($this->title) ?></h1>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  	<script>
    $(document).ready(function(){
        var date_input=$('input[name="waktu"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
	</script>
	
    <form action="" method="get">
  	Waktu: <br>
  	<input type="text" name="waktu" id="datepicker"><br><br>
  	ID Pelampung:<br>
  	<input type="text" name="id pelampung"><br><br>
  	<button type="submit">search</button>
	</form><br>
    
    <div id="map"></div>

    <div id="mapinfo"></div>

    </div>


    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyA1jV0-bdpbduEmLUd7QVHRlAzdvZiTKVQ&language=id"></script>
    <script>
    (function() {
      window.pelampung = [];
      window.koordinator = [];
      window.gmap0infoWindow;

      function initialize() {
          var mapOptions = {
              "center": new google.maps.LatLng(39.7200893118, 2.9116594452),
              "zoom": 17
          };

          var container = document.getElementById('map');
          container.style.width = '100%';
          container.style.height = '500px';
          window.gmap0 = new google.maps.Map(container, mapOptions);

          <?php for ($i=0;$i<count($allPelampung);$i++): ?>
          window.pelampung['pelampung<?= $i+1 ?>'] = new google.maps.Marker({
              "map": gmap0,
              "position": new google.maps.LatLng(<?= $allPelampung[$i]['latitude'] . ', ' . $allPelampung[$i]['longitude'] ?>),
              "title": "Pelampung <?= $i+1 ?>"
          });
          google.maps.event.addListener(window.pelampung['pelampung<?= $i+1 ?>'], 'click', function(event) {
              gmap0infoWindow.setContent('<p>Pelampung <?= $i+1 ?></p>');
              gmap0infoWindow.open(gmap0, this);
          });
          <?php endfor; ?>

          <?php for ($i=0;$i<count($allKoordinator);$i++): ?>
          window.koordinator['koordinator<?= $i+1 ?>'] = new google.maps.Marker({
              "map": gmap0,
              "position": new google.maps.LatLng(<?= $allKoordinator[$i]['latitude'] . ', ' . $allKoordinator[$i]['longitude'] ?>),
              "title": "Koordinator <?= $i+1 ?>"
          });
          google.maps.event.addListener(window.koordinator['koordinator<?= $i+1 ?>'], 'click', function(event) {
              gmap0infoWindow.setContent('<p>Koordinator <?= $i+1 ?></p>');
              gmap0infoWindow.open(gmap0, this);
          });
          <?php endfor; ?>

          gmap0infoWindow = new google.maps.InfoWindow();
      };
      initialize();
    })();

    window.checkLocation = function(){
      var formData = {
        pelampung : {},
        koordinator: {}
      };

      for (x in window.pelampung){
        formData.pelampung[x] = {
          lat : pelampung[x].position.lat(),
          lng : pelampung[x].position.lng()
        };
      }

      for (x in window.koordinator){
        formData.koordinator[x] = {
          lat : koordinator[x].position.lat(),
          lng : koordinator[x].position.lng()
        };
      }

      console.log(formData);



      $.post('<?= Url::base() ?>/site/checklocation', formData, function(data){
        ;
        var json = $.parseJSON(data);
        console.log(json)
        window.oldDistance = {};

        for (x in window.pelampung){
          oldDistance[x] = {};

          for (y in window.pelampung){
            if (x != y){
              oldDistance[x][y] = getDistance2(window.pelampung[x], window.pelampung[y]);
            }
          }

          for (z in json.koordinator){
            oldDistance[x][z] = getDistance2(window.pelampung[x], window.koordinator[z]);
          }

        }

        for (x in window.koordinator){
          oldDistance[x] = {};

          for (y in window.koordinator){
            if (x != y){
              oldDistance[x][y] = getDistance2(window.koordinator[x], window.koordinator[y]);
            }
          }

          for (z in window.pelampung){
            oldDistance[x][z] = getDistance2(window.koordinator[x], window.pelampung[z]);
          }
          
        }

        window.newDistance = {};


        //menghitung jarak dari pelampung
        for (x in json.pelampung){
          newDistance[x] = {};

          for (y in json.pelampung){
            if (x != y){
              newDistance[x][y] = getDistance2(json.pelampung[x], json.pelampung[y]);
            }
          }

          for (z in json.koordinator){
            newDistance[x][z] = getDistance2(json.pelampung[x], json.koordinator[z]);
          }

          window.pelampung[x].setPosition( new google.maps.LatLng(json.pelampung[x].latitude, json.pelampung[x].longitude) );
        }

        for (x in json.koordinator){
          window.koordinator[x].setPosition( new google.maps.LatLng(json.koordinator[x].latitude, json.koordinator[x].longitude) );
            google.maps.event.addListener(window.koordinator[x], 'click', function(event) {
                var html = '<table><tr><th>Nama</th><th>Latitude</th><th>Longitude</th><th>Jarak (km)</th><th>Status</th></tr>';
                for (y in window.pelampung){
                  html += '<tr><td>' + window.pelampung[y].title +  '</td><td>' + json.pelampung[y].latitude + '</td><td>' + json.pelampung[y].longitude + '</td><td>' + newDistance[x][y]  + '</td><td>' + ((newDistance[x][y] < oldDistance[x][y]) ? 'Mendekat' : 'Menjauh' ) + '</td></tr>';
                }
                html += '</table>';
                document.getElementById('mapinfo').innerHTML = html;
                //gmap0infoWindow.setContent(html);
                //gmap0infoWindow.open(gmap0, this);
            });
        }

        //menghitung jarak dari koordinator
        for (x in json.koordinator){
          newDistance[x] = {};

          for (y in json.koordinator){
            if (x != y){
              newDistance[x][y] = getDistance2(json.koordinator[x], json.koordinator[y]);
            }
          }

          for (z in json.pelampung){
            newDistance[x][z] = getDistance2(json.koordinator[x], json.pelampung[z]);
          }

          window.koordinator[x].setPosition( new google.maps.LatLng(json.koordinator[x].latitude, json.koordinator[x].longitude) );
        }

        for (x in json.koordinator){
          window.koordinator[x].setPosition( new google.maps.LatLng(json.koordinator[x].latitude, json.koordinator[x].longitude) );
        }

        //console.log(oldDistance);
        
      });
    };

    window.rad = function(x) {
      return x * Math.PI / 180;
    };

    window.getDistance = function(p1, p2) {
      var R = 6378137; // Earth’s mean radius in meter
      var dLat = rad(p2.lat() - p1.lat());
      var dLong = rad(p2.lng() - p1.lng());
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c;
      var e = d/1000;
      return e; // returns the distance in km
    };

    window.getDistance2 = function(p1, p2) {
      var R = 6378137; // Earth’s mean radius in meter
      var dLat = rad(p2.latitude - p1.latitude);
      var dLong = rad(p2.longitude - p1.longitude);
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(p1.latitude)) * Math.cos(rad(p2.latitude)) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c;
      var e = d/1000;
      return e; // returns the distance in km
    };

    setInterval(checkLocation, 10000);
    </script>
