<body>
    
    <div id="map"></div>

    <script>

        var customLabel = {//still in development
        art:{
          label: 'A'
        },
        family: {
          label: 'F'
        }
      };

var tempLat = <?php echo(json_encode($_SESSION["lat"]))?>;
var tempLon = <?php echo(json_encode($_SESSION["lon"]))?>;

//Add autonav function here testing session variables

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                //center: new google.maps.LatLng(42.886447, -78.878369),
                center: new google.maps.LatLng(tempLat, tempLon),
                zoom: 16
            });
            var infoWindow = new google.maps.InfoWindow;

//YOU ARE HERE MARKER
            var marker = new google.maps.Marker({
            position: {lat: tempLat, lng: tempLon},
            map: map,
            title: 'You are Here',
            icon: 
                { 
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                fillColor: 'red',
                fillOpacity: 1,      
                    }
            });
        
            // Change this depending on the name of your PHP or XML file
            downloadUrl('xmlmaker.php', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('eventID');
                    var name = markerElem.getAttribute('eventTitle');
                    var address = markerElem.getAttribute('eventLocation');
                    var type = markerElem.getAttribute('eventCategory');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('eventLatitude')),
                        parseFloat(markerElem.getAttribute('eventLongitude')));
                    var time = markerElem.getAttribute('eventTime');
                    var url = markerElem.getAttribute('eventLink');
                    var price = markerElem.getAttribute('eventPrice');
                    var infowincontent = document.createElement('div');

                    var link = document.createElement('a');
                    link.href = url;
                    link.target = '_blank';
                    link.textContent = name + "  " + time;
                    infowincontent.appendChild(link);
                    infowincontent.appendChild(document.createElement('br'));

                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    infowincontent.appendChild(document.createElement('br'));
                    var text = document.createElement('text');
                    text.textContent = type
                    infowincontent.appendChild(text);
                    infowincontent.appendChild(document.createElement('br'));
                    var text = document.createElement('text');
                    text.textContent = price
                    infowincontent.appendChild(text);
                    //Customize marker data after title here
                    var icon = customLabel[type] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        label: icon.label
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                    marker.addListener('mouseover', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                    //This will open the event link by clicking the marker
                    //Dont know if i want this functionality b.c mobile & desktop variability
                    //google.maps.event.addListener(marker, 'click', function() {
                    //    window.open(link.href);
                    //});
                });
            });
        }



        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function doNothing() {}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGMx3U3qcwgWyp4yurJ1MMCrwWOBanNHg&callback=initMap">
    </script>
</body>

</html>