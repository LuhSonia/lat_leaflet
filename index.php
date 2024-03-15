<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #map{
        width:auto;
        height:640px;
        }
        #refreshButton {
            position: absolute;
            background-color: white;
            width: 130px;
            top: 20px;
            right: 20px;
            padding: 10px;
            z-index: 400;
            box-shadow: 1px 1px 1px 1px;
        }
        #refreshButton button {
            width: 100px;
        }
    </style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <meta charset="UTF-8">
    <title>LEAFLET</title>
</head>
<body>
<div class="modal" id="staticBackdrop" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Objek GeoCoding</h5>
        
      </div>
      <div class="modal-body">
          <textarea class="form-control" id="tampil_data"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="save">Save Data</button>
      </div>
    </div>
  </div>
</div>

<div id="mapsid">
    
</div>
</head>
<body>
    <h1>PETA, <?php echo "SINGARAJA!"; ?></h1>
    <div id="map"></div>
    <div id="refreshButton" class="col-md-6 mx-auto">
        <table class="table">
            <thead>
                <th colspan="3" class="text-center">
                    layer
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <button id="geo_check" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            CekLatLng
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
    var map = L.map('map').setView([-8.1221, 115.1065], 14);

    var arr_tempat = [];
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([-8.1152, 115.0838]).addTo(map);

    var drawItems = new L.FeatureGroup();
    map.addLayer(drawItems);

    var drawControl = new L.Control.Draw({
        draw: {
            marker: false,
            rectangle: false,
            circle: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawItems
        }
    });

    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function(e) {
        var type = e.layerType,
            layer = e.layer;

        var layer_latlngs = layer._latlngs;

        for (var i = 0; i < layer_latlngs.length; i++) {
            arr_tempat.push([layer_latlngs[i].lat, layer_latlngs[i].lng]);
        }

        console.log(arr_tempat);

        $('#tampil_data').text(arr_tempat);
        map.addLayer(layer);
    });

    $(document).on("click","#save", function(){
        $.ajax({
    type: "POST",
    url: 'masuk.php',
    data: {'data_maps': arr_tempat},
    success: function(data){
        console.log(data);
    }
});
    });
</script>
    </body>
</html>