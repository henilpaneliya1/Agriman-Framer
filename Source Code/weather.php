<?php
include("header.php");
?>
  <main id="main">

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
			<br>
			<br>
			<br>
          <h3>Farm Weather Forecast</h3>
          <p>Check the 7-day forecast for your area to plan sowing, irrigation and spraying</p>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <section id="contact" class="contact">
      <div class="container">

        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
              <div class="col-lg-6">
                <div class="info w-100">
                  <h6>Enter your city or village:</h6>
                  <input type="text" id="weathercity" class="form-control" placeholder="e.g. Ahmedabad, Rajkot, Surat...">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="info w-100">
                  <h6>&nbsp;</h6>
                  <button type="button" class="btn btn-info" onclick="searchWeather()">Get Forecast</button>
                  <button type="button" class="btn btn-secondary" onclick="useMyLocation()">Use My Location</button>
                </div>
              </div>
            </div>

            <div id="weatherstatus" style="margin-top:20px;"></div>
            <div id="weathercurrent" class="row" style="margin-top:10px;"></div>
            <div id="weatherforecast" class="row" style="margin-top:10px;"></div>

          </div>
        </div>

      </div>
    </section>

  </main><!-- End #main -->

<?php
include("footer.php");
?>
<script type="application/javascript">

var weatherIcons = {
  0:"&#9728;&#65039; Clear", 1:"&#127780;&#65039; Mostly Clear", 2:"&#9925; Partly Cloudy", 3:"&#9729;&#65039; Overcast",
  45:"&#127787;&#65039; Fog", 48:"&#127787;&#65039; Fog", 51:"&#127782;&#65039; Light Drizzle", 53:"&#127782;&#65039; Drizzle",
  55:"&#127782;&#65039; Heavy Drizzle", 61:"&#127783;&#65039; Light Rain", 63:"&#127783;&#65039; Rain", 65:"&#127783;&#65039; Heavy Rain",
  66:"&#127784;&#65039; Freezing Rain", 67:"&#127784;&#65039; Freezing Rain", 71:"&#10052;&#65039; Light Snow", 73:"&#10052;&#65039; Snow",
  75:"&#10052;&#65039; Heavy Snow", 80:"&#127783;&#65039; Showers", 81:"&#127783;&#65039; Showers", 82:"&#9928;&#65039; Heavy Showers",
  95:"&#9928;&#65039; Thunderstorm", 96:"&#9928;&#65039; Thunderstorm + Hail", 99:"&#9928;&#65039; Thunderstorm + Hail"
};

function weatherLabel(code) {
  return weatherIcons[code] || "&#127780;&#65039; -";
}

function farmingTip(rainProb, rainSum, windMax, tempMax) {
  if (rainProb >= 60 || rainSum >= 10) {
    return "&#128166; Rain likely - avoid spraying pesticides, check field drainage.";
  }
  if (windMax >= 25) {
    return "&#128168; Windy - not suitable for spraying or drone work.";
  }
  if (tempMax >= 38) {
    return "&#128293; Very hot - irrigate in early morning or evening.";
  }
  return "&#9989; Good conditions for field work and spraying.";
}

function setStatus(msg) {
  document.getElementById("weatherstatus").innerHTML = msg;
}

function searchWeather() {
  var city = document.getElementById("weathercity").value.trim();
  if (city == "") {
    alert("Kindly enter your city or village name..");
    document.getElementById("weathercity").focus();
    return;
  }
  setStatus("<h5>Searching for <b>" + city.replace(/</g,"&lt;") + "</b>...</h5>");
  fetch("https://geocoding-api.open-meteo.com/v1/search?name=" + encodeURIComponent(city) + "&count=1&language=en&format=json")
    .then(function(r){ return r.json(); })
    .then(function(data){
      if (!data.results || data.results.length == 0) {
        setStatus("<h5 style='color:red;'>Sorry, could not find that place. Try a nearby bigger town.</h5>");
        return;
      }
      var loc = data.results[0];
      localStorage.setItem("kisan_weather_city", city);
      var placeName = loc.name + (loc.admin1 ? ", " + loc.admin1 : "") + (loc.country ? ", " + loc.country : "");
      loadForecast(loc.latitude, loc.longitude, placeName);
    })
    .catch(function(){ setStatus("<h5 style='color:red;'>Could not reach the weather service. Check your internet connection.</h5>"); });
}

