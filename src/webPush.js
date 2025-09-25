import helperFunc from "./helperFunc";
import store from "./store";

function checkBrowserRegistered(userNotification, browser_unique) {
  if (
    userNotification.browser &&
    userNotification.browser.state &&
    userNotification.browser.keysArr &&
    (!browser_unique ||
      userNotification.browser.keysArr.length <= 0 ||
      !userNotification.browser.keysArr.includes(browser_unique))
  ) {
    return false;
  }
  if (
    userNotification.browser &&
    userNotification.browser.state &&
    !userNotification.browser.keysArr
  ) {
    return false;
  }
  return true;
}

function initSW() {
  if (!"serviceWorker" in navigator) {
    console.log("service worker isn't supported");
    //service worker isn't supported
    alert("service worker isn't supported");
    return;
  }

  var NotificationIsSupported = !!(
    (
      window.Notification /* W3C Specification */ ||
      win.webkitNotifications /* old WebKit Browsers */ ||
      navigator.mozNotification
    ) /* Firefox for Android and Firefox OS */
  );
  if (!NotificationIsSupported) {
    console.log("Notification isn't supported");
    alert("Notification isn't supported");
    return;
  }

  //don't use it here if you use service worker
  //for other stuff.
  if (!"PushManager" in window) {
    //push isn't supported
    console.log("push isn't supported");
    return;
  }

  //register the service worker
  navigator.serviceWorker
    .register(`${import.meta.env.BASE_URL}sw.js`)
    .then(() => {
      console.log("serviceWorker installed!");
      initPush();
    })
    .catch(err => {
      console.log(err);
    });
}

function initPush() {
  if (!navigator.serviceWorker.ready) {
    return;
  }

  Notification.requestPermission(function(result) {
    if (result !== "granted") {
      throw new Error("We weren't granted permission.");
    }
    subscribeUser();
  });
}

function subscribeUser() {
  navigator.serviceWorker.ready
    .then(registration => {
      const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: helperFunc.urlBase64ToUint8Array(
          "BKIjZB1EdkwMo6ek1izI1mLeAQ6dPgqJdo3Xh7k99RUoMIGqZRfIWUn8phcqH3jufSELAYrV2LnySZnAeCVmFxA"
        )
      };

      return registration.pushManager.subscribe(subscribeOptions);
    })
    .then(pushSubscription => {
      console.log(
        "Received PushSubscription: ",
        JSON.stringify(pushSubscription)
      );
      storePushSubscription(pushSubscription);
    });
}

function storePushSubscription(pushSubscription) {
  store.dispatch("SAVE_WEBPUSH", JSON.stringify(pushSubscription));
}
export default { checkBrowserRegistered, initSW };
