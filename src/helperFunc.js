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

export default {
  evaluateTime
};
