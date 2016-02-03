var styles = [
      {
          "featureType": "administrative",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#dfeae3"
              }
          ]
      },
      {
          "featureType": "administrative",
          "elementType": "labels.text.fill",
          "stylers": [
              {
                  "color": "#444444"
              }
          ]
      },
      {
          "featureType": "administrative.locality",
          "elementType": "labels",
          "stylers": [
              {
                  "visibility": "on"
              }
          ]
      },
      {
          "featureType": "landscape",
          "elementType": "all",
          "stylers": [
              {
                  "color": "#f2f2f2"
              },
              {
                  "visibility": "simplified"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "all",
          "stylers": [
              {
                  "visibility": "on"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "geometry",
          "stylers": [
              {
                  "visibility": "simplified"
              },
              {
                  "saturation": "-65"
              },
              {
                  "lightness": "45"
              },
              {
                  "gamma": "1.78"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "labels",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "all",
          "stylers": [
              {
                  "saturation": -100
              },
              {
                  "lightness": 45
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "labels",
          "stylers": [
              {
                  "visibility": "on"
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "road.highway",
          "elementType": "all",
          "stylers": [
              {
                  "visibility": "simplified"
              }
          ]
      },
      {
          "featureType": "road.highway",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "road.arterial",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "transit.line",
          "elementType": "geometry",
          "stylers": [
              {
                  "saturation": "-33"
              },
              {
                  "lightness": "22"
              },
              {
                  "gamma": "2.08"
              }
          ]
      },
      {
          "featureType": "transit.station.airport",
          "elementType": "geometry",
          "stylers": [
              {
                  "gamma": "2.08"
              },
              {
                  "hue": "#ffa200"
              }
          ]
      },
      {
          "featureType": "transit.station.airport",
          "elementType": "labels",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "transit.station.rail",
          "elementType": "labels.text",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "transit.station.rail",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "simplified"
              },
              {
                  "saturation": "-55"
              },
              {
                  "lightness": "-2"
              },
              {
                  "gamma": "1.88"
              },
              {
                  "hue": "#ffab00"
              }
          ]
      },
      {
          "featureType": "water",
          "elementType": "all",
          "stylers": [
              {
                  "color": "#bbd9e5"
              },
              {
                  "visibility": "simplified"
              }
          ]
      }
]

if (document.getElementById('map-canvas')) {

  function initialize() {
      var myLatlng = new google.maps.LatLng(47.245236, -122.362339);
      var mapOptions = {
          zoom: 13,
          styles: styles,
          center: myLatlng,
          draggable: false,
          scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

       //=====Initialise Default Marker
      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'marker',
          icon: {
            url: mapIncludes.markericon,
            size: new google.maps.Size(21, 38),
            scaledSize: new google.maps.Size(21, 38),
            anchor: new google.maps.Point(21, 38)
          }
       //=====You can even customize the icons here
      });

      /*
       //=====Initialise InfoWindow
      var infowindow = new google.maps.InfoWindow({
        // TODO: Confirm this content?
        content: "<B>Skyway Dr</B>"
    });

     //=====Eventlistener for InfoWindow
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
    */
  }

  google.maps.event.addDomListener(window, 'load', initialize);
}
