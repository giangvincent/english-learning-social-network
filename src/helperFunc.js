const evaluateTime = function(beginTime) {
  let timeString = new Date(beginTime).getTime() / 1000;
  let timeNow = new Date().getTime() / 1000;
  let distanceTime = parseInt(timeNow) - timeString;
  let yearInSecond = 31536000;
  let monthInSecond = 2592000;
  let weekInSecond = 604800;
  let dayInSecond = 86400;
  let hourInsecond = 3600;
  let minuteInSecond = 60;
  if (distanceTime > yearInSecond) {
    return parseInt(distanceTime / yearInSecond) + " năm";
  } else if (distanceTime > monthInSecond) {
    return parseInt(distanceTime / monthInSecond) + " tháng";
  } else if (distanceTime > weekInSecond) {
    return parseInt(distanceTime / weekInSecond) + " tuần";
  } else if (distanceTime > dayInSecond) {
    return parseInt(distanceTime / dayInSecond) + " ngày";
  } else if (distanceTime > hourInsecond) {
    return parseInt(distanceTime / hourInsecond) + " giờ";
  } else if (distanceTime > minuteInSecond) {
    return parseInt(distanceTime / minuteInSecond) + " phút";
  } else {
    return parseInt(distanceTime) + " giây";
  }
};

const isLocalStorage = function() {
  var mod = "modernizr";
  try {
    localStorage.setItem(mod, mod);
    localStorage.removeItem(mod);
    return true;
  } catch (e) {
    return false;
  }
};

const isExist = function(url) {
  var http = new XMLHttpRequest();
  http.open("HEAD", url, false);
  http.send();
  return http.status != 404;
};

const urlBase64ToUint8Array = function(base64String) {
  var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
  var base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");

  var rawData = window.atob(base64);
  var outputArray = new Uint8Array(rawData.length);

  for (var i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
};

function randStr(len = 10) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < len; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

export default {
  evaluateTime,
  isLocalStorage,
  isExist,
  urlBase64ToUint8Array,
  randStr
};