function useMyLocation() {
  if (!navigator.geolocation) {
    alert("Your browser does not support location. Kindly type your city name.");
    return;
  }
  setStatus("<h5>Detecting your location...</h5>");
  navigator.geolocation.getCurrentPosition(function(pos){
    loadForecast(pos.coords.latitude, pos.coords.longitude, "Your Location");
  }, function(){
    setStatus("<h5 style='color:red;'>Location permission denied. Kindly type your city name instead.</h5>");
  });
}

function loadForecast(lat, lon, placeName) {
  setStatus("<h5>Loading forecast for <b>" + placeName + "</b>...</h5>");
  var url = "https://api.open-meteo.com/v1/forecast?latitude=" + lat + "&longitude=" + lon
          + "&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code"
          + "&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_sum,precipitation_probability_max,wind_speed_10m_max"
          + "&timezone=auto&forecast_days=7";
  fetch(url)
    .then(function(r){ return r.json(); })
    .then(function(data){
      setStatus("<h4>Forecast for <b>" + placeName + "</b></h4>");

      var c = data.current;
      document.getElementById("weathercurrent").innerHTML =
        "<div class='col-lg-12'><div class='info w-100' style='background:#f0f8f0;padding:15px;border-radius:8px;'>" +
        "<h5>Right Now: " + weatherLabel(c.weather_code) + " &nbsp; " + Math.round(c.temperature_2m) + "&deg;C" +
        " &nbsp;|&nbsp; Humidity: " + c.relative_humidity_2m + "%" +
        " &nbsp;|&nbsp; Wind: " + Math.round(c.wind_speed_10m) + " km/h</h5>" +
        "</div></div>";

      var d = data.daily;
      var days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
      var html = "";
      for (var i = 0; i < d.time.length; i++) {
        var dateObj = new Date(d.time[i] + "T00:00:00");
        var dayName = (i == 0) ? "Today" : days[dateObj.getDay()] + " " + dateObj.getDate() + "/" + (dateObj.getMonth()+1);
        var tip = farmingTip(d.precipitation_probability_max[i] || 0, d.precipitation_sum[i] || 0, d.wind_speed_10m_max[i] || 0, d.temperature_2m_max[i] || 0);
        html += "<div class='col-lg-3 col-md-6' style='margin-bottom:15px;'>" +
          "<div class='info w-100' style='border:1px solid #ddd;border-radius:8px;padding:15px;height:100%;'>" +
          "<h5>" + dayName + "</h5>" +
          "<p style='font-size:18px;margin-bottom:5px;'>" + weatherLabel(d.weather_code[i]) + "</p>" +
          "<p style='margin-bottom:5px;'><b>" + Math.round(d.temperature_2m_max[i]) + "&deg;</b> / " + Math.round(d.temperature_2m_min[i]) + "&deg;C</p>" +
          "<p style='margin-bottom:5px;'>&#127783;&#65039; Rain chance: <b>" + (d.precipitation_probability_max[i] == null ? "-" : d.precipitation_probability_max[i] + "%") + "</b> (" + d.precipitation_sum[i] + " mm)</p>" +
          "<p style='margin-bottom:5px;'>&#128168; Wind: " + Math.round(d.wind_speed_10m_max[i]) + " km/h</p>" +
          "<p style='margin-bottom:0;color:#1a7a2e;'><small>" + tip + "</small></p>" +
          "</div></div>";
      }
      document.getElementById("weatherforecast").innerHTML = html;
    })
    .catch(function(){ setStatus("<h5 style='color:red;'>Could not load the forecast. Kindly try again.</h5>"); });
}

// Auto-load the last searched city
(function(){
  var saved = localStorage.getItem("kisan_weather_city");
  if (saved) {
    document.getElementById("weathercity").value = saved;
    searchWeather();
  }
})();
</script>
