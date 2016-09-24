<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Safe Passage</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="application/javascript"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFZyhCp8lqfIeognHqe-iauOZLEhhzYjY&sensor=false"></script>
  <script>
    $(document).ready(function(){
      var markers = []; // define global array in script tag so you can use it in whole page    
      var infowindow = new google.maps.InfoWindow();
      var bounds = new google.maps.LatLngBounds();
      var myCenter=new google.maps.LatLng(41.881832,-87.623177);

      var mapProp = {
        center:myCenter, 
        zoom:11,
        minZoom:6,          
        mapTypeId : google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true           
      };

      function infoContent(info){
        var infoString = '<h1>' + info.name + '</h1><br><b>' + 'Address:</b> ' + info.address + '<br><b>School:</b> ' + isTrue(info.school) + '<br><b>Breakfast:</b> ' + isAvailable(info.breakfast) + '<br><b>Lunch:</b> ' + isAvailable(info.lunch) + '<br><b>Supper:</b> ' + isAvailable(info.supper) + '<br><b>PM Snack:</b> ' + isAvailable(info.snack) + '<br><b>Distance from Safe Passage: </b> ' + info.distance);
        return infoString;
      }

      function isTrue(data){
        if (data == 0){
          return 'False'
        }else{
          return 'True'
        }
      }

      function isAvailable(data){
        if (data == 0){
          return 'Not Available'
        }else{
          return 'Available'
        }
      }
      //google map object       
      var map = new google.maps.Map(document.getElementById("gMap"),mapProp);
	  $("#filenameHeat").change(function(e) {

			 var ext = $("input#filenameHeat").val().split(".").pop().toLowerCase();

			 if($.inArray(ext, ["csv"]) == -1) {
					alert('Upload CSV');
					return false;
			  }

			 if (e.target.files != undefined) {

				var reader = new FileReader();
				reader.onload = function(e) {

						  var csvval=e.target.result.split("\n");
						  var csvvalue;                                          
							var heatmapPoints = [];
						  for(var i = 1;i < csvval.length;i++)
						  {
								  csvvalue = csvval[i].split(",");
								  var date = csvvalue[0];
								  var lat = csvvalue[1]; //latitude
								  var lng = csvvalue[2]; //longitude
								  
								  if (!isNaN(lat) && !isNaN(lng)){ 
									var data = new google.maps.LatLng(lat,lng);
									heatmapPoints.push(data);
								 }									
						   }
						var heatmap = new google.maps.visualization.HeatmapLayer({
						  data: heatmapPoints,
						  map: map
						});
				 };
				 reader.readAsText(e.target.files.item(0));
			   }

			 return false;

		});
	  
      map.data.loadGeoJson('CPS_Safe_Passage_Routes_SY1516.geojson'); 
      var depositoriesApi =  "http://10.1.106.135:8080/depositories";
	  $.getJSON(depositoriesApi, function() {
        console.log( "success" );
      })
.done(function( item ) {

    $.each( item, function( i, item ) {
      markers[i] = []; 
      //item = item[i].split(",");
      markers[i][0] = item.name; //id
      info = [];
      info.name = item.name;
      info.address = item.address + ' ' + item.city + ', ' + item.state + ' ' + item.zip;
      info.school = item.isSchool;
      info.breakfast = item.hasBreakfast;
      info.lunch = item.hasLunch;
      info.supper = item.hasSupper;
      info.snack = item.hasPmSnack;
      info.distance = "1 miles"
      var name = item.name;
      var lat = item.yCoordinate; //latitude
      var lng = item.xCoordinate; //longitude

      markers[i][1] = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lng),
        map: map,
        title: name,
        info: info,                  
      });

      google.maps.event.addListener(markers[i][1], 'click', function () {
        infowindow.setContent(infoContent(this.info));
        infowindow.open(map, this);
      });

    });

  })
});








</script>
</head>

<body>
  <div style="height:700px; width:1500px;" id="gMap">
	
  </div>
  <input type="file" id="filenameHeat" name="filenameHeat"/>
</body>
</html>