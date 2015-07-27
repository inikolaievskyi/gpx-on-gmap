function initialize() {

  var mapOptions = {
    center: coords.points[0].LatLng,
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  var firstActivity = new Activity(coords, map, '#0000ff');

  firstActivity.addLine();
  firstActivity.runMarker();

}


Activity = function (obj, map, pathColor) {
  var me = this;
  this.points = obj.points;
  this.map = map;
  this.startPoint = this.points[0].LatLng;
  this.pathColor = pathColor ? pathColor : '#FF0000';
  this.getPath = function() {
    var data = [];
    for (var i in this.points) {
      data.push(this.points[i].LatLng);
    }

    return data;
  };

  this.flightPath = new google.maps.Polyline({
    path: me.getPath(),
    strokeColor: this.pathColor,
    strokeOpacity: 1.0,
    strokeWeight: 2
  });

  this.marker = new google.maps.Marker({
    position: this.startPoint,
    map: this.map
  });


  this.addLine = function () {
    this.flightPath.setMap(this.map);
  };

  this.runMarker = function() {
    var me = this;
    setInterval(function () {
      var point = me.points[0];
      me.marker.setPosition(point.LatLng);
      $('#hr-value').text(point.hr);
      $('#altitude-value').text(point.alt);
      me.points.shift();
    }, 10);
  }
};
google.maps.event.addDomListener(window, 'load', initialize);
